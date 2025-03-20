<x-modals.modal id="edit_modal" title="Edit Purchase Order">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/pr/edit">
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
  </form>   
</x-modals.modal>