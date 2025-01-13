<x-modals.modal id="edit_modal" title="Edit User">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/user/edit">
    @csrf
    <div class="form-group">
      <label>Username</label>
      <input type="hidden" name="id" />
      <input required name="username" class="form-control" type="text" placeholder="Username">
    </div>
    <div class="form-group">
      <label>Name</label>
      <input required name="name" class="form-control" type="text" placeholder="Name">
    </div>
    <div class="form-group">
      <label>Password</label>
      <input required name="password" class="form-control" type="password" placeholder="Password">
    </div>
  </form>   
</x-modals.modal>