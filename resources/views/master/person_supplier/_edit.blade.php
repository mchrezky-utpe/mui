<x-modals.modal id="edit_modal" title="Edit Person Supplier">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/person-supplier/edit">
    @csrf
    <input type="hidden" name="id" />
     
    <div class="form-group">
      <label>Initial</label>
      <input required name="description" class="form-control" type="text" placeholder="Initial">
    </div>
    <div class="form-group">
      <label>Con. Person Name</label>
      <input required name="contact_person_01" class="form-control" type="text" placeholder="Con. Person Name">
    </div>
    <div class="form-group">
      <label>Con. Person Phone</label>
      <input required name="phone_01" class="form-control" type="text" placeholder="Con. Person Phone">
    </div>
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
  </form>   
</x-modals.modal>