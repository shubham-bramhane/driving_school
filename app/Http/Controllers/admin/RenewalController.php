<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\Renewal;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Validator;

class RenewalController extends Controller
{
    public function index()
    {
        try {
        $page_title = 'Renewal Driving License';
        $page_description = '';
        $breadcrumbs = [
            [
            'title' => 'Renewal Driving License',
            'url' => '',
            ]
        ];
        $status = request('status');
        if ($status == '0') {
            $status = '2';
        }
        $details = Renewal::when($status !== null && $status !== '', function ($query) use ($status) {
                if ($status != '-1') {
                    $query->where('status', '=', $status);
                }
            })->orderBy('id', 'asc')->get();

        return view('admin.pages.renewal.list', compact('page_title', 'page_description', 'breadcrumbs',  'details'));
        } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            if ($request->isMethod('post')) {
                // dd($request->all());
                $validator = Validator::make($request->all(), [
                    'application_no' => 'required|string|max:255',
                    'application_date' => 'required|date',
                    // 'dl_number' => 'required|string|max:255',
                    // 'dl_covs' => 'required|string|max:255',
                    // 'nt_validity' => 'required|date',
                    // 'tr_validity' => 'required|date',
                    // 'license_approved_date' => 'required|date',
                    // 'appointment_date' => 'required|date',
                    // 'rto_office' => 'required|string|max:255',
                    // 'attendance' => 'required|string|max:255',
                    // 'result' => 'required|string|max:255',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'application_no' => $request->input('application_no'),
                    'application_date' => date('Y-m-d', strtotime($request->input('application_date'))),
                    'dl_number' => $request->input('dl_number'),
                    'dl_covs' => $request->input('dl_covs'),
                    'nt_validity' => date('Y-m-d', strtotime($request->input('nt_validity'))),
                    'tr_validity' => date('Y-m-d', strtotime($request->input('tr_validity'))),
                    'license_approved_date' => date('Y-m-d', strtotime($request->input('license_approved_date'))),
                    'appointment_date' => date('Y-m-d', strtotime($request->input('appointment_date'))),
                    'rto_office' => $request->input('rto_office'),
                    'attendance' => $request->input('attendance'),
                    'result' => $request->input('result'),
                    'status' => $request->input('status', 0), // Default to '0' if not provided
                ];

                $response = Renewal::updateOrCreate(['id' => $id], $array);
                if (!$response) {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to update learning details.');
                }

                DB::commit();

                return redirect('/admin/renewal/list')->with('success', 'Renewal updated successfully.');
            }





            $pageSettings = $this->pageSetting('edit', ['title' => 'Edit Renewal Form', 'url' => url('admin/renewal/list')]);
            $page_title = $pageSettings['page_title'];
            $page_description = $pageSettings['page_description'];
            $breadcrumbs = $pageSettings['breadcrumbs'];

            $details = Renewal::find($id);
            if (!$details) {
                return redirect()->back()->with('error', 'Renewal details not found.');
            }

            return view('admin.pages.renewal.edit', compact('page_title', 'page_description', 'breadcrumbs', 'details'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            if ($id) {
                DB::beginTransaction();
                $renewal = Renewal::find($id);
                if ($renewal && $renewal->delete()) {
                    DB::commit();
                    return redirect()->back()->with('success', 'Renewal deleted successfully.');
                } else {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Renewal details not found or failed to delete.');
                }
            } else {
                return redirect()->back()->with('error', 'Renewal details not found.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus($renewalId, $status)
    {
        try {
            if ($renewalId) {
                DB::beginTransaction();
                $newStatus = ($status == 1) ? 0 : 1;
                $renewal = Renewal::find($renewalId);
                if ($renewal) {
                    $renewal->status = $newStatus;
                    $renewal->save();
                    DB::commit();
                    return redirect('admin/renewal/list')->with('success', 'Renewal status updated successfully.');
                } else {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Renewal details not found.');
                }
            } else {
                return redirect()->back()->with('error', 'Renewal details not found.');
            }
        } catch (\Exception $e) {
            DB::rollback();
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
            $data['page_title'] = 'Renewal List';
            $data['page_description'] = 'Edit Renewal';
            $data['breadcrumbs'][] = [
                'title' => 'Renewal Driving License',
                'url' => url('admin/renewal/list'),
            ];
            if (!empty($dataArray['title'])) {
                $data['breadcrumbs'][] = [
                    'title' => $dataArray['title'],
                    'url' => '',
                ];
            }
        } elseif ($action == 'add') {
            $data['page_title'] = 'Renewal Form';
            $data['page_description'] = 'Add New Renewal Form';
            $data['breadcrumbs'][] = [
                'title' => 'Renewal Driving License',
                'url' => url('admin/renewal/list'),
            ];
            $data['breadcrumbs'][] = [
                'title' => 'Add a New Renewal Form',
                'url' => '',
            ];
        }

        return $data;
    }
}
