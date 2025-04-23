@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Categories</h2>

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
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSubcategoryModal">
        + Add New Sub-Category
    </button>
</div>

<!-- Subcategory Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive" style="max-height: 500px;">
            <table class="table table-bordered table-sm" id="categoriesTable">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Category</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($subcategories as $subcategory)
                        <tr class="subcategory-row" data-id="{{ $subcategory['fldID'] }}" data-subcategory-name="{{ $subcategory['categoryName'] }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $subcategory['subcategoryName'] }}</td>
                            <td>{{ $subcategory['fldDescription'] }}</td>
                            <td>{{ $subcategory['categoryName'] }}</td>
                            <td>
                                <button class="btn btn-info btn-sm view-morecontent-btn" data-bs-toggle="modal" data-bs-target="#viewMoreSubcategoryModal" data-id="{{ $subcategory['fldID'] }}">View More</button>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $subcategory['fldID'] }}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $subcategory['fldID'] }}" data-bs-toggle="modal" data-bs-target="#deleteSubcategoryModal">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View More Modal -->
<div class="modal fade" id="viewMoreSubcategoryModal" tabindex="-1" aria-labelledby="viewMoreSubcategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMoreSubcategoryLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewMoreSubcategoryContent">
                <!-- Dynamic content will be injected here via JS -->
            </div>
        </div>
    </div>
</div>

<!-- Add Subcategory Modal -->
<div class="modal fade" id="addSubcategoryModal" tabindex="-1" aria-labelledby="addSubcategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form id="addSubcategoryForm" method="POST" action="{{route('admin.subcategories.create')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubcategoryLabel">Add New Sub-Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fldName" class="form-label
                            ">Sub-Category Name</label>
                            <input type="text" class="form-control" id="fldName" name="fldName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fldDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="fldDescription" name="fldDescription" rows="3"></textarea>
                        </div>
                        <div class="col-md-6">
                            <label for="subCategoryId" class="form-label">Category</label>
                            <select class="form-select" id="subCategoryId" name="subCategoryId" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category['fldID'] }}">{{ $category['fldName'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Subcategory</button>
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
            <form id="editProductForm" action="{{route('admin.subcategories.edit')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3"></div>
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
<div class="modal fade" id="deleteSubcategoryModal" tabindex="-1" aria-labelledby="deleteSubcategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteSubcategoryForm" method="POST" action="{{route('admin.subcategories.delete')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteSubcategoryLabel">Delete Subcategory</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this subcategory?</p>
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
    var categories = @json($categories);
    var subcategories = @json($subcategories);
    console.log(subcategories);
    console.log(categories);

    const categoryFilter = document.getElementById('categoryFilter');
        categoryFilter.addEventListener('change', function() {
            const selectedCategoryName = this.options[this.selectedIndex].text;
            const rows = document.querySelectorAll('.subcategory-row');
            
            rows.forEach(row => {
                const rowCategoryName = row.getAttribute('data-subcategory-name');
                if (selectedCategoryName === "All Categories" || rowCategoryName === selectedCategoryName) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    
</script>

<script>
    var categories = @json($categories);
    var subcategories = @json($subcategories);
    console.log(categories);
    console.log(subcategories);
    document.addEventListener('DOMContentLoaded', function () {
        // View More Button Click Handler
        const viewMoreSubcategoryContent = document.getElementById('viewMoreSubcategoryContent');
        const viewMoreSubcategoryModal = document.getElementById('viewMoreSubcategoryModal');
        const editButton = document.querySelectorAll('.edit-btn');
        const deleteButton = document.querySelectorAll('.delete-btn');
        const viewMoreButtons = document.querySelectorAll('.view-morecontent-btn');
            viewMoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const subcategoryId = this.getAttribute('data-id');
                    const subcategory = subcategories.find(sub => sub.fldID == subcategoryId);
                    viewMoreSubcategoryContent.innerHTML = `
                        <h5>Sub-Category Name: ${subcategory.subcategoryName}</h5>
                        <p>Description: ${subcategory.fldDescription}</p>
                        <p>Category: ${subcategory.categoryName}</p>
                    `;
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
    // Delete SubCategory Button Click Handler
    const deleteSubcategoryModal = document.getElementById('deleteSubcategoryModal');
    const deleteSubcategoryForm = document.getElementById('deleteSubcategoryForm');
    const deleteSubcategoryIdInput = document.getElementById('delete_fldID');
    const deleteButton = document.querySelectorAll('.delete-btn');
    deleteButton.forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            deleteSubcategoryIdInput.value = categoryId;
            console.log(deleteSubcategoryIdInput.value);
        });
    });

</script>
@endsection
