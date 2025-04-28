@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Products</h2>

<!-- Top bar with Add button -->
<div class="d-flex justify-content-between align-items-center mb-3">
<div>
    <strong>Filter by Category:</strong>
    <form id="filterForm" method="GET" action="{{ route('admin.products') }}" class="d-inline-block">
        <select class="form-select d-inline-block w-auto" name="category" id="categoryFilter" onchange="document.getElementById('filterForm').submit();">
            <option value="">All Categories</option>
            @foreach($categories as $category)

                <option value="{{ $category['fldID'] }}" {{ request('category') == $category['fldID'] ? 'selected' : '' }}>
                    {{ $category['fldName'] }}
                </option>
            @endforeach
        </select>
    </form>
</div>
<div class="d-flex align-items-center gap-3">
<a href="{{ route('admin.products.export') }}" class="btn btn-success" style="margin-bottom: 20px;">
    <i class="fas fa-download"></i> Download Products CSV
</a>


    <form action="{{ route('admin.products.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="file">Choose a file to import</label>
            <input type="file" name="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>
</div>
    <button id="addProductButton" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
        + Add New Product
    </button>
</div>

<!-- Products Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive" style="max-height: 500px;">
            <table class="table table-bordered table-sm" id="productsTable">
                <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Short Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="product-row"
                        data-id="{{ $product['fldID'] }}"
                        data-name="{{ $product['fldName'] }}"
                        data-shortdescription="{{ $product['fldShortDescription'] }}"
                        data-price="{{ $product['fldPrice'] }}"
                        data-category="{{ $product['fldCategoryName'] }}"
                        data-brand="{{ $product['fldBrand'] }}">

                        <td>{{ $product['fldName'] }}</td>
                        <td>{{ $product['fldShortDescription'] }}</td>
                        <td>{{ $product['fldPrice'] }}</td>
                        <td>{{ $product['fldCategoryName'] }}</td>
                        <td>{{ $product['fldBrand'] }}</td>
                        <td>
                            <button class="btn btn-info btn-sm view-more-btn" data-bs-toggle="modal" data-bs-target="#viewMoreModal" data-id="{{ $product['fldID'] }}">View More</button>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $product['fldID'] }}">Edit</button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $product['fldID'] }}">Delete</button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    {{-- Pagination --}}
    {{ $products->links() }}
</div>

<!-- View More Modal -->
<div class="modal fade" id="viewMoreModal" tabindex="-1" aria-labelledby="viewMoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMoreLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewMoreContent">
                <!-- Dynamic content will be injected here via JS -->
            </div>
        </div>
    </div>
