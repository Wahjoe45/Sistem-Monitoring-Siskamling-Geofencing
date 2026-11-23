@extends('layouts.app')
@section('sidebar-menu')
@endsection
@section('content')

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-map-marker-alt mr-2"></i>
            Detail Pos {{ $posjaga->namaPos }}
        </h1>

        <a href="{{ route('posjaga.index') }}"
           class="btn btn-secondary btn-sm shadow-sm mt-3 mt-sm-0">
            <i class="fas fa-arrow-left fa-sm"> Kembali </i>
        </a>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-10 col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center
                            justify-content-between">

                    <h6 class="m-0 font-weight-bold text-primary">
                        Informasi Pos Jaga
                    </h6>

                    <span class="badge badge-primary">
                        ID Pos: {{ $posjaga->id_pos }}
                    </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <tbody>
                                <tr>
                                    <th class="bg-light" width="35%">
                                        <i class="fas fa-map-marker-alt text-primary mr-2"> Nama Pos Jaga </i>
                                    </th>

                                    <td> {{ $posjaga->namaPos }} </td>
                                </tr>

                                <tr>
                                    <th class="bg-light">
                                        <i class="fas fa-align-left text-primary mr-2"> Deskripsi Pos </i>
                                    </th>

                                    <td> {{ $posjaga->deskripsiPos }} </td>
                                </tr>

                                <tr>
                                    <th class="bg-light">
                                        <i class="fas fa-globe text-primary mr-2"> Latitude </i>
                                    </th>

                                    <td> {{ $posjaga->latitude }} </td>
                                </tr>

                                <tr>
                                    <th class="bg-light">
                                        <i class="fas fa-globe text-primary mr-2"> Longitude </i>
                                    </th>

                                    <td> {{ $posjaga->longitude }} </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mt-4 mb-0">
                        <i class="fas fa-info-circle mr-2"></i>
                        Koordinat latitude dan longitude di atas digunakan
                        sebagai titik lokasi pos jaga dalam sistem
                        checkpoint geofencing.
                    </div>
                </div>

                <div class="card-footer">
                    <div class="d-flex flex-column flex-sm-row">
                        <a href="{{ route('posjaga.index') }}" class="btn btn-secondary shadow-sm mr-sm-2 mb-2 mb-sm-0">
                            <i class="fas fa-arrow-left mr-1"> Kembali </i>
                        </a>

                        <a href="{{ route('posjaga.edit', $posjaga) }}" class="btn btn-warning shadow-sm" id="edit-product-btn">
                            <i class="fas fa-edit mr-1"> Rubah Data Pos </i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
