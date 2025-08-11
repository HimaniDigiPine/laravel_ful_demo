@extends('admin.layouts.master')

@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">

        <div class="card">
            <div class="card-header border-0 pt-6">
                <h2 class="card-title">Create New User</h2>
                <div class="card-toolbar">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light-primary">
                        <i class="ki-duotone ki-arrow-left fs-2"></i> Back to List
                    </a>
                </div>
            </div>

            <div class="card-body pt-0">
                <form id="userForm" action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-6">
                        <div class="col-md-6">
                            <label class="required form-label">First Name</label>
                            <input type="text" name="firstname" class="form-control" placeholder="Enter first name" required />
                        </div>

                        <div class="col-md-6">
                            <label class="required form-label">Last Name</label>
                            <input type="text" name="lastname" class="form-control" placeholder="Enter last name" required />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-md-6">
                            <label class="required form-label">Phone Number</label>
                            <input type="text" name="phonenumber" class="form-control" placeholder="Enter phone number" required />
                        </div>

                        <div class="col-md-6">
                            <label class="required form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter email" required />
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-md-6">
                            <label class="required form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="">-- Select Role --</option>
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ki-duotone ki-plus fs-2"></i> Create User
                        </button>
                    </div>
                </form>
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
        $('#userForm').validate({
            rules: {
                firstname: {
                    required: true,
                    maxlength: 50
                },
                lastname: {
                    required: true,
                    maxlength: 50
                },
                phonenumber: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 15
                },
                email: {
                    required: true,
                    email: true
                },
                role: {
                    required: true
                }
            },
            messages: {
                firstname: {
                    required: "First name is required",
                    maxlength: "Max 50 characters allowed"
                },
                lastname: {
                    required: "Last name is required",
                    maxlength: "Max 50 characters allowed"
                },
                phonenumber: {
                    required: "Phone number is required",
                    digits: "Only digits allowed",
                    minlength: "Minimum 10 digits",
                    maxlength: "Maximum 15 digits"
                },
                email: {
                    required: "Email is required",
                    email: "Enter a valid email"
                },
                role: {
                    required: "Please select a role"
                }
            },
            errorClass: 'text-danger',
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('text-danger mt-1');
                error.insertAfter(element);
            },
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            },
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
                            text: response.message || "User created successfully!"
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