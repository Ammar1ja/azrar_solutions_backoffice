@extends('layouts.app')
@section('content')
   
    <form id="home-settings-form" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($project))
            @method('PUT')
            
        @endif

        <div class="d-flex flex-column gap-2 ">
@component('admin.components.container',[
        'title' =>isset($project) ?  'Update Project' : 'Create Project',
    ])
 

        <div class="row g-2">
            <div class="col-lg-6">

                @include('admin.components.forms.input', [
                    'name' => 'en_title',
                    'label' => 'English Title',
                    'required' => true,
                    'id' => 'en_title',
                    'value' => old('en_title', $project->en_title ?? '')
                ])
    </div>


            <div class="col-lg-6">
                @include('admin.components.forms.input', [
                    'name' => 'ar_title',
                    'label' => 'Arabic Title',
                    'required' => true,
                    'id' => 'ar_title',
                    'value' => old('ar_title', $project->ar_title ?? '')
                ])
                </div>




               


                

                    <div class="col-lg-6">
                @include('admin.components.forms.text-area', [
                    'name' => 'en_description',
                    'label' => 'English Description',
                    'required' => true,
                    'id' => 'en_description',
                    'value' => old('en_description', $project->en_description ?? '')
                ])
                </div>


                
                    <div class="col-lg-6">
                @include('admin.components.forms.text-area', [
                    'name' => 'ar_description',
                    'label' => 'Arabic Description',
                    'required' => true,
                    'id' => 'ar_description',
                    'value' => old('ar_description', $project->ar_description ?? '')
                ])
                </div>



                  <div class="col-lg-6">
                @include('admin.components.forms.input', [
                    'name' => 'project_url',
                    'label' => 'Project Url',
                    'required' => true,
                    'id' => 'project_url',
                    'value' => old('project_url', $project->project_url ?? ''),
                    'type'=>'url',
                ])
                </div>



                 <div class="col-lg-6">
             @include('admin.components.forms.input', [
                    'name' => 'date',
                    'label' => 'Project Date',
                    'required' => true,
                    'id' => 'date',
                    'value' => old('date', $project->date ?? ''),
                    'type'=>'date',
                ])
                </div>





                

                <div class="col-lg-6">
                @include('admin.components.forms.file-uploader', [
                    'name' => 'thumbnail',
                    'label' => 'Thumbnail',
                    'required' => true,
                    'id' => 'thumbnail',
                    'value' => old('thumbnail', isset($project) && $project->thumbnail ?  asset('storage/'.$project->thumbnail) :'')
                ])


                                </div>



                                <div class="col-lg-6">
                @include('admin.components.forms.file-uploader', [
                    'name' => 'project_video',
                    'label' => 'Project Video',
                    'required' => true,
                    'id' => 'project_video',
                    'value' => old('project_video', isset($project) && $project->project_video ?  asset('storage/'.$project->project_video) :'')
                ])


                                </div>





                <div class="col-lg-6">

            @include('admin.components.forms.select', [
                'name' => 'service_id',
                'label' => 'Service',
                'options' => $services->map(function($service) {
                    return [
                        'value' => $service->id,
                        'label' => $service->en_title,
                    ];
                })
                ->toArray(),
                'id' => 'service_id',
                'classes'=>'select2',
                'multiple'=>true,
                'default'=> isset($project) ? $project->Services->pluck('id')->toArray() : []
            ])
                        
        </div>


        <div class="col-lg-6">

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
                'classes'=>'select2',
                'default'=> old('client_id', $project->client_id ?? '')
            ])
            </div>


                                            <div class="col-lg-6">
                @include('admin.components.forms.input-toggle', [
                    'name' => 'featured',
                    'label' => 'Is Featured',
                    'required' => false,
                    'id' => 'featured',
                    'value' => old('featured', $project->featured ?? '')
                ])
                </div>


                                </div>


    @endcomponent







    {{-- sumbit button --}}
    @component('admin.components.container')
        <button type="submit" form="home-settings-form" class="btn btn-success">Save Project</button>
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



                axios.post("{{isset($project) ?route('admin.project.update',$project->id) : route('admin.project.store') }}", formData)
                    .then(response => {

                        Swal.fire({
                            icon: 'success',
                            title: response.data.message || 'Project updated successfully.',
                            
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


        $('.select2').select2({
            width: '100%'
        });


</script>

@endpush