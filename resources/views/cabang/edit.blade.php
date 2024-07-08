<div class="modal fade" tabindex="-1" role="dialog" id="modal_edit_cabang">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Cabang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
            <div class="modal-body">
                <input type="hidden" name="id" id="cabang_id">
                <div class="form-group">
                    <label>Cabang</label>
                    <input type="text" class="form-control" name="cabang" id="edit_cabang">
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-cabang"></div>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" name="alamat" id="edit_alamat"></textarea>
                    <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-alamat"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="keluar">Keluar</button>
                <button type="button" class="btn btn-primary" id="update">Update</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


