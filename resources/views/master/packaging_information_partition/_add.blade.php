<x-modals.modal id="add_modal" title="Add Partition">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/packaging-information-partition">
  @csrf
    <div class="form-group">
      <label>Partition Type</label>
          <select required name="type_id" class="form-control"></select>
    </div>
    <div class="form-group">
      <label>Partition Name</label>
      <input required name="description" class="form-control" type="text">
    </div>

    <div class="form-group">
      <label>Partition Size</label>
         <input name="size" class="form-control" type="text">
    </div>
    <div class="form-group">
      <label>Partition Capacity</label>
      <input required name="capacity" class="form-control" type="number">
    </div>
  </form>
</x-modals.modal>
