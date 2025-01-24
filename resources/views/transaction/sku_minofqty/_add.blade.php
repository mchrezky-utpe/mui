<x-modals.modal id="add_modal" title="Add Sku Min Of Qty">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-minofqty">
    @csrf
    <div class="form-group">
      <label>Manual ID</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div>
    <div class="form-group">
      <label>SKU</label>
      <select required name="sku_id" class="form-control">
      </select >
    </div>
    <div class="form-group">
      <label>Qty</label>
      <input required name="qty" class="form-control" type="text" placeholder="qty">
    </div>
  </form>   
</x-modals.modal>
