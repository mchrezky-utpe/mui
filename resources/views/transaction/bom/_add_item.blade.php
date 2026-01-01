<div class="modal fade" id="add_modal_item" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bom Unit Quantity</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Process Type</label>
                            <select required name="process_type" class="form-control">
                            </select>
                            <input required id="sku_selected_id" name="sku_selected_id" class="form-control" type="hidden" value="1"/>
                            <input required id="sku_selected_name" name="sku_selected_name" class="form-control" type="hidden" value="1"/>
                            <input required id="sku_selected_code" name="sku_selected_code" class="form-control" type="hidden" value="1"/>
                        </div>
                        <div class="form-group">
                            <label>Unit</label>
                            <input required name="unit" class="form-control" type="text" placeholder="Unit">
                        </div>
                        <div class="form-group">
                            <label>Capacity</label>
                            <input required id="qty_capacity" name="capacity" class="form-control" type="text" placeholder="Capacity">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Capacity/Unit</label>
                            <input required id="qty_each_unit" name="capacity_per_unit" class="form-control" type="text" placeholder="Capacity/Unit">
                        </div>
                        <div class="form-group">
                            <label>Reg. Procurement</label>
                            <select required name="flag_reg_procurement" class="form-control">
                                <option value="0">YES</option>
                                <option value="1">NO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Parent Cost Included</label>
                            <select required name="flag_parent_cost_incl" class="form-control">
                                <option value="0">YES</option>
                                <option value="1">NO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Is Priority</label>
                            <input name="flag_main_priority" class="form-control" type="checkbox" placeholder="Priority">
                        </div>
                        <div class="form-group" id="levelGroup">
                            <label for="level">Level:</label>
                            <select id="level">
                                <option value="1">Level 1</option>
                            </select>
                        </div>

                        <div class="form-group" id="parentGroup" style="display: none;">
                            <label for="parent">Parent:</label>
                            <select id="parent"></select>
                        </div>
                    </div>
                </div>
                <div class="row">
                </div>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="addBtn">Add</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>