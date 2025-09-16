<x-modals.modal id="edit_modal" title="Edit" modalClass="custom-modal-dialog-medium">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-part-information/edit" enctype="multipart/form-data">
<div class="row">
@csrf
    <input type="hidden" name="id" />
      <div class="col-md-5">
        <div class="form-group">
        <div class="form-group">
          <label>Upload Gambar</label>
          <input type="file" class="form-control" name="blob_image" accept="image/*">
        </div>
          <label>Part Code (legacy)</label>
          <input readonly name="manual_id" class="form-control" type="text" value="PC-XXXXX-XXX">
        </div>
        <div class="form-group">
          <label>Part Name</label>
          <input required name="description" class="form-control" type="text">
        </div>
        <div class="form-group">
          <label>Set Code</label>
          <input readonly name="group_tag" class="form-control" type="text"/>
        </div>
        <div class="form-group">
          <label>Spesification Code</label>
          <input required name="specification_code" class="form-control" type="text">
        </div>
      </div>

      <!-- REGION SIDE 2 -->
      <div class="col-md-7">
        <div class="d-flex align-items-end">
          <div class="form-group flex-fill mr-2" style="width: 60%;">
            <label>Spesification Description</label>
            <input required name="specification_detail" class="form-control" type="text"/>
          </div>
          <div class="form-group flex-fill ml-2" style="width: 40%;">
            <label>Sales Category</label>
            <select required name="sku_sales_category_id" class="form-control"></select>
          </div>
        </div>

        <div class="d-flex align-items-end mt-3">
          <div class="form-group flex-fill mr-2" style="width: 45%;">
            <label>Business Type</label>
            <select required name="sku_business_type_id" class="form-control"></select>
          </div>
          <!-- <div class="form-group flex-fill ml-2" style="width: 55%;">
            <label>&nbsp;</label>
            <select required name="type_id" class="form-control"></select>
          </div> -->
        </div>

        <div class="d-flex align-items-end mt-3">
          <div class="form-group flex-fill mr-2" style="width: 30%;">
            <label>Weight (gram)</label>
            <input required name="val_weight" class="form-control" type="text">
          </div>
          <div class="form-group flex-fill mx-2" style="width: 30%;">
            <label>Surface Area (dm2)</label>
            <input required name="val_area" class="form-control" type="text">
          </div>
          <div class="form-group flex-fill ml-2" style="width: 35%;">
            <label>Model</label>
            <select  name="sku_model_id" class="form-control"></select>
          </div>
        </div>

        <div class="d-flex align-items-end mt-3">
          <div class="form-group flex-fill mr-2"  style="width: 30%;">
            <label>Inventory Unit</label>
            <select required name="sku_inventory_unit_id" class="form-control"></select>
          </div>
          <div class="form-group flex-fill mx-2"  style="width: 30%;">
            <label>Conversion Value</label>
            <input required name="val_conversion" class="form-control" type="text">
          </div>
          <div class="form-group flex-fill ml-2"  style="width: 35%;">
            <label>Inventory Reg.</label>
            <input required name="flag_inventory_register" class="form-control" type="checkbox">
          </div>
        </div>
      </div>
      </div>
  </form>
</x-modals.modal>
