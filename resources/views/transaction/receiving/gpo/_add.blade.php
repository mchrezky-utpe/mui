<x-modals.modal buttonName="Received" id="add_modal" title="General Purchase Order Receiving" modalClass="custom-modal-dialog-medium">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/gpo">
     @csrf
    <!-- TAB TRANSACTION -->
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="description_left">Receiving Date</label>
          <input required name="trans_date" class="form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
      </div>
      <!-- REGION SIDE 2 -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="description_right">Supplier</label>
          <select required id="supplier_select" name="prs_supplier_id" class="form-control">
            <option value="">-- Select Supplier --</option>
          </select>
        </div>
      </div>
      <!-- REGION SIDE 3 -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="description_right">DO Number</label>
            <input class="form-control" name="manual_id" />
        </div>
      </div>
      <!-- REGION SIDE 3 -->
      <div class="col-md-6">
        <div class="form-group">
          <label for="description_right">GPO Type</label>
          <select required id="gpo_type" name="purchase_order_id" class="form-control">
            <option selected value="1">Project Development</option>
            <option value="2">General Item</option>
          </select>
        </div>
      </div>

      <div class="col-md-6">
        <div class="form-group">
          <label for="description_right">Po Number</label>
          <select required id="po_select" name="purchase_order_id" class="form-control">
            <option value="">-- Select PO --</option>
          </select>
        </div>
      </div>
      <!-- HIDE FIELD -->
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <!-- Tab Navigation -->
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi" type="button" role="tab" aria-controls="transaksi" aria-selected="true"> Item DO </button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
      <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab"> @include('transaction.receiving.gpo._item') </div>
    </div>
  </form>
</x-modals.modal>