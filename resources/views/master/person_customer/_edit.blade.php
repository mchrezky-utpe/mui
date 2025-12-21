<x-modals.modal id="edit_modal" title="Edit Customer">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/customer/edit">
    @csrf
    <input type="hidden" name="id" />
   <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Customer Code</label>
        <input readonly class="form-control" type="text" placeholder="CTC-XXX">
      </div>
      <div class="form-group">
        <label>Customer Name</label>
        <input required name="name" class="form-control" type="text" placeholder="Customer Name">
      </div>
      <div class="form-group">
        <label>Customer Initial</label>
        <input required name="initials" class="form-control" type="text" placeholder="Customer Initials">
      </div>
      <div class="form-group">
        <label>Office Address</label>
        <input required name="office_address" class="form-control" type="text" placeholder="Office Address">
      </div>
      <div class="form-group">
        <label>NPWP</label>
        <input required name="npwp" class="form-control" type="text" placeholder="NPWP">
      </div>
    </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Phone</label>
        <input required name="phone_number" class="form-control" type="email" placeholder="Phone">
      </div>
      <div class="form-group">
        <label>Fax</label>
        <input required name="fax_number" class="form-control" type="email" placeholder="Fax">
      </div>
      <div class="form-group">
        <label>Email</label>
        <input required name="email" class="form-control" type="text" placeholder="Email">
      </div>
      <div class="form-group">
        <label>Contact Person Name</label>
        <input required name="contact_person_name" class="form-control" type="text" placeholder="Contact Person Name">
      </div>
      <div class="form-group">
        <label>Contact Person Phone</label>
        <input required name="contact_person_phone" class="form-control" type="text" placeholder="Contact Person Phone">
      </div>
      <div class="form-group">
        <label>Contact Person Email</label>
        <input required name="contact_person_email" class="form-control" type="text" placeholder="Contact Person Email">
      </div> 
  </div>
  </form>   
</x-modals.modal>