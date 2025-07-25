<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Learning;
use App\Models\User;
use Illuminate\Http\Request;
use DB;
use Validator;

class LearningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
        $page_title = 'Learning License';
        $page_description = '';
        $breadcrumbs = [
            [
            'title' => 'Learning License',
            'url' => '',
            ]
        ];
        $status = request('status');
        if ($status == '0') {
            $status = '2';
        }
        $details = Learning::when($status !== null && $status !== '', function ($query) use ($status) {
                if ($status != '-1') {
                    $query->where('status', '=', $status);
                }
            })->orderBy('id', 'asc')->get();

        return view('admin.pages.learning.list', compact('page_title', 'page_description', 'breadcrumbs',  'details'));
        } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    // The following methods are not needed here as similar methods for Learning already exist below.
    // If you want to manage Module, use a separate controller for Module-related logic.


    public function edit(Request $request, $id)
    {
        try {
            if ($request->isMethod('post')) {
                // dd($request->all());
                $validator = Validator::make($request->all(), [
                    'application_no' => 'required|string|max:255',
                    'application_date' => 'required|date',
                    // 'dl_covs' => 'required|string|max:255',
                    // 'learning_no' => 'required|string|max:255',
                    'learning_created_date' => 'required|date',
                    'learning_expired_date' => 'required|date|after_or_equal:learning_created_date',
                    'appointment_date' => 'nullable|date',
                    'rto_office' => 'nullable|string|max:255',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'application_no' => $request->input('application_no'),
                    'application_date' => date('Y-m-d', strtotime($request->input('application_date'))),
                    'dl_covs' => $request->input('dl_covs'),
                    'learning_no' => $request->input('learning_no'),
                    'learning_created_date' => date('Y-m-d', strtotime($request->input('learning_created_date'))),
                    'learning_expired_date' => date('Y-m-d', strtotime($request->input('learning_expired_date'))),
                    'appointment_date' => date('Y-m-d', strtotime($request->input('appointment_date'))),
                    'rto_office' => $request->input('rto_office'),
                    'status' => $request->input('status', '0'), // Default to '0' if not provided
                ];

                $response = Learning::updateOrCreate(['id' => $id], $array);
                if (!$response) {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Failed to update learning details.');
                }

                DB::commit();

                return redirect('/admin/learning/list')->with('success', 'Learning updated successfully.');
            }





            $pageSettings = $this->pageSetting('edit', ['title' => 'Edit Learning Form', 'url' => url('admin/learning/list')]);
            $page_title = $pageSettings['page_title'];
            $page_description = $pageSettings['page_description'];
            $breadcrumbs = $pageSettings['breadcrumbs'];

            $details = Learning::find($id);
            if (!$details) {
                return redirect()->back()->with('error', 'Learning details not found.');
            }

            return view('admin.pages.learning.edit', compact('page_title', 'page_description', 'breadcrumbs', 'details'));
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
                $learning = Learning::find($id);
                if ($learning && $learning->delete()) {
                    DB::commit();
                    return redirect()->back()->with('success', 'Learning deleted successfully.');
                } else {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Learning details not found or failed to delete.');
                }
            } else {
                return redirect()->back()->with('error', 'Learning details not found.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus($learningId, $status)
    {
        try {
            if ($learningId) {
                DB::beginTransaction();
                $newStatus = ($status == 1) ? 0 : 1;
                $learning = Learning::find($learningId);
                if ($learning) {
                    $learning->status = $newStatus;
                    $learning->save();
                    DB::commit();
                    return redirect('admin/learning/list')->with('success', 'Learning status updated successfully.');
                } else {
                    DB::rollback();
                    return redirect()->back()->with('error', 'Learning details not found.');
                }
            } else {
                return redirect()->back()->with('error', 'Learning details not found.');
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
            $data['page_title'] = 'Learning List';
            $data['page_description'] = 'Edit Learning';
            $data['breadcrumbs'][] = [
                'title' => 'Learning Form',
                'url' => url('admin/learning/list'),
            ];
            if (!empty($dataArray['title'])) {
                $data['breadcrumbs'][] = [
                    'title' => $dataArray['title'],
                    'url' => '',
                ];
            }
        } elseif ($action == 'add') {
            $data['page_title'] = 'Learning Form';
            $data['page_description'] = 'Add New Learning Form';
            $data['breadcrumbs'][] = [
                'title' => 'Learning Form',
                'url' => url('admin/learning/list'),
            ];
            $data['breadcrumbs'][] = [
                'title' => 'Add a New Learning Form',
                'url' => '',
            ];
        }

        return $data;
    }
}
