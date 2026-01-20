@extends('layouts.app')
@section('content')
   
    <form id="home-settings-form" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($faq))
            @method('PUT')
            
        @endif

        <div class="d-flex flex-column gap-2 ">
@component('admin.components.container',[
        'title' =>isset($faq) ?  'Update Faq' : 'Create Faq',
    ])
 

        <div class="row g-2">
            <div class="col-lg-6">

                @include('admin.components.forms.text-area', [
                    'name' => 'en_question',
                    'label' => 'English Question',
                    'required' => true,
                    'id' => 'en_question',
                    'value' => old('en_question', $faq->en_question ?? '')
                ])
    </div>


            <div class="col-lg-6">
                @include('admin.components.forms.text-area', [
                    'name' => 'ar_question',
                    'label' => 'Arabic Question',
                    'required' => true,
                    'id' => 'ar_question',
                    'value' => old('ar_question', $faq->ar_question ?? '')
                ])

                    </div>



            <div class="col-lg-6">
                @include('admin.components.forms.text-area', [
                    'name' => 'en_answer',
                    'label' => 'English Answer',
                    'required' => true,
                    'id' => 'en_answer',
                    'value' => old('en_answer', $faq->en_answer ?? '')
                ])
                </div>


            <div class="col-lg-6">
                @include('admin.components.forms.text-area', [
                    'name' => 'ar_answer',
                    'label' => 'Arabic Answer',
                    'required' => true,
                    'id' => 'ar_answer',
                    'value' => old('ar_answer', $faq->ar_answer ?? '')
                ])
                </div>


            



                  


          
                                </div>


    @endcomponent


  



    {{-- sumbit button --}}
    @component('admin.components.container')
        <button type="submit" form="home-settings-form" class="btn btn-success">Save Faq</button>
    @endcomponent




        </div>
    

                                </form>

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



                axios.post("{{isset($faq) ?route('admin.faq.update',$faq->id) : route('admin.faq.store') }}", formData)
                    .then(response => {

                        Swal.fire({
                            icon: 'success',
                            title: response.data.message || 'Faq updated successfully.',
                            
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            icon: 'error',
                            title: 'An error occurred while updating Faq.',
                            text: error.response.data.message || 'Please try again later.'
                        });
                    });
                return false;
            }
        });


</script>

@endpush