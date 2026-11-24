<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Checkpoint</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4">Detail Checkpoint</h3>
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h4>{{ $posjaga->namaPos }}</h4>
            <p>{{ $posjaga->deskripsiPos }}</p>
            <hr>
            <p>
                <strong>Latitude:</strong>
                {{ $posjaga->latitude }}
            </p>
            <p>
                <strong>Longitude:</strong>
                {{ $posjaga->longitude }}
            </p>
            <span class="badge bg-info">
                Radius validasi 3 meter
            </span>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5>Verifikasi Foto Selfie</h5>
            <p class="text-muted">
                Aktifkan kamera dan ambil foto sebagai bukti checkpoint.
            </p>
            <video id="video" width="100%" autoplay playsinline class="rounded border"> </video>
            <canvas id="canvas" style="display:none;"></canvas>
            <img id="preview" class="img-fluid rounded mt-3" style="display:none;">
            <div class="mt-3">

                <button type="button" id="btnKamera" class="btn btn-primary">
                    Aktifkan Kamera
                </button>

                <button type="button" id="btnFoto" class="btn btn-success" disabled>
                    Ambil Foto
                </button>
            </div>
        </div>
    </div>

    <form action="{{ route('checkpoint.store') }}" method="POST" id="formCheckpoint">
        @csrf
        <input type="hidden" name="id_pos" value="{{ $posjaga->id_pos }}">
        <input type="hidden" name="latitude_user" id="latitude_user">
        <input type="hidden" name="longitude_user" id="longitude_user">
        <input type="hidden" name="foto" id="foto">
        <button type="submit" id="btnCheckpoint" class="btn btn-success w-100"> Validasi Checkpoint
        </button>
    </form>

    <a href="{{ route('checkpoint.index') }}" class="btn btn-secondary w-100 mt-2"> Kembali </a>
</div>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');
    let cameraStream = null;
    document.getElementById('btnKamera')
        .addEventListener('click', async function () {
            try {
                cameraStream = await navigator.mediaDevices
                    .getUserMedia({
                        video: {
                            facingMode: 'user'
                        },
                        audio: false
                    });
                video.srcObject = cameraStream;
                document.getElementById('btnFoto').disabled = false;
            } catch (error) {
                alert('Kamera tidak dapat diakses. Periksa izin kamera.');
            }
        });

    document.getElementById('btnFoto')
        .addEventListener('click', function () {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const context = canvas.getContext('2d');
            context.drawImage(
                video,
                0,
                0,
                canvas.width,
                canvas.height
            );

            const fotoBase64 = canvas.toDataURL(
                'image/jpeg',
                0.8
            );

            document.getElementById('foto').value = fotoBase64;
            preview.src = fotoBase64;
            preview.style.display = 'block';
            alert('Foto berhasil diambil.');
        });

    document.getElementById('formCheckpoint')
        .addEventListener('submit', function (event) {
            event.preventDefault();
            const foto = document.getElementById('foto').value;

            if (!foto) {
                alert('Silakan ambil foto selfie terlebih dahulu.');
                return;
            }
            if (!navigator.geolocation) {
                alert('Perangkat tidak mendukung GPS.');
                return;
            }

            const tombol = document.getElementById('btnCheckpoint');
            tombol.disabled = true;
            tombol.innerText = 'Mengambil lokasi GPS...';
            navigator.geolocation.getCurrentPosition(
                function (position) {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    document.getElementById('latitude_user').value = latitude;
                    document.getElementById('longitude_user').value = longitude;
                    document.getElementById('formCheckpoint').submit();
                },

                function (error) {
                    tombol.disabled = false;
                    tombol.innerText = 'Validasi Checkpoint';
                    alert('Gagal mengambil lokasi. Pastikan GPS aktif dan izin lokasi diberikan.');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 20000,
                    maximumAge: 0
                }
            );
        });

    window.addEventListener('beforeunload', function () {
        if (cameraStream) {
            cameraStream.getTracks().forEach(track => track.stop());
        }
    });

</script>
</body>
</html>
