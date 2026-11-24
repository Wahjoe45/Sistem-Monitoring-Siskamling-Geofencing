<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Checkpoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    <h3 class="mb-4">Daftar Pos Checkpoint</h3>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        @forelse($posjagas as $pos)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">
                            {{ $pos->namaPos }}
                        </h5>

                        <p class="card-text">
                            {{ $pos->deskripsiPos }}
                        </p>

                        <p class="text-muted small">
                            Latitude: {{ $pos->latitude }}<br>
                            Longitude: {{ $pos->longitude }}
                        </p>

                        <a href="{{ route('checkpoint.show', $pos->id_pos) }}" class="btn btn-primary w-100"> Pilih Checkpoint </a>
                    </div>
                </div>
            </div>

        @empty

            <div class="col-12">
                <div class="alert alert-warning">
                    Belum terdapat data pos jaga.
                </div>
            </div>
        @endforelse
    </div>
</div>
</body>
</html>
