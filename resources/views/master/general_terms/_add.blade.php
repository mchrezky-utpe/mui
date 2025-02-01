<x-modals.modal id="add_modal" title="Add General Terms">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/general-terms">
    @csrf
    <div class="form-group">
      <label>Manual ID</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
    @include('master.general_terms._detail')
  </form>   
</x-modals.modal>
