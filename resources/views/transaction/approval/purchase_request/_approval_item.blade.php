<x-modals.modal id="detail_modal" title="Detail Items PR"  modalClass="custom-modal-dialog-medium2">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/general-terms/edit">
    @csrf
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Details</h5>
    </div>
    <div class="table-container">
      <table class="table table-scroll" id="detail_table">
        <thead>
          <tr>
            <th>No</th>
            <th>Sku Name</th>
            <th>Price</th>
            <th>Qty</th>
            <th>Sub Total</th>
            <th>Discount</th>
            <th>Vat</th>
            <th>Total</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </form>   
</x-modals.modal>