<x-modals.modal buttonName="Received" id="add_modal" title="Internal Receiving" modalClass="custom-modal-dialog-medium">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sdo/receive">
     @csrf
    <!-- TAB TRANSACTION -->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_left">Receiving Date</label>
          <input required name="trans_date" class="form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
      </div>
      <!-- REGION SIDE 3 -->
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_right">Origin</label>
          <select required id="po_select" name="purchase_order_id" class="form-control">
            <option value="">-- Select --</option>
            <option value="1">Production</option>
            <option value="2">Quality Control</option>
          </select>
        </div>
      </div>

      
      <!-- REGION SIDE 3 -->
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_right">Sub Origin</label>
          <select required id="po_select" name="purchase_order_id" class="form-control">
            <option value="">-- Select --</option>
            <option value="1">Assembly</option>
            <option value="2">Buffing</option>
            <option value="3">Painting</option>
            <option value="4">Plating</option>
          </select>
        </div>
      </div>

    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <!-- Tab Navigation -->
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi" type="button" role="tab" aria-controls="transaksi" aria-selected="true"> Item DO </button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
      <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab"> @include('transaction.sdo._item') </div>
    </div>
  </form>
</x-modals.modal>