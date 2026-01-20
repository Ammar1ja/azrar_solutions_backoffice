@extends('layouts.app')

@section('content')
    <div class="page-inner">
        <form id="country-form" method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($country))
                @method('PUT')
            @endif

            <div class="d-flex flex-column gap-2">
                @component('admin.components.container', [
                    'title' => isset($country) ? 'Update Country' : 'Add New Country',
                    'buttons' => [['text' => 'Back to List', 'url' => route('admin.country.index'), 'type' => 'secondary']],
                ])
                    <div class="row">
                        {{-- Name EN --}}
                        <div class="col-md-6">
                            @include('admin.components.forms.input', [
                                'name' => 'name_en',
                                'label' => 'Country Name (English)',
                                'placeholder' => 'e.g. Jordan',
                                'value' => old('name_en', $country->name_en ?? ''),
                                'required' => true,
                                'id' => 'name_en',
                            ])
                        </div>

                        {{-- Name AR --}}
                        <div class="col-md-6">
                            @include('admin.components.forms.input', [
                                'name' => 'name_ar',
                                'label' => 'Country Name (Arabic)',
                                'placeholder' => 'الأردن',
                                'value' => old('name_ar', $country->name_ar ?? ''),
                                'required' => true,
                                'id' => 'name_ar',
                            ])
                        </div>

                        {{-- ISO2 --}}
                        <div class="col-md-6">
                            @include('admin.components.forms.input', [
                                'name' => 'iso2',
                                'label' => 'ISO2 Code',
                                'placeholder' => 'JO',
                                'value' => old('iso2', $country->iso2 ?? ''),
                                'required' => true,
                                'id' => 'iso2',
                            ])
                        </div>

                        {{-- Flag --}}
                        <div class="col-md-6">
                            @include('admin.components.forms.file-uploader', [
                                'name' => 'flag',
                                'label' => 'Country Flag (Image)',
                                'id' => 'flag',
                                'accept' => 'image/*',
                                'required' => !isset($country),
                                'value' =>
                                    isset($country) && $country->flag ? asset('storage/' . $country->flag) : '',
                            ])
                        </div>
                    </div>
                @endcomponent

                {{-- Action Button Container --}}
                @component('admin.components.container')
                    <button type="submit" form="country-form" class="btn btn-success">
                        {{ isset($country) ? 'Update Country' : 'Save Country' }}
                    </button>
                @endcomponent
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $('#country-form').validate({
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
                const url =
                    "{{ isset($country) ? route('admin.country.update', $country->id) : route('admin.country.store') }}";

                axios.post(url, formData)
                    .then(response => {
                        Swal.fire({
                            icon: 'success',
                            title: response.data.message || 'Country saved successfully.',
                        }).then(() => {
                            window.location.href = "{{ route('admin.country.index') }}";
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response.data.message || 'Please check your inputs.'
                        });
                    });
                return false;
            }
        });
    </script>
@endpush
