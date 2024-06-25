@extends('backend/template/app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Request User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('permintaan.index') }}">Request User</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Tambah Request</h3>
                                {{-- <div class="card-tools">
                                    <a href="{{ route('permintaan.add') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add Data
                                    </a>
                                </div> --}}
                            </div>
                            <form action="{{ route('permintaan.store') }}" method="POST">
                                @csrf
                                @auth
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @endauth

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="pelapor">Nama Pelapor</label>
                                                <input type="text" class="form-control" id="pelapor" name="pelapor"
                                                    placeholder="Nama Pelapor" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lantai">Pilih Lokasi</label>
                                                <select id="lantai" class="form-control select2bs4" style="width: 100%"
                                                    required>
                                                    @foreach ($datalantai as $lantai)
                                                        <option value="{{ $lantai->id }}">
                                                            {{ $lantai->floorname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="lokasi_id" class="text-white">Pilih Lokasi</label>
                                                <select name="lokasi_id" id="lokasi_id" class="form-control select2bs4"
                                                    style="width: 100%" required>
                                                    @foreach ($datalokasi as $lokasi)
                                                        <option value="{{ $lokasi->id }}">
                                                            {{ $lokasi->locationname }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tingkat">Pilih Tingkat</label>
                                                <select name="tingkat" id="tingkat" class="form-control select2bs4"
                                                    style="width: 100%" required>
                                                    <option value="Mudah">Mudah</option>
                                                    <option value="Sedang">Sedang</option>
                                                    <option value="Sulit">Sulit</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kategori">Pilih Kategori</label>
                                                <select id="kategori" class="form-control select2bs4" style="width: 100%"
                                                    required>
                                                    <option value="Hardware">Hardware</option>
                                                    <option value="Jaringan">Jaringan</option>
                                                    <option value="Software">Software</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="kategori_id" class="text-white">Pilih Kategori</label>
                                                <select name="kategori_id" id="kategori_id" class="form-control select2bs4"
                                                    style="width: 100%" required>
                                                    @foreach ($datakategori as $kategori)
                                                        <option value="{{ $kategori->id }}">
                                                            {{ $kategori->hashtag }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="kendala">Kendala</label>
                                                <textarea class="form-control" name="kendala" id="kendala" cols="30" rows="3" required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <a href="{{ route('permintaan.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            $(function() {
                $('.select2bs4').select2({
                    theme: 'bootstrap4'
                });

                // Add onchange event handler to lantai select element
                $('#lantai').on('change', function() {
                    var selectedLantai = $(this).val();
                    // AJAX call or any method to get filtered lokasi options based on selected lantai
                    // For now, assuming filteredLokasi is an array of filtered options
                    var filteredLokasi = {!! json_encode($datalokasi->toArray()) !!}.filter(function(lokasi) {
                        return lokasi.floor_id == selectedLantai;
                    });
                    // Clear existing options
                    $('#lokasi_id').empty();
                    // Append filtered options to lokasi_id select element
                    filteredLokasi.forEach(function(lokasi) {
                        $('#lokasi_id').append('<option value="' + lokasi.id + '">' + lokasi
                            .locationname + '</option>');
                    });
                });

                // Add onchange event handler to kategori select element
                $('#kategori').on('change', function() {
                    var selectedkategori = $(this).val();
                    // AJAX call or any method to get filtered lokasi options based on selected kategori
                    // For now, assuming filteredkategori is an array of filtered options
                    var filteredkategori = {!! json_encode($datakategori->toArray()) !!}.filter(function(kategori) {
                        return kategori.categoryname == selectedkategori;
                    });
                    // Clear existing options
                    $('#kategori_id').empty();
                    // Append filtered options to kategori_id select element
                    filteredkategori.forEach(function(kategori) {
                        $('#kategori_id').append('<option value="' + kategori.id + '">' + kategori
                            .hashtag + '</option>');
                    });
                });
            });
        </script>
    </div>
@endsection
