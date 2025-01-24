<x-modals.modal id="other_cost_modal" title="Other Cost" modalClass="custom-modal-dialog-medium">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/other-cost"> @csrf <div class="row">
    <!-- REGION OF ITEMS -->
    <div class="col-md-12">
      <div class="card-header d-flex justify-content-between align-items-center">
        <button id="add_row_other_cost" type="button" class="btn btn-primary">+</button>
      </div>
      <div class="table">
        <table class="table table-scroll" id="other_cost_table">
          <thead>
            <tr>
              <th>No</th>
              <th>Description</th>
              <th>Other Cost</th>
              <th>Amount</th>
              <th>Qty</th>
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