<x-modals.modal id="add_modal"  title="General Item" modalClass="custom-modal-dialog-medium">
  <form id="form_modal2" autocomplete="off" class="form-horizontal" method="post" action="/sku-general-item" enctype="multipart/form-data">
    <div class="row">
      @csrf

      <input required name="flag_sku_type" value="3" class="form-control" type="hidden">
      <!-- REGION SIDE 1 -->
      <div class="col-md-5">
        <div class="form-group">
          <label>Upload Gambar</label>
          <input type="file" class="form-control" name="blob_image" accept="image/*">
        </div>
        <div class="form-group">
            <label>Item Type</label>
            <select required name="sku_type_id" class="form-control"></select>
        </div>
        <div class="form-group"> 
          <label>Item Code</label>
          <input readonly name="manual_id" class="form-control" type="text" value="IC-XXXXX-XXX">
        </div>
        <div class="form-group">
          <label>Item Name</label>
          <input required name="description" class="form-control" type="text">
        </div>
        <div class="form-group">
          <label>Spesification Code</label>
          <input required name="specification_code" class="form-control" type="text">
        </div>
      </div>

      <!-- REGION SIDE 2 -->
      <div class="col-md-7">

      <div class="form-group">
            <label>Spesification Description</label>
            <input required name="specification_description" class="form-control" type="text"/>
          </div>
        <div class="d-flex align-items-end mt-3">
          <div class="form-group flex-fill mr-2" style="width: 45%;">
          <label>Procurement Type</label>
          <select required name="flag_sku_procurement_type" class="form-control">
            <option value="">-- select --</option>
            <option value="1">in-house</option>
            <option value="2">purchase</option>
            <option value="3">supply</option>
            <option value="4">purchase & in-house</option>
          </select>
          </div>
        </div>

      <div class="d-flex align-items-end mt-3">   
          <div class="form-group flex-fill mr-2" style="width: 45%;">
            <label>Procurement Unit</label>
            <select required name="sku_procurement_unit_id" class="form-control"></select>
          </div>
        <div class="form-group flex-fill ml-2"  style="width: 35%;">
          <label>Inventory Unit</label>
          <select required name="sku_inventory_unit_id" class="form-control"></select>
        </div>
      </div>

      <div class="d-flex align-items-end mt-3">
          <div class="form-group flex-fill ml-2" style="width: 40%;">
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