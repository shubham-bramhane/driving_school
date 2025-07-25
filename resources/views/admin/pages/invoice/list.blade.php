@extends('admin.layout.default')

@section('invoice-master','active menu-item-open')
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-3 pb-0">
        <div class="card-title">
            <h3 class="card-label">Invoice & Receipt List
                <!-- <div class="text-muted pt-2 font-size-sm">Datatable initialized from HTML table</div> -->
            </h3>
        </div>

        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="{{url('/admin/invoice/add')}}" class="btn btn-primary font-weight-bolder">
                <i class="la la-plus"></i>Create Invoice</a>
            <!--end::Button-->
        </div>

        <form action="" method="get" class="w-100">
            <div class="row col-lg-12 pl-0 pr-0">
                <div class="col-sm-3">
                    <div class="dataTables_length">
                        <label>Payment Mode</label>
                        <select name="payment_mode" class="form-control">
                            <option value="">All Modes</option>
                            <option value="cash" @if(request('status')=='cash') selected @endif>Cash</option>
                            <option value="online" @if(request('status')=='online') selected @endif>Online</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="dataTables_length">
                        <label cla>&#160; </label>
                        <button type="submit" class="btn btn-success mt-7" data-toggle="tooltip" title="Apply Filter">Filter</button>
                        <a href="{{url('/admin/invoice/list')}}" class="btn btn-default mt-7" data-toggle="tooltip" title="Reset Filter">Reset</a>

                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-body">
        <!--begin: Datatable-->
        <table class="table table-bordered table-hover" id="myTable">
            <thead>
            <tr>
                <th class="custom_sno">SNo.</th>
                <th>Applicant Name</th>
                <th>Invoice Number</th>
                <th>Invoice Date</th>
                <th>Invoice Amount</th>
                <th>Payment Status</th>
                <th class="custom_action">Action</th>
            </tr>
            </thead>
            <tbody>
            @if(count($details) > 0)
            @foreach($details as $key => $value)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$value->user_id ? $value->user->name : ''}}</td>
                <td>{{ $value->invoice_number ?? '' }}</td>
                <td>{{ $value->invoice_date ? date('d-m-Y', strtotime($value->invoice_date)) : '' }}</td>
                <td>{{ $value->invoice_amount ?? '' }}</td>
                <td>
                @if($value->payment_status == 'cash')
                    <span class="badge badge-success">Cash</span>
                @elseif($value->payment_status == 'online')
                    <span class="badge badge-primary">Online</span>
                @else
                    <span class="badge badge-secondary">-</span>
                @endif
                </td>
                <td>
                <a href="{{url('/admin/invoice/edit/'.$value->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit details" data-toggle="tooltip">
                    <i class="la la-edit"></i>
                </a>
                <a href="javascript:void(0)" data-url="{{url('/admin/invoice/delete/'.$value->id)}}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" title="Delete category" onclick="deleteItem(this)">
                    <i class="la la-trash"></i>
                </a>
                </td>
            </tr>
            @endforeach
            @endif
            </tbody>
        </table>
        <!--end: Datatable-->
    </div>
</div>


<script>
    function changeStatus() {
        confirm("Do you want to change status?");
    }
</script>
@endsection

{{-- Styles Section --}}
@section('styles')
<!-- <link href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" /> -->
<link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endsection


{{-- Scripts Section --}}
@section('scripts')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable();
        $('.dataTables_filter label input[type=search]').addClass('form-control form-control-sm');
        $('.dataTables_length select').addClass('custom-select custom-select-sm form-control form-control-sm');
    });
</script>
{{-- vendors --}}
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript"></script>
<!-- <script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}" type="text/javascript"></script> -->

{{-- page scripts --}}
<!-- <script src="{{ asset('js/pages/crud/datatables/basic/basic.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script> -->
@endsection
