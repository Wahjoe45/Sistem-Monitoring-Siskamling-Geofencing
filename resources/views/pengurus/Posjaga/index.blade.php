@extends('layouts.app')

@section('sidebar-menu')
@endsection

@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Daftar Pos Jaga
        </h1>

        <a href="{{ route('posjaga.create') }}"
           class="btn btn-primary btn-sm shadow-sm mt-3 mt-sm-0">
            <i class="fas fa-plus fa-sm text-white-50"></i>
            Tambah Pos Jaga
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
                Data Pos Jaga
            </h6>

            <span class="small text-muted mt-2 mt-sm-0">
                Daftar lokasi pos jaga lingkungan
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
                            <th>Nama Pos Jaga</th>
                            <th>Deskripsi</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                            <th width="22%" class="text-center">
                                Action
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($posjagas as $posjaga)
                            <tr>
                                <td>
                                    {{ $loop->iteration +
                                       ($posjagas->currentPage() - 1)
                                       * $posjagas->perPage() }}
                                </td>
                                <td>
                                    {{ $posjaga->namaPos }}
                                </td>
                                <td>
                                    {{ $posjaga->deskripsiPos }}
                                </td>
                                <td>
                                    {{ $posjaga->latitude }}
                                </td>

                                <td>
                                    {{ $posjaga->longitude }}
                                </td>

                                <td class="text-center">
                                    <a href="{{ route('posjaga.show', $posjaga) }}"
                                       class="btn btn-info btn-sm mb-1"
                                       title="Lihat Detail">
                                        <i class="fas fa-eye"></i>
                                        Lihat
                                    </a>

                                    <a href="{{ route('posjaga.edit', $posjaga) }}"
                                       class="btn btn-warning btn-sm mb-1"
                                       title="Edit Pos Jaga">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('posjaga.destroy', $posjaga) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pos jaga ini?');">

                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-danger btn-sm mb-1"
                                                title="Hapus Pos Jaga">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty

                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Data pos jaga belum tersedia.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-column flex-sm-row
                        justify-content-between align-items-center mt-3">

                <div class="small text-muted mb-2 mb-sm-0">
                    Menampilkan {{ $posjagas->firstItem() ?? 0 }}
                    sampai {{ $posjagas->lastItem() ?? 0 }}
                    dari {{ $posjagas->total() }} data
                </div>
                <div>
                    {{ $posjagas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
