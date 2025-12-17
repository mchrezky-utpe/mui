<x-modals.modal id="edit_modal" title="Edit Sku Business Type">
    <form
        id="form_modal"
        autocomplete="off"
        class="form-horizontal"
        method="post"
        action="/sku-business-type/"
    >
        @csrf @method("PUT")
        <div class="form-group">
            <label>Manual ID</label>
            <input
                required
                name="manual_id"
                class="form-control"
                type="text"
                placeholder="SKUT-XXX"
                readonly
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
                name="name"
                class="form-control"
                type="text"
                placeholder="Name"
            />
        </div>
    </form>
</x-modals.modal>
