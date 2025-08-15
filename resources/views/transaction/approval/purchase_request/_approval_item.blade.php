<x-modals.modal notUsingSave="true" id="detail_modal" title="Detail Items PR"  modalClass="custom-modal-dialog-medium2">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="get" action="/approval-pr">
    @csrf

    <div class="mb-3 card" style="border: 1px solid #dee2e6;">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="fas fa-info-circle"></i> Purchase Request Information</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-2 row">
                            <div class="col-5"><strong>ID:</strong></div>
                            <div class="col-7" id="detail_id">-</div>
                        </div>
                        <div class="mb-2 row">
                            <div class="col-5"><strong>Doc Number:</strong></div>
                            <div class="col-7" id="detail_doc_num">-</div>
                        </div>
                        <div class="mb-2 row">
                            <div class="col-5"><strong>Supplier:</strong></div>
                            <div class="col-7" id="detail_supplier">-</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-2 row">
                            <div class="col-5"><strong>Date:</strong></div>
                            <div class="col-7" id="detail_date">-</div>
                        </div>
                        <div class="mb-2 row">
                            <div class="col-5"><strong>Description:</strong></div>
                            <div class="col-7" id="detail_description">-</div>
                        </div>
                        <div class="mb-2 row">
                            <div class="col-5"><strong>Status:</strong></div>
                            <div class="col-7" id="detail_status">-</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

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
            <th>Req Date</th>
            <th>Status</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
  </form>   
</x-modals.modal>