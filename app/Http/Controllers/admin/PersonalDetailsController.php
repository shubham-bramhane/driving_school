<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Learning;
use App\Models\Driving;
use App\Models\Renewal;
use DB;
use Validator;
use Illuminate\Support\Str;

class PersonalDetailsController extends Controller
{
    public function index()
    {
        try {

        $page_title = 'Personal Details';
        $page_description = '';
        $breadcrumbs = [
            [
            'title' => 'Personal Details',
            'url' => '',
            ]
        ];
        $status = request('status');
        if ($status == '0') {
            $status = '2';
        }
        $details = User::when($status, function ($users) use ($status) {
            if ($status != '-1') {
                $status = conditionalStatus($status);
                $users->where('status', '=', $status);
            }
        })->where('role_id', 2) // Exclude super admin
        ->orderBy('id', 'asc')->get();

        return view('admin.pages.personal-information.list', compact('page_title', 'page_description', 'breadcrumbs',  'details'));
        } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function add(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $validator = Validator::make($data, [
                    'json' => 'required|json',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                // Always save the JSON data in public directory with a date-time stamp
                $dateFolder = date('Y-m-d');
                $directory = public_path('license/' . $dateFolder);
                $fileName = $dateFolder . '.json';
                $filePath = $directory . '/' . $fileName;

                // Ensure the directory exists
                if (!is_dir($directory)) {
                    mkdir($directory, 0755, true);
                }

                // Validate and decode JSON data
                if (empty($data['json'])) {
                    return redirect()->back()->withErrors(['json' => 'JSON data is required.'])->withInput();
                }
                $jsonData = json_decode($data['json'], true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return redirect()->back()->withErrors(['json' => 'Invalid JSON data.'])->withInput();
                }

                // Read existing data or initialize as empty array
                $existingData = [];
                if (file_exists($filePath)) {
                    $existingData = json_decode(file_get_contents($filePath), true);
                    if (!is_array($existingData)) {
                        $existingData = [];
                    }
                }

                // Append new JSON to the array and save
                $existingData[] = $jsonData;
                file_put_contents($filePath, json_encode($existingData, JSON_PRETTY_PRINT));

                DB::beginTransaction();

                // Prepare user data, but do not update certain fields if already present
                $user = User::where('name', $jsonData['name'] ?? '')
                    ->where('date_of_birth', isset($jsonData['date_of_birth']) ? date('Y-m-d', strtotime($jsonData['date_of_birth'])) : null)
                    ->first();

                $userArray = [
                    'name' => $jsonData['name'] ?? '',
                    'date_of_birth' => $jsonData['date_of_birth'] ? date('Y-m-d', strtotime($jsonData['date_of_birth'])) : null,
                    'blood_group' => $jsonData['blood_group'] ?? '',
                    'father_name' => $jsonData['father_name'] ?? '',
                    'applicant_gender' => $jsonData['applicant_gender'] ?? '',
                    'email' => $jsonData['email'] ?? '',
                    'mobile_no' => $jsonData['mobile_no'] ?? '',
                    'role_id' => 2, // Assuming role_id 2 is for 'user'
                    'password' => $jsonData['mobile_no'] ?? '',
                    'total' => $jsonData['total'] ?? '',
                ];

                if ($user) {
                    // Do not update these fields if already present
                    unset($userArray['mobile_no'], $userArray['total'], $userArray['name'], $userArray['father_name']);
                    $user->update($userArray);
                } else {
                    $user = User::create($userArray);
                }


                if($jsonData['licence_type'] == '' || $jsonData['licence_type'] == 'll') {

                $dataArray = [
                    'user_id' => $user->id,
                    'application_no' => $jsonData['application_no'] ?? '',
                    'application_date' => isset($jsonData['application_date']) ? date('Y-m-d', strtotime($jsonData['application_date'])) : null,
                    'dl_covs' => $jsonData['dl_covs'] ?? '',
                    'learning_no' => $jsonData['learning_no'] ?? '',
                    'learning_created_date' => isset($jsonData['learning_created_date']) ? date('Y-m-d', strtotime($jsonData['learning_created_date'])) : null,
                    'learning_expired_date' => isset($jsonData['learning_expired_date']) ? date('Y-m-d', strtotime($jsonData['learning_expired_date'])) : null,
                    'appointment_date' => isset($jsonData['appointment_date']) ? date('Y-m-d', strtotime($jsonData['appointment_date'])) : null,
                    'rto_office' => $jsonData['rto_office'] ?? '',
                    'attendance' => $jsonData['attendance'] ?? '',
                    'result' => $jsonData['result'] ?? '',
                    'status' => 0, // Assuming status 0 is for 'pending'
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $learning = Learning::updateOrCreate(
                    ['user_id' => $user->id],
                    $dataArray
                );

                }
                elseif($jsonData['licence_type'] == 'dl') {

                    $dataArray = [
                        'user_id' => $user->id,
                        'application_no' => $jsonData['application_no'] ?? '',
                        'application_date' => isset($jsonData['application_date']) ? date('Y-m-d', strtotime($jsonData['application_date'])) : null,
                        'dl_number' => $jsonData['dl_number'] ?? '',
                        'dl_covs' => $jsonData['dl_covs'] ?? '',
                        'nt_validity' => isset($jsonData['nt_validity']) ? date('Y-m-d', strtotime($jsonData['nt_validity'])) : null,
                        'tr_validity' => isset($jsonData['tr_validity']) ? date('Y-m-d', strtotime($jsonData['tr_validity'])) : null,
                        'license_approval_date' => isset($jsonData['license_approved_date']) ? date('Y-m-d', strtotime($jsonData['license_approved_date'])) : null,
                        'appointment_date' => isset($jsonData['appointment_date']) ? date('Y-m-d', strtotime($jsonData['appointment_date'])) : null,
                        'rto_office' => $jsonData['rto_office'] ?? '',
                        'attendance' => $jsonData['attendance'] ?? '',
                        'result' => $jsonData['result'] ?? '',
                        'status' => 0, // Assuming status 0 is for 'pending'
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $learning = Driving::updateOrCreate(
                        ['user_id' => $user->id],
                        $dataArray
                    );
                }
                elseif($jsonData['licence_type'] == 'renewal') {

                    $dataArray = [
                        'user_id' => $user->id,
                        'application_no' => $jsonData['application_no'] ?? '',
                        'application_date' => isset($jsonData['application_date']) ? date('Y-m-d', strtotime($jsonData['application_date'])) : null,
                        'dl_number' => $jsonData['dl_number'] ?? '',
                        'dl_covs' => $jsonData['dl_covs'] ?? '',
                        'nt_validity' => isset($jsonData['nt_validity']) && $jsonData['nt_validity'] ? date('Y-m-d', strtotime($jsonData['nt_validity'])) : null,
                        'tr_validity' => isset($jsonData['tr_validity']) && $jsonData['tr_validity'] ? date('Y-m-d', strtotime($jsonData['tr_validity'])) : null,
                        'learning_no' => $jsonData['learning_no'] ?? '',
                        'license_approval_date' => isset($jsonData['license_approval_date']) && $jsonData['license_approval_date'] ? date('Y-m-d', strtotime($jsonData['license_approval_date'])) : null,
                        'rto_office' => $jsonData['rto_office'] ?? '',
                        'result' => $jsonData['result'] ?? '',
                        'status' => 0, // Assuming status 0 is for 'pending'
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];

                    $learning = Renewal::updateOrCreate(
                        ['user_id' => $user->id],
                        $dataArray
                    );
                }

                DB::commit();
                // Redirect based on licence_type
                if ($jsonData['licence_type'] == '' || $jsonData['licence_type'] == 'll') {
                    return redirect('/admin/learning/list')->with('success', 'Learning License added successfully.');
                } elseif ($jsonData['licence_type'] == 'dl') {
                    return redirect('/admin/driving/list')->with('success', 'Driving License added successfully.');
                } elseif ($jsonData['licence_type'] == 'renewal') {
                    return redirect('/admin/renewal/list')->with('success', 'Renewal License added successfully.');
                } else {
                    return redirect('/admin/personal-information/list')->with('success', 'License added successfully.');
                }
            }


            $pageSettings = $this->pageSetting('add');
            $page_title =  $pageSettings['page_title'];
            $page_description = $pageSettings['page_description'];
            $breadcrumbs = $pageSettings['breadcrumbs'];
            return view('admin.pages.personal-information.add', compact('page_title', 'page_description', 'breadcrumbs'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }



    public function edit(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                // dd($request->all());
                 $validator = Validator::make($request->all(), [
                    'name' => 'required',
                    'date_of_birth' => 'required|date',
                    'father_name' => 'required',
                    'email' => 'nullable|email',
                    'mobile_no' => 'required|digits_between:10,15',
                ], [
                    'name.required' => 'Name is required.',
                    'date_of_birth.required' => 'Date of birth is required.',
                    'date_of_birth.date' => 'Date of birth must be a valid date.',
                    'father_name.required' => 'Father name is required.',
                    'email.email' => 'Email must be a valid email address.',
                    'mobile_no.required' => 'Mobile number is required.',
                    'mobile_no.digits_between' => 'Mobile number must be between 10 and 15 digits.',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $userArray = [
                    'name' => $request->name,
                    'date_of_birth' => date('Y-m-d', strtotime($request->date_of_birth)),
                    'blood_group' => $request->blood_group,
                    'father_name' => $request->father_name,
                    'mobile_no' => $request->mobile_no,
                    'email' => $request->email,
                    'total' => $request->total,
                ];

                // Check if mobile_no already exists for another user
                $existingUser = User::where('mobile_no', $request->mobile_no)
                    ->where('id', '!=', $request->id)
                    ->first();

                if ($existingUser) {
                    return redirect()->back()->withErrors(['mobile_no' => 'Mobile number already exists.'])->withInput();
                }

                $response = User::updateOrCreate(['id' => $request->id], $userArray);
                if (!$response) {
                    return redirect()->back()->withErrors('Failed to update personal information.')->withInput();
                }
                DB::commit();
                return redirect('/admin/personal-information/list')->with('success', 'Personal information updated successfully.');
            }


            $pageSettings = $this->pageSetting('edit', ['title' => 'Edit Personal Information']);
            $page_title =  $pageSettings['page_title'];
            $page_description = $pageSettings['page_description'];
            $breadcrumbs = $pageSettings['breadcrumbs'];
            $details = User::find($request->id);
            if (!$details) {
                return redirect()->back()->withErrors('User not found.');
            }
            return view('admin.pages.personal-information.edit', compact('page_title', 'page_description', 'breadcrumbs','details'));
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors($e->getMessage());
        }
    }

    // view page for personal details
    public function view($id)
    {
        try {
            if ($id) {
                $pageSettings = $this->pageSetting('edit', ['title' => 'View Personal Information']);
                $page_title =  $pageSettings['page_title'];
                $page_description = $pageSettings['page_description'];
                $breadcrumbs = $pageSettings['breadcrumbs'];
                $details = User::with(['learnings', 'drivings', 'renewals'])
                    ->where('id', $id)
                    ->first();
                if (!$details) {
                    return redirect()->back()->with('error', 'User not found.');
                }
                return view('admin.pages.personal-information.view', compact('page_title', 'page_description', 'breadcrumbs', 'details'));
            } else {
                return redirect()->back()->with('error', 'User details not found.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function delete($id)
    {
        try {
            if ($id) {
                DB::beginTransaction();
                $user = User::find($id);
                if (!$user) {
                    return redirect()->back()->with('error', 'User not found.');
                }
                // Optionally delete related learning records
                Learning::where('user_id', $id)->delete();
                if ($user->delete()) {
                    DB::commit();
                    return redirect()->back()->with('success', 'Personal details deleted successfully.');
                } else {
                    return redirect()->back()->with('error', 'Failed to delete, try again.');
                }
            } else {
                return redirect()->back()->with('error', 'User details not found.');
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
                $user = User::find($id);
                if (!$user) {
                    return redirect()->back()->with('error', 'User not found.');
                }
                $user->status = ($status == 1) ? 0 : 1;
                $user->save();
                DB::commit();
                return redirect()->back()->with('success', 'User status updated successfully.');
            } else {
                return redirect()->back()->with('error', 'User details not found.');
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function pageSetting($action, $dataArray = [])
    {
        $data = [];

        if ($action == 'edit') {
            $data['page_title'] = 'Personal Details';
            $data['page_description'] = 'Edit Personal Details';
            $data['breadcrumbs'] = [
                [
                    'title' => 'Personal Details',
                    'url' => url('admin/personal-information/list'),
                ]
            ];
            if (isset($dataArray['title']) && !empty($dataArray['title'])) {
                $data['breadcrumbs'][] = [
                    'title' => $dataArray['title'],
                    'url' => '',
                ];
            }
            return $data;
        }

        if ($action == 'add') {
            $data['page_title'] = 'Personal Details';
            $data['page_description'] = 'Add New Personal Details';
            $data['breadcrumbs'] = [
                [
                    'title' => 'Personal Details',
                    'url' => url('admin/personal-information/list'),
                ],
                [
                    'title' => 'Add New',
                    'url' => '',
                ],
            ];
            return $data;
        }

        return $data;
    }
}
