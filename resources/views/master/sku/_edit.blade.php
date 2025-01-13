<x-modals.modal id="edit_modal" title="Edit Sku">
<form id="form_modal" autocomplete="off" class="form-horizontal" method="post" action="/sku/edit">
    @csrf
    <div class="form-group">
      <label>Manual ID</label>
      <input required name="manual_id" class="form-control" type="text" placeholder="Manual ID">
    </div>
    <div class="form-group">
      <label>Description</label>
      <input type="hidden" name="id" />
      <input required name="description" class="form-control" type="text" placeholder="Description">
    </div>
    <div class="form-group">
      <label>Detail</label>
      <select required name="detail_id" class="form-control">
      <option> === Select Detail === </option>
      @foreach($detail as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Type</label>
      <select required name="type_id" class="form-control">
      <option> === Select Type === </option>
      @foreach($type as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Unit</label>
      <select required name="unit_id" class="form-control">
      <option> === Select Unit === </option>
      @foreach($unit as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Model</label>
      <select required name="model_id" class="form-control">
      <option> === Select Model === </option>
      @foreach($model as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Packaging</label>
      <select required name="packaging_id" class="form-control">
      <option> === Select Packaging === </option>
      @foreach($packaging as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Process</label>
      <select required name="process_id" class="form-control">
      <option> === Select Process === </option>
      @foreach($process as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
    <div class="form-group">
      <label>Business</label>
      <select required name="business_type_id" class="form-control">
      <option value=""> === Select Business === </option>
      @foreach($business as $key => $value) 
        <option value="{{ $value->id }}">{{ $value->prefix }} - {{ $value->description }}</option>
        @endforeach 
      </select >
    </div>
  </form>   
</x-modals.modal>