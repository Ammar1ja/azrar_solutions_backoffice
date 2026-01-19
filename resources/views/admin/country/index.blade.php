@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column gap-3">
        @component('admin.components.container', [
            'title' => 'Countries',
            'buttons' => [
                [
                    'text' => 'Add Country',
                    'url' => route('admin.country.create'),
                    'type' => 'primary',
                ],
            ],
        ])
            <p>Manage list of countries for client localization.</p>
        @endcomponent

        @component('admin.components.container')
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        @endcomponent
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
