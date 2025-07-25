@extends('admin.layout.default')

@section('userlist','active menu-item-open')
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
                                <div><input type="text" name="name" value="{{old('name')}}" isrequired="required" class="form-control" placeholder="Enter User Name"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Email/User Name </label>
                                <div><input type="email" name="email" value="{{old('email') }}" isrequired="required" class="form-control" placeholder="Enter Email/User Name"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Mobile No.</label>
                                <div><input type="text" name="mobile_no" value="{{old('mobile_no')}}" isrequired="required" class="form-control number" maxlength="10" placeholder="Enter Mobile Number"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Password </label>
                                <div><input type="password" name="password" class="form-control" placeholder="Enter Password"></div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>User Role</label>
                                <select class="form-control" name="role_id" id="role_id" isrequired="required">
                                    <option value="">Select Role</option>
                                    @if($roles = getSystemRoles())
                                    @foreach($roles as $role )
                                    <option value="{{$role->id}}" {{runTimeSelection(old('role_id'),$role->id)}}>{{ $role->role }}</option>
                                    @endforeach
                                    @endif
                                </select>
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
