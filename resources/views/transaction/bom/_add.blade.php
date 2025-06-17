<x-modals.modal id="add_modal" title="Add Bom">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/bom">
    @csrf
    <div class="form-group">
      <label>Part Name</label>
          <select  required name="sku_id" class="form-control">
          </select >
    </div>
    <div class="form-group">
      <label>Remark</label>
      <input required name="remark" class="form-control" type="text" placeholder="Remark">
    </div>
    <div class="form-group">
      <label>Is Priority</label>
      <input  name="flag_main_priority" class="form-control" type="checkbox" placeholder="Priority">
    </div>
  </form>   
</x-modals.modal>
