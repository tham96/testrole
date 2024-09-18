<form class="row g-6" method="POST" action="{{route('role.edit')}}">
  @CSRF
    <input type="hidden" id="id" name="id" class="form-control" value="{{$role->id}}"/>
  <div class="col-12">
    <label class="form-label" for="name">Role Name</label>
    <input type="text" id="name" name="name" class="form-control" value="{{$role->name}}" placeholder="Enter a role name"
      tabindex="-1" />
  </div>
  <div class="col-12">
    <label class="form-label" for="guard_name">Display name</label>
    <input type="text" id="guard_name" name="guard_name" class="form-control" value="{{$role->guard_name}}" placeholder="Enter display name"
      tabindex="-1" />
  </div>
  <div class="col-12">
    <label class="form-label">Choose permissions</label></br>
    @foreach (getPermission() as $permission)
    <input class="form-check-input" type="checkbox" id="{{$permission['name']}}" name="permission[]" value="{{$permission['id']}}" {{ in_array($permission['id'], $rolePermissions) ? 'checked' : ''}}/>
    <label class="form-check-label">{{$permission['name']}}</label>
    @endforeach
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-3">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>