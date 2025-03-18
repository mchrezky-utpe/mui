import { initParam } from './supply_param.js';
import { handleTableServerSide } from './supply_table_server_side.js';
import { handleActionTable } from './supply_action_table.js';

$(document).ready(function () {
    initParam();
    // handleTableServerSide();
    handleActionTable();
});
