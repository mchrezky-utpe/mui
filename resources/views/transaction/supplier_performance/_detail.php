<div class="row mb-4">
                <div class="col-12">
                    <div class="row g-3">
                        <!-- Filter Tanggal -->
                        <div class="col-md-8">
                            <div class="row g-2">
                                <div class="col-sm-4">
                                    <label for="startDate" class="form-label">From</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>
                                <div class="col-sm-4">
                                    <label for="endDate" class="form-label">Until</label>
                                    <input type="date" class="form-control" id="endDate">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Filter Supplier -->
                        <div class="col-md-4">
                            <label class="form-label supplier_label">Supplier</label>
                            <select class="form-control supplier_select" id="supplier_id">
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
                    <div class="col-md-5">
                        <div class="data-list border rounded p-3">
                            <table id="supplier_peformance_table" class="table table-scroll table-clickable">
                                <thead>
                                <tr>
                                    <th>Supplier</th>
                                    <th colspan="2">Delivery Performance</th>
                                    <th colspan="2">Quality Performance</th>
                                </tr>
                                <tr>
                                    <th>Information</th>
                                    <th>Late</th>
                                    <th>Result</th>
                                    <th>PPM</th>
                                    <th>Result</th>
                                </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Area Kanan - List Data -->
                    <div class="col-md-7">
                        <div class="chart-card">
                            <div class="chart-container">
                                <canvas id="chart"></canvas>
                            </div>
                        </div>
                        <div class="data-list border rounded p-3">
                            <table id="detail_performance_table" class="table table-scroll table-clickable">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Description</th>
                                    <th>Jan</th>
                                    <th>Feb</th>
                                    <th>Mar</th>
                                    <th>Apr</th>
                                    <th>May</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Aug</th>
                                    <th>Sep</th>
                                    <th>Oct</th>
                                    <th>Nov</th>
                                    <th>Dec</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                </div>