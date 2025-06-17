<x-modals.modal id="add_modal" title="Add Data Prodcution Cycle Time">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/production_cost">
      @csrf
      <div class="row">
        <div class="col-md-12">
      <div class="form-group">
        <label>Part Name</label>
        <input required name="sku_name" class="form-control" type="text" placeholder="Part Name">
      </div>
      <div class="form-group">
        <label>Model</label>
        <select required id="sku_model" name="sku_model" class="form-control"></select>
      </div>
      </div>
    </div>
  </form>   
</x-modals.modal>
