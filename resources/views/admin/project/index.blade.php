@extends('layouts.app')
@section('content')


    <div class="d-flex flex-column gap-3">

        @component('admin.components.container', [
            'title' => 'Projects',
            'buttons' => [
                [
                    'text' => 'Add Project',
                    'url' => route('admin.project.create'),
                    'type' => 'primary',
                ],
            ],
        ])
    <form id="filter-form" class="">

            <div class="row g-2">
        <div class="col-md-4">

            @include('admin.components.forms.select', [
                'name' => 'service_id',
                'label' => 'Service',
                'options' => $services->map(function($service) {
                    return [
                        'value' => $service->id,
                        'label' => $service->en_title,
                    ];
                })
                ->prepend(['value' => '', 'label' => 'All Services'])
                ->toArray(),
                'id' => 'service_id',
                'classes'=>'select2'
            ])
                        
        </div>


        <div class="col-md-4">

            @include('admin.components.forms.select', [
                'name' => 'client_id',
                'label' => 'Client',
                'options' => $clients->map(function($client) {
                    return [
                        'value' => $client->id,
                        'label' => $client->en_name,
                    ];
                })
                ->prepend(['value' => '', 'label' => 'All Clients'])
                ->toArray(),
                'id' => 'client_id',
                'classes'=>'select2'
            ])
            </div>



        {{-- filter and reset --}}
        <div class="col-md-4 ">
            
            <div class="form-group">
            <label>&nbsp;</label>
            <div class="d-flex align-items-end gap-2">
            <button type="button" 
            onclick="reloadTable()"
            class="btn btn-primary">Filter</button>
            <button 
            type="button" 
            onclick="resetTable()"
            class="btn btn-secondary">Reset</button>
            </div>
        </div>
    </div>  
            </div>
        </form>

        @endcomponent

    @component('admin.components.container')

                        {{ $dataTable->table() }}
    @endcomponent


@endsection

</div>



@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}


    <script>

        $(document).ready(function() {
    $('.select2').select2({
        width: '100%'
    });
});

</script>
@endpush