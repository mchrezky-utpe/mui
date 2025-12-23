<x-modals.modal id="add_modal" title="Add Sku Business Type">
    <form
        id="form_modal"
        autocomplete="off"
        class="form-horizontal"
        method="post"
        action="/sku-business-type"
    >
        @csrf
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
</x-modals.modal>
