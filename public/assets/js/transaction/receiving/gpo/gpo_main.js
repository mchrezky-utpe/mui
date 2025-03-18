import { initParam } from './gpo_param.js';
import { handleTableServerSide } from './gpo_table_server_side.js';
import { handleActionTable } from './gpo_action_table.js';

$(document).ready(function () {
    initParam();
    // handleTableServerSide();
    handleActionTable();
});
