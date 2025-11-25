<x-modals.modal notUsingSave="true" id="entry_qcc_modal" title="Entry Qcc Quantity" modalClass="custom-modal-dialog-medium">
<style>
     .form-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 25px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-section {
            margin-bottom: 25px;
            padding-bottom: 25px;
            border-bottom: 1px solid #dee2e6;
        }
        .form-section:last-child {
            border-bottom: none;
        }
        .form-section-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .checkbox-group, .radio-group {
            display: flex;
            flex-wrap: wrap;
                gap: 35px;
        }
        .checkbox-item, .radio-item {
            display: flex;
            align-items: center;
        }
        .checkbox-item input, .radio-item input {
            margin-right: 5px;
        }
        .form-footer {
            margin-top: 25px;
            text-align: right;
        }
        @media (max-width: 768px) {
            .checkbox-group, .radio-group {
                flex-direction: column;
                gap: 35px;
            }
        }
</style>
    <form id="form_modal" autocomplete="off" class="form-horizontal" method="get" action="/qc/entry-qcc">
        @csrf
    
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Qty Receiving</label>
                                <input required name="manual_id" class="form-control" type="text" placeholder="Enter quantity">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">All Good</label>
                                <div class="checkbox-item mt-2">
                                    <input required name="prefix" class="form-check-input" type="checkbox">
                                </div>
                            </div>
                        </div>
                        </div>
                
                        <div class="form-group radio-group">
                            <label class="form-label">Sampling Level</label>
                            <div class="radio-item">
                                <input required name="description" class="form-check-input" type="radio" id="level1" value="level1">
                                <label class="form-check-label" for="level1">No Sampling</label>
                            </div>
                            <div class="radio-item">
                                <input required name="description" class="form-check-input" type="radio" id="level2" value="level2">
                                <label class="form-check-label" for="level2">Normal</label>
                            </div>
                            <div class="radio-item">
                                <input required name="description" class="form-check-input" type="radio" id="level3" value="level3">
                                <label class="form-check-label" for="level3">Tighten</label>
                            </div>
                        </div>
                
                        <div class="form-group">
                            <label class="form-label">Qty Rework</label>
                            <input required name="manual_id" class="form-control" type="text" placeholder="Enter rework quantity">
                        </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Process Date</label>
                                    <input required name="manual_id" class="form-control" type="date">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Cavity</label>
                                    <select name="cavity" class="form-select">
                                        <option value="">- Select -</option>
                                        <option value="1">Cavity 1</option>
                                        <option value="2">Cavity 2</option>
                                        <option value="3">Cavity 3</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Claim Submit</label>
                                    <select name="claim_submit" class="form-select">
                                        <option value="">- Select -</option>
                                        <option value="yes">Yes</option>
                                        <option value="no">No</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Claim Action</label>
                                    <select name="claim_action" class="form-select">
                                        <option value="">- Select -</option>
                                        <option value="approve">Approve</option>
                                        <option value="reject">Reject</option>
                                        <option value="pending">Pending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="form-group">
                            <div class="checkbox-group">
                                <div class="checkbox-item">
                                    <input required name="judgement" class="form-check-input" type="checkbox" id="judgement">
                                    <label class="form-check-label" for="judgement">Judgement</label>
                                </div>
                                <div class="checkbox-item">
                                    <input required name="sampling" class="form-check-input" type="checkbox" id="sampling">
                                    <label class="form-check-label" for="sampling">Sampling</label>
                                </div>
                                <div class="checkbox-item">
                                    <input required name="sorting" class="form-check-input" type="checkbox" id="sorting">
                                    <label class="form-check-label" for="sorting">Sorting</label>
                                </div>
                                <div class="checkbox-item">
                                    <input required name="rework" class="form-check-input" type="checkbox" id="rework">
                                    <label class="form-check-label" for="rework">Rework</label>
                                </div>
                                <div class="checkbox-item">
                                    <input required name="return" class="form-check-input" type="checkbox" id="return">
                                    <label class="form-check-label" for="return">Return</label>
                                </div>
                            </div>
                        </div>
                    <div class="col-md-6">
                    </div>
                </div>
            
    </form>   
</x-modals.modal>