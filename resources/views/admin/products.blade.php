@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Products</h2>

<!-- Top bar with Add button -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <strong>Filter by Category:</strong>
        <select class="form-select d-inline-block w-auto" id="categoryFilter">
            <option value="">All Categories</option>
            @foreach($categories as $category)
                <option value="{{ $category['fldCategoryID'] }}">{{ $category['fldName'] }}</option>
            @endforeach
        </select>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
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
                    <th>FDA Registration</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="product-row" data-id="{{ $product['fldID'] }}" data-category-name="{{ $product['fldCategoryName'] }}">
                            <td>{{ $product['fldName'] }}</td>
                            <td>{{ $product['fldShortDescription'] }}</td>
                            <td>{{ $product['fldPrice'] }}</td>
                            <td>{{ $product['fldCategoryName'] }}</td>
                            <td>{{ $product['fldBrand'] }}</td>
                            <td>{{ $product['fldFDARegistration'] }}</td>
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
</div>

<!-- View More Modal -->
<div class="modal fade" id="viewMoreModal" tabindex="-1" aria-labelledby="viewMoreLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
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
            <form id="addProductForm" method="POST" action="{{route('admin.products.create')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductLabel">Add New Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Basic Info -->
                        <div class="col-md-4">
                            <input type="text" name="fldName" class="form-control" placeholder="Product Name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="fldShortDescription" class="form-control" placeholder="Short Description">
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="fldDescription" class="form-control" placeholder="Description">
                        </div>

                        <!-- Pricing & Category -->
                        <div class="col-md-2">
                            <input type="number" name="fldPrice" class="form-control" step="0.0001" placeholder="Price" required>
                        </div>
                        <div class="col-md-4">
                            <select name="fldCategoryID" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['fldID'] }}">{{ $category['fldName'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand & FDA -->
                        <div class="col-md-4"><input type="text" name="fldBrand" class="form-control" placeholder="Brand"></div>
                        <div class="col-md-4"><input type="text" name="fldFDARegistration" class="form-control" placeholder="FDA Registration"></div>

                        <!-- Additional Info -->
                        <div class="col-md-4"><input type="text" name="fldMaterial" class="form-control" placeholder="Material"></div>

                        <!-- Dimensions -->
                        <div class="col-md-2"><input type="number" name="fldWeight" class="form-control" placeholder="Weight"></div>
                        <div class="col-md-2"><input type="number" name="fldWidth" class="form-control" placeholder="Width"></div>
                        <div class="col-md-2"><input type="number" name="fldLength" class="form-control" placeholder="Length"></div>
                        <div class="col-md-2"><input type="number" name="fldHeight" class="form-control" placeholder="Height"></div>
                        <div class="col-md-2"><input type="text" name="fldDimension" class="form-control" placeholder="Dimension"></div>

                        <!-- Warranty & Conditions -->
                        <div class="col-md-2"><input type="text" name="fldUnit" class="form-control" placeholder="Unit"></div>
                        <div class="col-md-2"><input type="text" name="fldWarranty" class="form-control" placeholder="Warranty"></div>
                        <div class="col-md-4"><input type="text" name="fldWarrantyPolicy" class="form-control" placeholder="Warranty Policy"></div>
                        <div class="col-md-2"><input type="text" name="fldCondition" class="form-control" placeholder="Condition"></div>
                        <div class="col-md-2"><input type="number" name="fldSpecialPrice" class="form-control" step="0.0001" placeholder="Special Price"></div>

                        <!-- Flags -->
                        <div class="col-md-2">
                            <select name="fldIsBattery" class="form-select"><option value="0">Battery: No</option><option value="1">Battery: Yes</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="fldIsFlammable" class="form-select"><option value="0">Flammable: No</option><option value="1">Flammable: Yes</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="fldIsLiquid" class="form-select"><option value="0">Liquid: No</option><option value="1">Liquid: Yes</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="fldIsPublished" class="form-select"><option value="1">Published</option><option value="0">Unpublished</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="fldIsCompanyOwned" class="form-select"><option value="1">Company-Owned</option><option value="0">Not Company-Owned</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="fldIsSoldOut" class="form-select"><option value="0">Available</option><option value="1">Sold Out</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="fldIsVisible" class="form-select"><option value="1">Visible</option><option value="0">Hidden</option></select>
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
            <form id="editProductForm" action="{{route('admin.products.edit')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Basic Info -->
                        <input type="hidden" name="edit_fldID" id="edit_fldID">
                        <div class="col-md-4">
                            <input type="text" id="edit_fldName" name="edit_fldName" class="form-control" placeholder="Product Name" required>
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="edit_fldShortDescription" name="edit_fldShortDescription" class="form-control" placeholder="Short Description">
                        </div>
                        <div class="col-md-4">
                            <input type="text" id="edit_fldDescription" name="edit_fldDescription" class="form-control" placeholder="Description">
                        </div>

                        <!-- Pricing & Category -->
                        <div class="col-md-2">
                            <input type="number" id="edit_fldPrice" name="edit_fldPrice" class="form-control" step="0.0001" placeholder="Price" required>
                        </div>
                        <div class="col-md-4">
                            <select name="edit_fldCategoryID" class="form-select" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['fldID'] }}">{{ $category['fldName'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Brand & FDA -->
                        <div class="col-md-4"><input type="text" name="edit_fldBrand" class="form-control" placeholder="Brand"></div>
                        <div class="col-md-4"><input type="text" name="edit_fldFDARegistration" class="form-control" placeholder="FDA Registration"></div>

                        <!-- Additional Info -->
                        <div class="col-md-4"><input type="text" name="edit_fldMaterial" class="form-control" placeholder="Material"></div>

                        <!-- Dimensions -->
                        <div class="col-md-2"><input type="number" name="edit_fldWeight" class="form-control" placeholder="Weight"></div>
                        <div class="col-md-2"><input type="number" name="edit_fldWidth" class="form-control" placeholder="Width"></div>
                        <div class="col-md-2"><input type="number" name="edit_fldLength" class="form-control" placeholder="Length"></div>
                        <div class="col-md-2"><input type="number" name="edit_fldHeight" class="form-control" placeholder="Height"></div>
                        <div class="col-md-2"><input type="text" name="edit_fldDimension" class="form-control" placeholder="Dimension"></div>

                        <!-- Warranty & Conditions -->
                        <div class="col-md-2"><input type="text" name="edit_fldUnit" class="form-control" placeholder="Unit"></div>
                        <div class="col-md-2"><input type="text" name="edit_fldWarranty" class="form-control" placeholder="Warranty"></div>
                        <div class="col-md-4"><input type="text" name="edit_fldWarrantyPolicy" class="form-control" placeholder="Warranty Policy"></div>
                        <div class="col-md-2"><input type="text" name="edit_fldCondition" class="form-control" placeholder="Condition"></div>
                        <div class="col-md-2"><input type="number" name="edit_fldSpecialPrice" class="form-control" step="0.0001" placeholder="Special Price"></div>

                        <!-- Flags -->
                        <div class="col-md-2">
                            <select name="edit_fldIsBattery" class="form-select"><option value="0">Battery: No</option><option value="1">Battery: Yes</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="edit_fldIsFlammable" class="form-select"><option value="0">Flammable: No</option><option value="1">Flammable: Yes</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="edit_fldIsLiquid" class="form-select"><option value="0">Liquid: No</option><option value="1">Liquid: Yes</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="edit_fldIsPublished" class="form-select"><option value="1">Published</option><option value="0">Unpublished</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="edit_fldIsCompanyOwned" class="form-select"><option value="1">Company-Owned</option><option value="0">Not Company-Owned</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="edit_fldIsSoldOut" class="form-select"><option value="0">Available</option><option value="1">Sold Out</option></select>
                        </div>
                        <div class="col-md-2">
                            <select name="edit_fldIsVisible" class="form-select"><option value="1">Visible</option><option value="0">Hidden</option></select>
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
                
                products.forEach(product => {
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
                    }
                });

                const modalContent = document.getElementById('viewMoreContent');
                modalContent.innerHTML = `
                    <p><strong>Product Name:</strong> ${productData.name}</p>
                    <p><strong>Description:</strong> ${productData.description}</p>
                    <p><strong>Short Description:</strong> ${productData.shortDescription}</p>
                    <p><strong>Price:</strong> ${productData.price}</p>
                    <p><strong>Category:</strong> ${productData.categoryName}</p>
                    <p><strong>Brand:</strong> ${productData.brand}</p>
                    <p><strong>FDA Registration:</strong> ${productData.fdaRegistration}</p>
                    <p><strong>Expiry Date:</strong> ${productData.expiryDate}</p>
                    <p><strong>Material:</strong> ${productData.material}</p>
                    <p><strong>Weight:</strong> ${productData.weight}</p>
                    <p><strong>Width:</strong> ${productData.width}</p>
                    <p><strong>Length:</strong> ${productData.length}</p>
                    <p><strong>Height:</strong> ${productData.height}</p>
                    <p><strong>Dimension:</strong> ${productData.dimension}</p>
                    <p><strong>Unit:</strong> ${productData.unit}</p>
                    <p><strong>Warranty:</strong> ${productData.warranty}</p>
                    <p><strong>Warranty Policy:</strong> ${productData.warrantyPolicy}</p>
                    <p><strong>Condition:</strong> ${productData.condition}</p>
                    <p><strong>Special Price:</strong> ${productData.specialPrice}</p>
                    <p><strong>Variation 1:</strong> ${productData.variation1}</p>
                    <p><strong>Variation 2:</strong> ${productData.variation2}</p>
                    <p><strong>Battery:</strong> ${productData.isBattery === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Flammable:</strong> ${productData.isFlammable === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Liquid:</strong> ${productData.isLiquid === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Published:</strong> ${productData.isPublished === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Company-Owned:</strong> ${productData.isCompanyOwned === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Sold Out:</strong> ${productData.isSoldOut === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Visible:</strong> ${productData.isVisible === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Deleted:</strong> ${productData.isDeleted === '1' ? 'Yes' : 'No'}</p>
                    <p><strong>Image:</strong> <img src="${productData.image}" alt="${productData.name}" style="max-width: 100%;"></p>
                `;
            });
        });

        // Filter Table by Category
        const categoryFilter = document.getElementById('categoryFilter');
        categoryFilter.addEventListener('change', function() {
            const selectedCategoryName = this.options[this.selectedIndex].text;
            const rows = document.querySelectorAll('.product-row');
            
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
    console.log(products);
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.edit-btn');
        editButtons.forEach(button => {
            button.addEventListener('click', function () {
                const productId = this.getAttribute('data-id');
                const row = document.querySelector(`.product-row[data-id="${productId}"]`);
                const cells = row.querySelectorAll('td');
                products.forEach(product => {
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
                    }
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
</script>
@endsection
