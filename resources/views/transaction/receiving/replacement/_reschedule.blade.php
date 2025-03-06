<x-modals.modal id="reschedule_modal" title="Reschedule">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sds/reschedule">
    @csrf
    <div class="form-group">
      <label>Current SDS Number</label>
      <input name="id" class="form-control" type="hidden"  readonly>
      <input name="doc_number_old" class="form-control" type="text" readonly>
    </div>
    <div class="form-group">
      <label>New SDS Number</label>
      <input name="doc_number_new" class="form-control" type="text" value="XXX" readonly>
    </div>
    <div class="form-group">
      <label>SDS Date</label>
      <input required name="date" class="form-control" type="date">
    </div>
  </form>   
</x-modals.modal>