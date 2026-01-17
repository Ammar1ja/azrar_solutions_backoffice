@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Blogs</h1>

        <!-- Success message -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- DataTable -->
        {!! $dataTable->table(['class' => 'table table-bordered table-striped table-hover'], true) !!}
    </div>
@endsection

@section('scripts')
    {!! $dataTable->scripts() !!}
@endsection
