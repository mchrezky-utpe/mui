<x-modals.modal id="add_modal" title="Add Customer Delivery Destination">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/customer/<?php echo $customer_id; ?>/delivery">
    @csrf
   <div class="row">
    <div class="col-md-6">
      <div class="form-group">
        <label>Customer Code</label>
        <input readonly class="form-control" type="text" placeholder="CTC-XXX" value="<?php echo $customer_code; ?>">
      </div>
      <div class="form-group">
        <label>Customer Name</label>
        <input readonly name="customer_name" class="form-control" type="text" value="<?php echo $customer_name; ?>">
      </div>
      <div class="form-group">
        <label>DD Code</label>
        <input readonly name="prefix" class="form-control" type="text" placeholder="DD-XXX">
      </div>
      <div class="form-group">
        <label>Destination Code</label>
        <input required name="destination_code" class="form-control" type="text" placeholder="Destination Code">
      </div>
  </div>
    <div class="col-md-6">
      <div class="form-group">
        <label>Destination Name</label>
        <input required name="destination_name" class="form-control" type="text" placeholder="Destination Name">
      </div>
      <div class="form-group">
        <label>Destination Address</label>
        <textarea required name="destination_address" class="form-control" type="text" placeholder="Destination Address">
        </textarea>
      </div>
      <div class="form-group">
        <label>Destination Type</label>
        <select name="flag_destination_type" class="form-control"> 
            <option value="1">DELIVERY</option>
            <option value="2">INVOICE</option>
        </select>
      </div>
  </div>
  </form>   
</div>
</x-modals.modal>
