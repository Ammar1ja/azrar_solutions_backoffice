@extends('layouts.app')
@section('content')


    <div class="d-flex flex-column gap-3">

        @component('admin.components.container', [
            'title' => 'Services',
            'buttons' => [
                [
                    'text' => 'Add Service',
                    'url' => route('admin.service.create'),
                    'type' => 'primary',
                ],
            ],
        ])
    <form id="filter-form" class="">

            <div class="row g-2">
        <div class="col-md-4">

                            @include('admin.components.forms.input', [
                                'label' => 'Feature',
                                'name' => 'feature',
                                'id' => 'feature',
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
@endpush