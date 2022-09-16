{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">Create New User</h3>
        </div>
        <!--begin::Form-->
        <form class="form" id="kt_form" action="{{ route('users.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Name:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="name" type="text" class="form-control form-control-solid name"
                            placeholder="Enter Name" required autocomplete="off" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">E-mail:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="email" type="email" class="form-control form-control-solid"
                            placeholder="Enter Email Address" required autocomplete="off" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Role:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">

                        {{-- {{ Form::select('role_id', $roles, null, ['class' => 'form-control form-control-solid role', 'autocomplete' => 'off', 'required' => true]) }} --}}

                        <select class="form-control form-control-solid role" id="role_id" name="role_id" required>
                            @foreach ($roles as $key => $role)
                                <option value="{{ $key }}">{{ ucfirst(trans($role)) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row dealer">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Dealer:</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {{ Form::select('dealer_id', $dealers, null, ['class' => 'form-control form-control-solid', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="form-group row exchange">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Exchange:</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {{ Form::select('exchange_id', $exchanges, null, ['class' => 'form-control form-control-solid', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Username:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="username" type="text" class="form-control form-control-solid username"
                            placeholder="Enter Username" required autocomplete="off" />
                        <span class="form-text text-muted unameMsg" style="display:none;color : red !important;">This
                            username already exists. Choose another one.</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Password:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="password" type="password" class="form-control form-control-solid password"
                            placeholder="Enter Password" value="Pass1234" required
                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" />
                        <span class="form-text text-muted">Must contain at least one number and one uppercase and lowercase
                            letter, and at least 8 or more characters. Default Password is <span
                                class="text-primary"><b>Pass1234</b></span></span>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.name').change(function() {
                var name = $(this).val();
                var username = name.substr(0, name.indexOf(' ')).toLowerCase();
                $('.username').val(username);
                $('.username').trigger('change');
            });


            $('.username').change(function(e) {
                var username = $('.username').val();
                $.ajax({
                    type: "POST",
                    data: {
                        'username': username,
                        '_token': "{{ csrf_token() }}"
                    },
                    url: '{{ route('check_username') }}',
                    success: function(response) {
                        if (response) {
                            $('.submitBtn').prop("disabled", false);
                            $('.unameMsg').css("display", "none");
                        } else {
                            $('.submitBtn').prop("disabled", true);
                            $('.unameMsg').css("display", "block");
                        }
                    }
                });
            });

            $('.dealer').hide();
            $('.exchange').hide();
            $('.role').change(function(e) {
                if ($(this).val() == 2) {
                    $('.dealer').show();
                    $('.exchange').hide();
                } else if ($(this).val() == 3) {
                    $('.exchange').show();
                    $('.dealer').hide();
                } else {
                    $('.dealer').hide();
                    $('.exchange').hide();
                }
            })
        });
    </script>
@endsection
