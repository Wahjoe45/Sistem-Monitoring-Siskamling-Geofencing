<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Checkpoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>
<div class="container mt-4">
    <h3 class="mb-4">Riwayat Checkpoint Warga</h3>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Warga</th>
                            <th>Pos Jaga</th>
                            <th>Foto</th>
                            <th>Jarak</th>
                            <th>Status</th>
                            <th>Waktu</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($checkpoints as $checkpoint)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $checkpoint->nama }}</td>
                                <td>{{ $checkpoint->namaPos }}</td>
                                <td>

                                    <a href="{{ asset('storage/' . $checkpoint->foto) }}"
                                        target="_blank">

                                        <img
                                            src="{{ asset('storage/' . $checkpoint->foto) }}"
                                            width="70"
                                            class="rounded">
                                    </a>
                                </td>
                                <td>
                                    {{ number_format($checkpoint->jarak_meter, 2) }} meter
                                </td>

                                <td>
                                    @if($checkpoint->status_validasi == 'valid')
                                        <span class="badge bg-success">
                                            Valid
                                        </span>
                                    @else
                                        <span class="badge bg-danger">
                                            Invalid
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $checkpoint->created_at->format('d-m-Y H:i:s') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum terdapat riwayat checkpoint.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>
