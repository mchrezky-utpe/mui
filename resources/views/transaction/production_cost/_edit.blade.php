<x-modals.modal id="edit_modal" title="Edit Prodcution Cycle">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/production_cost/edit">
      @csrf
      <input type="hidden" name="id" />
       
       <div class="form-group">
        <label>Part Name</label>
        <input required name="sku_name" class="form-control" type="text" placeholder="Part Name">
      </div>
      <div class="form-group">
        <label>Model</label>
        <input required name="sku_model" class="form-control" type="text" placeholder="Model">
      </div>
    </form>   
  </x-modals.modal>