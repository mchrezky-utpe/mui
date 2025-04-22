<x-modals.modal id="add_modal" title="Add Person Employee">
  <form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/person-employee">
      @csrf
      <div class="row">
        <div class="col-md-6">
      <div class="form-group">
        <label>First Name</label>
        <input required name="firstname" class="form-control" type="text" placeholder="First Name">
      </div>
      <div class="form-group">
        <label>Last Name</label>
        <input required name="lastname" class="form-control" type="text" placeholder="Last Name">
      </div>
      <div class="form-group">
        <label for="flag_gender">Gender</label>
        <select required name="flag_gender" class="form-control" id="flag_gender">
          <option value="">Pilih Gender</option>
          <option value="1">Laki-laki</option>
          <option value="2">Perempuan</option>
        </select>
      </div>
      
      </div>
  <div class="col-md-6">
    <div class="form-group">
      <label>Middle Name</label>
      <input required name="middlename" class="form-control" type="text" placeholder="Middle Name">
    </div>
    <div class="form-group">
      <label>FullName</label>
      <input required name="fullname" class="form-control" type="text" placeholder="FullName">
    </div>
  </div>
    </div>
  </form>   
</x-modals.modal>
