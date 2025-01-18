<x-modals.modal id="add_modal" title="Add Person Supplier">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/person-supplier">
    @csrf
    <div class="form-group">
      <label>Manual ID</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
    <div class="form-group">
      <label>Address</label>
      <input required name="address" class="form-control" type="text" placeholder="Address">
    </div>
    <div class="form-group">
      <label>Phone</label>
      <input required name="phone" class="form-control" type="text" placeholder="Phone">
    </div>
    <div class="form-group">
      <label>Fax</label>
      <input required name="fax" class="form-control" type="text" placeholder="Fax">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input required name="email" class="form-control" type="email" placeholder="Email@mail.com">
    </div>
    <div class="form-group">
      <label>Contact Person</label>
      <input required name="contact_person" class="form-control" type="text" placeholder="Contact Person">
    </div>
  </form>   
</x-modals.modal>
