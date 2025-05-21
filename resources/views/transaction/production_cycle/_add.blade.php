<x-modals.modal id="add_modal" title="Add Data Prodcution Cycle Time">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/production_cycle">
      @csrf
      <div class="row">
        <div class="col-md-12">
      <div class="form-group">
        <label>Jigging</label>
        <input required name="num_jigging" class="form-control" type="text" placeholder="Jigging">
      </div>
      <div class="form-group">
        <label>Line Process</label>
        <input required name="num_lineprocess" class="form-control" type="text" placeholder="Line Process">
      </div>
      <div class="form-group">
        <label>Unjigging</label>
        <input required name="num_unjigging" class="form-control" type="text" placeholder="Unjigging">
      </div>
      <div class="form-group">
        <label>Inspection</label>
        <input required name="num_inspection" class="form-control" type="text" placeholder="Inspection">
      </div>
      <div class="form-group">
        <label>Assembly</label>
        <input required name="num_assembly" class="form-control" type="text" placeholder="Assembly">
      </div>
      <div class="form-group">
        <label>Cutting</label>
        <input required name="num_cutting" class="form-control" type="text" placeholder="Cutting">
      </div>
      <div class="form-group">
        <label>Masking</label>
        <input required name="num_masking" class="form-control" type="text" placeholder="Masking">
      </div>
      <div class="form-group">
        <label>Buffing</label>
        <input required name="num_buffing" class="form-control" type="text" placeholder="Buffing">
      </div>      
      </div>
    </div>
  </form>   
</x-modals.modal>
