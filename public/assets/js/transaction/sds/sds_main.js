import { initParam } from "./sds_param.js";
import { handleTableServerSide } from "./sds_table_server_side.js";
import { handleActionTable } from "./sds_action_table.js";

$(document).ready(function () {
    initParam();
    handleTableServerSide();
    handleActionTable();
});
