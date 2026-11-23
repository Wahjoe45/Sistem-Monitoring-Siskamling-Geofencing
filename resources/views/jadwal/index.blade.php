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
<div class="container">
    <h3>Jadwal Jaga Keamanan Lingkungan</h3>
    <form action="{{ route('jadwal.index') }}" method="GET"
        class="mb-4">
        <label>Bulan</label>
        <select name="bulan" class="form-control">
            @for ($i = 1; $i <= 12; $i++)
                <option value="{{ sprintf('%02d', $i) }}"
                    {{ $bulan == sprintf('%02d', $i) ? 'selected' : '' }}>
                    {{ Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                </option>
            @endfor
        </select>

        <label class="mt-2">Tahun</label>
        <input type="number" name="tahun"
            value="{{ $tahun }}" class="form-control">

        <button type="submit" class="btn btn-primary mt-2">
            Tampilkan Jadwal
        </button>
    </form>

    <p>Jumlah warga terdaftar: {{ $jumlahWarga }}</p>

    @if (auth()->user()->role == 'pengurus')
        <form action="{{ route('jadwal.acak') }}" method="POST">
            @csrf
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">

            <button type="submit" class="btn btn-success mb-3"
                onclick="return confirm('Acak ulang jadwal bulan ini?')">
                Acak Jadwal
            </button>
        </form>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Jaga</th>
                    <th>Nama Warga</th>
                    <th>Blok</th>
                </tr>
            </thead>

            <tbody>
                @if ($jadwal && $jadwal->details->isNotEmpty())

                    @php
                        $nomor = 1;

                        $detailPerTanggal = $jadwal->details
                            ->groupBy(function ($detail) {
                                return \Carbon\Carbon::parse(
                                    $detail->tanggal
                                )->format('Y-m-d');
                            });
                    @endphp

                    @foreach ($detailPerTanggal as $tanggal => $details)
                        <tr>
                            <td>{{ $nomor++ }}</td>

                            <td>
                                {{ \Carbon\Carbon::parse($tanggal)
                                    ->translatedFormat('d F Y') }}
                            </td>

                            <td>
                                @foreach ($details as $detail)
                                    <div>{{ $detail->warga->nama ?? '-' }}</div>
                                @endforeach
                            </td>

                            <td>
                                @foreach ($details as $detail)
                                    <div>{{ $detail->warga->blok ?? '-' }}</div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                @else
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'pengurus' ? 5 : 4 }}"
                            class="text-center">
                            Belum ada jadwal jaga untuk bulan ini.
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

</div>
@endsection
