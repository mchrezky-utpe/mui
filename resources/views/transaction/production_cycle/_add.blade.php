<x-modals.modal id="add_modal" title="Add Data Prodcution Cycle Time">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/production">
      @csrf
      <div class="row">
        <div class="col-md-12">
      <div class="form-group">
        <label>Jigging</label>
        <input required name="jigging" class="form-control" type="text" placeholder="Jigging">
      </div>
      <div class="form-group">
        <label>Line Process</label>
        <input required name="Line Process" class="form-control" type="text" placeholder="Line Process">
      </div>
      <div class="form-group">
        <label>Unjigging</label>
        <input required name="Unjigging" class="form-control" type="text" placeholder="Unjigging">
      </div>
      <div class="form-group">
        <label>Inspection</label>
        <input required name="Inspection" class="form-control" type="text" placeholder="Inspection">
      </div>
      <div class="form-group">
        <label>Assembly</label>
        <input required name="Assembly" class="form-control" type="text" placeholder="Assembly">
      </div>
      <div class="form-group">
        <label>Cutting</label>
        <input required name="Cutting" class="form-control" type="text" placeholder="Cutting">
      </div>
      <div class="form-group">
        <label>Masking</label>
        <input required name="Masking" class="form-control" type="text" placeholder="Masking">
      </div>
      <div class="form-group">
        <label>Buffing</label>
        <input required name="Buffing" class="form-control" type="text" placeholder="Buffing">
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
