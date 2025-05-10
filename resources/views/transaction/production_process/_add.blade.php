<x-modals.modal id="add_modal" title="Add Data Prodcution Cycle Time">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/production">
      @csrf
      <div class="row">
        <div class="col-md-12">
      <div class="form-group">
        <label for="flag_process_classification">Process Classification</label>
        <select required name="flag_process_classification" class="form-control" id="flag_process_classification">
          <option value="">Pilih</option>
          <option value="1">Regular</option>
          <option value="2">Satin</option>
        </select>
      </div>
      <div class="form-group">
        <label for="flag_checking_input_method">Checking Input Method</label>
        <select required name="flag_checking_input_method" class="form-control" id="flag_checking_input_method">
          <option value="">Pilih</option>
          <option value="1">Normal</option>
          <option value="2">Hourly</option>
        </select>
      </div>
      <div class="form-group">
        <label>Line Part Code</label>
        <input required name="line_part_code" class="form-control" type="text" placeholder="Line part code">
      </div>
      <div class="form-group">
        <label>Surface Area</label>
        <input required name="Surface Area" class="form-control" type="text" placeholder="Surface Area">
      </div>
      <div class="form-group">
        <label>Weight</label>
        <input required name="Weight" class="form-control" type="text" placeholder="Weight">
      </div>
      <div class="form-group">
        <label>Quantity Standard</label>
        <input required name="Quantity Standard" class="form-control" type="text" placeholder="Quantity Standard">
      </div>
      <div class="form-group">
        <label>Quantity Target</label>
        <input required name="Quantity Target" class="form-control" type="text" placeholder="Quantity Target">
      </div>
      {{-- <div class="form-group">
        <label for="flag_gender">Gender</label>
        <select required name="flag_gender" class="form-control" id="flag_gender">
          <option value="">Pilih Gender</option>
          <option value="1">Laki-laki</option>
          <option value="2">Perempuan</option>
        </select>
      </div> --}}
      
      </div>
    </div>
  </form>   
</x-modals.modal>
