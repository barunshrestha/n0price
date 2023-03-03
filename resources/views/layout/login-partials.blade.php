<!--begin::Login-->
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
                    <div class="d-flex flex-center flex-row-fluid ">
                        <div class="login-form text-center  overflow-hidden">
                            <!--begin::Login Sign in form-->
                            <div class="login-signin">
                                <div class="mb-10">
                                    <h2 style="color: #ffffff;">Login</h2>
                                    <div class="text-muted font-weight-bold">Enter your
                                        details
                                        to login to your account:</div>
                                </div>
                                <form class="kt-form" action="{{ route('login') }}" method="post"
                                    novalidate="novalidate">
                                    {{ csrf_field() }}
                                    @if (session('fail'))
                                        <div class="alert alert-danger d-flex" role="alert">
                                            <div class="alert-text">
                                                {!! session('fail') !!}
                                            </div>
                                            <div class="alert-close ml-auto">
                                                <i class="flaticon2-cross kt-icon-sm text-white"
                                                    data-dismiss="alert"></i>
                                            </div>
                                        </div>
                                    @endif
                                    @if (session('success'))
                                        <div class="alert alert-success d-flex" role="alert">
                                            <div class="alert-text">
                                                {!! session('success') !!}
                                            </div>
                                            <div class="alert-close ml-auto">
                                                <i class="flaticon2-cross kt-icon-sm text-white"
                                                    data-dismiss="alert"></i>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="form-group mb-5">
                                        <input class="form-control h-auto form-control-solid py-4 px-8" type="text"
                                            value="{{ old('email') }}" placeholder="Email" name="email"
                                            autocomplete="off" />
                                    </div>
                                    <div class="form-group mb-5">
                                        <input class="form-control h-auto form-control-solid py-4 px-8 password"
                                            type="password" value="{{ old('password') }}" placeholder="Password"
                                            name="password" />
                                    </div>
                                    <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
                                        <a href="/forgot-password" class="text-muted text-hover-primary">Forget
                                            Password ?</a>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign
                                        In</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
