<x-modals.modal id="add_modal" title="Add User">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/user">
    @csrf
    <div class="form-group">
      <label>Username</label>
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



