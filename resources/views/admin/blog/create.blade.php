@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Create New Blog</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" id="blogForm">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="title">Blog Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter title">
                    </div>

                    <div class="form-group mb-3">
                        <label for="category_id">Category</label>
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="description">Short Description</label>
                        <textarea name="description" rows="2" class="form-control" placeholder="Brief summary..."></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="body">Blog Body Content</label>
                        <textarea name="body" rows="6" class="form-control" placeholder="Write full content here..."></textarea>
                    </div>

                    <div class="form-group mb-3">
                        <label for="image">Featured Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Publish Blog</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/additional-methods.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#blogForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 5
                    },
                    category_id: {
                        required: true
                    },
                    description: {
                        required: true,
                        maxlength: 500
                    },
                    body: {
                        required: true,
                        minlength: 50
                    },
                    image: {
                        required: true,
                        extension: "jpg|jpeg|png|webp"
                    }
                },
                messages: {
                    category_id: "Please select a category",
                    body: "Content must be at least 50 characters long"
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endpush
