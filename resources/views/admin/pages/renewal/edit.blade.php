@extends('admin.layout.default')

@section('renewal-master','active menu-item-open')
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
                                <input type="text" name="application_no" value="{{ $details->application_no }}" class="form-control" placeholder="Enter Application No">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Application Date</label>
                                <input type="date" name="application_date" value="{{ $details->application_date }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>DL Number</label>
                                <input type="text" name="dl_number" value="{{ $details->dl_number }}" class="form-control" placeholder="Enter DL Number">
                            </div>
                            <div class="form-group col-md-6">
                                <label>DL COVs</label>
                                <input type="text" name="dl_covs" value="{{ $details->dl_covs }}" class="form-control" placeholder="Enter DL COVs">
                            </div>

                            <div class="form-group col-md-6">
                                <label>NT Validity</label>
                                <input type="date" name="nt_validity" value="{{ $details->nt_validity }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>TR Validity</label>
                                <input type="date" name="tr_validity" value="{{ $details->tr_validity }}" class="form-control">
                            </div>



                            <div class="form-group col-md-6">
                                <label>License Approval Date</label>
                                <input type="date" name="license_approval_date" value="{{ $details->license_approval_date }}" class="form-control">
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
<!-- Modal -->
<div class="modal fade" id="password-change" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{route('change-password',['id'=>$details->id])}}" class="row align-items-center dataSubmit">
            @csrf
            <div class="form-group col-md-12">
                <label>User Name : {{$details->email }} </label>
            </div>
            <div class="form-group col-md-12">
                <label>New Password</label>
                <div><input type="text" name="password" value=""  isrequired="required"
                        class="form-control" placeholder="Enter Password" >
                    <span class="pw"></span>
                    </div>
            </div>
            <div class="form-group col-md-12">
                <button type="submit" class="btn btn-success">Save</button>
            </div>
         </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
<script>
    $(document).ready(function() {
        // Show/hide Vendor dropdown based on user type selection
        function toggleVendorDropdown() {
            if ($('#vendor_user').is(':checked')) {
                $('#vendor_id').closest('.form-group').removeClass('d-none');
                $('#vendor_id').attr('required', 'required');
            } else {
                $('#vendor_id').closest('.form-group').addClass('d-none');
                $('#vendor_id').removeAttr('required');
            }
        }

        // Initial check on page load
        toggleVendorDropdown();

        // On change of user type radio buttons
        $('input[name="user_type"]').on('change', function() {
            toggleVendorDropdown();
        });
    });
</script>
@endsection
