import { initParam } from './sdo_param.js';
import { handleTableServerSide } from './sdo_table_server_side.js';
import { handleActionTable } from './sdo_action_table.js';

$(document).ready(function () {
    initParam();
    handleTableServerSide();
    handleActionTable();
});
