<x-modals.modal id="add_modal" title="Add Sku Unit">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-unit">
  @csrf
    <div class="form-group">
      <label>Unit Code</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Unit Code">
    </div>
    <div class="form-group">
      <label>Unit Name</label>
      <input required name="prefix" class="form-control" type="text" placeholder="Unit Name">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
  </form>   
</x-modals.modal>
