<x-modals.modal id="add_modal_po" title="Add Purchase Order" modalClass="custom-modal-dialog-large">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/pr/po"> @csrf <div class="row">
      <div class="col-md-4">
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
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_left">Valid From</label>
          <input required name="valid_from_date" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="description_left">Valid To</label>
          <input required name="valid_to_date" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label>Attention</label>
          <input name="attention" class="form-control" type="text" placeholder="Attention" />
        </div>
        <div class="form-group">
          <label>Description</label>
          <textarea required name="description" class="form-control" type="text" placeholder="Description"></textarea>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label>PPN</label>
              <div class="input-group">
                <input name="ppn" class="form-control" type="text" placeholder="%"/>
              </div>
            </div>
            <div class="col-md-6">
              <label>&nbsp</label>
              <div class="input-group">
                <input name="ppn" class="form-control" type="text"  readonly/>
              </div>
            </div>
         </div>
        </div>
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label>PPH 23</label>
              <div class="input-group">
                <input name="pph23" class="form-control" type="text" placeholder="%" />
              </div>
            </div>
            <div class="col-md-6">
              <label>&nbsp</label>
              <div class="input-group">
                <input name="pph23_total" class="form-control" type="text" readonly/>
              </div>
            </div>
         </div>
        </div>
        
        <div class="form-group">
          <div class="row">
            <div class="col-md-6">
              <label>Discount</label>
              <div class="input-group">
                <input name="discount" class="form-control" type="text" placeholder="%" />
              </div>
            </div>
            <div class="col-md-6">
              <label>&nbsp</label>
              <div class="input-group">
                  <input name="discount_total" class="form-control" type="text" readonly/>
              </div>
            </div>
         </div>
        </div>

        <div class="form-group">
          <label>Sub Total</label>
          <input name="sub_total" class="form-control" type="text" placeholder="Total" readonly/>
        </div>
        <div class="form-group">
          <label>Total</label>
          <input name="total" class="form-control" type="text" placeholder="Attention" readonly/>
        </div>
      </div>
    </div>
    
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <!-- Tab Navigation -->
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi" type="button" role="tab" aria-controls="transaksi" aria-selected="true"> Item Transaction </button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
      <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab"> @include('transaction.pr._item') </div>
    </div>
  </form>
</x-modals.modal>