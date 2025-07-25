<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use DB;
use Validator;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    public function index()
    {
        try {

        $view_page_base_path = env('VIEW_ADMIN_BASE_PATH');
        $jsonPath = $view_page_base_path. "module/view_list.json";
        $json = json_decode(file_get_contents(resource_path($jsonPath)), true);

        if (!$json) {
            return redirect()->back()->withErrors(['JSON file not found or invalid.']);
        }

        $page_title = 'Module Management';
        $page_description = '';
        $breadcrumbs = [
            [
            'title' => 'Module Management',
            'url' => '',
            ]
        ];
        $status = request('status');
        if ($status == '0') {
            $status = '2';
        }
        $details = Module::when($status, function ($users) use ($status) {
            if ($status != '-1') {
            $status = conditionalStatus($status);
            $users->where('status', '=', $status);
            }
        })->orderBy('id', 'asc')->get();
        return view('admin.layout.data-view-master.list', compact('json','page_title', 'page_description', 'breadcrumbs',  'details'));
        } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->with('error', $e->getMessage());
        }
    }





    public function add(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
            }

            $view_page_base_path = env('VIEW_ADMIN_BASE_PATH');
            $jsonPath = $view_page_base_path. "module/add_form.json";
            $json = json_decode(file_get_contents(resource_path($jsonPath)), true);

            if (!$json) {
                return redirect()->back()->withErrors(['JSON file not found or invalid.']);
            }
            $pageSettings = $this->pageSetting('add');
            $page_title =  $pageSettings['page_title'];
            $page_description = $pageSettings['page_description'];
            $breadcrumbs = $pageSettings['breadcrumbs'];
            return view('admin.layout.form-master.add', compact('json','page_title', 'page_description', 'breadcrumbs'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }



    public function edit(Request $request, $id)
    {
        try {

            if ($request->isMethod('post')) {
            }

            $details = Module::where('id',$id)->first();
            if ($details) {


                $view_page_base_path = env('VIEW_ADMIN_BASE_PATH');
                $jsonPath = $view_page_base_path. "module/edit_form.json";
                $json = json_decode(file_get_contents(resource_path($jsonPath)), true);

                if (!$json) {
                    return redirect()->back()->withErrors(['JSON file not found or invalid.']);
                }


                $pageSettings = $this->pageSetting('edit');
                $page_title =  $pageSettings['page_title'];
                $page_description = $pageSettings['page_description'];
                $breadcrumbs = $pageSettings['breadcrumbs'];
                return view('admin.layout.form-master.edit', compact('page_title', 'page_description', 'breadcrumbs', 'details','json'));
            } else {
                return redirect()->back()->withErrors(['Role details not exist.']);
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            if ($id) {
                DB::beginTransaction();
                $cat = Module::find($id);
                if ($cat->delete()) {
                    DB::commit();
                    return redirect()->back()->with('success', 'Module deleted successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to delete try again.');
                }
            } else {
                return redirect()->back()->with('error', 'Module details not found.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function updateStatus($id, $status)
    {
        try {
            if ($id) {
                DB::beginTransaction();
                $status = ($status == 1) ? $status = 0 : $status = 1;
                $updateArr = [
                    'status' => $status,
                ];
                $response = Module::UpdateOrCreate(['id' => $id], $updateArr);
                DB::commit();
                return redirect()->back()->with('success', 'Module status updated successfully.');
            } else {
                return redirect()->back()->with('error', 'Module details not found.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function pageSetting($action, $dataArray = [])
    {
        if ($action == 'edit') {
            $data['page_title'] = 'Module List';
            $data['page_description'] = 'Edit Module';
            $data['breadcrumbs'] = [
                [
                    'title' => 'Modules',
                    'url' => url('admin/module/list'),
                ]
            ];
            if (isset($dataArray['title']) && !empty($dataArray['title'])) {
                $data['breadcrumbs'][] =
                    [
                        'title' => $dataArray['title'],
                        'url' => '',

                    ];
            }
            return $data;
        }

        if ($action == 'add') {
            $data['page_title'] = 'Modules';
            $data['page_description'] = 'Add New Module';
            $data['breadcrumbs'] = [
                [
                    'title' => 'Module',
                    'url' => url('admin/module/list'),
                ],
                [
                    'title' => 'Add a New Module',
                    'url' => '',
                ],
            ];
            return $data;
        }

        if ($action == 'template') {
            $data['page_title'] = 'Module Template';
            $data['page_description'] = 'Module Template';
            $data['breadcrumbs'] = [
                [
                    'title' => 'Module Template',
                    'url' => '',
                ],
            ];
            return $data;
        }

    }

}
