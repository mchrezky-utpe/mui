<x-modals.modal id="add_modal" title="Add Sku Model">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-model">
    @csrf
    <div class="form-group">
      <label>Model Code</label>
        <input readonly name="manual_id" class="form-control" type="text" value="SM-XXX">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
  </form>   
</x-modals.modal>
