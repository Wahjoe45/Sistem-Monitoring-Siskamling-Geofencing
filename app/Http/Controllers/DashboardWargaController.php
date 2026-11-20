<?php

namespace App\Http\Controllers;
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

        // Mengirimkan variabel ke halaman dashboard
        return view('warga.viewwarga', [
            'jumlahPosJaga' => $jumlahPosJaga,
            'jumlahWarga' => $jumlahWarga
        ]);
    }
}
