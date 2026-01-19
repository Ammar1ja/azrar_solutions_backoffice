@extends('layouts.app')
@section('content')
   
    <form id="home-settings-form" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($service))
            @method('PUT')
            
        @endif

        <div class="d-flex flex-column gap-2 ">
@component('admin.components.container',[
        'title' =>isset($service) ?  'Update Service' : 'Create Service',
    ])
 

        <div class="row g-2">
            <div class="col-lg-6">

                @include('admin.components.forms.input', [
                    'name' => 'en_title',
                    'label' => 'English Title',
                    'required' => true,
                    'id' => 'en_title',
                    'value' => old('en_title', $service->en_title ?? '')
                ])
    </div>


            <div class="col-lg-6">
                @include('admin.components.forms.input', [
                    'name' => 'ar_title',
                    'label' => 'Arabic Title',
                    'required' => true,
                    'id' => 'ar_title',
                    'value' => old('ar_title', $service->ar_title ?? '')
                ])
                </div>



                    <div class="col-lg-6">

                @include('admin.components.forms.input', [
                    'name' => 'en_button_text',
                    'label' => 'English Button Text',
                    'required' => true,
                    'id' => 'en_button_text',
                    'value' => old('en_button_text', $service->en_button_text ?? '')
                ])
    </div>


            <div class="col-lg-6">
                @include('admin.components.forms.input', [
                    'name' => 'ar_button_text',
                    'label' => 'Arabic Button Text',
                    'required' => true,
                    'id' => 'ar_button_text',
                    'value' => old('ar_button_text', $service->ar_button_text ?? '')
                ])
                </div>


                

                    <div class="col-lg-6">
                @include('admin.components.forms.text-area', [
                    'name' => 'en_description',
                    'label' => 'English Description',
                    'required' => true,
                    'id' => 'en_description',
                    'value' => old('en_description', $service->en_description ?? '')
                ])
                </div>


                
                    <div class="col-lg-6">
                @include('admin.components.forms.text-area', [
                    'name' => 'ar_description',
                    'label' => 'Arabic Description',
                    'required' => true,
                    'id' => 'ar_description',
                    'value' => old('ar_description', $service->ar_description ?? '')
                ])
                </div>


                {{-- icon and image --}}
                <div class="col-lg-6">
                @include('admin.components.forms.file-uploader', [
                    'name' => 'icon',
                    'label' => 'Service Icon',
                    'required' => true,
                    'id' => 'icon',
                    'value' => old('icon', isset($service) && $service->icon ? asset('storage/'.$service->icon)  :'')
                ])

                </div>

                <div class="col-lg-6">
                @include('admin.components.forms.file-uploader', [
                    'name' => 'image',
                    'label' => 'Service Image',
                    'required' => true,
                    'id' => 'image',
                    'value' => old('image', isset($service) && $service->image ?  asset('storage/'.$service->image) :'')
                ])


                                </div>
                                </div>


    @endcomponent


    @component('admin.components.container',[
        'title'=>'Features',
        
        'buttons' => [
            [
                'type' => 'button',
                'text' => 'Add Feature',
                'classes' => 'btn btn-primary',
                'id' => 'add-feature-button',
                'onclick' => 'addFeatureRow()',
            ],
        ],
    ])


<div class="features_container">
   @if (isset($service))
                                    @foreach ($service->Features as $feature)
                                        @include('admin.service.components.feature-row', [
                                            'feature' => $feature,
                                        ])
                                        
                                    @endforeach

                                    @else
                                    @include('admin.service.components.feature-row')
                                @endif

</div>
                             
    
    @endcomponent



    {{-- sumbit button --}}
    @component('admin.components.container')
        <button type="submit" form="home-settings-form" class="btn btn-success">Save Service</button>
    @endcomponent




        </div>
    

                                </form>

@endsection
@push('scripts')

<script>
    function addFeatureRow() {
            let row =`@include('admin.service.components.feature-row',['is_new'=>true])`;
            row =row.replaceAll('new_row', Date.now());
            $('.features_container').append(row);


    }




    
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



                axios.post("{{isset($service) ?route('admin.service.update',$service->id) : route('admin.service.store') }}", formData)
                    .then(response => {

                        Swal.fire({
                            icon: 'success',
                            title: response.data.message || 'Service updated successfully.',
                            
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