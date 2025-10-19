<x-modals.modal id="edit_modal" title="Edit Purchase Order">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/po/edit">
    @csrf
    <div class="form-group">
      <label>PO Number</label>
      <input readonly name="id" class="form-control" type="hidden">
      <input readonly name="doc_num" class="form-control" type="text" placeholder="PO Number">
    </div>
    <div class="form-group">
      <label for="description_right">Terms</label>
      <select id="terms_select" name="gen_terms_detail_id" class="form-control terms_select"></select>
    </div>
    <div class="form-group">
      <label>Attention</label>
      <input name="attention" class="form-control" type="text" placeholder="Attention" />
    </div>
    <div class="form-group">
      <label>Description</label>
      <input type="hidden" name="id" />
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
  </form>   
</x-modals.modal>