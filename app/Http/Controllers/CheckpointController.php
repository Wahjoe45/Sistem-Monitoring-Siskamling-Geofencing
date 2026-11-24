<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Checkpoint;
use App\Models\Posjaga;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckpointController extends Controller
{
    public function index()
    {
        abort_unless(Auth::user()->role === 'warga', 403);
        $posjagas = Posjaga::all();
        return view('checkpoint.index', compact('posjagas'));
    }

    public function show($id)
    {
        abort_unless(Auth::user()->role === 'warga', 403);

        // Mencari pos berdasarkan ID
        $posjaga = Posjaga::findOrFail($id);

        return view('checkpoint.show', compact('posjaga'));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'warga', 403);
        $request->validate([
            'id_pos' => 'required|exists:posjagas,id_pos',
            'latitude_user' => 'required|numeric|between:-90,90',
            'longitude_user' => 'required|numeric|between:-180,180',
            'foto' => 'required|string',
        ]);

        $posjaga = Posjaga::findOrFail($request->id_pos);
        $latPos = (float) $posjaga->latitude;
        $lonPos = (float) $posjaga->longitude;
        $latUser = (float) $request->latitude_user;
        $lonUser = (float) $request->longitude_user;
        $jarak = $this->hitungJarak(
            $latUser,
            $lonUser,
            $latPos,
            $lonPos
        );

        $radius = 10;
        if ($jarak <= $radius) {
            $status = 'valid';
        } else {
            $status = 'invalid';
        }

        $foto = $request->foto;

        // Memastikan format foto adalah Base64 JPEG
        if (!preg_match(
            '/^data:image\/jpeg;base64,/',
            $foto
        )) {
            return back()->withErrors([
                'foto' => 'Format foto tidak valid.'
            ]);
        }

        $foto = substr(
            $foto,
            strpos($foto, ',') + 1
        );

        $foto = base64_decode($foto, true);

        if ($foto === false) {
            return back()->withErrors([
                'foto' => 'Foto gagal diproses.'
            ]);
        }

        $namaFoto = 'checkpoint_' .
            Auth::id() . '_' .
            time() . '.jpg';

        Storage::disk('public')->put(
            'checkpoint/' . $namaFoto,
            $foto
        );

        Checkpoint::create([
            'id_warga' => Auth::user()->id_warga,
            'id_pos' => $posjaga->id_pos,
            'nama' => Auth::user()->nama,
            'namaPos' => $posjaga->namaPos,
            'foto' => 'checkpoint/' . $namaFoto,
            'latitude_user' => $latUser,
            'longitude_user' => $lonUser,
            'jarak_meter' => $jarak,
            'status_validasi' => $status,
        ]);

        if ($status === 'valid') {

            return redirect()
                ->route('checkpoint.index')
                ->with('success',
                    'Checkpoint berhasil! Jarak Anda ' .
                    round($jarak, 2) . ' meter dari pos.'
                );
        } else {
            return redirect()
                ->route('checkpoint.show', $posjaga->id_pos)
                ->with('error',
                    'Checkpoint tidak valid! Jarak Anda ' .
                    round($jarak, 2) .
                    ' meter. Maksimal radius adalah 10 meter. Silakan coba kembali.'
                );
        }
    }

    private function hitungJarak(
        $lat1,
        $lon1,
        $lat2,
        $lon2
    ) {

        $radiusBumi = 6371000;
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;
        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos($lat1) * cos($lat2)
            * sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(
            sqrt($a),
            sqrt(1 - $a)
        );
        return $radiusBumi * $c;
    }

    public function riwayat()
    {
        abort_unless(Auth::user()->role === 'pengurus', 403);
        $checkpoints = Checkpoint::latest()
            ->get();

        return view(
            'checkpoint.riwayat',
            compact('checkpoints')
        );
    }
}

