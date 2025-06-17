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
        <select required id="sku_model" name="sku_model" class="form-control"></select>
      </div>
    </form>   
  </x-modals.modal>