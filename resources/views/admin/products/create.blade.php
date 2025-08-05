@extends('admin.layouts.master')

@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Add Product</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Add Product</li>
            </ul>
        </div>

        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>
<!--end::Toolbar-->

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100">
                    <div class="card-header pt-7">
                        <div class="card-title">
                            <h2>Create Product</h2>
                        </div>
                    </div>
                    <div class="card-body pt-5">

                        <form id="createProductForm" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Name -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3"><span class="required">Product Name</span></label>
                                <input type="text" class="form-control form-control-solid" name="name" id="name" required />
                            </div>

                            <!-- Slug -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3"><span class="required">Slug</span></label>
                                <input type="text" class="form-control form-control-solid" name="slug" id="slug" required />
                            </div>

                            <!-- Category -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3"><span class="required">Category</span></label>
                                <select class="form-control form-select form-select-solid" name="category_id" id="category_id" required>
                                    <option value="">--Select Category--</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Subcategory -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">Subcategory</label>
                                <select class="form-control form-select form-select-solid" name="sub_category_id" id="sub_category_id">
                                    <option value="">--Select Subcategory--</option>
                                </select>
                            </div>

                            <!-- Price -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3"><span class="required">Price ($)</span></label>
                                <input type="number" class="form-control form-control-solid" name="price" required />
                            </div>

                            <!-- Description -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">Description</label>
                                <textarea class="form-control form-control-solid" name="description" rows="3"></textarea>
                            </div>

                            <!-- Image -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">Product Image</label>
                                <div class="mt-1">
                                    <!--begin::Image placeholder-->
                                    <style>
                                        .image-input-placeholder {
                                            background-image: url("{{ asset('admin-assets/images/svg/files/blank-image.svg') }}");
                                        }

                                        [data-bs-theme="dark"] .image-input-placeholder {
                                            background-image: url("{{ asset('admin-assets/images/svg/files/blank-image-dark.svg') }}");
                                        }
                                    </style>
                                    <!--end::Image placeholder-->
                                    <!--begin::Image input-->
                                    <div class="image-input image-input-outline image-input-placeholder image-input-empty image-input-empty" data-kt-image-input="true">
                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-100px h-100px" style="background-image: url('')"></div>
                                        <!--end::Preview existing avatar-->
                                        <!--begin::Edit-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <!--begin::Inputs-->
                                            <input type="file" name="image" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                            <!--end::Inputs-->
                                        </label>
                                        <!--end::Edit-->
                                        <!--begin::Cancel-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <!--end::Cancel-->
                                        <!--begin::Remove-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <!--end::Image input-->
                                </div>
                                <!--end::Image input wrapper-->
                            </div>

                            <!-- Status -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3"><span class="required">Status</span></label>
                                <select class="form-control form-select form-select-solid" name="status" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('admin.products.index') }}" class="btn btn-light me-3">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Create</span>
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
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {

    // Slug auto-generate
    $('#name').on('keyup', function () {
        let slug = $(this).val().toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');
        $('#slug').val(slug);
    });

    // Load subcategories via AJAX
    $('#category_id').on('change', function () {
        var categoryId = $(this).val();
        $('#sub_category_id').html('<option value="">Loading...</option>');
        if (categoryId) {
            $.ajax({
                url: '/admin/get-subcategories/' + categoryId,
                type: 'GET',
                success: function (data) {
                    $('#sub_category_id').empty();
                    if (data.length > 0) {
                        $('#sub_category_id').append('<option value="">Select Subcategory</option>');
                        $.each(data, function (key, subcat) {
                            $('#sub_category_id').append('<option value="' + subcat.id + '">' + subcat.name + '</option>');
                        });
                    } else {
                        $('#sub_category_id').append('<option value="">No subcategories found</option>');
                    }
                },
                error: function () {
                    $('#sub_category_id').html('<option value="">Error loading</option>');
                }
            });
        } else {
            $('#sub_category_id').html('<option value="">Select Category First</option>');
        }
    });


    $.validator.addMethod("decimal", function(value, element) {
        return this.optional(element) || /^\d+(\.\d{1,2})?$/.test(value);
    }, "Enter a valid price");

    // jQuery Validation + AJAX submit
    $('#createProductForm').validate({
        rules: {
            name: { required: true, minlength: 3 },
            slug: { required: true },
            category_id: { required: true },
            price: { required: true },
            status: { required: true }
        },
        messages: {
            name: "Enter Product Name",
            slug: "Enter Slug",
            category_id: "Select Category",
            price: "Enter a valid price",
            status: "Select status"
        },
        errorClass: 'text-danger',
        errorElement: 'span',
        submitHandler: function (form) {
            let formData = new FormData(form);
            $.ajax({
                url: $(form).attr('action'),
                type: 'POST',
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
                        text: response.message
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