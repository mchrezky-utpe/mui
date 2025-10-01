<x-modals.modal notUsingSave="true" id="detail_modal" title="Detail Supplier Delivery Schedule" modalClass="custom-modal-dialog-medium2">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="get" action="/sds">
    @csrf

    <div class="mb-3 card" style="border: 1px solid #dee2e6;">
        <div class="card-header bg-light">
            <h6 class="mb-0"><i class="fas fa-truck"></i> Supplier Delivery Schedule Information</h6>
        </div>
        
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-2 row">
                        <div class="col-5"><strong>PO Number:</strong></div>
                        <div class="col-7" id="detail_po_number">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>SDS Number:</strong></div>
                        <div class="col-7" id="detail_doc_num">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Supplier:</strong></div>
                        <div class="col-7" id="detail_supplier">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Department:</strong></div>
                        <div class="col-7" id="detail_department">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Date SDS:</strong></div>
                        <div class="col-7" id="detail_sds_date">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Date Received:</strong></div>
                        <div class="col-7" id="detail_received_date">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Date Pulled Back:</strong></div>
                        <div class="col-7" id="detail_pulled_date">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Date Reschedule:</strong></div>
                        <div class="col-7" id="detail_reschedule_date">-</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-2 row">
                        <div class="col-5"><strong>SDS Status:</strong></div>
                        <div class="col-7" id="detail_status">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Revision:</strong></div>
                        <div class="col-7" id="detail_rev_counter">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>EDI Status:</strong></div>
                        <div class="col-7" id="detail_edi_status">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Delivery:</strong></div>
                        <div class="col-7" id="detail_delivery">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Shipment:</strong></div>
                        <div class="col-7" id="detail_shipment">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Reschedule Status:</strong></div>
                        <div class="col-7" id="detail_reschedule">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Date Reschedule:</strong></div>
                        <div class="col-7" id="detail_date_reschedule">-</div>
                    </div>
                    <div class="mb-2 row">
                        <div class="col-5"><strong>Revision Date:</strong></div>
                        <div class="col-7" id="detail_rev_date">-</div>
                    </div>
                </div>
            </div>
        </div>

    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Details</h5>
    </div>
    <div class="table-container">
      <table class="table table-scroll item_table" id="item_table">
        <thead>
          <tr>
            <th>Item Name</th>
            <th>Item Code</th>
            <th>Specification Code</th>
            <th>Item Type</th>
            <th>Unit</th>
            <th>Qty Sds</th>
            <th>Outstanding SDO</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>
    </div>

    {{-- <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">SDS Details Items</h5>
    </div>
    <div class="table-container">
        <table class="table table-scroll table-striped" id="detail_table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Item Code</th>
                    <th>Item Name</th>
                    <th>Qty Ordered</th>
                    <th>Qty Delivered</th>
                    <th>Unit</th>
                    <th>Delivery Date</th>
                    <th>Status</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div> --}}
</form>   
</x-modals.modal>