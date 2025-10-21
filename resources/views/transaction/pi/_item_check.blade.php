 <x-modals.modal notUsingSave="true" id="item_check_modal" title="Purchae Invoice Item Check" modalClass="custom-modal-dialog-medium">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="get" action="/po">
    @csrf 
<div class="card-header d-flex justify-content-between align-items-center">
</div>
<div class="table">
  <table id="item_check_table" class="table data-table item_check_table" id="add_table">
    <thead>
      <tr>
        <th>Trans. Date</th>
        <th>PO Number</th>
        <th>DO Number</th>
        <th>Item Code</th>
        <th>Item Name</th>
        <th>Item Type</th>
        <th>Qty</th>
        <th>Check</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
  <button type="button" class="btn btn-primary verify">Verify</button>
</div>

  </form>
</x-modals.modal>