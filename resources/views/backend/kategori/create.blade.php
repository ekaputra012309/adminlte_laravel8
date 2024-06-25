@extends('backend/template/app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Kategori</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori</a></li>
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
                                <h3 class="card-title">Tambah Kategori</h3>
                                {{-- <div class="card-tools">
                                    <a href="{{ route('kategori.add') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Add Data
                                    </a>
                                </div> --}}
                            </div>
                            <form action="{{ route('kategori.store') }}" method="POST">
                                @csrf
                                @auth
                                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                @endauth

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="categoryname">Kategori</label>
                                                <select name="categoryname" id="categoryname"
                                                    class="form-control select2bs4" style="width: 100%" required>
                                                    <option value="">Pilih Kategori</option>
                                                    <option value="Hardware">Hardware</option>
                                                    <option value="Jaringan">Jaringan</option>
                                                    <option value="Software">Software</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="hashtag"># Hashtag</label>
                                                <input type="text" class="form-control" id="hashtag" name="hashtag"
                                                    placeholder="# Hashtag" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <button type="reset" class="btn btn-danger">Reset</button>
                                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
