<x-modals.modal notUsingSave="true" id="detail_modal" title="Detail Purchase Order" modalClass="custom-modal-dialog-large">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="get" action="/po">
    @csrf

    <div class="mb-3 card" style="border: 1px solid #dee2e6;">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-shopping-cart"></i> Purchase Order Information</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PO Number:</strong></div>
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
                <div class="col-md-4">
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Department:</strong></div>
                        <div class="col-7" id="detail_department">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Terms:</strong></div>
                        <div class="col-7" id="detail_terms">-</div>
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
                        <div class="col-5"><strong>Revision Status:</strong></div>
                        <div class="col-7" id="detail_revision">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PDF:</strong></div>
                        <div class="col-7" id="detail_file">-</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Currency:</strong></div>
                        <div class="col-7" id="detail_currency">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Sub Total:</strong></div>
                        <div class="col-7" id="detail_sub_total">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PPN:</strong></div>
                        <div class="col-7" id="detail_ppn">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Pph23:</strong></div>
                        <div class="col-7" id="detail_pph23">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Discount:</strong></div>
                        <div class="col-7" id="detail_discount">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Total:</strong></div>
                        <div class="col-7" id="detail_total">-</div>
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
                        <th>Item Code</th>
                        <th>Item Name</th>
                        <th>Spec Code</th>
                        <th>Item Type</th>
                        <th>Unit</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>OS SDS</th>
                        <th>OS Receiving</th>
                        <th>Status SDS</th>
                        <th>Receiving</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</form>   
</x-modals.modal>