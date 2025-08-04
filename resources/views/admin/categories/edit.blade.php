@extends('admin.layouts.master')

@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Edit Category</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Edit Category</li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_contacts_main">
                    <div class="card-header pt-7">
                        <div class="card-title">
                            <h2>Edit Category</h2>
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

                        <form id="editCategoryForm" class="form" method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                            @csrf
                            @method('PUT')

                            <!-- Category Name -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Category Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" id="name"
                                       value="{{ old('name', $category->name) }}" required />
                            </div>

                            <!-- Slug -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Category Slug</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="slug" id="slug"
                                       value="{{ old('slug', $category->slug) }}" required />
                            </div>

                            <!-- Status -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Category Status</span>
                                </label>
                                <select class="form-control form-select form-select-solid" name="status" required>
                                    <option value="active" {{ $category->status == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $category->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="separator mb-6"></div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Update</span>
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
    $('#name').on('keyup', function () {
        let slug = $(this).val().toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');
        $('#slug').val(slug);
    });

    // Custom validation rules
    $.validator.addMethod("noNumbers", function (value) {
        return !/\d/.test(value);
    }, "Name must not contain numbers.");

    $.validator.addMethod("noSpaces", function (value) {
        return value.trim().length > 0;
    }, "Field cannot be empty or spaces only.");

    // Initialize validation
    $('#editCategoryForm').validate({
        rules: {
            name: { required: true, minlength: 3, noNumbers: true, noSpaces: true },
            slug: { required: true },
            status: { required: true }
        },
        messages: {
            name: {
                required: "Enter Category Name",
                minlength: "Minimum 3 characters"
            },
            slug: { required: "Slug is required" },
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
                        text: response.message || "Category Updated successfully!"
                    }).then(() => {
                        // Redirect to index
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
            return false; // Prevent default submit
        }
    });

});
</script>

@endpush