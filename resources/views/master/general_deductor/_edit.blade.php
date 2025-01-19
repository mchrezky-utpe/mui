<x-modals.modal id="edit_modal" title="Edit General Deductor">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/general-deductor/edit">
    @csrf
    <div class="form-group">
      <label>Manual ID</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input type="hidden" name="id" />
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
    <div class="form-group">
      <label>App Module Id</label>
      <input required name="app_module_id" class="form-control" type="text" placeholder="App Module Id">
    </div>
  </form>   
</x-modals.modal>