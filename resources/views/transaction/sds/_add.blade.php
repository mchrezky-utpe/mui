<x-modals.modal id="add_modal" title="Add Sds" modalClass="custom-modal-dialog-medium">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sds">
     @csrf
    <!-- TAB TRANSACTION -->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_left">Sds Date</label>
          <input required name="trans_date" class="form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
      </div>
      <!-- REGION SIDE 2 -->
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_right">Supplier</label>
          <select required id="supplier_select" name="prs_supplier_id" class="form-control supplier_select">
            <option value="">-- Select Supplier --</option>
          </select>
        </div>
      </div>
      <!-- REGION SIDE 3 -->
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_right">Po Number</label>
          <select id="po_select" name="trans_po_id" class="form-control po_select">
            <option value="">-- Select PO --</option>
          </select>
        </div>
      </div>
      <!-- HIDE FIELD -->
    </div>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <!-- Tab Navigation -->
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi" type="button" role="tab" aria-controls="transaksi" aria-selected="true"> Item Po </button>
      </li>
    </ul>
    <div class="mt-3 tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab"> @include('transaction.sds._item') </div>
    </div>
  </form>
</x-modals.modal>