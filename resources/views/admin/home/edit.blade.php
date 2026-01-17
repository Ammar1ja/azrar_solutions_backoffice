@extends('layouts.app')
@section('content')

    @component('admin.components.container')
    <h1>Edit Home Settings</h1>
    <form id="home-settings-form" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- @method('PUT') --}}

        <div class="row g-2">
            <div class="col-lg-6">

                @include('admin.components.forms.input', [
                    'name' => 'hero_en_title',
                    'label' => 'Hero English Title',
                    'required' => true,
                    'id' => 'hero_en_title',
                    'value' => old('hero_en_title', $settings->hero_en_title ?? '')
                ])
                            </div>
                                        <div class="col-lg-6">
                                                @include('admin.components.forms.input', [
                                                    'name' => 'hero_ar_title',
                                                    'label' => 'Hero Arabic Title',
                                                    'required' => true,
                                                    'id' => 'hero_ar_title',
                                                    'value' => old('hero_ar_title', $settings->hero_ar_title ?? '')

                                                ])
                    </div>

            {{-- subtitle --}}
                <div class="col-lg-6">
            @include('admin.components.forms.input', [
                'name' => 'hero_en_subtitle',
                'label' => 'Hero English Subtitle',
                'required' => true,
                'id' => 'hero_en_subtitle',
                'value' => old('hero_en_subtitle', $settings->hero_en_subtitle ?? '')
            ])
                    </div>

                                        <div class="col-lg-6">
                                            @include('admin.components.forms.input', [
                                                'name' => 'hero_ar_subtitle',
                                                'label' => 'Hero Arabic Subtitle',
                                                'required' => true,
                                                'id' => 'hero_ar_subtitle',
                                                'value' => old('hero_ar_subtitle', $settings->hero_ar_subtitle ?? '')
                                            ])
                                            </div>



                                            {{-- button text --}}
                    <div class="col-lg-6">
        @include('admin.components.forms.input', [
            'name' => 'hero_en_button_text',
            'label' => 'Hero English Button Text',
            'required' => true,
            'id' => 'hero_en_button_text',
            'value' => old('hero_en_button_text', $settings->hero_en_button_text ?? '')
        ])
                </div>
                                        <div class="col-lg-6">
                                @include('admin.components.forms.input', [
                                    'name' => 'hero_ar_button_text',
                                    'label' => 'Hero Arabic Button Text',
                                    'required' => true,
                                    'id' => 'hero_ar_button_text',
                                    'value' => old('hero_ar_button_text', $settings->hero_ar_button_text ?? '')
                                ])
                                    </div>
                                        {{-- video file uploader --}}
                    <div class="col-lg-6">
                @include('admin.components.forms.file-uploader', [
                    'name' => 'hero_background',
                    'label' => 'Hero Video',
                    'required' => true,
                    'value' => $settings->hero_background ? asset('storage/' . $settings->hero_background) : ''
                ])
                </div>
        </div>


                    <button type="submit" class="btn btn-primary">Save Settings</button>
                </form>
    @endcomponent
@endsection
    
    
    
    @push('scripts')

            <script>



          $('#home-settings-form').validate({

                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element, errorClass, validClass
        ) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            },
            submitHandler: function (form) {
                const formData = new FormData(form);



                axios.post("{{ route('admin.home.update') }}", formData)
                    .then(response => {

                        Swal.fire({
                            icon: 'success',
                            title: 'Settings updated successfully!',
                            
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred while updating settings.',
                            text: error.response.data.message || 'Please try again later.'
                        });
                    });
                return false;
            }
        });




        </script>
    @endpush