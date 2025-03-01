<x-modals.modal buttonName="Upload" id="upload_modal" title="Upload PO"  modalClass="custom-modal-dialog-medium">
<form  id="form_upload" autocomplete="off" class="form-horizontal" method="post" action="/po/upload" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label>Manual ID</label>
      <input required type="file" id="fileInput" name="file" accept=".html,.pdf">
      <input type="hidden" id="po_id" name="id" />
    </div>
  </form>   
  <div id="preview"></div>
</x-modals.modal>