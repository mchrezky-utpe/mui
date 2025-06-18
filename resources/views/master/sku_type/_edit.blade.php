<x-modals.modal id="edit_modal" title="Edit Sku Type"  modalClass="custom-modal-dialog-medium">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-type/edit">
    @csrf
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
        <input type="hidden" name="id" />
          <label>Item Type Code (legacy)</label>
          <input required name="manual_id" class="form-control" type="text">
        </div>
        <div class="form-group">
          <label>Category</label>
          <select required name="sku_category_id" class="form-control">
            <option value=""> === Select === </option>
          </select >
        </div>
        <div class="form-group">
          <label>Sub Category</label>
          <select required name="sku_sub_category_id" class="form-control">
            <option value=""> === Select === </option>
          </select >
        </div>
        <div class="form-group">
          <label>Name</label>
          <input required name="description" class="form-control" type="text" >
        </div>
        <div class="form-group">
          <label>Extension</label>
          <input required name="prefix" class="form-control" type="text" >
        </div>
        <div class="form-group">
          <label>Group</label>
          <input required name="group_tag" class="form-control" type="text" >
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <label>Classification</label>
          <select required name="sku_classification_id" class="form-control">
            <option value=""> === Select === </option>
          </select >
        </div>
        <div class="form-group">
          <label>Trading Status</label>
          <select required name="flag_trans_type" class="form-control">
            <option value=""> === Select === </option>
            <option value="1">Sell</option>
            <option value="2">Buy</option>
          </select >
        </div>
        <div class="form-group">
          <label>Primary Status</label>
          <input required name="flag_primary" class="form-control" type="checkbox" >
        </div>
        <div class="form-group">
          <label>Checking Status</label>
          <input required name="flag_checking" class="form-control" type="checkbox" >
        </div>
        <div class="form-group">
          <label>Result Status</label>
          <select required name="flag_checking_result" class="form-control">
            <option value=""> === Select === </option>
            <option value="1">Good</option>
            <option value="2">Not Good</option>
            <option value="3">Return</option>
            <option value="4">Unchecked</option>
          </select >
        </div>
        <div class="form-group">
          <label>Bom Status</label>
          <input required name="flag_bom" class="form-control" type="checkbox" >
        </div>
      </div>

      <div class="col-md-4">
        <div class="form-group">
          <label>Allowance Status</label>
          <select required name="flag_allowance" class="form-control">
            <option value=""> === Select === </option>
            <option value="1">Fixed</option>
            <option value="2">Customized</option>
          </select >
        </div>
        <div class="form-group">
          <label>Allowance Value  </label>
          <input required name="val_allowance" class="form-control" type="number" >
        </div>
    </div>
    </div>
  </form>
</x-modals.modal>
