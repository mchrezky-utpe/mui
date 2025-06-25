<x-modals.modal id="add_modal" title="Add General Terms">
<form id="form_modal" autocomplete="off" class="form-horizontal add_modal" method="post" action="/general-terms">
    @csrf
    <div class="form-group">
      <label>Term Code</label>
      <input readonly name="manual_id" class="form-control" type="text" placeholder="TC-XXX">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
    @include('master.general_terms._detail')
  </form>   
</x-modals.modal>
