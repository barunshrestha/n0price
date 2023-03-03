<div class="d-flex flex-column flex-root mt-20">
    <!--begin::Login-->
    <div class="login login-signin-on login-3 d-flex flex-row-fluid" id="kt_login">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-6">
                    <a href="#">
                        {{-- Logo here --}}
                    </a>
                </div>

                <div class="login-signin">
                    <div class="mb-10">
                        <h3 class="font-weight-bold" style="color: #ffffff;">Sign Up
                        </h3>

                        <div class="font-weight-bold" style="color: #ffffff;">Enter
                            your details to
                            create your account</div>

                    </div>
                    <form class="form" action="{{ route('register') }}" method="POST">
                        @if (session('fail'))
                            @if (session('action') == 'signup')
                                <div class="alert alert-danger d-flex" role="alert">
                                    <div class="alert-text">
                                        {!! session('fail') !!}</div>
                                    <div class="alert-close ml-auto">
                                        <i class="flaticon2-cross kt-icon-sm text-white" data-dismiss="alert"></i>
                                    </div>
                                </div>
                            @endif
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success d-flex" role="alert">
                                <div class="alert-text">
                                    {!! session('success') !!}</div>
                                <div class="alert-close ml-auto">
                                    <i class="flaticon2-cross kt-icon-sm text-white" data-dismiss="alert"></i>
                                </div>
                            </div>
                        @endif
                        @csrf
                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8 @error('name')is-invalid @enderror"
                                type="text" value="{{ old('name') }}" placeholder="Fullname" name="name" />
                            @error('name')
                                <div class="d-flex mt-2 invalid-feedback">
                                    <i class="text-danger flaticon2-information" data-dismiss="alert"></i>
                                    <div class="text-danger mx-3">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8 @error('email')is-invalid @enderror"
                                type="text" value="{{ old('email') }}" placeholder="Email" name="email"
                                autocomplete="off" />
                            @error('email')
                                <div class="d-flex mt-2 invalid-feedback">
                                    <i class="text-danger flaticon2-information" data-dismiss="alert"></i>
                                    <div class="text-danger mx-3">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <input
                                class="form-control h-auto form-control-solid py-4 px-8 @error('password')is-invalid @enderror"
                                type="password" value="{{ old('password') }}" placeholder="Password" name="password" />
                            @error('password')
                                <div class="d-flex mt-2 invalid-feedback">
                                    <i class="text-danger flaticon2-information" data-dismiss="alert"></i>
                                    <div class="text-danger mx-3">
                                        {{ $message }}
                                    </div>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                                value="{{ old('rpassword') }}" placeholder="Confirm Password" name="rpassword" />
                        </div>

                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button id="kt_login_signup_submit"
                                class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign
                                Up</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!--end::Login-->
</div>
