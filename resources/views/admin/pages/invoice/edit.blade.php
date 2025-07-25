@extends('admin.layout.default')

@section('invoice-master','active menu-item-open')
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
                                <label>Candidate Name</label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">Select Candidate</option>
                                    @php $candidates = \App\Models\User::where('role_id', 2)->get(); @endphp
                                    @foreach($candidates as $candidate)
                                        <option value="{{ $candidate->id }}" {{ (old('user_id', $details->user_id ?? '') == $candidate->id) ? 'selected' : '' }}>
                                            {{ $candidate->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Invoice Number</label>
                                <input type="text" name="invoice_number" required value="{{ old('invoice_number', $details->invoice_number ?? '') }}" class="form-control" placeholder="Enter Invoice Number">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Invoice Date</label>
                                <input type="date" name="invoice_date" required value="{{ old('invoice_date', $details->invoice_date ?? '') }}" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Invoice Amount</label>
                                <input type="text" step="0.01" required name="invoice_amount" value="{{ old('invoice_amount', $details->invoice_amount ?? '') }}" class="form-control number" placeholder="Enter Invoice Amount">
                            </div>
                            <div class="form-group col-md-6">
                                <label>Payment Status</label>
                                <select name="payment_status" class="form-control" required>
                                    <option value="">Select Payment Status</option>
                                    <option value="cash" {{ (old('payment_status', $details->payment_status ?? '') == 'cash') ? 'selected' : '' }}>Cash</option>
                                    <option value="online" {{ (old('payment_status', $details->payment_status ?? '') == 'online') ? 'selected' : '' }}>Online</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Invoice Description</label>
                                <textarea name="invoice_description" class="form-control" placeholder="Enter Invoice Description">{{ old('invoice_description', $details->invoice_description ?? '') }}</textarea>
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

@section('styles')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('select[name="user_id"]').select2({
            placeholder: "Select Candidate",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection
