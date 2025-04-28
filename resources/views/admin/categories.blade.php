@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Welcome, Admin')

@section('content')
<h2 class="text-2xl font-bold mb-4">Categories</h2>

<!-- Top bar with Add button -->
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <strong>List of Categories</strong>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
        + Add New Category
    </button>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive" style="max-height: 500px;">
            <table class="table table-bordered table-sm" id="categoriesTable">
                <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>SubCategories (Count)</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="category-row" data-id="{{ $category['fldID'] }}" data-category-name="{{ $category['fldCategoryName'] }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category['fldName'] }}</td>
                            <td>{{ $category['fldDescription'] }}</td>
                            <td>{{ $category['SubcategoryCount'] }}</td>
                            <td>
                                <button class="btn btn-info btn-sm view-morecontent-btn" data-bs-toggle="modal" data-bs-target="#viewMoreCategoryModal" data-id="{{ $category['fldID'] }}">View More</button>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="{{ $category['fldID'] }}" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $category['fldID'] }}" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View More Modal -->
<div class="modal fade" id="viewMoreCategoryModal" tabindex="-1" aria-labelledby="viewMoreCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewMoreCategoryLabel">Category Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="viewMoreCategoryContent">
                <!-- Dynamic content will be injected here via JS -->
            </div>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <form id="addCategoryForm" method="POST" action="{{route('admin.categories.create')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryLabel">Add New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="fldName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="fldName" name="fldName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="fldDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="fldDescription" name="fldDescription"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Category</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" >
        <div class="modal-content">
            <form id="editCategoryForm" action="{{route('admin.categories.edit')}}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <input type="hidden" name="edit_fldID" id="edit_fldID">
                        <div class="col-md-6">
                            <label for="edit_fldName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="edit_fldName" name="edit_fldName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_fldDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="edit_fldDescription" name="edit_fldDescription"></textarea>
                        </div>
                        <div class="col-md-6">
                        <label for="edit_subcategories" class="form-label">Subcategories</label>
                        <button id="addSubcategories" class="btn btn-success">+</button>
                        <div class="d-flex">
                            <div class="table-responsive">
                                <table class="table table-bordered table-sm">
                                    <tbody id="subcategoryTableBody">
                                        <!-- Subcategories will be dynamically added here -->
                                        <tr>
                                            <th>SUBCATEGORY</th>
                                            <th>DELETE</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                             
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save Category</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Category Modal -->
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteCategoryForm" method="POST" action="{{route('admin.categories.delete')}}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryLabel">Delete Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this Category?</p>
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
    console.log(categories);
    console.log(subcategories);
    document.addEventListener('DOMContentLoaded', function () {
        // View More Button Click Handler
        const viewMoreCategoryContent = document.getElementById('viewMoreCategoryContent');
        const viewMoreCategoryModal = document.getElementById('viewMoreCategoryModal');
        const editButton = document.querySelectorAll('.edit-btn');
        const deleteButton = document.querySelectorAll('.delete-btn');
        const viewMoreButtons = document.querySelectorAll('.view-morecontent-btn');
            viewMoreButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const categoryId = this.getAttribute('data-id');
                    const category = categories.find(cat => cat.fldID == categoryId);
                    const subcategoriesList = subcategories.filter(subcat => subcat.fldID == categoryId);
                    viewMoreCategoryContent.innerHTML = `
                        <h5>Category: ${category.fldName}</h5>
                        <p><i>"${category.fldDescription}"</i></p>
                        <h6>Subcategories:</h6>
                        <ul>
                            ${subcategoriesList.map(subcat => `<li>${subcat.fldName}</li>`).join('')}
                        </ul>
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

    // Edit Category Button Click Handler
    const editCategoryModal = document.getElementById('editCategoryModal');
    const editCategoryForm = document.getElementById('editCategoryForm');
    const editCategoryIdInput = document.getElementById('edit_fldID');
    const editCategoryNameInput = document.getElementById('edit_fldName');
    const editCategoryDescriptionInput = document.getElementById('edit_fldDescription');
    const editCategorySubcategoriesInputs = document.querySelectorAll('input[name="edit_subcategories[]"]');
    const editButtons = document.querySelectorAll('.edit-btn');
    const subcategoryTableBody = document.getElementById('subcategoryTableBody');
    const addEditSubcategoryButton = document.getElementById('addSubcategories');
   
    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            const category = categories.find(cat => cat.fldID == categoryId);
            editCategoryIdInput.value = category.fldID;
            editCategoryNameInput.value = category.fldName;
            editCategoryDescriptionInput.value = category.fldDescription;

            // Clear the subcategory table body
            subcategoryTableBody.innerHTML = '';
            // Populate the subcategory table
            subcategories.forEach(subcat => {
                if (subcat.fldID === parseInt(categoryId)) {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>
                            <input type="checkbox" id="edit_subcategory_${subcat.subcategoryId}" name="edit_subcategories[]" value="${subcat.subcategoryId}" ${subcat.fldID == categoryId ? 'checked' : ''} hidden>
                            ${subcat.fldName}
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm delete-subcategory-btn" data-id="${subcat.subcategoryId}">Delete</button>
                        </td>
                    `;
                    subcategoryTableBody.appendChild(row);
                }
            });
            addEditSubcategoryButton.textContent = '+';
            addEditSubcategoryButton.classList.remove('btn-danger');
            addEditSubcategoryButton.classList.add('btn-success');
            const deleteSubcategoryButtons = document.querySelectorAll('.delete-subcategory-btn');
            console.log(deleteSubcategoryButtons);
            deleteSubcategoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const subcategoryId = this.getAttribute('data-id');
                    const subcategoryRow = this.closest('tr');
                    // Are you sure you want to delete this subcategory?, using decent modal
                    if(confirm('Are you sure you want to delete this subcategory?')) {
                        // just hide the row
                        subcategoryRow.style.display = 'none';
                        // Change the subcat.fldID to 0
                        const subcategoryInput = subcategories.find(subcat => subcat.subcategoryId == subcategoryId);
                        if (subcategoryInput) {
                            subcategoryInput.fldID = 0; // Set fldID to 0
                        }
                    }
                    // Convert the input to unchecked
                    const subcategoryInput = document.getElementById(`edit_subcategory_${subcategoryId}`);
                    if (subcategoryInput) {
                        subcategoryInput.checked = false;
                    }
                });
            });


        });
    });
   

    addEditSubcategoryButton.addEventListener('click', function(e) {
        e.preventDefault();

        if (addEditSubcategoryButton.textContent === '+') {
            // Change button label to "Cancel" and make it red
            addEditSubcategoryButton.textContent = 'Cancel';
            addEditSubcategoryButton.classList.remove('btn-success');
            addEditSubcategoryButton.classList.add('btn-danger');

            // Add subcategories with label "NA"
            subcategories.forEach(subcat => {
                if (subcat.fldID === 0) {
                    const row = document.createElement('tr');
                    row.classList.add('temp-subcategory-row'); // Mark rows for easy removal
                    row.innerHTML = `
                        <td>
                            <input id="edit_subcategory_${subcat.subcategoryId}" name="edit_subcategories[]" value="${subcat.subcategoryId}" checked hidden>
                            ${subcat.fldName}
                        </td>
                        <td>
                            <button type="button" class="btn btn-success btn-sm add-subcategory-btn" data-id="${subcat.subcategoryId}">Add</button>
                        </td>
                    `;
                    subcategoryTableBody.appendChild(row);
                }
            });
        } else {
            // Revert button label to "+" and make it green
            addEditSubcategoryButton.textContent = '+';
            addEditSubcategoryButton.classList.remove('btn-danger');
            addEditSubcategoryButton.classList.add('btn-success');

            // Remove all temporary subcategory rows
            const tempRows = document.querySelectorAll('.temp-subcategory-row');
            tempRows.forEach(row => row.remove());
        }
        // Add event listener to the new "Add" buttons
        const addSubcategoryButtons = document.querySelectorAll('.add-subcategory-btn');
        addSubcategoryButtons.forEach(button => {
            button.addEventListener('click', function() {
                const subcategoryId = this.getAttribute('data-id');
                const subcategoryRow = this.closest('tr');
                // Once Clicked, it will be added to the subcategory table checked
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>
                        <input type="checkbox" id="edit_subcategory_${subcategoryId}" name="edit_subcategories[]" value="${subcategoryId}" checked hidden>
                        ${subcategories.find(subcat => subcat.subcategoryId == subcategoryId).fldName}
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-subcategory-btn" data-id="${subcategoryId}">Delete</button>
                    </td>
                `;
                subcategoryTableBody.appendChild(row);
                const subcategoryInput = subcategories.find(subcat => subcat.subcategoryId == subcategoryId);
                if (subcategoryInput) {
                    subcategoryInput.fldID = "";
                }
                // Change button label to "Added" and disable it
                button.textContent = 'Added';
                button.disabled = true;
                button.classList.remove('btn-success');
                button.classList.add('btn-secondary');
            });
        });


    });
    

    // Delete Category Button Click Handler
    const deleteCategoryModal = document.getElementById('deleteCategoryModal');
    const deleteCategoryForm = document.getElementById('deleteCategoryForm');
    const deleteCategoryIdInput = document.getElementById('delete_fldID');
    const deleteButton = document.querySelectorAll('.delete-btn');
    deleteButton.forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.getAttribute('data-id');
            deleteCategoryIdInput.value = categoryId;
        });
    });
    // Add Subcategory Button Click Handler
    const addSubcategoriesButton = document.getElementById('addSubcategories');


    
</script>
@endsection
