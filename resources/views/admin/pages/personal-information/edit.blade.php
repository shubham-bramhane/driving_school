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
                            <div class="form-group col-md-6">
                                <label>Name</label>
                                <div>
                                    <input type="text" name="name" value="{{ $details->name }}" isrequired="required"  class="form-control" placeholder="Enter User Name">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Date of Birth</label>
                                <div>
                                    <input type="date" name="date_of_birth" value="{{ $details->date_of_birth }}" isrequired="required"  class="form-control" placeholder="Enter Date of Birth">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Father Name</label>
                                <div>
                                    <input type="text" name="father_name" value="{{ $details->father_name }}" isrequired="required"  class="form-control" placeholder="Enter Father Name">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Blood Group</label>
                                <div>
                                    <select name="blood_group" class="form-control">
                                        <option value="">Select Blood Group</option>
                                        @php $blood_group = ['A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-']; @endphp
                                        @foreach($blood_group as $group)
                                            <option value="{{ $group }}" {{ $details->blood_group == $group ? 'selected' : '' }}>{{ $group }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Email/User Name</label>
                                <div>
                                    <input type="email" name="email" value="{{ $details->email }}" class="form-control" placeholder="Enter Email">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Mobile No</label>
                                <div>
                                    <input type="text" name="mobile_no" isrequired="required" value="{{ $details->mobile_no }}"  class="form-control number" max="10" min="10" placeholder="Enter Mobile No">
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Total</label>
                                <input type="text" name="total" value="{{ $details->total }}" isrequired="required"  class="form-control number" placeholder="Enter Total Amount">
                            </div>

                            <div class="form-group col-md-12">
                                <center>
                                    <button class="btn btn-success">Update</button>
                                </center>
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
