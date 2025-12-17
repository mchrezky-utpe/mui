<x-modals.modal id="edit_modal" title="Edit Sku Model">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-model/edit">
    @csrf
    <div class="form-group">
      <label>Model Code</label>
      <input name="id" class="form-control" type="hidden">
      <input name="prefix" class="form-control" type="text" readonly>
    </div>
    <div class="form-group">
      <label>Model Name</label>
      <input type="hidden" name="id" />
      <input required name="description" class="form-control" type="text" placeholder="Model Name">
    </div>
  </form>   
</x-modals.modal>