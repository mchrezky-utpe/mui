  <x-modals.modal id="add_general_item_modal" title="Add General Item Price" modalClass="custom-modal-dialog-large" >
                        <!-- Form Section -->
                     <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-pricelist">
                        <div class="row">
                            <div class="col-md-4">
                                    @csrf
                                    <div class="form-group">
                                        <label>Item Code</label>
                                        <input readonly name="sku_code" class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>Item Name</label>
                                        <input readonly name="sku_name" class="form-control" type="text" />
                                        <input name="sku_id" class="form-control" type="hidden" />
                                    </div>
                                    <div class="form-group">
                                        <label>Supplier</label>
                                        <select required name="prs_supplier_id" class="form-control">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Currency</label>
                                        <select required name="gen_currency_id" class="form-control">
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Lead Time</label>
                                        <input required name="lead_time" class="form-control" type="number" />
                                    </div>
                                    <div class="form-group">
                                    <label>MOQ</label>
                                    <input  name="moq" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label>Valid From</label>
                                        <input required name="valid_date_from" class="form-control" type="date" value="{{ date('Y-m-d') }}" />
                                    </div>
                                    <div class="form-group">
                                        <label>Valid To</label>
                                        <input required name="valid_date_to" class="form-control" type="date" value="{{ date('Y-m-d') }}" />
                                    </div>
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="flag_status" name="flag_status" checked>
                                        <label class="form-check-label" for="flag_status">Activated Status</label>
                                    </div>
                                    <div class="form-group">
                                        <label>Price</label>
                                        <input required name="price" class="form-control" type="text" />
                                    </div>
                                    <div class="form-group">
                                        <label>Retail Price</label>
                                        <input required name="price_retail" class="form-control" type="text" />
                                    </div>
                            </div>
                            
                            <!-- Table Section -->
                            <div class="col-md-8">
                                <h5>Item</h5>
                                <div class="table-container">
                                    <table id="table-item-general" class="table table-striped table-hover">
                                        <thead class="sticky-top bg-light">
                                            <tr>
                                                <th>Item Code</th>
                                                <th>Item Name</th>
                                                <th>Spec Code</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Data akan diisi melalui JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
    </form>
</x-modals.modal>