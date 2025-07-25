@extends('admin.layout.default')

@section('learning-master','active menu-item-open')
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
                                <label>Application No</label>
                                <input type="text" name="application_no" value="{{ $details->application_no }}" class="form-control number" placeholder="Enter Application No">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Application Date</label>
                                <input type="date" name="application_date" value="{{ $details->application_date }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Class of Vehicle (COV's)</label>
                                <select name="covs[]" class="form-control" id="covs" multiple>
                                    @php $products = getProducts(); @endphp
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ in_array($product->id, $details->covs ?? []) ? 'selected' : '' }}>
                                            {{ $product->name }} (&#8377; {{ number_format($product->price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Learning No</label>
                                <input type="text" name="learning_no" value="{{ $details->learning_no }}" class="form-control" placeholder="Enter Learning No">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Learning Created Date</label>
                                <input type="date" name="learning_created_date" value="{{ $details->learning_created_date }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Learning Expired Date</label>
                                <input type="date" name="learning_expired_date" value="{{ $details->learning_expired_date }}" class="form-control">
                            </div>

                            <div class="form-group col-md-6">
                                <label>Appointment Date</label>
                                <input type="date" name="appointment_date" value="{{ $details->appointment_date }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>RTO Office</label>
                                <select name="rto_office" class="form-control">
                                    <option value="">Select RTO Office</option>
                                    <option value="34" {{ $details->rto_office == '34' ? 'selected' : '' }}>Chandrapur (MH34)</option>
                                    <option value="29" {{ $details->rto_office == '29' ? 'selected' : '' }}>Yavatmal (MH29)</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Attendance</label>
                                <select name="attendance" class="form-control">
                                    <option value="present" {{ $details->attendance == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="absent" {{ $details->attendance == 'absent' ? 'selected' : '' }}>Absent</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Result</label>
                                <select name="result" class="form-control">
                                    <option value="pass" {{ $details->result == 'pass' ? 'selected' : '' }}>Pass</option>
                                    <option value="fail" {{ $details->result == 'fail' ? 'selected' : '' }}>Fail</option>
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Select Status</option>
                                    <option value="0" {{ $details->status == '0' ? 'selected' : '' }}>Pending</option>
                                    <option value="1" {{ $details->status == '1' ? 'selected' : '' }}>Approved</option>
                                    <option value="2" {{ $details->status == '2' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <center><button class="btn btn-success">Update</button></center>
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
<script src="{{ asset('multiselect/bootstrap.multiselect.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#covs').multiselect({
            nonSelectedText: 'Select Class of Vehicle',
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonWidth: '100%'
        });
    });
</script>


@endsection
