<!-- Add Role Modal -->
<div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-simple modal-dialog-centered modal-add-new-role">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="text-center mb-6">
          <h4 class="role-title mb-2">Add New Role</h4>
        </div>
        <!-- Add role form -->
        <form class="row g-6" method="POST" action="{{route('role.create')}}">
        @CSRF
          <div class="col-12">
            <label class="form-label" for="name">Role Name</label>
            <input type="text" id="name" name="name" class="form-control" placeholder="Enter a role name"
              tabindex="-1" />
          </div>
          <div class="col-12">
            <label class="form-label" for="display_name">Guard name</label>
            <input type="text" id="guard_name" name="guard_name" class="form-control"
              placeholder="Enter guard name" tabindex="-1" />
          </div>
          <div class="col-12">
            <label class="form-label">Choose permissions</label></br>
            @foreach (getNamePermission() as $permission)
            <input class="form-check-input" type="checkbox" id="{{$permission['name']}}" name="permission[]" value="{{$permission['name']}}"/>
            <label class="form-check-label">{{$permission['name']}}</label>
            @endforeach
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