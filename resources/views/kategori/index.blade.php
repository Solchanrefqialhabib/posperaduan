@extends('layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<div class="mt-4">
  <h2>Manajemen Kategori</h2>
  <div class="d-flex justify-content-between align-items-center mb-2">
    <div></div>
    <button id="addCategoryBtn" class="btn btn-primary">Tambah Kategori</button>
  </div>
  <table id="categoryTable" class="table table-striped">
    <thead>
      <tr>
        <th>No</th>
        <th>Kategori</th>
        <th>Opsi</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($kategori as $index => $kategori)
        <tr>
          <td>{{ $index + 1 }}</td>
          <td>{{ $kategori->nama_kategori }}</td>
          <td>
            <div class=" justify-content-center">
              <button class="btn btn-warning btn-sm edit-category ms-5"  data-id="{{ $kategori->id }}" data-name="{{ $kategori->nama_kategori }}">Edit</button>
              <button class="btn btn-danger btn-sm delete-category ms-5"  data-id="{{ $kategori->id }}">Hapus</button>
            </div>
          </td>
        </tr>
      @endforeach
    </tbody>
  </table>
</div>

<!-- Modal Tambah/Edit Kategori -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="categoryModalLabel">Tambah Kategori</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="categoryForm" method="post" action="">
          @csrf
          <input type="hidden" id="method" name="_method" value="post">
          <div class="mb-3">
            <label for="categoryName" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control" id="categoryName" name="nama_kategori" required>
          </div>
          <div class="mb-3">
            <label for="categoryCode" class="form-label">Kode Kategori</label>
            <input type="text" class="form-control" id="categoryCode" name="kode_kategori" required>
          </div>
          <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function() {
  // Menampilkan modal tambah kategori
  $('#addCategoryBtn').click(function() {
    $('#categoryForm').attr('action', '/kategori');
    $('#method').val('post');
    $('#categoryName').val('');
    $('#categoryCode').val('');
    $('#categoryModalLabel').text('Tambah Kategori');
    $('#categoryModal').modal('show');
  });

  // Menampilkan modal edit kategori
  $('.edit-category').click(function() {
    let id = $(this).data('id');
    let name = $(this).data('name');
    $('#categoryForm').attr('action', `/kategori/${id}`);
    $('#method').val('put');
    $('#categoryName').val(name);
    $('#categoryModalLabel').text('Edit Kategori');
    $('#categoryModal').modal('show');
  });

  // Menghapus kategori
  $('.delete-category').click(function() {
    let id = $(this).data('id');
    if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
      $.ajax({
        url: `/kategori/${id}`,
        type: 'delete',
        data: {
          _token: '{{ csrf_token() }}'
        },
        success: function(result) {
          location.reload();
        }
      });
    }
  });
});
</script>
@endpush
