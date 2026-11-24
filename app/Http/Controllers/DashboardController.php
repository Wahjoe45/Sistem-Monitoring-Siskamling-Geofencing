<?php

namespace App\Http\Controllers;
use App\Models\Checkpoint;
use App\Models\Posjaga;
use App\Models\User;

use Illuminate\Http\Request;

class DashboardController extends Controller


{
    public function viewpengurus()
    {
        // Menghitung jumlah data pada tabel posjaga
        $jumlahPosJaga = Posjaga::count();
        $jumlahWarga = User::where('role', 'warga')->count();
        $checkpointValid = Checkpoint::where('status_validasi', 'valid')->count();
        $checkpointInvalid = Checkpoint::where('status_validasi', 'invalid')->count();

        // Mengirimkan variabel ke halaman dashboard
        return view('pengurus.viewpengurus', [
            'jumlahPosJaga' => $jumlahPosJaga,
            'jumlahWarga' => $jumlahWarga,
            'checkpointValid' => $checkpointValid,
            'checkpointInvalid' => $checkpointInvalid,
        ]);
    }

    public function showJumlahWarga()
    {
        // Menghitung jumlah data pada tabel posjaga
        $jumlahWarga = User::where('role', 'warga')->count();

        // Mengirimkan variabel ke halaman dashboard
        return view('warga.viewwarga', [
            'jumlahWarga' => $jumlahWarga
        ]);
    }
}
