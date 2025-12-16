<x-modals.modal id="edit_modal" title="Edit Sku Process Classification">
    <form
        id="form_modal"
        autocomplete="off"
        class="form-horizontal"
        method="post"
        action="/sku-process-classification/{:D}"
    >
        @csrf @method("PUT")
        <div class="form-group">
            <label>Code</label>
            <input
                name="manual_id"
                class="form-control"
                type="text"
                placeholder="PCC-XXX"
                readonly
            />
        </div>

        <div class="form-group">
            <label>Item Type</label>
            <select name="mst_sku_process_type_id" class="form-control">
                <option value="">-- SELECT PROCESS TYPE ---</option>
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
    </form>
</x-modals.modal>
