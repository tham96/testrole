<form class="row g-6" method="POST" action="{{route('role.edit')}}">
  @CSRF
    <input type="hidden" id="id" name="id" class="form-control" value="{{$role->id}}"/>
  <div class="col-12">
    <label class="form-label" for="name">Role Name</label>
    <input type="text" id="name" name="name" class="form-control" value="{{$role->name}}" placeholder="Enter a role name"
      tabindex="-1" />
  </div>
  <div class="col-12">
    <label class="form-label" for="display_name">Display name</label>
    <input type="text" id="display_name" name="display_name" class="form-control" value="{{$role->display_name}}" placeholder="Enter display name"
      tabindex="-1" />
  </div>
  <div class="col-12">
    <label class="form-label" for="description">Description</label>
    <input type="text" id="description" name="description" class="form-control" value="{{$role->description}}" placeholder="Enter description"
      tabindex="-1" />
  </div>
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-3">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>