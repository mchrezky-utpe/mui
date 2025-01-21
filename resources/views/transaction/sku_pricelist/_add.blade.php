<x-modals.modal id="add_modal" title="Add Sku Pricelist">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-pricelist">
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
      <label>Currency</label>
      <select required name="gen_currency_id" class="form-control">
      </select >
    </div>
    <div class="form-group">
      <label>Supplier</label>
      <select required name="prs_supplier_id" class="form-control">
      </select >
    </div>
    <div class="form-group">
      <label>Price</label>
      <input required name="price" class="form-control" type="text" placeholder="price">
    </div>
  </form>   
</x-modals.modal>
