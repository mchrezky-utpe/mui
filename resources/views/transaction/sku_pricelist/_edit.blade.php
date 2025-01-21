<x-modals.modal id="edit_modal" title="Edit Sku Pricelist">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku-pricelis/edit">
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
      <label>Currency</label>
      <select required name="gen_currency_id" class="form-control">
      <option value=""> === Select Currency === </option>
      @foreach($currency as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Price</label>
      <input required name="price" class="form-control" type="text" placeholder="price">
    </div>
    <div class="form-group">
      <label>Supplier</label>
      <select required name="prs_supplier_id" class="form-control">
      <option value=""> === Select Supplier === </option>
      @foreach($supplier as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
  </form>   
</x-modals.modal>