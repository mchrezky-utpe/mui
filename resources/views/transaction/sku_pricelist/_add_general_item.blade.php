<x-modals.modal id="add_general_item_modal" title="Add General Item Price" >
  
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-pricelist">
<!-- <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-pricelist"> -->
    @csrf
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Item Code</label>
          <input readonly name="material_code" class="form-control" type="text" />
        </div>
        <div class="form-group">
          <label>Item Name</label>
          <select id="sku_id_edit" required name="sku_id" class="form-control">
          </select >
        </div>
        <div class="form-group">
          <label>Supplier</label>
          <select required name="prs_supplier_id" class="form-control">
          </select >
        </div>
        <div class="form-group">
          <label>Lead Time</label>
          <input required name="lead_time" class="form-control" type="number" />
        </div>
        <div class="form-group">
          <label>MOQ</label>
          <input  name="moq" class="form-control" />
        </div>
        <div class="form-group">
          <label>Procurement Unit</label>
          <input readonly name="procurement_unit" class="form-control" />
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label>Currency</label>
          <select required name="gen_currency_id" class="form-control">
          </select >
        </div>
        <div class="form-group">
        <div class="form-group">
          <label>Price</label>
          <input required name="price" class="form-control" type="text" />
        </div>
        <div class="form-group">
          <label>Retail Price</label>
          <input required name="price_retail" class="form-control" type="text" />
        </div>
          <label>Valid From</label>
          <input required name="valid_date_from" class="form-control" type="date" value="{{ date('Y-m-d') }}" />
        </div>
        <div class="form-group">
          <label>Valid To</label>
          <input required name="valid_date_to" class="form-control" type="date" value="{{ date('Y-m-d') }}" />
        </div>
        <div class="form-group">
          <label>Activated Status</label>
          <input required name="flag_status" class="form-control" type="checkbox" checked/>
        </div>
      </div>
    </div>
  </form>   
</x-modals.modal>
