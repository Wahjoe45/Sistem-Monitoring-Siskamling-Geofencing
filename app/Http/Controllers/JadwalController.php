<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Jadwal;
use App\Models\JadwalDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JadwalController extends Controller
{

    public function index(Request $request)
    {
        $bulan = (int) $request->input('bulan', date('m'));
        $tahun = (int) $request->input('tahun', date('Y'));

        $jumlahWarga = User::where('role', 'warga')
            ->count();

        $jadwal = Jadwal::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        $details = collect();

        if ($jadwal) {
            $details = JadwalDetail::with('warga')
                ->where('id_jadwal', $jadwal->id_jadwal)
                ->orderBy('tanggal')
                ->get();
        }

        return view('jadwal.index', compact(
            'bulan',
            'tahun',
            'jumlahWarga',
            'jadwal',
            'details'
        ));
    }

    public function acak(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2020|max:2100',
        ]);

        $bulan = (int) $request->bulan;
        $tahun = (int) $request->tahun;

        $wargas = User::where('role', 'warga')
            ->orderBy('id_warga')
            ->get();

        if ($wargas->isEmpty()) {
            return redirect()
                ->route('jadwal.index', [
                    'bulan' => $bulan,
                    'tahun' => $tahun,
                ])
                ->with('error', 'Belum ada warga yang terdaftar.');
        }

        $jumlahHari = Carbon::create($tahun, $bulan, 1)
            ->daysInMonth;

        $tanggalJaga = [];

        for ($tanggal = 3; $tanggal <= 30; $tanggal += 3) {

            if ($tanggal <= $jumlahHari) {
                $tanggalJaga[] = $tanggal;
            }
        }

        $jumlahKelompok = count($tanggalJaga);

        DB::transaction(function () use (
            $wargas,
            $bulan,
            $tahun,
            $tanggalJaga,
            $jumlahKelompok
        ) {

            $jadwal = Jadwal::firstOrCreate([
                'bulan' => $bulan,
                'tahun' => $tahun,
            ]);

            JadwalDetail::where(
                'id_jadwal',
                $jadwal->id_jadwal
            )->delete();

            $wargas = $wargas->shuffle()->values();

            $dataJadwal = [];

            foreach ($wargas as $index => $warga) {
                $kelompok = $index % $jumlahKelompok;
                $tanggal = $tanggalJaga[$kelompok];
                $tanggalLengkap = Carbon::create(
                    $tahun,
                    $bulan,
                    $tanggal
                )->format('Y-m-d');

                $dataJadwal[] = [
                    'id_jadwal' => $jadwal->id_jadwal,
                    'id_warga' => $warga->id_warga,
                    'tanggal' => $tanggalLengkap,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            JadwalDetail::insert($dataJadwal);
        });

        return redirect()
            ->route('jadwal.index', [
                'bulan' => $bulan,
                'tahun' => $tahun,
            ])
            ->with(
                'success',
                'Jadwal berhasil dibuat menggunakan algoritma Round Robin!'
            );
    }

    public function destroy($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $jadwal->delete();

        return redirect()
            ->route('jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
