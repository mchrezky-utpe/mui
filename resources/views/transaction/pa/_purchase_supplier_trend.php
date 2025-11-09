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
                            <label class="form-label">Count</label>
                                <input type="number" value="10" class="form-control" id="count">
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
                            <table id="purchase_table" class="table table-scroll table-clickable table-nowrap">
                                <thead>
                                <tr>
                                    <th>Supplier</th>
                                    <th>Amount</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Area Kanan - List Data -->
                    <div class="col-md-8">
                        <div class="chart-card">
                            <div class="chart-container">
                                <canvas id="barChartTab"></canvas>
                        </div>
                    </div>
                </div>