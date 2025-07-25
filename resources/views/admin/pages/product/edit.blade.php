@extends('admin.layout.default')

@section('product-master','active menu-item-open')
@section('content')
<div class="card card-custom">
    <div class="card-body">
        <div class="mb-7">
            <div class="row align-items-center">
                <form method="POST" action="" enctype="multipart/form-data" class="w-100">
                    {{ csrf_field() }}
                    <div class="col-lg-9 col-xl-12">
                        <div class="row align-items-center">
                            <div class="form-group col-md-6">
                                <label>Product Name</label>
                                <div>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="form-control" placeholder="Enter Product Name">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Price</label>
                                <div>
                                    <input type="text" name="price" value="{{ old('price', $product->price) }}" required class="form-control number" placeholder="Enter Product Price">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Description</label>
                                <div>
                                    <textarea name="description" rows="5" class="form-control" placeholder="Enter Product Description">{{ old('description', $product->description) }}</textarea>
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Product Image</label>
                                <div>
                                    <input type="file" name="image" class="form-control">
                                    @if($product->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product Image" width="120">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <center>
                                    <button class="btn btn-success">Update</button>
                                </center>
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
@endsection
