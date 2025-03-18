import { initParam } from './replacement_param.js';
import { handleTableServerSide } from './replacement_table_server_side.js';
import { handleActionTable } from './replacement_action_table.js';

$(document).ready(function () {
    initParam();
    // handleTableServerSide();
    handleActionTable();
});
