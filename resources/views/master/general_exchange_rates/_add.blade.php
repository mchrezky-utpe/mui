<x-modals.modal id="add_modal" title="Add General Exchange Rates">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/general-exchange-rates">
    @csrf
    <div class="form-group">
      <label>Date</label>
      <input required name="date" class="form-control" type="date" placeholder="Date">
    </div>
    <div class="form-group">
      <label>Currency</label>
      <select required name="gen_currency_id" class="form-control currency_select"></select>
    </div>
    <div class="form-group">
      <label>Value</label>
      <input required name="val_exchangerates" class="form-control" type="text" placeholder="Value">
    </div>
  </form>   
</x-modals.modal>
