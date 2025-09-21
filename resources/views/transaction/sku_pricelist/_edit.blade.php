<x-modals.modal id="edit_modal" title="Edit Sku Pricelist">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-pricelist/edit">
    @csrf
    <input type="hidden" name="id" />
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Material Name</label>
          <select required name="sku_id" class="form-control">
          </select >
        </div>
        <div class="form-group">
          <label>Supplier</label>
          <select required name="prs_supplier_id" class="form-control">
          </select >
        </div>
        <div class="form-group">
          <label>Currency</label>
          <select required name="gen_currency_id" class="form-control">
          </select >
        </div>
        <div class="form-group">
          <label>Lead Time</label>
          <input required name="lead_time" class="form-control" type="number">
        </div>
        <div class="form-group">
          <label>MOQ</label>
          <input  name="moq" class="form-control" />
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Valid From</label>
          <input required name="valid_date_from" class="form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label>Valid To</label>
          <input required name="valid_date_to" class="form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label>Activated Status</label>
          <input required name="flag_status" class="form-control" type="checkbox">
        </div>
        <div class="form-group">
          <label>Price</label>
          <input required name="price" class="form-control" type="text">
        </div>
        <div class="form-group">
          <label>Retail Price</label>
          <input required name="price_retail" class="form-control" type="text">
        </div>
      </div>
    </div>
  </form>   
</x-modals.modal>