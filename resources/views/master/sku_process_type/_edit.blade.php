<x-modals.modal id="edit_modal" title="Edit Sku Process Type">
    <form
        id="form_modal"
        autocomplete="off"
        class="form-horizontal"
        method="post"
        action="/sku-process-type/{:D}"
    >
        @csrf @method("PUT")
        <div class="form-group">
            <label>Code</label>
            <input
                name="manual_id"
                class="form-control"
                type="text"
                placeholder="PTC-XXX"
                readonly
            />
        </div>
        <div class="form-group">
            <label>Category</label>
            <select name="category" class="form-control">
                <option value="">-- SELECT CATEGORY ---</option>
                <option value="IN-HOUSE">IN-HOUSE</option>
                <option value="PURCHASE">PURCHASE</option>
            </select>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input
                required
                name="name"
                class="form-control"
                type="text"
                placeholder="Name"
            />
        </div>
        <div class="form-group">
            <label>Item Type</label>
            <select name="mst_sku_type_id" class="form-control">
                <option value="" selected>-- SELECT ITEM TYPE ---</option>
            </select>
        </div>
    </form>
</x-modals.modal>
