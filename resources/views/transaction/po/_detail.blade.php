<x-modals.modal notUsingSave="true" id="detail_modal" title="Detail Purchase Order" modalClass="custom-modal-dialog-medium2">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="get" action="/po">
    @csrf

    <div class="mb-3 card" style="border: 1px solid #dee2e6;">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-shopping-cart"></i> Purchase Order Information</h6>
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
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PO Date:</strong></div>
                        <div class="col-7" id="detail_date">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PO Type:</strong></div>
                        <div class="col-7" id="detail_po_type">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Description:</strong></div>
                        <div class="col-7" id="detail_description">-</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PR Doc Number:</strong></div>
                        <div class="col-7" id="detail_pr_doc_num">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>EDI Status:</strong></div>
                        <div class="col-7" id="detail_edi_status">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PO Status:</strong></div>
                        <div class="col-7" id="detail_po_status">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>File:</strong></div>
                        <div class="col-7" id="detail_file">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Created At:</strong></div>
                        <div class="col-7" id="detail_created_at">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Updated At:</strong></div>
                        <div class="col-7" id="detail_updated_at">-</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PO Items Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">PO Details Items</h5>
        </div>
        <div class="table-container">
            <table class="table table-scroll table-striped" id="detail_table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Description</th>
                        <th>Sku</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>After Discount</th>
                        <th>Vat</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</form>   
</x-modals.modal>