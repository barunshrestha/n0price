{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">Add new coin</h3>
        </div>
        <!--begin::Form-->
        <form class="form" id="kt_form" action="{{ route('coins.store') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="card-body">
                <div class="form-group row">
                    <label class="col-form-label text-right col-lg-3 col-sm-12">Name:*</label>
                    <div class="col-lg-9 col-md-9 col-sm-12">
                        <input name="name" type="text" class="form-control form-control-solid name"
                            placeholder="Enter Name" required autocomplete="off" />
                    </div>
                </div>
              
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-lg-6">
                        <button type="submit" class="btn btn-primary mr-2 submitBtn">Save</button>
                        <a href="{{ route('coins.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
{{-- Scripts Section --}}
@section('scripts')
    
@endsection
