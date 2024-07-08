<div class="modal fade" tabindex="-1" role="dialog" id="modal_detail_makanan">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Detail Makanan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form enctype="multipart/form-data">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">     
                        <input type="hidden" id="makanan_id">
                        <div class="form-group">
                            <label>Gambar</label><br>
                            <img src="" class="img-preview img-fluid mb-3 mt-2" id="detail_gambar_preview" style="max-height: 200px; overflow:hidden; border: 1px solid black;">
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-gambar"></div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Makanan</label>
                            <input type="text" class="form-control" name="nama_makanan" id="detail_nama_makanan" disabled readonly>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-nama_makanan"></div>
                        </div>
        
                        <div class="form-group">
                            <label>Deskripsi</label>
                            <textarea class="form-control" name="deskripsi" id="detail_deskripsi" disabled readonly></textarea>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-deskripsi"></div>
                        </div>
        
                        <div class="form-group">
                          <label>Harga</label>
                          <div class="input-group">
                            <span class="input-group-text" id="addon-wrapping">Rp</span>
                            <input type="number" class="form-control" aria-label="Username" aria-describedby="addon-wrapping" name="harga" id="detail_harga" disabled readonly>
                          </div>
                          <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-harga"></div>
                        </div>

                        <div class="form-group">
                          <label>Cabang</label>
                            <select class="form-control" name="cabang" id="detail_cabang_id" style="width: 100%" disabled>
                              @foreach ($cabangs as $cabang)
                                  @if (old('cabang_id', $cabang->cabang) == $cabang->id)
                                    <option value="{{ $cabang->id }}" selected>{{ $cabang->cabang }}</option>
                                  @else
                                    <option value="{{ $cabang->id }}">{{ $cabang->cabang }}</option>
                                  @endif
                              @endforeach
                            </select>
                            <div class="alert alert-danger mt-2 d-none" role="alert" id="alert-cabang"></div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="keluar">Keluar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>


