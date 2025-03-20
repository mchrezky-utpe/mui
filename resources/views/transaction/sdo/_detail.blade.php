<x-modals.modal notUsingSave="true" id="detail_modal" title="Detail Items Receive"  modalClass="custom-modal-dialog-medium2">
    @csrf
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Details</h5>
    </div>
    <div class="table-container">
      <table class="table table-scroll" id="detail_table">
        <thead>
          <tr>
            <th>Do Number</th>
            <th>Do Date</th>
            <th>Po Number</th>
            <th>Description</th>
            <th>Qty</th>
            <th>Item Name</th>
            <th>Item Code</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
</x-modals.modal>