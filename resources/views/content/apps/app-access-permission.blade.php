@extends('layouts/layoutMaster')

@section('title', 'Permission - Apps')

@section('vendor-style')
@vite([
  'resources/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.scss',
  'resources/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.scss',
  'resources/assets/vendor/libs/@form-validation/form-validation.scss',
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
  'resources/assets/js/app-access-permission.js',
  'resources/assets/js/modal-add-permission.js',
  'resources/assets/js/modal-edit-permission.js',
  ])
@endsection

@section('content')


<!-- Permission Table -->
<div class="card">
  <div class="card-datatable table-responsive">
    <table class="datatables-permissions table border-top">
      <thead>
        <tr>
          <th>Name</th>
          <th>Guard name</th>
          <th>Created at</th>
          <th>Actions</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<!--/ Permission Table -->

<!-- Modal -->
@include('_partials/_modals/modal-add-permission')
<div class="modal fade" id="editPermission" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-simple">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close btn-pinned" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="mb-2">Edit Permission</h4>
        </div>
        <div class="alert alert-warning d-flex align-items-start" role="alert">
          <span class="alert-icon me-4 rounded-2"><i class="ti ti-alert-triangle ti-md"></i></span>
          <span>
            <span class="alert-heading mb-1 h5">Warning</span><br>
            <span class="mb-0 p">By editing the permission name, you might break the system permissions functionality. Please ensure you're absolutely certain before proceeding.</span>
          </span>
        </div>
        <form id="bodyEditPermission" class="row pt-2" method="POST", action="{{route('permission.edit')}}">
          @CSRF
        </form>
      </div>
    </div>
  </div>
</div>
<!-- /Modal -->
@endsection
