<x-modals.modal id="add_modal" title="Add Sku Unit">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-unit">
  @csrf
    <div class="form-group">
      <label>Unit Code</label>
         <input name="prefix" class="form-control" type="text" placeholder="IUC-XXX" readonly>
    </div>
    <div class="form-group">
      <label>Unit Name</label>
      <input required name="description" class="form-control" type="text" placeholder="Unit Name">
    </div>
  </form>
</x-modals.modal>
