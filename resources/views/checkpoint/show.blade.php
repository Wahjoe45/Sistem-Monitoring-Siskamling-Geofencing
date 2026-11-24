
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
            Detail Checkpoint
        </h1>

        <a href="{{ route('checkpoint.index') }}"
           class="btn btn-secondary btn-sm shadow-sm mt-3 mt-sm-0">
            <i class="fas fa-arrow-left fa-sm"></i>
            Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm"
             role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
            <button type="button" class="close"
                    data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-xl-5 col-lg-6 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle mr-1"></i>
                        Informasi Pos Checkpoint
                    </h6>
                </div>

                <div class="card-body">
                    <h4 class="font-weight-bold text-gray-800">
                        {{ $posjaga->namaPos }}
                    </h4>

                    <p class="text-gray-600">
                        {{ $posjaga->deskripsiPos }}
                    </p>

                    <hr>

                    <div class="mb-3">

                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                            <strong>Latitude:</strong>
                            {{ $posjaga->latitude }}
                        </p>

                        <p class="mb-0">
                            <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                            <strong>Longitude:</strong>
                            {{ $posjaga->longitude }}
                        </p>
                    </div>

                    <hr>
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-crosshairs mr-2"></i>
                        <strong>Radius Validasi Geofencing</strong>
                        <h4 class="font-weight-bold mb-0 mt-1">
                            10 Meter
                        </h4>

                        <small>
                            Pengguna harus berada dalam radius yang ditentukan
                            untuk melakukan checkpoint.
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-6 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-camera mr-1"></i>
                        Verifikasi Foto Selfie
                    </h6>
                </div>

                <div class="card-body">

                    <p class="text-muted">
                        Aktifkan kamera smartphone dan ambil foto selfie
                        sebagai bukti pelaksanaan checkpoint.
                    </p>

                    <div class="text-center">
                        <video id="video"
                               class="img-fluid rounded border"
                               style="width: 100%; max-height: 400px; background: #222;"
                               autoplay
                               playsinline>
                        </video>

                        <canvas id="canvas" style="display: none;"></canvas>
                        <div class="mt-3">
                            <img id="preview"
                                 class="img-fluid rounded border"
                                 style="display: none; max-height: 400px;"
                                 alt="Preview foto selfie">
                        </div>
                    </div>
>
                    <div class="mt-3 d-flex flex-column flex-sm-row">
                        <button type="button"
                                id="btnKamera"
                                class="btn btn-primary mr-sm-2 mb-2 mb-sm-0">
                            <i class="fas fa-video mr-1"></i>
                            Aktifkan Kamera
                        </button>

                        <button type="button"
                                id="btnFoto"
                                class="btn btn-success"
                                disabled>
                            <i class="fas fa-camera mr-1"></i>
                            Ambil Foto
                        </button>
                    </div>

                    <small class="text-muted d-block mt-3">
                        Pastikan wajah terlihat jelas ketika mengambil foto.
                    </small>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-location-arrow mr-1"></i>
                Validasi Lokasi Checkpoint
            </h6>
        </div>

        <div class="card-body">
            <form action="{{ route('checkpoint.store') }}"
                  method="POST"
                  id="formCheckpoint">
                @csrf
                <input type="hidden"
                       name="id_pos"
                       value="{{ $posjaga->id_pos }}">

                <input type="hidden"
                       name="latitude_user"
                       id="latitude_user">

                <input type="hidden"
                       name="longitude_user"
                       id="longitude_user">

                <input type="hidden"
                       name="foto"
                       id="foto">

                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Pastikan kamera sudah mengambil foto selfie dan GPS
                    perangkat sudah aktif sebelum melakukan validasi.
                </div>

                <button type="submit"
                        id="btnCheckpoint"
                        class="btn btn-success btn-block shadow-sm">
                    <i class="fas fa-check-circle mr-1"></i>
                    Validasi Checkpoint
                </button>
            </form>

            <a href="{{ route('checkpoint.index') }}"
               class="btn btn-secondary btn-block mt-2">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali ke Daftar Checkpoint
            </a>
        </div>
    </div>
</div>

<script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');
    let cameraStream = null;
    document.getElementById('btnKamera')
        .addEventListener('click', async function () {
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({
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
            if (!video.videoWidth || !video.videoHeight) {
                alert('Kamera belum siap. Silakan tunggu beberapa saat.');
                return;

            }

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
            tombol.innerHTML =
                '<i class="fas fa-spinner fa-spin mr-1"></i> Mengambil lokasi GPS...';

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
                    tombol.innerHTML =  '<i class="fas fa-check-circle mr-1"></i> Validasi Checkpoint';
                    alert( 'Gagal mengambil lokasi. Pastikan GPS aktif dan izin lokasi diberikan.' );
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
@endsection
