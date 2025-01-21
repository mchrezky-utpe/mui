<x-modals.modal id="edit_modal" title="Edit Sku Min Of Qty">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-minofqty/edit">
    @csrf
    <input type="hidden" name="id" />
    <div class="form-group">
      <label>Manual ID</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div>
    <div class="form-group">
      <label>SKU</label>
      <select required name="sku_id" class="form-control">
      <option value=""> === Select SKU === </option>
      @foreach($sku as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Qty</label>
      <input required name="qty" class="form-control" type="text" placeholder="qty">
    </div>
  </form>   
</x-modals.modal>
