import { initParam } from './pr_param.js';
import { handleTableServerSide } from './pr_table_server_side.js';
import { handleActionTable } from './pr_action_table.js';

$(document).ready(function () {
    initParam();
    handleTableServerSide();
    handleActionTable();
});
