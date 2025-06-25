<x-modals.modal id="edit_modal" title="Edit General Terms">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/general-terms/edit">
    @csrf
    <div class="form-group">
      <label>Term Code</label>
      <input readonly name="manual_id" class="form-control" type="text" placeholder="Term ID">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input type="hidden" name="id" />
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
    @include('master.general_terms._detail')
  </form>   
</x-modals.modal>