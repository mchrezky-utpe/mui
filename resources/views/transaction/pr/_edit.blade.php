<x-modals.modal id="edit_modal" title="Edit Purchase Order"  modalClass="custom-modal-dialog-medium">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/pr/edit">
    @csrf
    {{-- <div class="form-group">
      <label>Manual ID</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input type="hidden" name="id" />
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div> --}}
    @csrf
    <!-- TAB TRANSACTION -->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="description_left">PR Date</label>
          <input required name="trans_date" class="form-control" type="date" value="{{ date('Y-m-d') }}">
        </div>
        <div class="form-group">
          <label for="manual_id_right">PR Type</label>
          <select required name="flag_type" class="form-control">
            <option value="">-- Select Type --</option>
            <option value="1"> Production Project Material </option>
            <option value="2"> General Item </option>
          </select>
        </div>
      </div>
      <!-- REGION SIDE 2 -->
      <div class="col-md-4">
        <div class="form-group">
          <label for="manual_id_right">PR Propose</label>
          <select required name="flag_purpose" class="form-control">
            <option value="">-- Propose --</option>
            <option value="1"> Project Development </option>
            <option value="2"> Additional </option>
            <option value="3"> Recovery </option>
            <option value="4"> Early Development </option>
          </select>
        </div>
        <div class="form-group">
          <label for="description_right">Supplier</label>
          <select required id="supplier_select" name="prs_supplier_id" class="form-control">
            <option value="">-- Select Supplier --</option>
          </select>
        </div>
      </div>
      <div class="col-md-4">
        <div class="form-group">
            <label for="manual_id_right">Currency</label>
            <select required id="currency_select" name="gen_currency_id" class="form-control">
              <option value="">-- Select Currency --</option>
            </select>
          </div>
      </div>

      <!-- REGION SIDE 3 -->
      <!-- REGION SIDE 4 -->
      <!-- HIDE FIELD -->
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