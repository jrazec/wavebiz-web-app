@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Product List') }}</div>
                <!-- Slicer of Categories & Subcategories -->
                <div class="card-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select id="category" name="category" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->fldID }}">{{ $category->fldName }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="subcategory" class="form-label">Subcategory</label>
                        <select id="subcategory" name="subcategory" class="form-select">
                            <option value="">Select Subcategory</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->fldID }}">{{ $subcategory->subcategoryName }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Access $product and put into table -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Product Name</th>
                                <th scope="col">Description</th>
                                <th scope="col">Short Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->fldName }}</td>
                                    <td>{{ $product->fldDescription }}</td>
                                    <td>{{ $product->fldShortDescription }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var products = @json($products);
    var categories = @json($categories);
    var subcategories = @json($subcategories);
    console.log(products);
    console.log(categories);
    console.log(subcategories);
</script>