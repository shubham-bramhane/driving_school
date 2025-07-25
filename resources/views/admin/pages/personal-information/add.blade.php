@extends('admin.layout.default')

@section('personal-information-master','active menu-item-open')
@section('content')
<div class="card card-custom">

    <div class="card-body">
        <div class="mb-7">
            <div class="row align-items-center">

                <form method="POST" action="" class="w-100">
                    {{ csrf_field() }}
                    <div class="col-lg-9 col-xl-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-12">
                                <label>Json</label>
                                <div><textarea name="json" rows="20" isrequired="required" class="form-control" placeholder="Enter Json Format">{{old('json')}}</textarea></div>
                            </div>

                            <div class="form-group col-md-12">
                                <center><button class="btn btn-success">Submit</button></center>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

{{-- Styles Section --}}
@section('styles')
@endsection

{{-- Scripts Section --}}
@section('scripts')
@endsection
