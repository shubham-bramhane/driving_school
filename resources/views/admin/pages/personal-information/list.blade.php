@extends('admin.layout.default')

@section('personal-information-master','active menu-item-open')
@section('content')
<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-3 pb-0">
        <div class="card-title">
            <h3 class="card-label">Personal Details
                <!-- <div class="text-muted pt-2 font-size-sm">Datatable initialized from HTML table</div> -->
            </h3>
        </div>

        <div class="card-toolbar">
            <!--begin::Button-->
            <a href="{{url('/admin/personal-information/add')}}" class="btn btn-primary font-weight-bolder">
                <i class="la la-plus"></i>Add Data</a>
            <!--end::Button-->
        </div>

        <form action="" method="get" class="w-100">
            <div class="row col-lg-12 pl-0 pr-0">
                <div class="col-sm-3">
                    <div class="dataTables_length">
                        <label>Status</label>
                        <select name="status" value="" class="form-control">
                            <option value="">All Status</option>
                            <option value="0" @if(request('status')=='0' ) {{runTimeSelection(0, request('status'))}} @endif>InActive</option>
                            <option value="1" @if(request('status')=='1' ) {{runTimeSelection(1, request('status'))}} @endif>Active</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="dataTables_length">
                        <label cla>&#160; </label>
                        <button type="submit" class="btn btn-success mt-7" data-toggle="tooltip" title="Apply Filter">Filter</button>
                        <a href="{{url('/admin/personal-information/list')}}" class="btn btn-default mt-7" data-toggle="tooltip" title="Reset Filter">Reset</a>

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
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Mobile</th>
                    <th>Total</th>
                    <th>Amount Received</th>
                    <th>Amount Due</th>
                    <th class="custom_status">Status</th>
                    <th class="custom_action">Action</th>
                </tr>
            </thead>
            <tbody>

                @if(count($details) > 0)
                @foreach($details as $key => $value)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        <a href="{{ url('admin/personal-information/view/' . $value->id) }}">
                            {{ $value->name }}
                        </a>
                    </td>
                    <td>{{($value->date_of_birth) ? date('d-m-Y', strtotime($value->date_of_birth)) : ''}}</td>
                    <td>{{$value->mobile_no }}</td>
                    <td>&#8377; {{$value->total ? number_format($value->total, 2) : '0.00'}}</td>
                    <td>{{$value->invoices->sum('invoice_amount') ? number_format($value->invoices->sum('invoice_amount'), 2) : '0.00'}}</td>
                    <td>{{$value->invoices->sum('invoice_amount') ? number_format($value->total - $value->invoices->sum('invoice_amount'), 2) : '0.00'}}</td>
                    <td>
                        <a href="javascript:void(0)" data-url="{{url('admin/personal-information/update-status/'.$value->id.'/'.$value->status)}}" onclick="changeStatus(this)"> <span class="label label-lg font-weight-bold label-light-{{($value->status == 1) ? 'success' : 'danger'}} label-inline">{{($value->status == 1) ? 'Active' : 'InActive'}}</span></a>
                    </td>
                    <td>
                        <a href="{{url('admin/personal-information/edit/'.$value->id)}}" class="btn btn-sm btn-clean btn-icon" title="Edit details">
                            <i class="la la-edit"></i>
                        </a>
                       <a href="javascript:void(0)" data-url="{{url('/admin/personal-information/delete/'.$value->id)}}" class="btn btn-sm btn-clean btn-icon" data-toggle="tooltip" title="Delete category" onclick="deleteItem(this)">
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
