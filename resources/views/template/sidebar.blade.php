
<div class="logo">
                <a href="/">
                    <img src="{{asset('assets/images/icon/mui.png')}}" width="150" alt="mui" />
                </a>
            </div>
            <div class="menu-sidebar__content js-scrollbar1">
                <nav class="navbar-sidebar">
                    <ul class="list-unstyled navbar__list">
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/">Dashboard 1</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#">Master</a>
                        </li>
                        <!-- SKU Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tags"></i>SKU</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/sku">Main</a>
                                </li>
                                <li>
                                    <a href="/sku-type">Type</a>
                                </li>
                                <li>
                                    <a href="/sku-unit">Unit</a>
                                </li>
                                <li>
                                    <a href="/sku-model">Model</a>
                                </li>
                                <li>
                                    <a href="/sku-process">Process</a>
                                </li>
                                <li>
                                    <a href="/sku-business">Business Type</a>
                                </li>
                                <li>
                                    <a href="/sku-packaging">Packaging</a>
                                </li>
                                <li>
                                    <a href="/sku-detail">Detail</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Person Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-users"></i>Person</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/person-supplier">Supplier</a>
                                </li>
                                <li>
                                    <a href="/person-customer">Customer</a>
                                </li>
                                <li>
                                    <a class="button_sidebar" href="user">User System</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Factory Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-industry"></i>Factory</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/factory-warehouse">Warehouse</a>
                                </li>
                                <li>
                                    <a href="/factory-machine">Machine</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Terms Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file-alt"></i>General</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/general-terms">Terms</a>
                                </li>
                                <li>
                                    <a href="/general-department">Department</a>
                                </li>
                                <li>
                                    <a href="/general-currency">Currency</a>
                                </li>
                                <li>
                                    <a href="/general-tax">Tax</a>
                                </li>
                                <li>
                                    <a href="/general-deductor">Deductor</a>
                                </li>
                                <li>
                                    <a href="/general-other-cost">Other Cost</a>
                                </li>
                                <!-- <li>
                                    <a href="/general-exchange-rates">Exchange Rates</a>
                                </li> -->
                            </ul>
                        </li>

                        {{-- <li>
                            <a href="chart.html">
                                <i class="fas fa-file"></i>Echange Rates</a>
                        </li> --}}

                        
                        <li>
                            <a href="#">Transaction</a>
                        </li>
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-tags"></i>SKU</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/sku-pricelist">Pricelist</a>
                                </li>
                                <li>
                                    <a href="/sku-minofstock">Minimum Stock</a>
                                </li>
                                <li>
                                    <a href="/sku-minofqty">Minimum Qty</a>
                                </li>
                                <li>
                                    <a href="/bom">Bill of Material</a>
                                </li>
                            </ul>
                        </li><li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-box"></i>Inventory</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/inventory-receiving">Receiving</a>
                                </li>
                                <li>
                                    <a href="delivery_order.html">Delivery Order</a>
                                </li>
                                <li>
                                    <a href="material_request.html">Material Request</a>
                                </li>
                                <li>
                                    <a href="sales_return.html">Sales Return</a>
                                </li>
                                <li>
                                    <a href="purchase_return.html">Purchase Return</a>
                                </li>
                                <li>
                                    <a href="adjustment.html">Adjustment</a>
                                </li>
                            </ul>
                        </li><li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-industry"></i>Production</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="schedule.html">Schedule</a>
                                </li>
                                <li>
                                    <a href="manage_resources.html">Manage Resources</a>
                                </li>
                                <li>
                                    <a href="working_days.html">Working Days</a>
                                </li>
                                <li>
                                    <a href="cost.html">Cost</a>
                                </li>
                                <li>
                                    <a href="cycle_time.html">Cycle Time</a>
                                </li>
                                <li>
                                    <a href="production_process.html">Production Process</a>
                                </li>
                                <li>
                                    <a href="production_order.html">Production Order</a>
                                </li>
                            </ul>
                        </li>
                        <!-- QC Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-check-circle"></i>QC</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="qc_sales.html">Sales</a>
                                </li>
                                <li>
                                    <a href="qc_purchase.html">Purchase</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Engineering Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-cogs"></i>Engineering</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="titration.html">Titration</a>
                                </li>
                                <li>
                                    <a href="chemical_additional.html">Chemical Additional</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Purchase Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-shopping-bag"></i>Purchase</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="/pr">Purchase Request (PR)</a>
                                </li>
                                <li>
                                    <a href="/po">Purchase Order (PO)</a>
                                </li>
                                <li>
                                    <a href="purchase_invoice.html">Purchase Invoice</a>
                                </li>
                                <li>
                                    <a href="supplier_delivery_schedule.html">Supplier Delivery Schedule (SDS)</a>
                                </li>
                                <li>
                                    <a href="payment.html">Payment</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Sales Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-shopping-cart"></i>Sales</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="forecast.html">Forecast</a>
                                </li>
                                <li>
                                    <a href="order.html">Order</a>
                                </li>
                                <li>
                                    <a href="invoice.html">Invoice</a>
                                </li>
                                <li>
                                    <a href="customer_delivery_schedule.html">Customer Delivery Schedule (CDS)</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Maintenance Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-wrench"></i>Maintenance</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="scheduling.html">Scheduling</a>
                                </li>
                                <li>
                                    <a href="sparepart_request.html">Sparepart Request</a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="chart.html">Report</a>
                        </li>
                        <!-- Inventory Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Inventory</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="stock_view.html">Stock View</a>
                                </li>
                                <li>
                                    <a href="balance_stock.html">Balance Stock</a>
                                </li>
                                <li>
                                    <a href="transaction_history.html">Transaction History</a>
                                </li>
                                <li>
                                    <a href="stock_card.html">Stock Card</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Production Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Production</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="capacity.html">Capacity</a>
                                </li>
                                <li>
                                    <a href="check_list.html">Check List</a>
                                </li>
                                <li>
                                    <a href="summary_production.html">Summary</a>
                                </li>
                                <li>
                                    <a href="analysis_production.html">Analysis</a>
                                </li>
                            </ul>
                        </li>

                        <!-- QC Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>QC</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="summary_qc.html">Summary</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Purchase Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Purchase</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="supplier_delivery_order.html">Supplier Delivery Order (SDO)</a>
                                </li>
                                <li>
                                    <a href="received_goods.html">Received Goods</a>
                                </li>
                                <li>
                                    <a href="analysis_purchase.html">Analysis</a>
                                </li>
                                <li>
                                    <a href="supplier_performance.html">Supplier Performance</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Sales Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Sales</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="sales_report.html">Sales Report</a>
                                </li>
                                <li>
                                    <a href="analysis_sales.html">Analysis</a>
                                </li>
                                <li>
                                    <a href="comparison_sales.html">Comparison</a>
                                </li>
                            </ul>
                        </li>

                        <!-- Cost Menu -->
                        <li class="has-sub">
                            <a class="js-arrow" href="#">
                                <i class="fas fa-file"></i>Cost</a>
                            <ul class="list-unstyled navbar__sub-list js-sub-list">
                                <li>
                                    <a href="operational_resource_consumption.html">Operational Resource Consumption</a>
                                </li>
                                <li>
                                    <a href="manpower.html">Manpower</a>
                                </li>
                                <li>
                                    <a href="gross_profit.html">Gross Profit</a>
                                </li>
                                <li>
                                    <a href="poor_quality.html">Poor Quality</a>
                                </li>
                            </ul>
                        </li>

                         </ul>
                        </li>
                    </ul>
                </nav>
            </div>