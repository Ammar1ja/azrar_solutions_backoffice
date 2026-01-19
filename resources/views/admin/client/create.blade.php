@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Clients</h4>
            <ul class="breadcrumbs">
                <li class="nav-home"><a href="#"><i class="flaticon-home"></i></a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
                <li class="nav-item"><a href="{{ route('admin.client.index') }}">Clients</a></li>
                <li class="separator"><i class="flaticon-right-arrow"></i></li>
                <li class="nav-item"><a href="#">Create</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Create New Client</div>
                    </div>
                    <form action="{{ route('admin.client.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_ar_name">Client Name (Arabic)</label>
                                        <input type="text"
                                            class="form-control @error('client_ar_name') is-invalid @enderror"
                                            id="client_ar_name" name="client_ar_name" placeholder="اسم العميل"
                                            value="{{ old('client_ar_name') }}">
                                        @error('client_ar_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="client_en_name">Client Name (English)</label>
                                        <input type="text"
                                            class="form-control @error('client_en_name') is-invalid @enderror"
                                            id="client_en_name" name="client_en_name" placeholder="Enter English Name"
                                            value="{{ old('client_en_name') }}">
                                        @error('client_en_name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="country_id">Country</label>
                                        <select class="form-control @error('country_id') is-invalid @enderror"
                                            id="country_id" name="country_id">
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}"
                                                    {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                                    {{ $country->name_en }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="website_url">Website URL (Optional)</label>
                                        <input type="url"
                                            class="form-control @error('website_url') is-invalid @enderror" id="website_url"
                                            name="website_url" placeholder="https://example.com"
                                            value="{{ old('website_url') }}">
                                        @error('website_url')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="client_logo">Client Logo</label>
                                        <input type="file"
                                            class="form-control-file @error('client_logo') is-invalid @enderror"
                                            id="client_logo" name="client_logo">
                                        @error('client_logo')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">
                            <button type="submit" class="btn btn-success">Submit</button>
                            <a href="{{ route('admin.client.index') }}" class="btn btn-danger">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
