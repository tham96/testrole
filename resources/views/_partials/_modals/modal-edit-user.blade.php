<form class="row g-6" method="POST", action="{{route('app-user-edit')}}">
  @CSRF
  <input type="hidden" name="id" value="{{$user->id}}" />
  <div class="col-12">
    <label class="form-label" for="modalEditUserName">Username</label>
    <input type="text" id="modalEditUserName" name="name" class="form-control" value="{{$user->name}}" />
  </div>
  <div class="col-12">
    <label class="form-label" for="modalEditUserEmail">Email</label>
    <input type="text" id="modalEditUserEmail" name="email" class="form-control" value="{{$user->email}}" />
  </div>
  <div class="col-12">
    <label class="form-label">Choose Role</label></br>
    @foreach (getRole() as $role)
    <input class="form-check-input" type="checkbox" id="{{$role['name']}}" name="role[]" value="{{$role['name']}}" {{ in_array($role['id'], $roles) ? 'checked' : ''}}/>
    <label class="form-check-label">{{$role['name']}}</label>
    @endforeach
  </div>
  <div class="col-12 text-center">
    <button type="submit" class="btn btn-primary me-3">Submit</button>
    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
  </div>
</form>
