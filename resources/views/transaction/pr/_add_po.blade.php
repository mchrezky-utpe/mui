<x-modals.modal id="add_modal_po" title="Add Purchase Order">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/pr/po"> 
    @csrf <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>PR Doc Number</label>
          <input readonly name="pr_doc_numb" class="form-control" type="text" placeholder="" />
        </div>
        <div class="form-group">
          <input name="id" class="form-control" type="hidden" placeholder="id purchase request" />
          <input name="prs_supplier_id" class="form-control" type="hidden" placeholder="id supplier" />
          <label>Supplier</label>
          <input readonly required name="supplier_name" class="form-control" type="text" placeholder="Supplier" />
        </div>
        <div class="form-group">
          <label for="description_right">Terms</label>
          <select id="terms_select" name="gen_terms_detail_id" class="form-control terms_select"></select>
        </div>
        <div class="form-group">
          <label>PO Date</label>
          <input required name="trans_po_date" class="form-control" type="date" placeholder="PO Date" value="{{ date('Y-m-d') }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="description_left">Valid From</label>
          <input required name="valid_from_date" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="description_left">Valid To</label>
          <input required name="valid_to_date" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea required name="description" class="form-control" type="text" placeholder="Description"></textarea>
        </div>
      </div>
    </div>
  </form>
</x-modals.modal>