<x-modals.modal id="approval_modal" title="Confirmation">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="">
    @csrf
    <input type="hidden" name="action_type" id="action_type">
    <input type="hidden" name="selected_ids" id="selected_ids">
    <p><span id="action_message"></span> Selected Transaction(s)?</p>
  </form>   
</x-modals.modal>



