<x-modals.modal id="edit_modal" title="Edit Sku Unit">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-unit/edit">
    @csrf
    <div class="form-group">
      <label>Unit Code</label>
      <input name="id" class="form-control" type="hidden">
      <input required name="prefix" class="form-control" type="text" placeholder="Unit Code" readonly>
    </div>
    <div class="form-group">
      <label>Unit Name</label>
      <input required name="description" class="form-control" type="text" placeholder="Unit Name">
    </div>
  </form>
</x-modals.modal>
