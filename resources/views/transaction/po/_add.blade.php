<x-modals.modal id="add_modal" title="Add Purchase Order" modalClass="custom-modal-dialog-large">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/po"> @csrf <div class="row">
    
    <!-- REGION OF HEADER -->
    <!-- REGION SIDE 1 -->
      <div class="col-md-2">
        <div class="form-group">
          <label for="manual_id_left">Manual ID</label>
          <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
        </div>
        <div class="form-group">
          <label for="description_left">Doc Number(Auto)</label>
          <input readonly name="doc_number" class="form-control" type="text" placeholder="Doc Number">
        </div>
        <div class="form-group">
          <label for="description_left">Date</label>
          <input name="trans_date" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
        </div>
      </div>
      
    <!-- REGION SIDE 2 -->
      <div class="col-md-2">
        <div class="row">
          <!-- Row untuk layout grid -->
          <div class="col-md-6">
            <div class="form-group">
              <label for="description_left">Valid From</label>
              <input name="valid_from" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <label for="description_left">Valid To</label>
              <input name="valid_to" class="form-control" type="date" placeholder="Description" value="{{ date('Y-m-d') }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="manual_id_right">Type</label>
          <select name="type" class="form-control">
          <option value="">-- Select Type --</option>
            <option value="1"> Production Project Material </option>
            <option value="2"> General Item </option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Terms</label>
          <select id="terms_select" name="terms" class="form-control">
          </select>
        </div>
      </div>
      
      <!-- REGION SIDE 3 -->
      <div class="col-md-2">
        <div class="form-group">
          <label for="description_right">Department</label>
          <select name="department" class="form-control">
          <option value="">-- Select Department --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Supplier</label>
          <select id="supplier_select" name="supplier" class="form-control">
          <option value="">-- Select Supplier --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Currency</label>
          <select name="currency" class="form-control">
          <option value="">-- Select Currency --</option>
          </select>
        </div>
      </div>
      
      <div class="col-md-1">
      <div class="form-group">
          <label for="description_left">Description</label>
          <input readonly name="description" class="form-control" type="text" placeholder="Description">
        </div>
          <div class="form-group">
            <button id="add_other_cost" type="button" class="btn btn-primary"  data-toggle="modal" data-target="#other_cost_modal">+ Other Cost</button>
          </div>
          <div class="form-group">
            <button id="add_deduction" type="button" class="btn btn-primary">+ Deduction</button>
          </div>
      </div>
      
      <!-- REGION SIDE 4 -->
      <div class="col-md-2">
          <div class="form-group">
              <label for="sub_total">Sub Total</label>
              <input id="sub_total" name="sub_total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
          </div>
          <div class="form-group">
              <label for="sub_total">Other Cost Total</label>
              <input id="sub_total" name="other_cost_total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
          </div>
          <div class="form-group">
              <label for="sub_total">Deduction Total</label>
              <input id="sub_total" name="deduction_total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
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
              <label for="total">Total</label>
              <input id="total" name="total" class="form-control" type="number" placeholder="0" step="0.01" readonly>
          </div>
      </div>


    </div>

    <!-- REGION OF ITEMS -->
    <div class="">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">items</h5>
        <button id="add_row" type="button" class="btn btn-primary">+</button>
      </div>
      <div class="table-container">
        <table class="table table-scroll" id="add_table">
          <thead>
            <tr>
              <th>No</th>
              <th>Description</th>
              <th>Sku</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Sub Total</th>
              <th>Discount Percentage</th>
              <th>After Discount</th>
              <th>Vat</th>
              <th>Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </form>
</x-modals.modal>