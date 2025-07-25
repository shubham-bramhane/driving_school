<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Invoice;
use DB;
use Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        try {
            $page_title = 'Invoice & Receipt List';
            $page_description = 'List of all invoices and receipts';
            $breadcrumbs = [
                [
                    'title' => 'Invoice & Receipt List',
                    'url' => '',
                ]
            ];
            $payment_mode = request('payment_mode');
            $details = Invoice::when($payment_mode !== null && $payment_mode !== '', function ($query) use ($payment_mode) {
                if ($payment_mode != '') {
                    $query->where('payment_status', '=', $payment_mode);
                }
            }
            )->orderBy('id', 'asc')->get();

            // dd($details);

            return view('admin.pages.invoice.list', compact('page_title', 'page_description', 'breadcrumbs', 'details'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // Other methods like add, edit, delete, etc. will go here
    public function add(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'user_id' => 'required|exists:admin_users,id',
                    'invoice_number' => 'required|unique:invoices,invoice_number',
                    // 'invoice_date' => 'required|date',
                    // 'invoice_amount' => 'required|numeric',
                    // 'payment_status' => 'required|string|in:cash,online',
                    // 'invoice_description' => 'nullable|string|max:1000',
                ],
                [
                    'user_id.required' => 'User is required.',
                    'user_id.exists' => 'Selected user does not exist.',
                    'invoice_number.required' => 'Invoice number is required.',
                    'invoice_number.unique' => 'Invoice number must be unique.',
                    // 'invoice_date.required' => 'Invoice date is required.',
                    // 'invoice_amount.required' => 'Invoice amount is required.',
                    // 'payment_status.required' => 'Payment status is required.',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                DB::beginTransaction();

                $invoiceData = [
                    'user_id' => $request->input('user_id'),
                    'invoice_number' => $request->input('invoice_number'),
                    'invoice_date' => $request->input('invoice_date'),
                    'invoice_amount' => $request->input('invoice_amount'),
                    'payment_status' => $request->input('payment_status'),
                    'invoice_description' => $request->input('invoice_description', ''),
                ];
                // dd($invoiceData);
                $invoice = Invoice::create($invoiceData);

                DB::commit();
                return redirect('admin/invoice/list')->with('success', 'Invoice created successfully.');
            }

            $pageSettings = $this->pageSetting('add');
            $page_title =  $pageSettings['page_title'];
            $page_description = $pageSettings['page_description'];
            $breadcrumbs = $pageSettings['breadcrumbs'];
            return view('admin.pages.invoice.add', compact('page_title', 'page_description', 'breadcrumbs'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $invoice = Invoice::findOrFail($id);

            if ($request->isMethod('post')) {
                $validator = Validator::make($request->all(), [
                    'user_id' => 'required|exists:admin_users,id',
                    'invoice_number' => 'required|unique:invoices,invoice_number,' . $id,
                    // 'invoice_date' => 'required|date',
                    // 'invoice_amount' => 'required|numeric',
                    // 'payment_status' => 'required|string|in:cash,online',
                    // 'invoice_description' => 'nullable|string|max:1000',
                ],
                [
                    'user_id.required' => 'User is required.',
                    'user_id.exists' => 'Selected user does not exist.',
                    'invoice_number.required' => 'Invoice number is required.',
                    'invoice_number.unique' => 'Invoice number must be unique.',
                    // 'invoice_date.required' => 'Invoice date is required.',
                    // 'invoice_amount.required' => 'Invoice amount is required.',
                    // 'payment_status.required' => 'Payment status is required.',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                DB::beginTransaction();

                $invoiceData = [
                    'user_id' => $request->input('user_id'),
                    'invoice_number' => $request->input('invoice_number'),
                    'invoice_date' => $request->input('invoice_date'),
                    'invoice_amount' => $request->input('invoice_amount'),
                    'payment_status' => $request->input('payment_status'),
                    'invoice_description' => $request->input('invoice_description', ''),
                ];
                // dd($invoiceData);
                $invoice->update($invoiceData);

                DB::commit();
                return redirect('admin/invoice/list')->with('success', 'Invoice updated successfully.');
            }

            $pageSettings = $this->pageSetting('edit', ['title' => $invoice->invoice_number]);
            $page_title =  $pageSettings['page_title'];
            $page_description = $pageSettings['page_description'];
            $breadcrumbs = $pageSettings['breadcrumbs'];
            $details = Invoice::where('id', $id)->first();
            return view('admin.pages.invoice.edit', compact('page_title', 'page_description', 'breadcrumbs', 'details'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            $invoice = Invoice::findOrFail($id);
            $invoice->delete();
            return redirect('admin/invoice/list')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function pageSetting($action, $dataArray = [])
    {
        $data = [
            'page_title' => '',
            'page_description' => '',
            'breadcrumbs' => [],
        ];

        if ($action == 'edit') {
            $data['page_title'] = 'Edit Invoice';
            $data['page_description'] = 'Edit existing invoice';
            $data['breadcrumbs'][] = [
                'title' => 'Invoice & Receipt List',
                'url' => url('admin/invoice/list'),
            ];
            if (!empty($dataArray['title'])) {
                $data['breadcrumbs'][] = [
                    'title' => $dataArray['title'],
                    'url' => '',
                ];
            }
        } elseif ($action == 'add') {
            $data['page_title'] = 'Add Invoice';
            $data['page_description'] = 'Create a new invoice';
            $data['breadcrumbs'][] = [
                'title' => 'Invoice & Receipt List',
                'url' => url('admin/invoice/list'),
            ];
            $data['breadcrumbs'][] = [
                'title' => 'Add Invoice',
                'url' => '',
            ];
        }

        return $data;
    }
}
