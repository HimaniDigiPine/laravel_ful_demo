@extends('frontend.layouts.master')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<main>
    <!-- Breadcrumb area start -->
    <div class="breadcrumb__area theme-bg-1 p-relative z-index-11 pt-95 pb-95">
        <div class="breadcrumb__thumb" data-background="{{ asset('frontend-assets/imgs/bg/breadcrumb-bg.jpg') }}"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="breadcrumb__wrapper text-center">
                        <h2 class="breadcrumb__title">Registration</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><span><a href="{{ route('userdashboard') }}">Home</a></span></li>
                                    <li><span>Registration</span></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb area end -->

    <!-- Contact area start -->
    <div class="contact-area section-space">
        <div class="container">
            <div class="contact-wrapper pt-80">
                <div class="row gy-50">
                    <div class="col-xxl-6 col-xl-6">
                        <div class="contact-map">
                            <img src="{{ asset('frontend-assets/imgs/Registration.jpg') }}" alt="Registration">
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6">
                        <div class="contact-from">
                            <div id="registrationMessage" style="margin-bottom: 10px; font-weight: bold;"></div>
                            <form id="registrationForm" action="" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="text" name="firstname" id="firstname" placeholder="First Name*" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="text" name="lastname" id="lastname" placeholder="Last Name*" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="email" name="email" id="email" placeholder="Email*" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="text" name="phonenumber" id="phonenumber" placeholder="Phonenumber*" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="password" name="password" id="password" placeholder="Password*" >
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confrim Password*" >
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="appointment__btn">
                                            <button class="fill-btn" type="submit">
                                                <span class="fill-btn-inner">
                                                    <span class="fill-btn-normal">Registration<i class="fa-regular fa-angle-right"></i></span>
                                                    <span class="fill-btn-hover">Registration<i class="fa-regular fa-angle-right"></i></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="appointment__btn">
                                            <div class="text-center mt-20">
                                                <p> Have an account? <a href="{{ route('user.login') }}" class="text-primary">Login here</a></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact area end -->
</main>
@endsection

@push('scripts')
<!-- jQuery -->

<!-- jQuery Validation Plugin -->
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

<script>
$(document).ready(function () {
    $("#registrationForm").validate({
        rules: {
            firstname: { required: true, minlength: 2 },
            lastname: { required: true, minlength: 2 },
            email: { required: true, email: true },
            phonenumber: { required: true, digits: true, minlength: 10, maxlength: 15 },
            password: { required: true, minlength: 6 },
            password_confirmation: { required: true, equalTo: "[name='password']" }
        },
        messages: {
            firstname: { required: "Please enter your first name", minlength: "At least 2 characters" },
            lastname: { required: "Please enter your last name", minlength: "At least 2 characters" },
            email: { required: "Please enter a valid email", email: "Invalid email format" },
            phonenumber: { required: "Please enter your phone number", digits: "Only digits allowed", minlength: "At least 10 digits", maxlength: "No more than 15 digits" },
            password: { required: "Please provide a password", minlength: "Minimum 6 characters" },
            password_confirmation: { required: "Please confirm your password", equalTo: "Passwords do not match" }
        },
        errorPlacement: function (error, element) {
            error.css("color", "red");
            error.insertAfter(element);
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
                        text: response.message || "Registration successfully!"
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