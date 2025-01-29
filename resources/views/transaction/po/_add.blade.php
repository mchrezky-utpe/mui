<x-modals.modal id="add_modal" title="Add Purchase Order" modalClass="custom-modal-dialog-large">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/po">
     @csrf
    <!-- TAB TRANSACTION -->
    <div class="row">
      <div class="col-md-2">
        <div class="form-group">
          <label for="manual_id_left">Manual ID</label>
          <input value="{{ Str::random(10) }}" name="manual_id" class="form-control" type="text" placeholder="Manual ID">
        </div>
        <div class="form-group">
          <label for="description_left">Doc Number(Auto)</label>
          <input readonly value="MUI/PR/XX/XX/XXXX" name="doc_number" class="form-control" type="text" placeholder="Doc Number">
        </div>
        <div class="form-group">
          <label for="description_left">Date</label>
          <input required name="trans_date" class="form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
      </div>
      <!-- REGION SIDE 2 -->
      <div class="col-md-2">
        <div class="row">
          <!-- Row untuk layout grid -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="description_left">Valid From</label>
              <input required name="valid_from_date" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="description_left">Valid To</label>
              <input required name="valid_to_date" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="manual_id_right">Type</label>
          <select required name="flag_type" class="form-control">
            <option value="">-- Select Type --</option>
            <option value="1"> Production Project Material </option>
            <option value="2"> General Item </option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Terms</label>
          <select id="terms_select" name="gen_terms_detail_id" class="form-control"></select>
        </div>
      </div>
      <!-- REGION SIDE 3 -->
      <div class="col-md-2">
        <div class="form-group">
          <label for="description_right">Department</label>
          <select required id="department_select" name="gen_department_id" class="form-control">
            <option value="">-- Select Department --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Supplier</label>
          <select required id="supplier_select" name="prs_supplier_id" class="form-control">
            <option value="">-- Select Supplier --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Currency</label>
          <select required id="currency_select" name="gen_currency_id" class="form-control">
            <option value="">-- Select Currency --</option>
          </select>
        </div>
        <div class="form-group">
          <label  for="description_left">Description</label>
          <input required name="description" class="form-control" type="text" placeholder="Description">
        </div>
      </div>
      <!-- REGION SIDE 4 -->
      <!-- HIDE FIELD -->
      <input id="tax_rate" name="val_exchangerates" class="form-control" type="hidden" readonly>
      <div class="col-md-2">
        <div class="form-group">
          <label for="sub_total">Sub Total</label>
          <input id="sub_total" name="sub_total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
        </div>
        <div class="form-group">
          <label for="sub_total">Other Cost Total</label>
          <input id="other_cost_total" name="other_cost_total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
        </div>
        <div class="form-group">
          <label for="sub_total">Deduction Total</label>
          <input id="deduction_total" name="deduction_total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
        </div>
      </div>
      <div class="col-md-2">
        <div class="form-group">
          <label for="discount_total">Discount Total</label>
          <input id="discount_total" name="discount_total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
        </div>
        <div class="form-group">
          <label for="after_discount">After Discount</label>
          <input id="after_discount" name="after_discount" class="form-control" type="number" placeholder="0" step="0.01" readonly>
        </div>
        <div class="form-group">
          <label for="after_discount">Vat</label>
          <input id="vat" name="vat" class="form-control" type="number" placeholder="0" step="0.01" readonly>
        </div>
        <div class="form-group">
          <label for="total">Total</label>
          <input id="total" name="total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
        </div>
      </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <!-- Tab Navigation -->
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="transaksi-tab" data-bs-toggle="tab" data-bs-target="#transaksi" type="button" role="tab" aria-controls="transaksi" aria-selected="true"> Item Transaction </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="other-cost-tab" data-bs-toggle="tab" data-bs-target="#other-cost" type="button" role="tab" aria-controls="other-cost" aria-selected="false"> Other Cost </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="deduction-tab" data-bs-toggle="tab" data-bs-target="#deduction" type="button" role="tab" aria-controls="deduction" aria-selected="false"> Deduction </button>
      </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
      <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab"> @include('transaction.po._item') </div>
      <div class="tab-pane fade" id="other-cost" role="tabpanel" aria-labelledby="other-cost-tab"> @include('transaction.po._other_cost') </div>
      <div class="tab-pane fade" id="deduction" role="tabpanel" aria-labelledby="deduction-tab"> @include('transaction.po._deduction') </div>
    </div>
  </form>
</x-modals.modal>