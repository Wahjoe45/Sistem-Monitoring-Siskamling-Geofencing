
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
            <i class="fas fa-history mr-2"></i>
            Riwayat Checkpoint Warga
        </h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-clipboard-list mr-1"></i>
                Data Riwayat Patroli Checkpoint
            </h6>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th>Nama Warga</th>
                            <th>Pos Jaga</th>
                            <th class="text-center">Foto</th>
                            <th class="text-center">Jarak</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Waktu</th>
                        </tr>

                    </thead>

                    <tbody>
                        @forelse($checkpoints as $checkpoint)
                            <tr>
                                <td class="text-center">
                                    {{ method_exists($checkpoints, 'firstItem') ? $checkpoints->firstItem() + $loop->index : $loop->iteration }}
                                </td>

                                <td class="align-middle">
                                    {{ $checkpoint->nama }}
                                </td>

                                <td class="align-middle">
                                    {{ $checkpoint->namaPos }}
                                </td>

                                <td class="text-center align-middle">
                                    @if($checkpoint->foto)
                                        <a href="{{ asset('storage/' . $checkpoint->foto) }}"
                                           target="_blank"
                                           title="Lihat foto checkpoint">
                                            <img src="{{ asset('storage/' . $checkpoint->foto) }}"
                                                 alt="Foto checkpoint {{ $checkpoint->nama }}"
                                                 class="img-thumbnail"
                                                 style="width: 70px; height: 70px; object-fit: cover;">

                                        </a>
                                    @else
                                        <span class="text-muted small">
                                            Tidak ada foto
                                        </span>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    {{ number_format($checkpoint->jarak_meter, 2) }}
                                    meter
                                </td>

                                <td class="text-center align-middle">
                                    @if($checkpoint->status_validasi == 'valid')
                                        <span class="badge badge-success">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Valid
                                        </span>
                                    @else

                                        <span class="badge badge-danger">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Invalid
                                        </span>
                                    @endif
                                </td>

                                <!-- Waktu -->
                                <td class="text-center align-middle">
                                    {{ $checkpoint->created_at->format('d-m-Y H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-history fa-2x text-gray-400 mb-2"></i>
                                    <p class="text-muted mb-0">
                                        Belum terdapat riwayat checkpoint.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($checkpoints, 'links'))
                <div class="mt-3">
                    {{ $checkpoints->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