</div>

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form id="addProductForm" method="POST" action="{{ route('admin.products.create') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                    <div class="container-fluid">
                        
                        <!-- Section: Basic Information -->
                        <h5 class="mb-3 mt-2 border-bottom pb-2">Basic Information</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="fldName" class="form-control" placeholder="Product Name" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="fldShortDescription" class="form-control" placeholder="Short Description">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="fldDescription" class="form-control" placeholder="Description">
                            </div>
                        </div>

                        <!-- Section: Pricing & Categories -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Pricing & Categories</h5>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <input type="number" name="fldPrice" class="form-control" step="0.0001" placeholder="Price" required>
                            </div>
                            <div class="col-md-5">
                                <select name="fldMainCategory" class="form-select" required>
                                    <option value="">-- Select Main Category --</option>
                                    @foreach($categories as $category)
                                        @if($category['subCategoryId'] == NULL)
                                            <option value="{{ $category['fldID'] }}">{{ $category['fldName'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-5">
                                <select name="fldCategoryID" class="form-select">
                                    <option value="">-- Select Subcategory --</option>
                                    @foreach($categories as $category)
                                        @if($category['subCategoryId'] != NULL)
                                            <option value="{{ $category['fldID'] }}">{{ $category['fldName'] }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Section: Product Image -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Product Image</h5>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <input type="file" name="fldImage" class="form-control" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <div class="col-md-6 text-center">
                                <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid d-none" style="max-height: 200px; border-radius: 20px;">
                            </div>
                        </div>

                        <!-- Section: Brand & FDA -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Brand & FDA Details</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <input type="text" name="fldBrand" class="form-control" placeholder="Brand">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="fldFDARegistration" class="form-control" placeholder="FDA Registration">
                            </div>
                        </div>

                        <!-- Section: Additional Info -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Additional Info</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="text" name="fldMaterial" class="form-control" placeholder="Material">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="fldWeight" class="form-control" placeholder="Weight (kg)">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="fldWidth" class="form-control" placeholder="Width (cm)">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="fldLength" class="form-control" placeholder="Length (cm)">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="fldHeight" class="form-control" placeholder="Height (cm)">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="fldDimension" class="form-control" placeholder="Custom Dimension (Optional)">
                            </div>
                        </div>

                        <!-- Section: Warranty & Conditions -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Warranty & Conditions</h5>
                        <div class="row g-3">
                            <div class="col-md-3">
                                <input type="text" name="fldUnit" class="form-control" placeholder="Unit">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="fldWarranty" class="form-control" placeholder="Warranty">
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="fldWarrantyPolicy" class="form-control" placeholder="Warranty Policy">
                            </div>
                            <div class="col-md-2">
                                <input type="text" name="fldCondition" class="form-control" placeholder="Condition">
                            </div>
                        </div>

                        <!-- Section: Special Pricing -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Special Pricing</h5>
                        <div class="row g-3">
                            <div class="col-md-4">
                                <input type="number" name="fldSpecialPrice" class="form-control" step="0.0001" placeholder="Special Price (Optional)">
                            </div>
                        </div>

                        <!-- Section: Product Flags -->
                        <h5 class="mb-3 mt-4 border-bottom pb-2">Product Flags</h5>
                        <div class="row g-3">
                            <div class="col-md-2">
                                <select name="fldIsBattery" class="form-select">
                                    <option value="0">Battery: No</option>
                                    <option value="1">Battery: Yes</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="fldIsFlammable" class="form-select">
                                    <option value="0">Flammable: No</option>
                                    <option value="1">Flammable: Yes</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="fldIsLiquid" class="form-select">
                                    <option value="0">Liquid: No</option>
                                    <option value="1">Liquid: Yes</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="fldIsPublished" class="form-select">
                                    <option value="1">Published</option>
                                    <option value="0">Unpublished</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="fldIsCompanyOwned" class="form-select">
                                    <option value="1">Company-Owned</option>
                                    <option value="0">Not Company-Owned</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="fldIsSoldOut" class="form-select">
                                    <option value="0">Available</option>
                                    <option value="1">Sold Out</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select name="fldIsVisible" class="form-select">
                                    <option value="1">Visible</option>
                                    <option value="0">Hidden</option>
                                </select>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form id="editProductForm" action="{{ route('admin.products.edit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">

                    <!-- Hidden ID -->
                    <input type="hidden" name="edit_fldID" id="edit_fldID">
                    <!-- Product Current Image -->
                     <div class="mb-3">
                        <label for="currentImage" class="form-label">Current Product Image</label>
                        <img id="currentImage" src="" alt="" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                    </div>
                    <!-- Basic Information -->
                    <h5 class="mt-3">Basic Information</h5>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-4 form-floating">
                            <input type="text" id="edit_fldName" name="edit_fldName" class="form-control" placeholder="Product Name" required>
                            <label for="edit_fldName">Product Name</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <input type="text" id="edit_fldShortDescription" name="edit_fldShortDescription" class="form-control" placeholder="Short Description">
                            <label for="edit_fldShortDescription">Short Description</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <input type="text" id="edit_fldDescription" name="edit_fldDescription" class="form-control" placeholder="Description">
                            <label for="edit_fldDescription">Description</label>
                        </div>
                    </div>

                    <!-- Pricing & Categories -->
                    <h5 class="mt-4">Pricing & Categories</h5>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-2 form-floating">
                            <input type="number" id="edit_fldPrice" name="edit_fldPrice" class="form-control" step="0.0001" placeholder="Price" required>
                            <label for="edit_fldPrice">Price</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <select name="edit_fldMainCategory" id="edit_fldMainCategory" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    @if($category['subCategoryId'] == NULL)
                                        <option value="{{ $category['fldID'] }}">{{ $category['fldName'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="edit_fldMainCategory">Main Category</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <select name="edit_fldCategoryID" id="edit_fldCategoryID" class="form-select">
                                <option value="">-- Select Subcategory --</option>
                                @foreach($categories as $category)
                                    @if($category['subCategoryId'] != NULL)
                                        <option value="{{ $category['fldID'] }}">{{ $category['fldName'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <label for="edit_fldCategoryID">Subcategory</label>
                        </div>
                    </div>

                    <!-- Brand & FDA -->
                    <h5 class="mt-4">Brand & FDA Info</h5>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-4 form-floating">
                            <input type="text" name="edit_fldBrand" class="form-control" placeholder="Brand">
                            <label>Brand</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <input type="text" name="edit_fldFDARegistration" class="form-control" placeholder="FDA Registration">
                            <label>FDA Registration</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <input type="text" name="edit_fldMaterial" class="form-control" placeholder="Material">
                            <label>Material</label>
                        </div>
                    </div>

                    <!-- Dimensions -->
                    <h5 class="mt-4">Product Dimensions</h5>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-2 form-floating">
                            <input type="number" name="edit_fldWeight" class="form-control" placeholder="Weight">
                            <label>Weight</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <input type="number" name="edit_fldWidth" class="form-control" placeholder="Width">
                            <label>Width</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <input type="number" name="edit_fldLength" class="form-control" placeholder="Length">
                            <label>Length</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <input type="number" name="edit_fldHeight" class="form-control" placeholder="Height">
                            <label>Height</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <input type="text" name="edit_fldDimension" class="form-control" placeholder="Dimension">
                            <label>Dimension</label>
                        </div>
                    </div>

                    <!-- Warranty & Conditions -->
                    <h5 class="mt-4">Warranty & Conditions</h5>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-2 form-floating">
                            <input type="text" name="edit_fldUnit" class="form-control" placeholder="Unit">
                            <label>Unit</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <input type="text" name="edit_fldWarranty" class="form-control" placeholder="Warranty">
                            <label>Warranty</label>
                        </div>
                        <div class="col-md-4 form-floating">
                            <input type="text" name="edit_fldWarrantyPolicy" class="form-control" placeholder="Warranty Policy">
                            <label>Warranty Policy</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <input type="text" name="edit_fldCondition" class="form-control" placeholder="Condition">
                            <label>Condition</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <input type="number" name="edit_fldSpecialPrice" class="form-control" step="0.0001" placeholder="Special Price">
                            <label>Special Price</label>
                        </div>
                    </div>

                    <!-- Flags -->
                    <h5 class="mt-4">Product Flags</h5>
                    <hr>
                    <div class="row g-3">
                        <div class="col-md-2 form-floating">
                            <select name="edit_fldIsBattery" class="form-select">
                                <option value="0">No</option><option value="1">Yes</option>
                            </select>
                            <label>Battery</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <select name="edit_fldIsFlammable" class="form-select">
                                <option value="0">No</option><option value="1">Yes</option>
                            </select>
                            <label>Flammable</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <select name="edit_fldIsLiquid" class="form-select">
                                <option value="0">No</option><option value="1">Yes</option>
                            </select>
                            <label>Liquid</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <select name="edit_fldIsPublished" class="form-select">
                                <option value="1">Published</option><option value="0">Unpublished</option>
                            </select>
                            <label>Status</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <select name="edit_fldIsCompanyOwned" class="form-select">
                                <option value="1">Company-Owned</option><option value="0">Not Company-Owned</option>
                            </select>
                            <label>Ownership</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <select name="edit_fldIsSoldOut" class="form-select">
                                <option value="0">Available</option><option value="1">Sold Out</option>
                            </select>
                            <label>Availability</label>
                        </div>
                        <div class="col-md-2 form-floating">
                            <select name="edit_fldIsVisible" class="form-select">
                                <option value="1">Visible</option><option value="0">Hidden</option>
                            </select>
                            <label>Visibility</label>
                        </div>
                    </div>

                    <!-- Upload Image -->
                    <h5 class="mt-4">Product Images</h5>
                    <hr>
                    <div class="mb-3">
                        <label for="edit_fldImage" class="form-label">Upload Product Image</label>
                        <input class="form-control" type="file" id="edit_fldImage" name="edit_fldImage" accept="image/*" name="edit_fldImage" onchange="previewImage(event)">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Product Modal -->
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteProductForm" method="POST" action="{{route('admin.products.delete')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductLabel">Delete Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product?</p>
                    <input type="hidden" name="delete_fldID" id="delete_fldID">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Delete</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Flash Message Modal -->
@if(session('success') || session('error') || session('info'))
<div class="modal fade" id="flashMessageModal" tabindex="-1" aria-labelledby="flashMessageLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-{{ session('success') ? 'success' : (session('error') ? 'danger' : 'info') }}">
            <div class="modal-header bg-{{ session('success') ? 'success' : (session('error') ? 'danger' : 'info') }} text-white">
                <h5 class="modal-title" id="flashMessageLabel">
                    {{ session('success') ? 'Success' : (session('error') ? 'Error' : 'Notice') }}
                </h5>
            </div>
            <div class="modal-body">
                {{ session('success') ?? session('error') ?? session('info') }}
            </div>
        </div>
    </div>
</div>
@endif


@endsection


@section('scripts')
<script>
    var products = @json($products);
    document.addEventListener('DOMContentLoaded', function () {
        // View More Button Click Handler
        const viewMoreButtons = document.querySelectorAll('.view-more-btn');
        viewMoreButtons.forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-id');
                const productRow = document.querySelector(`.product-row[data-id="${productId}"]`);
                const productData = {
                    name: productRow.cells[0].innerText,
                    shortDescription: productRow.cells[1].innerText,
                    price: productRow.cells[2].innerText,
                    category: productRow.cells[3].innerText,
                    brand: productRow.cells[4].innerText,
                    fdaRegistration: productRow.cells[5].innerText,
                };
                
                products.data.forEach(product => {
                    if(product.fldID == productId) {
                        productData.description = product.fldDescription;
                        productData.expiryDate = product.fldExpiryDate;
                        productData.material = product.fldMaterial;
                        productData.weight = product.fldWeight;
                        productData.width = product.fldWidth;
                        productData.length = product.fldLength;
                        productData.height = product.fldHeight;
                        productData.dimension = product.fldDimension;
                        productData.unit = product.fldUnit;
                        productData.warranty = product.fldWarranty;
                        productData.warrantyPolicy = product.fldWarrantyPolicy;
                        productData.condition = product.fldCondition;
                        productData.specialPrice = product.fldSpecialPrice;
                        productData.variation1 = product.fldVariation1;
                        productData.variation2 = product.fldVariation2;
                        productData.isBattery = (product.fldIsBattery == '1') ? 'Yes' : 'No';
                        productData.isFlammable = (product.fldIsFlammable == '1') ? 'Yes' : 'No';
                        productData.isLiquid = (product.fldIsLiquid == '1') ? 'Yes' : 'No';
                        productData.isPublished = (product.fldIsPublished == '1') ? 'Yes' : 'No';
                        productData.isCompanyOwned = (product.fldIsCompanyOwned == '1') ? 'Yes' : 'No';
                        productData.isSoldOut = (product.fldIsSoldOut == '1') ? 'Yes' : 'No';
                        productData.isVisible = (product.fldIsVisible == '1') ? 'Yes' : 'No';
                        productData.image = product.fldImage ? '{{ asset('storage') }}/' + product.fldImage : '{{ asset('storage/images/default.png') }}';
                    }
                });

                const modalContent = document.getElementById('viewMoreContent');

                modalContent.innerHTML = `
                    <div class="container-fluid">
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <img src="${productData.image}" alt="${productData.name}" class="img-fluid rounded" style="max-height: 300px; object-fit: contain;">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <h3 class="fw-bold">${productData.name}</h3>
                                <p class="text-muted">${productData.shortDescription}</p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="fw-semibold">Product Details</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Price:</strong> ${productData.price}</li>
                                    <li class="list-group-item"><strong>Special Price:</strong> ${productData.specialPrice}</li>
                                    <li class="list-group-item"><strong>Category:</strong> ${productData.category}</li>
                                    <li class="list-group-item"><strong>Brand:</strong> ${productData.brand}</li>
                                    <li class="list-group-item"><strong>FDA Registration:</strong> ${productData.fdaRegistration}</li>
                                    <li class="list-group-item"><strong>Condition:</strong> ${productData.condition}</li>
                                    <li class="list-group-item"><strong>Expiry Date:</strong> ${productData.expiryDate}</li>
                                    <li class="list-group-item"><strong>Warranty:</strong> ${productData.warranty}</li>
                                    <li class="list-group-item"><strong>Warranty Policy:</strong> ${productData.warrantyPolicy}</li>
                                    <li class="list-group-item"><strong>Unit:</strong> ${productData.unit}</li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-semibold">Specifications</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Material:</strong> ${productData.material}</li>
                                    <li class="list-group-item"><strong>Weight:</strong> ${productData.weight}</li>
                                    <li class="list-group-item"><strong>Dimensions:</strong> ${productData.length} x ${productData.width} x ${productData.height} ${productData.dimension}</li>
                                    <li class="list-group-item"><strong>Variation 1:</strong> ${productData.variation1}</li>
                                    <li class="list-group-item"><strong>Variation 2:</strong> ${productData.variation2}</li>
                                    <li class="list-group-item"><strong>Battery:</strong> ${productData.isBattery}</li>
                                    <li class="list-group-item"><strong>Flammable:</strong> ${productData.isFlammable}</li>
                                    <li class="list-group-item"><strong>Liquid:</strong> ${productData.isLiquid}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="fw-semibold">Visibility</h5>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><strong>Published:</strong> ${productData.isPublished}</li>
                                    <li class="list-group-item"><strong>Company-Owned:</strong> ${productData.isCompanyOwned}</li>
                                    <li class="list-group-item"><strong>Sold Out:</strong> ${productData.isSoldOut}</li>
                                    <li class="list-group-item"><strong>Visible:</strong> ${productData.isVisible}</li>
                                    <li class="list-group-item"><strong>Deleted:</strong> ${productData.isDeleted ? 'Yes' : 'No'}</li>
                                </ul>
                            </div>

                            <div class="col-md-6">
                                <h5 class="fw-semibold">Full Description</h5>
                                <p>${productData.description}</p>
                            </div>
                        </div>
                    </div>
                `;

            });
            
        });

        // Filter Table by Category
        const categoryFilter = document.getElementById('categoryFilter');
        categoryFilter.addEventListener('change', function() {
            const selectedCategoryName = this.options[this.selectedIndex].text;

            
            rows.forEach(row => {
                const rowCategoryName = row.getAttribute('data-category-name');
                if (selectedCategoryName === "All Categories" || rowCategoryName === selectedCategoryName) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

<script>
    var products = @json($products);
    var categories = @json($categories);
    console.log(".",products);
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                const cells = row.querySelectorAll('td');
                products.data.forEach(product => {
                    if(product.fldID == productId) {
                        document.getElementById('edit_fldID').value = product.fldID;
                        document.getElementById('edit_fldName').value = product.fldName ;
                        document.getElementById('edit_fldShortDescription').value = product.fldShortDescription;
                        document.getElementById('edit_fldDescription').value = product.fldDescription;
                        document.getElementById('edit_fldPrice').value = product.fldPrice;
                        document.querySelector(`select[name="edit_fldCategoryID"]`).value = product.fldCategoryID;
                        document.querySelector(`input[name="edit_fldBrand"]`).value = product.fldBrand;
                        document.querySelector(`input[name="edit_fldFDARegistration"]`).value = product.fldFDARegistration;
                        document.querySelector(`input[name="edit_fldMaterial"]`).value = product.fldMaterial;
                        document.querySelector(`input[name="edit_fldWeight"]`).value = product.fldWeight;
                        document.querySelector(`input[name="edit_fldWidth"]`).value = product.fldWidth;
                        document.querySelector(`input[name="edit_fldLength"]`).value = product.fldLength;
                        document.querySelector(`input[name="edit_fldHeight"]`).value = product.fldHeight;
                        document.querySelector(`input[name="edit_fldDimension"]`).value = product.fldDimension;
                        document.querySelector(`input[name="edit_fldUnit"]`).value = product.fldUnit;
                        document.querySelector(`input[name="edit_fldWarranty"]`).value = product.fldWarranty;
                        document.querySelector(`input[name="edit_fldWarrantyPolicy"]`).value = product.fldWarrantyPolicy;
                        document.querySelector(`input[name="edit_fldCondition"]`).value = product.fldCondition;
                        document.querySelector(`input[name="edit_fldSpecialPrice"]`).value = product.fldSpecialPrice;
                        document.querySelector(`select[name="edit_fldIsBattery"]`).value = product.fldIsBattery;
                        document.querySelector(`select[name="edit_fldIsFlammable"]`).value = product.fldIsFlammable;
                        document.querySelector(`select[name="edit_fldIsLiquid"]`).value = product.fldIsLiquid;
                        document.querySelector(`select[name="edit_fldIsPublished"]`).value = product.fldIsPublished;
                        document.querySelector(`select[name="edit_fldIsCompanyOwned"]`).value = product.fldIsCompanyOwned;
                        document.querySelector(`select[name="edit_fldIsSoldOut"]`).value = product.fldIsSoldOut;
                        document.querySelector(`select[name="edit_fldIsVisible"]`).value = product.fldIsVisible;
                        document.querySelector('#currentImage').src = product.fldImage ? '{{ asset('storage') }}/' + product.fldImage : '{{ asset('storage/images/default.png') }}';
                    }
                });
                const categorySelect = document.querySelector(`select[name="edit_fldMainCategory"]`);
                const subCategorySelect = document.querySelector(`select[name="edit_fldCategoryID"]`);
                categorySelect.value = row.getAttribute('data-category');
                subCategorySelect.value = row.getAttribute('data-subcategory');
                categorySelect.addEventListener('change', function() {
                    const selectedCategory = this.value;
                    subCategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
                    console.log(categories)
                    categories.forEach(category => {
                        if (category.subCategoryId == selectedCategory) {
                            const option = document.createElement('option');
                            option.value = category.fldID;
                            option.textContent = category.fldName;
                            subCategorySelect.appendChild(option);
                        }
                    });
                });
                const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
                editModal.show();
            });
        });

        @if(session('success') || session('error') || session('info'))
            const flashModal = new bootstrap.Modal(document.getElementById('flashMessageModal'));
            flashModal.show();
            setTimeout(() => {
                flashModal.hide();
            }, 3000);
        @endif
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                document.getElementById('delete_fldID').value = productId;

                const deleteModal = new bootstrap.Modal(document.getElementById('deleteProductModal'));
                deleteModal.show();
            });
        });
    });
    document.querySelector('#addProductButton').addEventListener('click', function() {
        
        const categorySelect = document.querySelector(`select[name="fldMainCategory"]`);
        const subCategorySelect = document.querySelector(`select[name="fldCategoryID"]`);
        categorySelect.addEventListener('change', function() {
            const selectedCategory = this.value;
            subCategorySelect.innerHTML = '<option value="">-- Select Subcategory --</option>';
            console.log(categories)
            categories.forEach(category => {
                if (category.subCategoryId == selectedCategory) {
                    const option = document.createElement('option');
                    option.value = category.fldID;
                    option.textContent = category.fldName;
                    subCategorySelect.appendChild(option);
                }
            });
        });
    });
    // Preview Image Function
    function previewImage(event) {
        const image = document.getElementById('currentImage');
        //create image below 
        const img = document.createElement('img');
        img.src = URL.createObjectURL(event.target.files[0]);
        // add it to the modal edit
        const editModal = document.getElementById('editProductModal');
        const modalBody = editModal.querySelector('.modal-body');
        modalBody.appendChild(img);
        img.style.maxHeight = '200px';
        img.style.objectFit = 'contain';
        img.style.width = '100%';
        img.style.borderRadius = '0.5rem';
        img.style.marginTop = '1rem';
        img.style.marginBottom = '1rem';
        img.style.display = 'block';
    }
</script>
@endsection
