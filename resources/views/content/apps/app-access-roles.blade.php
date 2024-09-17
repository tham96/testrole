@php
  $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Roles - Apps')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
])
@endsection

@section('vendor-script')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/popular.js',
  'resources/assets/vendor/libs/@form-validation/bootstrap5.js',
  'resources/assets/vendor/libs/@form-validation/auto-focus.js',
])
@endsection

@section('page-script')
@vite([
  'resources/assets/js/app-access-roles.js',
  'resources/assets/js/modal-add-role.js',
  'resources/assets/js/modal-edit-role.js',
])
@endsection

@section('content')
<h4 class="mb-1">Roles List</h4>
<!-- Role cards -->
<div class="row g-6">
  <div class="col-xl-4 col-lg-6 col-md-6">
    <div class="card h-100">
      <div class="row h-100">
        <div class="col-sm-5">
          <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-4">
            <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" class="img-fluid mt-sm-4 mt-md-0"
              alt="add-new-roles" width="83">
          </div>
        </div>
        <div class="col-sm-7">
          <div class="card-body text-sm-end text-center ps-sm-0">
            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
              class="btn btn-sm btn-primary mb-4 text-nowrap add-new-role">Add New Role</button>
            <p class="mb-0"> Add new role, <br> if it doesn't exist.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-12">
    <!-- Role Table -->
    <div class="card">
      <div class="card-datatable table-responsive">
        <table class="datatables-users table border-top">
          <thead>
            <tr>
              <th>Role</th>
              <th>Guard name</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
    <!--/ Role Table -->
  </div>
</div>

<!-- Add Role Modal -->
@include('_partials/_modals/modal-add-role')
<!-- / Add Role Modal -->
 
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="role-title mb-2">Edit Role</h4>
        </div>
        <!-- Add role form -->
        <form id="bodyEditRole" method="POST" action="{{route('role.edit')}}" class="row g-6" ></form>
      <!--/ Add role form -->
    </div>
  </div>
</div>
@endsection