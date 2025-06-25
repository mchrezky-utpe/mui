<x-modals.modal id="add_modal" title="Add Person Supplier">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/person-supplier">
    @csrf
    <div class="row">
      <div class="col-md-12">
    {{-- <div class="form-group">
      <label>Manual ID</label>
      <input value="{{ Str::random(10) }}" required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div> --}}
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
</div>
{{-- <div class="col-md-6">
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
</div> --}}
    </div>
  </form>   
</x-modals.modal>
