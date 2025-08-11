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
                        <h2 class="breadcrumb__title">Login</h2>
                        <div class="breadcrumb__menu">
                            <nav>
                                <ul>
                                    <li><span><a href="{{ route('userdashboard') }}">Home</a></span></li>
                                    <li><span>Login</span></li>
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
                            <img src="{{ asset('frontend-assets/imgs/Login.jpg') }}" alt="Login">
                        </div>
                    </div>
                    <div class="col-xxl-6 col-xl-6">
                        <div class="contact-from">
                            <div id="loginMessage" style="margin-bottom: 10px; font-weight: bold;"></div>
                            <form id="loginForm" action="{{ route('user.login') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="email" name="email" id="email" placeholder="Email Address*" required>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="contact__from-input">
                                            <input type="password" name="password" id="password" placeholder="Password*" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="appointment__btn">
                                            <button class="fill-btn" type="submit">
                                                <span class="fill-btn-inner">
                                                    <span class="fill-btn-normal">Login<i class="fa-regular fa-angle-right"></i></span>
                                                    <span class="fill-btn-hover">Login<i class="fa-regular fa-angle-right"></i></span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="appointment__btn">
                                            <div class="text-center mt-20">
                                <p>Don’t have an account? <a href="{{ route('register') }}" class="text-primary">Register here</a></p>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function(){
    $('#loginForm').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: "{{ route('user.login') }}",
            type: "POST",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response){
                if(response.status){
                    $('#loginMessage').css('color', 'green').text(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    $('#loginMessage').css('color', 'red').text(response.message);
                }
            },
            error: function(xhr){
                $('#loginMessage').css('color', 'red').text('An error occurred. Please try again.');
            }
        });
    });
});
</script>
@endpush