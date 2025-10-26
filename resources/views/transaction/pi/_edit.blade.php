<x-modals.modal id="edit_modal" title="Purchase Invoice Adjustment">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/pi/edit">
    @csrf
    <div class="row row-calc">
      
      <div class="col-md-6">
        <div class="form-group">
          <label for="description_left">Invoice Code(Auto)</label>
          <input readonly name="id" class="form-control" type="hidden">
          <input readonly value="PI/XX/XX/XXXX" name="doc_number" class="form-control" type="text" placeholder="Doc Number">
        </div>
        <div class="form-group">
          <label for="manual_id_left">Invoice Number</label>
          <input  name="manual_id" class="form-control" type="text" placeholder="Invoice Number">
        </div>
          <div class="form-group">
            <label for="manual_id_right">Terms of Pay.</label>
            <select required name="gen_terms_detail_id" class="terms_select form-control">
              <option value="">-- Select --</option>
            </select>
          </div>
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

      </div>
      <!-- REGION SIDE 2 -->
      <div class="col-md-6">
            <!-- Row untuk layout grid -->
            
        <div class="form-group">
          <label for="description_right">Currency</label>
          <select required name="gen_currency_id" class="currency_select form-control">
            <option value="">-- Select --</option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">PPN</label>
          <input name="tax_master" class="form-control" type="hidden" placeholder="0" step="0.01" readonly>
          <input name="val_vat" class="val_vat form-control" type="hidden" placeholder="0" step="0.01" readonly>
          <input name="is_ppn" class="is_ppn form-control" onclick="calc(this)" type="checkbox" placeholder="0" step="0.01" readonly>
        </div>
  
      <input name="val_exchangerates" class="tax_rate form-control" type="hidden" readonly>
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
  </form>   
</x-modals.modal>