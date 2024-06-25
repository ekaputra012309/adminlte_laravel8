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
                            <li class="breadcrumb-item active">Edit</li>
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
                                <h3 class="card-title">Edit Kategori</h3>
                            </div>
                            <form action="{{ route('kategori.update', $kategori->id) }}" method="POST">
                                @csrf
                                @method('PUT') <!-- Use PUT method for update -->
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
                                                    <option value="Hardware"
                                                        {{ $kategori->categoryname == 'Hardware' ? 'selected' : '' }}>
                                                        Hardware</option>
                                                    <option value="Jaringan"
                                                        {{ $kategori->categoryname == 'Jaringan' ? 'selected' : '' }}>
                                                        Jaringan</option>
                                                    <option value="Software"
                                                        {{ $kategori->categoryname == 'Software' ? 'selected' : '' }}>
                                                        Software</option>
                                                    <option value="Other"
                                                        {{ $kategori->categoryname == 'Other' ? 'selected' : '' }}>
                                                        Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="hashtag"># Hashtag</label>
                                                <input type="text" class="form-control" id="hashtag" name="hashtag"
                                                    placeholder="# Hashtag" required value="{{ $kategori->hashtag }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
