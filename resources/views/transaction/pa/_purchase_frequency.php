<div class="row mb-4">
                <div class="col-12">
                    <div class="row g-3">
                        <!-- Filter Tanggal -->
                        <div class="col-md-6">
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <label for="startDate" class="form-label">From</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                                <div class="col-sm-6">
                                    <label for="endDate" class="form-label">Until</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filter Supplier -->
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select class="form-control department_select" id="gen_department_id">
                                <option>-</option>                               
                            </select>
                            <div class="mt-2">
                                <button id="btn-filter" type="button" class="btn btn-primary btn-sm" >
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm ms-1" onclick="window.location.reload();">
                                    <i class="fas fa-redo"></i> Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                    <!-- Area Kiri - List Data -->
                    <div class="col-md-4">
                        <div class="data-list border rounded p-3">
                            <table id="purchase_freq_table" class="table table-scroll table-clickable">
                                <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Curr.</th>
                                    <th>Total Purchase</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Area Kanan - List Data -->
                    <div class="col-md-8">
                        <div class="data-list border rounded p-3">
                              <table id="table-po" class="table table-striped table-bordered first unwrap-column">
                                <thead>
                                <tr>
                                    <th>PO Date</th>
                                    <th>PO Number</th>
                                    <th>Department</th>
                                    <th>Item Name</th>
                                    <th>Item Unit</th>
                                    <th>Qty</th>
                                    <th>Curr</th>
                                    <th>Price</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                </table>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        
                        <div class="chart-card">
                            <div class="chart-container">
                                <canvas id="barChartTab"></canvas>
                        </div>
                        <!-- <div class="section-title">Purchase Frequencey</div>
                        <div class="chart-container border rounded p-3">
                            <canvas id="chartTab1" width="1332" height="243" style="display: block; box-sizing: border-box; height: 216.2px; width: 1184px;"></canvas>
                        </div> -->
                    </div>
                </div>