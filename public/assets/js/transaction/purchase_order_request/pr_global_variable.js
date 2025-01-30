export let termsMaster = null;
export let departmentMaster = null;
export let supplierMaster = null;
export let currencyMaster = null;
export let otherCostMaster = null;
export let deductionMaster = null;
export let is_using_item = true;
export let skuMaster = null;
export let table_pr = null;

export function setGlobalVariable(key, value) {
    switch (key) {
        case 'termsMaster':
            termsMaster = value;
            break;
        case 'departmentMaster':
            departmentMaster = value;
            break;
        case 'supplierMaster':
            supplierMaster = value;
            break;
        case 'currencyMaster':
            currencyMaster = value;
            break;
        case 'otherCostMaster':
            otherCostMaster = value;
            break;
        case 'deductionMaster':
            deductionMaster = value;
            break;
        case 'is_using_item':
            is_using_item = value;
            break;
        case 'skuMaster':
            skuMaster = value;
            break;
        case 'table_pr':
            table_pr = value;
            break;
        default:
            console.warn(`Global variable '${key}' does not exist.`);
    }
}