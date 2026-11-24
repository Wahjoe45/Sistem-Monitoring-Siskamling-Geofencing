<?php

namespace App\Http\Controllers;

use App\Models\Checkpoint;
use App\Models\Laporan;
use App\Models\Posjaga;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardWargaController extends Controller
{
    public function viewwarga()
    {
        // Menghitung jumlah data pada tabel posjaga
        $jumlahPosJaga = Posjaga::count();
        $jumlahWarga = User::where('role', 'warga')->count();
        $checkpointValid = Checkpoint::where('status_validasi', 'valid')->count();
        $checkpointInvalid = Checkpoint::where('status_validasi', 'invalid')->count();
        $jumlahLaporan = Laporan::count();

        // Mengirimkan variabel ke halaman dashboard
        return view('warga.viewwarga', [
            'jumlahPosJaga' => $jumlahPosJaga,
            'jumlahWarga' => $jumlahWarga,
            'jumlahLaporan' => $jumlahLaporan,
            'checkpointValid' => $checkpointValid,
            'checkpointInvalid' => $checkpointInvalid,
        ]);
    }
}
