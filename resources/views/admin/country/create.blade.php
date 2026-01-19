@extends('layouts.app')

@section('content')
    <div class="page-inner">
        @component('admin.components.container', [
            'title' => 'Add New Country',
            'buttons' => [['text' => 'Back to List', 'url' => route('admin.country.index'), 'type' => 'secondary']],
        ])
            <form action="{{ route('admin.country.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Country Name (English)</label>
                            <input type="text" name="name_en" class="form-control @error('name_en') is-invalid @enderror"
                                value="{{ old('name_en') }}" placeholder="e.g. Jordan">
                            @error('name_en')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Country Name (Arabic)</label>
                            <input type="text" name="name_ar" class="form-control @error('name_ar') is-invalid @enderror"
                                value="{{ old('name_ar') }}" placeholder="الأردن">
                            @error('name_ar')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>ISO2 Code</label>
                            <input type="text" name="iso2" class="form-control @error('iso2') is-invalid @enderror"
                                value="{{ old('iso2') }}" placeholder="JO">
                            @error('iso2')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Flag Emoji (Optional)</label>
                            <input type="text" name="flag" class="form-control" value="{{ old('flag') }}"
                                placeholder="🇯🇴">
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-success">Save Country</button>
                </div>
            </form>
        @endcomponent
    </div>
@endsection
