@extends('admin.layout.default')

@section('personal-information-master','active menu-item-open')
@section('content')
<div class="card card-custom">
    <div class="card-body">
        <h4 class="mb-4">Personal Information</h4>
        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td style="width:50%; vertical-align:top; border-right:1px solid #dee2e6;">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>Name</th>
                                <td>{{ $details->name }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>{{ $details->date_of_birth ? date('d-m-Y', strtotime($details->date_of_birth)) : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Father Name</th>
                                <td>{{ $details->father_name }}</td>
                            </tr>
                            <tr>
                                <th>Blood Group</th>
                                <td>{{ $details->blood_group }}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width:50%; vertical-align:top;">
                        <table class="table table-borderless mb-0">
                            <tr>
                                <th>Email/User Name</th>
                                <td>{{ $details->email }}</td>
                            </tr>
                            <tr>
                                <th>Mobile No</th>
                                <td>{{ $details->mobile_no }}</td>
                            </tr>
                            <tr>
                                <th>Total</th>
                                <td>&#8377;&nbsp;{{ isset($details->total) ? number_format($details->total, 2) : '0.00' }}</td>
                            </tr>
                            <tr>
                                <th>Amount Received</th>
                                <td>&#8377;&nbsp;{{ $details->invoices->sum('invoice_amount') ? number_format($details->invoices->sum('invoice_amount'), 2) : '0.00' }}</td>
                            </tr>
                            <tr>
                                <th>Amount Due</th>
                                <td>&#8377;&nbsp;{{ isset($details->total) ? number_format($details->total - $details->invoices->sum('invoice_amount'), 2) : '0.00' }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tbody>

            {{-- learning, driving , renewal data --}}
            @if(isset($details->learnings) && count($details->learnings))
                <tr>
                    <th colspan="2" class="text-center">Learning License Details</th>
                </tr>
                @foreach($details->learnings as $index => $learning)
                    <tr>
                        <td style="width:50%; vertical-align:top; border-right:1px solid #dee2e6;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Learning License No{{ count($details->learnings) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $learning->learning_no ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Learning Created Date{{ count($details->learnings) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $learning->created_at ? date('d-m-Y', strtotime($learning->created_at)) : 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%; vertical-align:top;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Learning Expired Date{{ count($details->learnings) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $learning->expired_date ? date('d-m-Y', strtotime($learning->expired_date)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Learning RTO Office{{ count($details->learnings) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>
                                        {{-- 34 , 29 IF 34 THEN SHOW CHANDRAPUR(MH34) --}}
                                        @if($learning->rto_office == '34')
                                            Chandrapur (MH34)
                                        @elseif($learning->rto_office == '29')
                                            Yavatmal (MH29)
                                        @else
                                            {{ $learning->rto_office ?? 'N/A' }}
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endif

            @if(isset($details->driving) && count($details->driving))
                <tr>
                    <th colspan="2" class="text-center">Driving License Details</th>
                </tr>
                @foreach($details->driving as $index => $driving)
                    <tr>
                        <td style="width:50%; vertical-align:top; border-right:1px solid #dee2e6;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Driving License No{{ count($details->driving) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $driving->license_no ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Driving Created Date{{ count($details->driving) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $driving->created_at ? date('d-m-Y', strtotime($driving->created_at)) : 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%; vertical-align:top;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Driving Expired Date{{ count($details->driving) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $driving->expired_date ? date('d-m-Y', strtotime($driving->expired_date)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Driving RTO Office{{ count($details->driving) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $driving->rto_office ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endif


            @if(isset($details->renewals) && count($details->renewals))
                <tr>
                    <th colspan="2" class="text-center">Renewal License Details</th>
                </tr>
                @foreach($details->renewals as $index => $renewal)
                    <tr>
                        <td style="width:50%; vertical-align:top; border-right:1px solid #dee2e6;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Renewal License No{{ count($details->renewals) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $renewal->license_no ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Renewal Created Date{{ count($details->renewals) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $renewal->created_at ? date('d-m-Y', strtotime($renewal->created_at)) : 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%; vertical-align:top;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Renewal Expired Date{{ count($details->renewals) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $renewal->expired_date ? date('d-m-Y', strtotime($renewal->expired_date)) : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Renewal RTO Office{{ count($details->renewals) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $renewal->rto_office ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endif

            {{-- invoices --}}
            @if(isset($details->invoices) && count($details->invoices))
                <tr>
                    <th colspan="2" class="text-center">Invoices</th>
                </tr>
                @foreach($details->invoices as $index => $invoice)
                    <tr>
                        <td style="width:50%; vertical-align:top; border-right:1px solid #dee2e6;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Invoice No{{ count($details->invoices) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $invoice->invoice_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Invoice Date{{ count($details->invoices) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $invoice->invoice_date ? date('d-m-Y', strtotime($invoice->invoice_date)) : 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                        <td style="width:50%; vertical-align:top;">
                            <table class="table table-borderless mb-0">
                                <tr>
                                    <th>Invoice Amount{{ count($details->invoices) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>&#8377;&nbsp;{{ $invoice->invoice_amount ? number_format($invoice->invoice_amount, 2) : '0.00' }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Status{{ count($details->invoices) > 1 ? ' ' . ($index + 1) : '' }}</th>
                                    <td>{{ $invoice->payment_status ?? 'N/A' }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>

        </table>
    </div>
</div>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection
