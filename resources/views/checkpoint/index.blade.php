@extends('layouts.app')
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

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-map-marker-alt mr-2"></i>
            Daftar Pos Checkpoint
        </h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        @forelse($posjagas as $pos)
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 mb-4">
                <div class="card shadow h-100">
                    <div class="card-header py-3 d-flex align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">
                            <i class="fas fa-map-pin mr-2"></i>
                            {{ $pos->namaPos }}
                        </h6>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <h6 class="font-weight-bold text-gray-800">
                                Deskripsi Pos
                            </h6>

                            <p class="text-gray-700 mb-0">
                                {{ $pos->deskripsiPos }}
                            </p>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="font-weight-bold text-gray-800">
                                <i class="fas fa-globe-asia mr-1 text-primary"></i>
                                Koordinat Lokasi
                            </h6>

                            <div class="small text-muted">
                                <p class="mb-1">
                                    <i class="fas fa-arrows-alt-v mr-2"></i>
                                    Latitude:
                                    {{ $pos->latitude }}
                                </p>

                                <p class="mb-0">
                                    <i class="fas fa-arrows-alt-h mr-2"></i>
                                    Longitude:
                                    {{ $pos->longitude }}
                                </p>
                            </div>
                        </div>

                        <div class="mt-auto pt-3">
                            <a href="{{ route('checkpoint.show', $pos->id_pos) }}"
                               class="btn btn-primary btn-block shadow-sm">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                Pilih Checkpoint
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-map-marked-alt fa-3x text-gray-400 mb-3"></i>
                        <h5 class="font-weight-bold text-gray-700">
                            Belum Terdapat Data Pos Jaga
                        </h5>
                        <p class="text-muted mb-0">
                            Saat ini belum tersedia pos jaga yang dapat digunakan sebagai checkpoint patroli.
                        </p>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
