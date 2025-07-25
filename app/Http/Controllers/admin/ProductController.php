<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product; // Assuming you have a Product model
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        try {
        $page_title = 'Product List';
        $page_description = '';
        $breadcrumbs = [
            [
            'title' => 'Product List',
            'url' => '',
            ]
        ];
        $status = request('status');
        if ($status == '0') {
            $status = '2';
        }
        $details = Product::when($status !== null && $status !== '', function ($query) use ($status) {
                if ($status != '-1') {
                    $query->where('status', '=', $status);
                }
            })->orderBy('id', 'asc')->get();

        return view('admin.pages.product.list', compact('page_title', 'page_description', 'breadcrumbs',  'details'));
        } catch (\Exception $e) {
        dd($e);
        return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function add(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $validator = \Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'price' => 'required|numeric|min:0',
                    // 'description' => 'nullable|string',
                    // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->input('name'),
                    'description' => $request->input('description', ''),
                    'price' => $request->input('price', 0.00),
                    'status' => $request->input('status', 1),
                ];

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/products'), $filename);
                    $array['image'] = 'uploads/products/' . $filename;
                }

                $product = Product::updateOrCreate(
                    ['id' => $request->input('id', 0)],
                    $array
                );
                DB::commit();
                return redirect('/admin/product/list')->with('success', 'Product saved successfully!');
            }
            $page_title = 'Add Product';
            $page_description = '';
            $breadcrumbs = [
                [                'title' => 'Add Product',
                'url' => '',
                ]
            ];
            return view('admin.pages.product.add', compact('page_title', 'page_description', 'breadcrumbs'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id, Request $request)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            if ($request->isMethod('post')) {
                $validator = \Validator::make($request->all(), [
                    'name' => 'required|string|max:255',
                    'price' => 'required|numeric|min:0',
                    // 'description' => 'nullable|string',
                    // 'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                DB::beginTransaction();

                $array = [
                    'name' => $request->input('name'),
                    'description' => $request->input('description', ''),
                    'price' => $request->input('price', 0.00),
                    'status' => $request->input('status', 1),
                ];

                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $filename = time() . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('uploads/products'), $filename);
                    $array['image'] = 'uploads/products/' . $filename;
                }

                $product->update($array);
                DB::commit();
                return redirect('/admin/product/list')->with('success', 'Product updated successfully!');
            }

            $page_title = 'Edit Product';
            $page_description = '';
            $breadcrumbs = [
                [
                    'title' => 'Edit Product',
                    'url' => '',
                ]
            ];
            return view('admin.pages.product.edit', compact('page_title', 'page_description', 'breadcrumbs', 'product'));
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            $product->delete();
            return redirect('/admin/product/list')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus($id, $status)
    {
        try {
            $product = Product::find($id);
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found.');
            }

            $product->status = $status;
            $product->save();

            return redirect('/admin/product/list')->with('success', 'Product status updated successfully!');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
