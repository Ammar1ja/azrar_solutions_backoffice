@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <div class="page-header">
            <h4 class="page-title">Clients</h4>
        </div>

        @component('admin.components.container', [
            'title' => isset($client) ? 'Edit Client: ' . $client->client_en_name : 'Create New Client',
            'buttons' => [['text' => 'Cancel', 'url' => route('admin.client.index'), 'type' => 'danger']],
        ])
            {{-- Added ID "client-form" to the form tag --}}
            <form id="client-form"
                action="{{ isset($client) ? route('admin.client.update', $client->id) : route('admin.client.store') }}"
                method="POST" enctype="multipart/form-data">

                @csrf
                @if (isset($client))
                    @method('PUT')
                @endif

                <div class="row">
                    {{-- Arabic Name --}}
                    <div class="col-md-6">
                        @include('admin.components.forms.input', [
                            'name' => 'client_ar_name',
                            'label' => 'Client Name (Arabic)',
                            'value' => old('client_ar_name', $client->client_ar_name ?? ''),
                            'required' => true,
                            'id' => 'client_ar_name',
                        ])
                    </div>

                    {{-- English Name --}}
                    <div class="col-md-6">
                        @include('admin.components.forms.input', [
                            'name' => 'client_en_name',
                            'label' => 'Client Name (English)',
                            'value' => old('client_en_name', $client->client_en_name ?? ''),
                            'required' => true,
                            'id' => 'client_en_name',
                        ])
                    </div>

                    {{-- Country Select --}}
                    <div class="col-md-6">
                        @include('admin.components.forms.select', [
                            'name' => 'country_id',
                            'label' => 'Country',
                            'options' => $countries->map(
                                    fn($c) => [
                                        'value' => $c->id,
                                        'label' => $c->name_en,
                                    ])->toArray(),
                            'default' => old('country_id', $client->country_id ?? ''),
                            'required' => true,
                        ])
                    </div>

                    {{-- Website URL --}}
                    <div class="col-md-6">
                        @include('admin.components.forms.input', [
                            'type' => 'url',
                            'name' => 'website_url',
                            'label' => 'Website URL (Optional)',
                            'value' => old('website_url', $client->website_url ?? ''),
                            'id' => 'website_url',
                        ])
                    </div>

                    {{-- File Uploader (Logo) --}}
                    <div class="col-md-12">
                        @include('admin.components.forms.file-uploader', [
                            'name' => 'client_logo',
                            'label' => 'Client Logo',
                            'accept' => 'image/*',
                            'required' => !isset($client),
                            'id' => 'client_logo',
                            'value' =>
                                isset($client) && $client->client_logo
                                    ? asset('storage/' . $client->client_logo)
                                    : '',
                        ])
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-success">
                        {{ isset($client) ? 'Update Client' : 'Submit' }}
                    </button>
                </div>
            </form>
        @endcomponent
    </div>
@endsection

@push('scripts')
    <script>
        $('#client-form').validate({
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            },
            submitHandler: function(form) {
                const formData = new FormData(form);
                // Dynamically determine the URL based on create or edit mode
                const url =
                    "{{ isset($client) ? route('admin.client.update', $client->id) : route('admin.client.store') }}";

                axios.post(url, formData)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: response.data.message || 'Client saved successfully.',
                        }).then(() => {
                            // Redirect to index after success
                            window.location.href = "{{ route('admin.client.index') }}";
                        });
                    })
                    .catch(error => {
                        let errorMessage = 'An error occurred while saving.';
                        if (error.response && error.response.data.message) {
                            errorMessage = error.response.data.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: errorMessage
                        });
                    });
                return false; // Prevent default form submit
            }
        });
    </script>
@endpush
