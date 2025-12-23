<!-- <x-modals.modal id="edit_modal" title="Edit Sku Business Type">
    <form
        id="form_modal"
        autocomplete="off"
        class="form-horizontal"
        method="post"
        action="/sku-process-classification/edit"
    >
        @csrf
        <input type="hidden" name="id" />
        <div class="form-group">
            <label>Code</label>
            <input
                name="prefix"
                class="form-control"
                type="text"
                placeholder="SKUT-XXX"
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
            <label>Categori</label>
            <select name="category" class="form-control" required>
                <option value="">-- SELECT Category ---</option>
                <option value="AUTOMOTIVE">AUTOMOTIVE</option>
                <option value="NON-AUTOMOTIVE">NON-AUTOMOTIVE</option>
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
</x-modals.modal> -->

<x-modals.modal id="edit_modal" title="Edit Sku Process Classification">
    <form
        id="form_modal"
        autocomplete="off"
        class="form-horizontal"
        method="post"
        action="/sku-process-classification/edit"
    >
        @csrf

        <input type="hiddem" name="id" />
        <div class="form-group">
            <label>Code</label>
            <input
                name="prefix    "
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
                <option value="">-- SELECT PROCESS TYPE ---</option>
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
