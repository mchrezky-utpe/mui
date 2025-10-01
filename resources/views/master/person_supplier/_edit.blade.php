<x-modals.modal id="edit_modal" title="Edit Person Supplier">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/person-supplier/edit">
    @csrf
    <input type="hidden" name="id" />
     
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Supplier Initial</label>
          <input required name="prefix" class="form-control" type="text" placeholder="Initial">
        </div>
          <div class="form-group">
            <label>Supplier Name</label>
            <input required name="description" class="form-control" type="text" placeholder="Supplier Name">
          </div>
          <div class="form-group">
            <label>Address Name</label>
            <input required name="address_01" class="form-control" type="text" placeholder="Address Name">
          </div>
        <div class="form-group">
          <label>Con. Person Name</label>
          <input required name="contact_person_01" class="form-control" type="text" placeholder="Con. Person Name">
        </div>
        <div class="form-group">
          <label>Office Phone</label>
          <input required name="phone_01" class="form-control" type="text" placeholder="Office Phone">
        </div>
        <div class="form-group">
          <label>Con. Person Phone</label>
          <input required name="phone_02" class="form-control" type="text" placeholder="Con. Person Phone">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>WH/Del PIC Name</label>
          <input required name="contact_person_02" class="form-control" type="text" placeholder="WH/Del PIC Name">
        </div>
        <div class="form-group">
          <label>WH/Del PIC Email</label>
          <input required name="email_02" class="form-control" type="text" placeholder="WH/Del PIC Email">
        </div>
        <div class="form-group">
          <label>QC PIC Name</label>
          <input required name="contact_person_03" class="form-control" type="text" placeholder="QC PIC Name">
        </div>
        <div class="form-group">
          <label>QC PIC Email</label>
          <input required name="email_03" class="form-control" type="text" placeholder="QC PIC Email">
        </div>
      </div>
    </div>
  </form>   
</x-modals.modal>