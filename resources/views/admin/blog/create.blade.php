@extends('layouts.app')
@section('content')
    <form id="home-settings-form" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($blog))
            @method('PUT')
        @endif

        <div class="d-flex flex-column gap-2 ">
            @component('admin.components.container', [
                'title' => isset($blog) ? 'Update Blog' : 'Create Blog',
            ])
                <div class="row g-2">
                    <div class="col-lg-6">

                        @include('admin.components.forms.input', [
                            'name' => 'title',
                            'label' => 'Title',
                            'required' => true,
                            'id' => 'title',
                            'value' => old('title', $blog->title ?? ''),
                        ])
                    </div>



                    <div class="col-lg-12">
                        @include('admin.components.forms.text-area', [
                            'name' => 'description',
                            'label' => 'Description',
                            'required' => true,
                            'id' => 'description',
                            'value' => old('description', $blog->description ?? ''),
                        ])
                    </div>



                    <div class="col-lg-12">
                        @include('admin.components.forms.text-area', [
                            'name' => 'body',
                            'label' => 'Body',
                            'required' => true,
                            'id' => 'body',
                            'value' => old('body', $blog->body ?? ''),
                        ])
                    </div>




                    <div class="col-lg-6">
                        @include('admin.components.forms.file-uploader', [
                            'name' => 'image',
                            'label' => 'Image',
                            'required' => true,
                            'id' => 'image',
                            'value' => old(
                                'image',
                                isset($blog) && $blog->image ? asset('storage/' . $blog->image) : ''),
                        ])


                    </div>









                    <div class="col-lg-6">

                        @include('admin.components.forms.select', [
                            'name' => 'category_id',
                            'label' => 'Categories',
                            'options' => $categories->map(function ($category) {
                                    return [
                                        'value' => $category->id,
                                        'label' => $category->name,
                                    ];
                                })->toArray(),
                            'id' => 'category_id',
                            'classes' => 'select2',
                            'multiple' => true,
                            'default' => isset($blog) ? $blog->Categories->pluck('id')->toArray() : [],
                            'required' => true,
                        ])

                    </div>




                    <div class="col-lg-6">

                        @include('admin.components.forms.select', [
                            'name' => 'tags',
                            'label' => 'Tags',
                            'options' => isset($blog)
                                ? $blog->Tags->map(function ($tag) {
                                        return [
                                            'value' => $tag->name,
                                            'label' => $tag->name,
                                        ];
                                    })->toArray()
                                : [],
                            'id' => 'tags',
                            'classes' => 'selectTags2',
                            'multiple' => true,
                            'default' => isset($blog) ? $blog->Tags->pluck('name')->toArray() : [],
                        ])

                    </div>




                </div>
            @endcomponent







            {{-- sumbit button --}}
            @component('admin.components.container')
                <button type="submit" form="home-settings-form" class="btn btn-success">Save Blog</button>
            @endcomponent




        </div>


    </form>
@endsection
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.14.1/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('body');
        CKEDITOR.replace('description');

        $('#home-settings-form').validate({

            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass('is-valid').removeClass('is-invalid');
            },
            submitHandler: function(form) {
                const formData = new FormData(form);

                formData.append('body', CKEDITOR.instances['body'].getData());
                formData.append('description', CKEDITOR.instances['description'].getData());



                axios.post(
                        "{{ isset($blog) ? route('admin.blog.update', $blog->id) : route('admin.blog.store') }}",
                        formData)
                    .then(response => {

                        Swal.fire({
                            icon: 'success',
                            title: response.data.message || 'Blog updated successfully.',

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

        $('.selectTags2').select2({
            width: '100%',
            tags: true,
        });
    </script>
@endpush
