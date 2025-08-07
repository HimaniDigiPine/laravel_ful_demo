@extends('admin.layouts.master')

@section('content')

<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Add New Gallery</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Gallery</li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_contacts_main">
                    <div class="card-header pt-7">
                        <div class="card-title">
                            <h2>Add New Gallery</h2>
                        </div>
                    </div>

                    <div class="card-body pt-5">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form id="galleryForm" class="form" method="POST" action="{{ route('admin.galleries.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Title -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Title</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="title" id="title" required />
                            </div>

                            <!-- Slug -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Slug</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="slug" id="slug" required />
                            </div>

                            <!-- Image Upload -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Upload Image</span>
                                </label>
                                <input type="file" class="form-control form-control-solid" name="image" id="image" accept="image/*" required />
                                <div id="preview" class="mt-2"></div>
                            </div>

                            <!-- Status -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Status</span>
                                </label>
                                <select class="form-control form-select form-select-solid" name="status" required>
                                    <option value="">--Select Status--</option>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="separator mb-6"></div>

                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light me-3">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Save</span>
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
<script>
$(document).ready(function () {

    // Auto-generate slug
    $('#title').on('keyup', function () {
        let slug = $(this).val().toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');
        $('#slug').val(slug);
    });

    // Image Preview
    $('#image').on('change', function () {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('#preview').html('<img src="'+e.target.result+'" width="150" class="mt-2"/>');
        }
        reader.readAsDataURL(this.files[0]);
    });

    // Validate
    $('#galleryForm').validate({
        rules: {
            title: { required: true, minlength: 3 },
            slug: { required: true },
            image: { required: true, extension: "jpg|jpeg|png|gif" },
            status: { required: true }
        },
        messages: {
            title: { required: "Enter title", minlength: "Minimum 3 characters" },
            slug: { required: "Slug is required" },
            image: { required: "Upload an image", extension: "Only jpg, jpeg, png, gif allowed" },
            status: { required: "Select status" }
        },
        errorClass: 'text-danger',
        errorElement: 'span',
        highlight: function (element) { $(element).addClass('is-invalid'); },
        unhighlight: function (element) { $(element).removeClass('is-invalid'); },

        submitHandler: function (form) {
            let formData = new FormData(form);

            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $('.indicator-label').hide();
                    $('.indicator-progress').show();
                },
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Success",
                        text: response.message || "Gallery created successfully!"
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Error",
                        text: xhr.responseJSON?.message || "Something went wrong!"
                    });
                },
                complete: function () {
                    $('.indicator-label').show();
                    $('.indicator-progress').hide();
                }
            });
            return false;
        }
    });

});
</script>
@endpush