import { initParam } from './po_param.js';
import { handleTableServerSide } from './po_table_server_side.js';
import { handleActionTable } from './po_action_table.js';

$(document).ready(function () {
    initParam();
    handleTableServerSide();
    handleActionTable();
});
