@extends('admin.layouts.master')

@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Add New Product</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Products</li>
            </ul>
        </div>
        <div class="d-flex align-items-center gap-2 gap-lg-3">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
</div>

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-7">
            <div class="col-xl-12">
                <div class="card card-flush h-lg-100" id="kt_contacts_main">
                    <div class="card-header pt-7">
                        <div class="card-title">
                            <i class="ki-duotone ki-badge fs-1 me-2"></i>
                            <h2>Add New Product</h2>
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

                        <form id="productForm" class="form" method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Product Name -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Product Name</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="name" id="name" required />
                            </div>

                            <!-- Slug -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Slug</span>
                                </label>
                                <input type="text" class="form-control form-control-solid" name="slug" id="slug" required />
                            </div>

                            <!-- Category -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Category</span>
                                </label>
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

                            <!-- Image -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">Product Image</label>
                                <input type="file" class="form-control form-control-solid" name="image" accept="image/*" />
                            </div>

                            <!-- Description -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">Description</label>
                                <textarea class="form-control form-control-solid" name="description" rows="3"></textarea>
                            </div>

                            <!-- Price -->
                            <div class="fv-row mb-7">
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Price</span>
                                </label>
                                <input type="number" step="0.01" class="form-control form-control-solid" name="price" required />
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
    $('#name').on('keyup', function () {
        let slug = $(this).val().toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');
        $('#slug').val(slug);
    });

    // Load subcategories dynamically
    $('#category_id').on('change', function () {
        let categoryId = $(this).val();
        $('#sub_category_id').html('<option value="">Loading...</option>');

        if (categoryId) {
            $.ajax({
                url: "{{ url('/admin/get-subcategories') }}/" + categoryId,
                type: "GET",
                success: function (data) {
                    let options = '<option value="">--Select Subcategory--</option>';
                    data.forEach(function (subcategory) {
                        options += `<option value="${subcategory.id}">${subcategory.name}</option>`;
                    });
                    $('#sub_category_id').html(options);
                },
                error: function () {
                    $('#sub_category_id').html('<option value="">No subcategories found</option>');
                }
            });
        } else {
            $('#sub_category_id').html('<option value="">--Select Subcategory--</option>');
        }
    });

    // Validate and submit form
    $('#productForm').validate({
        rules: {
            name: { required: true, minlength: 3 },
            slug: { required: true },
            category_id: { required: true },
            price: { required: true, number: true },
            status: { required: true }
        },
        messages: {
            name: { required: "Enter Product Name", minlength: "Minimum 3 characters" },
            slug: { required: "Slug is required" },
            category_id: { required: "Select a category" },
            price: { required: "Enter product price", number: "Price must be a number" },
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
                        text: response.message || "Product created successfully!"
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