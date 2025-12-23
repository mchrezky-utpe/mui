<x-modals.modal id="add_modal" title="Add Sku Process Classification">
    <form
        id="form_modal"
        autocomplete="off"
        class="form-horizontal"
        method="post"
        action="/sku-process-classification"
    >
        @csrf
        <div class="form-group">
            <label>Code</label>
            <input
                name="prefix"
                class="form-control"
                type="text"
                placeholder="PCC-XXX"
                readonly
            />
        </div>

        <div class="form-group">
            <label>Manual ID</label>
            <input
                name="manual_id"
                class="form-control"
                type="text"
                placeholder="Custom ID (optional)"
            />
        </div>

        <div class="form-group">
            <label>Item Type</label>
            <select name="mst_sku_process_type_id" class="form-control">
                <option value="" selected>-- SELECT PROCESS TYPE ---</option>
            </select>
        </div>

        <div class="form-group">
            <label>Name</label>
            <input
                required
                name="description"
                class="form-control"
                type="text"
                placeholder="Name"
            />
        </div>
    </form>
</x-modals.modal>
