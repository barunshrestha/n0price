{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">Update User Detail</h3>
        </div>
        <!--begin::Form-->
        <form class="form" id="kt_form" action="{{ route('users.update', $data->id) }}" method="POST"
            enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Name:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="name" type="text" class="form-control form-control-solid name"
                            placeholder="Enter Name" required value="{{ $data->name }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">E-mail:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="email" type="email" class="form-control form-control-solid"
                            placeholder="Enter Email Address" required value="{{ $data->email }}" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Role:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">

                        {{ Form::select('role_id', $roles, $data->role_id, ['class' => 'form-control role', 'autocomplete' => 'off', 'required' => true]) }}
                    </div>
                </div>
                <div class="form-group row dealer">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Dealer:</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {{ Form::select('dealer_id',['' => 'Select Dealer'] + $dealers, $data->dealer_id, ['class' => 'form-control form-control-solid', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="form-group row exchange">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Exchange:</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        {{ Form::select('exchange_id', $exchanges, $data->exchange_id, ['class' => 'form-control form-control-solid', 'autocomplete' => 'off']) }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Username:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="username" type="text" class="form-control form-control-solid username"
                            placeholder="Enter Username" required value="{{ $data->username }}" />
                        <span class="form-text text-muted unameMsg" style="display:none;color : red !important;">This
                            username already exists. Choose another one.</span>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Password:</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="password" type="password" class="form-control form-control-solid"
                            placeholder="Change Password" />
                        <span class="form-text text-muted">Please fill if the password needs to be changed otherwise leave
                            empty</span>
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
            });

            $('.role').trigger('change');
        });
    </script>
@endsection
