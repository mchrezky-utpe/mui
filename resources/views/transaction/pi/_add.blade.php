<x-modals.modal id="add_modal" title="Add Purchase Invoice" modalClass="custom-modal-dialog-medium">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/pi">
     @csrf
    <!-- TAB TRANSACTION -->
    <div class="row  row-calc">
      <div class="col-md-3">
        <div class="form-group">
          <label for="description_left">Invoice Date</label>
          <input required name="trans_date" class="trans_date form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="manual_id_left">Invoice Number</label>
          <input  name="manual_id" class="form-control" type="text" placeholder="Invoice Number">
        </div>
        <div class="form-group">
          <label for="description_left">Invoice Code(Auto)</label>
          <input readonly value="PI/XX/XX/XXXX" name="doc_number" class="form-control" type="text" placeholder="Doc Number">
        </div>
        <div class="form-group">
          <label for="manual_id_right">Invoice Type</label>
          <select required name="flag_type" class="form-control">
            <option value="">-- Select --</option>
            <option value="1"> PRODUCTION MATERIAL PI </option>
            <option value="2"> GENERAL PI </option>
            <option value="3"> RECURRING / SUBSRIPTION PI </option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Approval Req.</label>
          <select required name="flag_approval" class="form-control">
            <option value="">-- Select --</option>
            <option value="1"> Yes </option>
            <option value="2"> No </option>
          </select>
        </div>
      </div>
      <!-- REGION SIDE 2 -->
      <div class="col-md-3">
        <div class="row">
            <!-- Row untuk layout grid -->
          <div class="form-group">
            <label for="description_right">Department</label>
            <select required  name="gen_department_id" class="department_select form-control">
              <option value="">-- Select --</option>
            </select>
          </div>
          <div class="form-group">
            <label for="description_right">Supplier</label>
            <select required name="prs_supplier_id" class="supplier_select form-control">
              <option value="">-- Select --</option>
            </select>
          </div>
          <div class="form-group">
            <label for="manual_id_right">Terms of Pay.</label>
            <select required name="gen_terms_detail_id" class="terms_select form-control">
              <option value="">-- Select --</option>
            </select>
          </div>
          <div class="form-group">
            <label for="manual_id_right">Invoice Phase.</label>
            <select required name="flag_phase" class="form-control">
              <option value="">-- Select --</option>
              <option value="1"> Regular </option>
              <option value="2"> Partial </option>
            </select>
          </div>
        </div>
      </div>

      <!-- REGION SIDE 3 -->
      <div class="col-md-3">
          <div class="form-group">
            <label for="manual_id_right">Invoice Phase Payment</label>
            <select required name="flag_phase_payment" class="form-control">
              <option value="">-- Select --</option>
              <option value="1"> DOWN PAYMENT </option>
              <option value="2"> 2ND PAYMENT </option>
              <option value="3"> 3RD PAYMENT </option>
              <option value="4"> FINAL PAYMENT </option>
            </select>
          </div>
        <div class="form-group">
          <label for="description_right">Currency</label>
          <select required  name="gen_currency_id" class="currency_select form-control">
            <option value="">-- Select --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">PPN</label>
          <input name="tax_master" class="form-control" type="hidden" placeholder="0" step="0.01" readonly>
          <input name="val_vat" class="val_vat form-control" type="hidden" placeholder="0" step="0.01" readonly>
          <input name="is_ppn" class="is_ppn form-control" onclick="calc(this)" type="checkbox" placeholder="0" step="0.01" readonly>
        </div>
      </div>
      <!-- REGION SIDE 4 -->
      <!-- HIDE FIELD -->
      <input name="val_exchangerates" class="tax_rate form-control" type="hidden" readonly>
      <div class="col-md-3">
        <div class="form-group">
          <label for="sub_total">Sub Total</label>
          <input id="sub_total" onchange="calc(this)" name="val_subtotal" class="val_subtotal form-control" type="number" placeholder="0" step="0.01">
        </div>
        <div class="form-group">
          <label for="sub_total">PPH</label>
          <input id="other_cost_total" onchange="calc(this)" name="val_pph23" class="val_pph23 form-control" type="number" placeholder="0" step="0.01" >
        </div>
        <div class="form-group">
          <label for="discount_total">Discount</label>
          <input id="discount_total" onchange="calc(this)" name="val_discount" class="val_discount form-control" type="number" placeholder="0" step="0.01" >
        </div>
        <div class="form-group">
          <label for="total">Total</label>
          <input id="total" name="val_total" class="val_total form-control" type="number" placeholder="0" step="0.01" >
        </div>
      </div>
      
    </div>
    
    <div class="tab-content mt-2" id="myTabContent">
        <div class="card-header d-flex justify-content-between align-items-center">
          <h5 class="mb-0">Detail</h5>
          <button type="button" class="add_row btn btn-primary">Add</button>
        </div>
        <div class="table-container">
          <table id="item_table" class="table table-scroll item_table" id="add_table">
            <thead>
              <tr>
                <th>PO Number</th>
                <th>Check</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
    </div>
  </form>
</x-modals.modal>