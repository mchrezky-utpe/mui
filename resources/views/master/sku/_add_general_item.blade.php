<x-modals.modal id="add_general_item_modal"  title="General Item" modalClass="custom-modal-dialog-medium">
  <form id="form_modal2" autocomplete="off" class="form-horizontal" method="post" action="/sku">
    <div class="row">
      @csrf

      <input required name="flag_sku_type" value="3" class="form-control" type="hidden">
      <!-- REGION SIDE 1 -->
      <div class="col-md-5">
        <div class="form-group">
          <label>Item Code</label>
          <input readonly name="manual_id" class="form-control" type="text" value="IC-XXXXX-XXX">
        </div>
        <div class="form-group">
          <label>Item Group Code</label>
          <input required name="group_tag" class="form-control" type="text">
        </div>
        <div class="form-group">
          <label>Item Name</label>
          <input required name="description" class="form-control" type="text">
        </div>
        <div class="form-group">
          <label>Spesification Code</label>
          <input required name="specification_code" class="form-control" type="text">
        </div>
          <div class="form-group">
            <label>Spesification Description</label>
            <input required name="specification_description" class="form-control" type="text"/>
          </div>
      </div>

      <!-- REGION SIDE 2 -->
      <div class="col-md-7">

        <div class="d-flex align-items-end mt-3">
          <div class="form-group flex-fill mr-2" style="width: 45%;">
            <label>Item Type</label>
            <select required name="sku_type_id" class="form-control"></select>
          </div>
          <div class="form-group flex-fill ml-2"  style="width: 35%;">
            <label>Sales Category</label>
            <select required name="sku_sales_category_id" class="form-control"></select>
          </div>
        </div>

      <div class="d-flex align-items-end mt-3">
        <div class="form-group flex-fill mr-2"  style="width: 30%;">
          <label>Inventory Unit</label>
          <select required name="sku_inventory_unit_id" class="form-control"></select>
        </div>
          <div class="form-group flex-fill ml-2" style="width: 30%;">
          <label>Conversion value</label>
          <input required name="val_conversion" class="form-control" type="text">
          </div>
          <div class="form-group flex-fill ml-2" style="width: 40%;">
            <label>Inventory Reg.</label>
            <input required name="flag_inventory_register" class="form-control" type="checkbox">
          </div>
      </div>

      </div>
    </div>
  </form>
</x-modals.modal>