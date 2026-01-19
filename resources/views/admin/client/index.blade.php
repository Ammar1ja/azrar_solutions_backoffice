@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column gap-3">
        @component('admin.components.container', [
            'title' => 'Clients Management',
            'buttons' => [['text' => 'Add Client', 'url' => route('admin.client.create'), 'type' => 'primary']],
        ])
            <form id="filter-form">
                <div class="row g-2">
                    <div class="col-md-4">
                        @include('admin.components.forms.input', [
                            'label' => 'Search Name',
                            'name' => 'name',
                            'id' => 'name_filter',
                        ])
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="button" onclick="reloadTable()" class="btn btn-primary">Filter</button>
                        <button type="button" onclick="resetTable()" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
            </form>
        @endcomponent

        @component('admin.components.container')
            {{ $dataTable->table() }}
        @endcomponent
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script>
        function reloadTable() {
            window.LaravelDataTables['client-table'].draw();
        }

        function resetTable() {
            $('#filter-form')[0].reset();
            reloadTable();
        }
    </script>
@endpush
