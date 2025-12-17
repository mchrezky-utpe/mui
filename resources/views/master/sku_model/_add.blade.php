<x-modals.modal id="add_modal" title="Add Sku Model">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-model">
    @csrf
    <div class="form-group">
      <label>Model Code</label>
        <input  class="form-control" type="text" placeholder="IMC-XXX" readonly>
    </div>
    <div class="form-group">
      <label>Model Name</label>
      <input required name="description" class="form-control" type="text" placeholder="Model Name">
    </div>
  </form>   
</x-modals.modal>
