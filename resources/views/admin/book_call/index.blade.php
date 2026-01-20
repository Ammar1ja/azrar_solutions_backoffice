@extends('layouts.app')
@section('content')


    <div class="d-flex flex-column gap-3">

        @component('admin.components.container', [
            'title' => 'Book Call',
           
        ])
  

        @endcomponent

    @component('admin.components.container')

                        {{ $dataTable->table() }}
    @endcomponent


@endsection

</div>



@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush