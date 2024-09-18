<!-- Edit Permission Modal -->
<form id="editPermissionForm" class="row pt-2" method="POST", action="{{route('permission.edit')}}">
@CSRF
  <input type="hidden" id="id" name="id" class="form-control" value="{{$permission->id}}"/>
  <div class="col-sm-9">
    <label class="form-label" for="name">Permission Name</label>
    <input type="text" id="name" name="name" class="form-control" value="{{$permission->name}}" placeholder="Permission Name" tabindex="-1" />
  </div>
  <div class="col-sm-3 mb-4">
    <label class="form-label invisible d-none d-sm-inline-block">Button</label>
    <button type="submit" class="btn btn-primary mt-1 mt-sm-0">Update</button>
  </div>
</form>
<!--/ Edit Permission Modal -->
