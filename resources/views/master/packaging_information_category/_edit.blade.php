<x-modals.modal id="edit_modal" title="Edit Category">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/packaging-information-category/edit">
  @csrf
  
    <input type="hidden" name="id" />
    <div class="form-group">
      <label>Category Type</label>
          <select required name="type_id" class="form-control"></select>
    </div>
    <div class="form-group">
      <label>Category Name</label>
      <input required name="description" class="form-control" type="text">
    </div>
    <div class="form-group">
      <label>Category Model</label>
        <select  name="model_id" class="form-control"></select>
    </div>
    
    <div class="form-group">
      <label>Category Size</label>
         <input name="category_size" class="form-control" type="text">
    </div>
    <div class="form-group">
      <label>Category Unit</label>
        <select required name="unit_id" class="form-control"></select>
    </div>
    <div class="form-group">
      <label>Total Stock</label>
      <input required name="total_stock" class="form-control" type="number">
    </div>
  </form>
</x-modals.modal>
