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
            <i class="fas fa-file-alt mr-2"></i>
            Daftar Laporan
        </h1>

        <a href="{{ route('laporan.create') }}"
           class="btn btn-primary btn-sm shadow-sm mt-3 mt-sm-0">
            <i class="fas fa-plus fa-sm text-white-50"></i>
        </a>

    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show"
             role="alert">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
            <button type="button"
                    class="close"
                    data-dismiss="alert"
                    aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-column flex-sm-row
                    align-items-sm-center justify-content-between">

            <h6 class="m-0 font-weight-bold text-primary">
                Data Laporan Keamanan Lingkungan
            </h6>

            <span class="small text-muted mt-2 mt-sm-0">
                Daftar laporan warga
            </span>
        </div>


        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover"
                       id="dataTable"
                       width="100%"
                       cellspacing="0">

                    <thead class="thead-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Laporan</th>
                            <th>Nama Pelapor</th>
                            <th>Isi Laporan</th>
                            <th width="22%" class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($laporans as $laporan)
                            <tr>
                                <td>
                                    {{ $loop->iteration +
                                       ($laporans->currentPage() - 1)
                                       * $laporans->perPage() }}
                                </td>

                                <td>
                                    {{ $laporan->namaLaporan }}
                                </td>

                                <td>
                                    {{ $laporan->namaPelapor }}
                                </td>

                                <td>
                                    {{ $laporan->isiLaporan }}
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('laporan.show', $laporan) }}"
                                       id="{{ $laporan->id_laporan }}-show-btn"
                                       class="btn btn-info btn-sm mb-1"
                                       title="Lihat Laporan">
                                        <i class="fas fa-eye"></i>
                                        Lihat
                                    </a>

                                    <a href="{{ route('laporan.edit', $laporan) }}"
                                       id="{{ $laporan->id_laporan }}-edit-btn"
                                       class="btn btn-warning btn-sm mb-1"
                                       title="Edit Laporan">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                    <!-- Tombol Hapus -->
                                    <form
                                        action="{{ route('laporan.destroy', $laporan) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus laporan ini?');">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm mb-1"
                                                id="{{ $laporan->id_laporan }}-delete-btn"
                                                title="Hapus Laporan">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="5" class="text-center text-muted">

                                    <i class="fas fa-info-circle mr-1"></i>
                                    Belum ada laporan yang tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row
                        justify-content-between align-items-center mt-3">
                <div class="small text-muted mb-2 mb-sm-0">
                    Menampilkan {{ $laporans->firstItem() ?? 0 }}
                    sampai {{ $laporans->lastItem() ?? 0 }}
                    dari {{ $laporans->total() }} laporan
                </div>

                <div>
                    {{ $laporans->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
