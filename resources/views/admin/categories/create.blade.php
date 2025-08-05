@extends('admin.layouts.master')

@section('content')

<!--begin::Toolbar-->
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
	<!--begin::Toolbar container-->
	<div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
		<!--begin::Page title-->
		<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
			<!--begin::Title-->
			<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Add New Category</h1>
			<!--end::Title-->
			<!--begin::Breadcrumb-->
			<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">
					<a href="{{ route('home') }}" class="text-muted text-hover-primary">Home</a>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item">
					<span class="bullet bg-gray-400 w-5px h-2px"></span>
				</li>
				<!--end::Item-->
				<!--begin::Item-->
				<li class="breadcrumb-item text-muted">Category</li>
				<!--end::Item-->
			</ul>
			<!--end::Breadcrumb-->
		</div>
		<!--end::Page title-->
		<!--begin::Actions-->
		<div class="d-flex align-items-center gap-2 gap-lg-3">
			
			<a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Back</a>
		</div>
		<!--end::Actions-->
	</div>
	<!--end::Toolbar container-->
</div>
<!--end::Toolbar-->

<!--begin::Content-->
<div id="kt_app_content" class="app-content flex-column-fluid">
	<!--begin::Content container-->
	<div id="kt_app_content_container" class="app-container container-xxl">
		<!--begin::Contacts App- Add New Contact-->
		<div class="row g-7">
			<!--begin::Content-->
			<div class="col-xl-12">
				<!--begin::Contacts-->
				<div class="card card-flush h-lg-100" id="kt_contacts_main">
					<!--begin::Card header-->
					<div class="card-header pt-7" id="kt_chat_contacts_header">
						<!--begin::Card title-->
						<div class="card-title">
							<i class="ki-duotone ki-badge fs-1 me-2">
								<span class="path1"></span>
								<span class="path2"></span>
								<span class="path3"></span>
								<span class="path4"></span>
								<span class="path5"></span>
							</i>
							<h2>Add New Category</h2>
						</div>
						<!--end::Card title-->
					</div>
					<!--end::Card header-->
					<!--begin::Card body-->
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

						<!--begin::Form-->
						<form id="categoryForm" class="form" method="POST" action="{{ route('admin.categories.store') }}">
							@csrf
							<!--begin::Input group-->
							<div class="fv-row mb-7">
								<!--begin::Label-->
								<label class="fs-6 fw-semibold form-label mt-3">
									<span class="required">Category Name</span>
									<span class="ms-1" data-bs-toggle="tooltip" title="Enter the category name.">
										<i class="ki-duotone ki-information fs-7">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span>
								</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input type="text" class="form-control form-control-solid" name="name" id="name"  required />
								<!--end::Input-->
							</div>
							<!--end::Input group-->


							<!--begin::Input group-->
							<div class="fv-row mb-7">
								<!--begin::Label-->
								<label class="fs-6 fw-semibold form-label mt-3">
									<span class="required">Category Slug</span>
									<span class="ms-1" data-bs-toggle="tooltip" title="Enter the category name.">
										<i class="ki-duotone ki-information fs-7">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
										</i>
									</span>
								</label>
								<!--end::Label-->
								<!--begin::Input-->
								<input type="text" class="form-control form-control-solid" name="slug" id="slug"  required />
								<!--end::Input-->
							</div>
							<!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fs-6 fw-semibold form-label mt-3">
                                    <span class="required">Category Status</span>
                                    <span class="ms-1" data-bs-toggle="tooltip" title="Enter the category name.">
                                        <i class="ki-duotone ki-information fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                    </span>
                                </label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <div class="w-100">
                                    <!--begin::Select2-->
                                    <select id="kt_ecommerce_select2_country" class="form-control form-select form-select-solid " name="status" data-kt-ecommerce-settings-type="select2_flags" data-placeholder="Select a Status">
                                        <option value="">--Select Status --</option>
                                        <option value="active" >Active</option>
                                        <option value="inactive">Inactive</option>
                                    </select>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

							
							
							<!--begin::Separator-->
							<div class="separator mb-6"></div>
							<!--end::Separator-->
							<!--begin::Action buttons-->
							<div class="d-flex justify-content-end">
								<!--begin::Button-->
								<button type="reset" data-kt-contacts-type="cancel" class="btn btn-light me-3">Cancel</button>

								<!--end::Button-->
								<!--begin::Button-->
								<button type="submit" data-kt-contacts-type="submit" class="btn btn-primary">
									<span class="indicator-label">Save</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
								<!--end::Button-->
							</div>
							<!--end::Action buttons-->
						</form>
						<!--end::Form-->
					</div>
					<!--end::Card body-->
				</div>
				<!--end::Contacts-->
			</div>
			<!--end::Content-->
		</div>
		<!--end::Contacts App- Add New Contact-->
	</div>
	<!--end::Content container-->
</div>
<!--end::Content-->


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
    $('#categoryForm').validate({
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
                        text: response.message || "Category created successfully!"
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