@extends('layouts.app')
@section('sidebar-menu')

    <li class="nav-item active">
        <a class="nav-link" href="{{ route('pengurus.viewpengurus') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('posjaga.index') }}">
            <i class="fas fa-fw fa-plus-circle"></i>
            <span>Data Pos Jaga</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('laporan.index') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Lihat Laporan</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('checkpoint.riwayat') }}">
            <i class="fas fa-fw fa-file-alt"></i>
            <span>Riwayat checkpoint warga</span>
        </a>
    </li>

@if (auth()->user()->role == 'pengurus')
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
            <i class="fas fa-edit mr-2"></i>
            Edit Pos Jaga
        </h1>

        <a href="{{ route('posjaga.index') }}" class="btn btn-secondary btn-sm shadow-sm mt-3 mt-sm-0">
            <i class="fas fa-arrow-left fa-sm"> Kembali </i>
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"> Form Edit Data Pos Jaga </h6>
                </div>

                <div class="card-body">
                    <form action="{{ route('posjaga.update', $posjaga) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="namaPos"> Nama Pos Jaga <span class="text-danger">*</span>
                        </label>
                            <input type="text" class="form-control @error('namaPos') is-invalid @enderror"
                                   id="namaPos"
                                   name="namaPos"
                                   value="{{ old('namaPos', $posjaga->namaPos) }}" placeholder="Masukkan nama pos jaga" required>

                            @error('namaPos')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="deskripsiPos">
                                Deskripsi Pos
                            </label>

                            <input type="text"
                                   class="form-control @error('deskripsiPos') is-invalid @enderror"
                                   id="deskripsiPos"
                                   name="deskripsiPos"
                                   value="{{ old('deskripsiPos', $posjaga->deskripsiPos) }}"
                                   readonly>

                            @error('deskripsiPos')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <small class="form-text text-muted">
                                Deskripsi pos tidak dapat diubah melalui halaman ini.
                            </small>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="latitude">
                                Latitude
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   class="form-control @error('latitude') is-invalid @enderror"
                                   id="latitude"
                                   name="latitude"
                                   value="{{ old('latitude', $posjaga->latitude) }}"
                                   placeholder="Contoh: -8.107167"
                                   required>

                            @error('latitude')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="form-group">
                            <label for="longitude">
                                Longitude
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   class="form-control @error('longitude') is-invalid @enderror"
                                   id="longitude"
                                   name="longitude"
                                   value="{{ old('longitude', $posjaga->longitude) }}"
                                   placeholder="Contoh: 112.162667"
                                   required>

                            @error('longitude')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <hr>
                        <div class="d-flex flex-column flex-sm-row">
                            <button type="submit"
                                    class="btn btn-primary shadow-sm mr-sm-2 mb-2 mb-sm-0">
                                <i class="fas fa-save mr-1">Simpan Perubahan</i>
                            </button>

                            <a href="{{ route('posjaga.index') }}"
                               class="btn btn-secondary shadow-sm">
                                <i class="fas fa-times mr-1">Batal</i>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
