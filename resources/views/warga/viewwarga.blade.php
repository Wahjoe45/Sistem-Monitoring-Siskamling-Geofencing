@extends('layouts.app')
@section('title', 'Dashboard Warga')
@section('page-title', 'Dashboard Warga')
@section('sidebar-menu')

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('warga.viewwarga') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Diagram riwayat checkpoint</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-plus-circle"></i>
            <span>Buat Laporan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('checkpoint.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Halaman Checkpoint</span>
        </a>
    </li>

@if (auth()->user()->role == 'warga')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('jadwal.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Jadwal Jaga</span>
        </a>
    </li>
@endif
@endsection

@section('content')
    <p class="text-gray-600">
        Selamat datang, {{ Auth::user()->nama }}!
    </p>

    <div class="row">
        <script src="{{ asset('vendor/chart.js/Chart.min.js') }}"></script>
        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-primary mb-1">
                        Checkpoint Valid
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        {{ $checkpointValid }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success mb-1">
                        Checkpoint invalid
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        {{ $checkpointInvalid }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success mb-1">
                        Jumlah Pos Jaga
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        {{ $jumlahPosJaga }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success mb-1">
                        Jumlah Warga
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        {{ $jumlahWarga }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-xl-3 mb-4">
            <div class="card border-left-primary shadow py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success mb-1">
                        Jumlah Laporan
                    </div>
                    <div class="h5 font-weight-bold text-gray-800">
                        {{ $jumlahLaporan }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
