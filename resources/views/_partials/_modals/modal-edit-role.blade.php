<!-- Add Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="role-title mb-2">Edit Role</h4>
        </div>
        <!-- Add role form -->
        <form class="row g-6" method="POST" action="{{route('role.edit')}}">
        @CSRF
          <div class="col-12">
            <label class="form-label" for="name">Role Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{$role->name}}" placeholder="Enter a role name"
              tabindex="-1" />
          </div>
          <div class="col-12">
            <label class="form-label" for="display_name">Display name</label>
            <input type="text" id="display_name" name="display_name" class="form-control"
              placeholder="Enter display name" tabindex="-1" />
          </div>
          <div class="col-12">
            <label class="form-label" for="description">Description</label>
            <input type="text" id="description" name="description" class="form-control" placeholder="Enter description"
              tabindex="-1" />
          </div>
      </div>
      <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-3">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
      </form>
      <!--/ Add role form -->
    </div>
  </div>
</div>
<!--/ Add Role Modal -->