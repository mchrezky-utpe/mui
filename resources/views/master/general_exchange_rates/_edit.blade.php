<x-modals.modal id="edit_modal" title="Edit General Exchange Rates">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/general-exchange-rates/edit">
    @csrf
    <div class="form-group">
      <label>Date</label>
      <input required name="date" class="form-control" type="date" placeholder="Date">
    </div>
    <div class="form-group">
      <label>Currency</label>
      <select readonly name="gen_currency_id" class="form-control currency_select"></select>
    </div>
    <div class="form-group">
      <label>Value</label>
      <input required name="val_exchangerates" class="form-control" type="text" placeholder="Value">
    </div>
  </form>   
</x-modals.modal>