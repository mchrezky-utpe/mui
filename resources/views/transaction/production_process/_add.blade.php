<x-modals.modal id="add_modal" title="Add Data Prodcution Cycle Time">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/production_process">
      @csrf
      <div class="row">
        <div class="col-md-12">
      <div class="form-group">
        <label>Description</label>
        <input required name="description" class="form-control" type="text" placeholder="Description">
      </div>
      <div class="form-group">
        <label for="flag_process_classification">Process Classification</label>
        <select required name="flag_process_classification" class="form-control" id="flag_process_classification">
          <option value="">Pilih Classification</option>
          <option value="1">Regular</option>
          <option value="2">Satin</option>
        </select>
      </div>
      <div class="form-group">
        <label for="flag_checking_input_method">Input Method</label>
        <select required name="flag_checking_input_method" class="form-control" id="flag_checking_input_method">
          <option value="">Pilih Input</option>
          <option value="1">Normal</option>
          <option value="2">Hourly</option>
        </select>
      </div>
      <div class="form-group">
        <label for="flag_item_size_category">Size Category</label>
        <select required name="flag_item_size_category" class="form-control" id="flag_item_size_category">
          <option value="">Pilih Size Category</option>
          <option value="1">Small</option>
          <option value="2">Big</option>
        </select>
      </div>
      <div class="form-group">
        <label>Line Part Code</label>
        <input required name="line_part_code" class="form-control" type="text" placeholder="Line Part Code">
      </div>
      <div class="form-group">
        <label>Val Area</label>
        <input required name="val_area" class="form-control" type="text" placeholder="val area">
      </div>
      <div class="form-group">
        <label>Val Weight</label>
        <input required name="val_weight" class="form-control" type="text" placeholder="Val Weight">
      </div>
      <div class="form-group">
        <label>Quantity Standard</label>
        <input required name="qty_standard" class="form-control" type="text" placeholder="Quantity Standard">
      </div>
      <div class="form-group">
        <label>Quantity Target</label>
        <input required name="qty_target" class="form-control" type="text" placeholder="Quantity Target">
      </div>      
      </div>
    </div>
  </form>   
</x-modals.modal>
