@extends('layouts.app')

@include('produk.create')
@include('produk.edit')
@include('produk.show')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Data Produk</h1>
            <div class="ml-auto">
                <a href="javascript:void(0)" class="btn btn-primary" id="button_tambah_produk"><i class="fa fa-plus"></i>
                    Tambah Produk</a>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="table_id" class="hover" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Kode</th>
                                            <th>Nama</th>
                                            <th>Kategori</th>
                                            <th>HPP</th>
                                            <th>Harga</th>
                                            <th>Stok</th>
                                            <th>Cabang</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Fetch Data -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable();
        });
        $.ajax({
            url: "/produk/get-data",
            type: "GET",
            dataType: 'JSON',
            success: function(response) {
                let counter = 1;
                $('#table_id').DataTable().clear();
                $.each(response.data, function(key, value) {
                    let produk = `
                    <tr class="produk-row" id="index_${value.id}">
                        <td>${counter++}</td>
                        <td><img src="/storage/${value.gambar}" alt="gambar" style="width: 150px"; height:"150px"></td>
                        <td>${value.kode_produk}</td>
                        <td>${value.nama_produk}</td>
                        <td>${value.kategori}</td>
                        <td>${value.stok}</td>
                         <td><span class="badge badge-secondary">RP. ${value.hpp}</span></td>
                        <td><span class="badge badge-secondary">RP. ${value.harga_jual}</span></td>
                        <td>${value.cabang.cabang}</td>
                        <td>
                            <a href="javascript:void(0)" id="button_detail_produk" data-id="${value.id}" class="btn btn-lg btn-success mb-2"><i class="far fa-eye"></i> </a>
                            <a href="javascript:void(0)" id="button_edit_produk" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                            <a href="javascript:void(0)" id="button_hapus_produk" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                        </td>
                    </tr>
                `;
                    $('#table_id').DataTable().row.add($(produk)).draw(false);
                });
            }
        });
    </script>

    <!-- Show Modal Create -->
    <script>
        $('body').on('click', '#button_tambah_produk', function() {
            $('#modal_tambah_produk').modal('show');
            resetAlerts();
        });

        function resetAlerts() {
            $('#alert-gambar').removeClass('d-block').addClass('d-none');
            $('#alert-kode_produk').removeClass('d-block').addClass('d-none');
            $('#alert-nama_produk').removeClass('d-block').addClass('d-none');
            $('#alert-kategori_id').removeClass('d-block').addClass('d-none');
            $('#alert-hpp').removeClass('d-block').addClass('d-none');
            $('#alert-harga_jual').removeClass('d-block').addClass('d-none');
            $('#alert-stok').removeClass('d-block').addClass('d-none');
            $('#alert-cabang_id').removeClass('d-block').addClass('d-none');
        }

        $('#store').click(function(e) {
            e.preventDefault();

            let gambar = $('#gambar')[0].files[0];
            let kode_prouk = $('#kode_produk').val();
            let nama_prouk = $('#nama_produk').val();
            let kategori_id = $('#kategori_id').val();
            let hpp = $('#hpp').val();
            let harga_jual = $('#harga_jual').val();
            let stok = $('#stok').val();
            let cabang_id = $('#cabang_id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('gambar', gambar);
            formData.append('kode_produk', kode_produk);
            formData.append('nama_produk', nama_produk);
            formData.append('kategori_id', kategori_id);
            formData.append('hpp', hpp);
            formData.append('harga_jual', harga_jual);
            formData.append('stok', stok);
            formData.append('cabang_id', cabang_id);
            formData.append('_token', token);

            $.ajax({
                url: '/produk',
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });

                    $.ajax({
                        url: "/produk/get-data",
                        type: "GET",
                        dataType: 'JSON',
                        success: function(response) {
                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let produk = `
                                <tr class="produk-row" id="index_${value.id}">
                                    <td>${counter++}</td>
                                    <td><img src="/storage/${value.gambar}" alt="gambar" style="width: 150px"; height:"150px"></td>
                                    <td>${value.kode_produk}</td>
                                    <td>${value.nama_produk}</td>
                                    <td>${value.kategori}</td>
                                    <td><span class="badge badge-secondary">RP. ${value.hpp}</span></td>
                                    <td><span class="badge badge-secondary">RP. ${value.harga_jual}</span></td>
                                    <td>${value.stok}</td>
                                    <td>${value.cabang.cabang}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_detail_produk" data-id="${value.id}" class="btn btn-lg btn-success mb-2"><i class="far fa-eye"></i> </a>
                                        <a href="javascript:void(0)" id="button_edit_produk" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_produk" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                            `;
                                $('#table_id').DataTable().row.add($(produk)).draw(
                                    false);
                            });

                            $('#gambar').val('');
                            $('#preview').attr('src', '');
                            $('#kode_produk').val('');
                            $('#nama_produk').val('');
                            $('#kategori_id').val('');
                            $('#hpp').val('');
                            $('#harga_jual').val('');
                            $('#stok').val('');
                            $('#cabang_id').val('');

                            $('#modal_tambah_produk').modal('hide');

                            let table = $('#table_id').DataTable();
                            table.draw();
                        }
                    });
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.gambar && error.responseJSON.gambar[
                            0]) {
                        $('#alert-gambar').removeClass('d-none');
                        $('#alert-gambar').addClass('d-block');

                        $('#alert-gambar').html(error.responseJSON.gambar[0]);
                    }

                    if (error.responseJSON && error.responseJSON.nama_produk && error.responseJSON
                        .nama_produk[0]) {
                        $('#alert-nama_produk').removeClass('d-none');
                        $('#alert-nama_produk').addClass('d-block');

                        $('#alert-nama_produk').html(error.responseJSON.nama_produk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.kode_produk && error.responseJSON
                        .kode_produk[0]) {
                        $('#alert-kode_produk').removeClass('d-none');
                        $('#alert-kode_produk').addClass('d-block');

                        $('#alert-kode_produk').html(error.responseJSON.kode_produk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.kategori_id && error.responseJSON
                        .kategori_id[0]) {
                        $('#alert-kategori_id').removeClass('d-none');
                        $('#alert-kategori_id').addClass('d-block');

                        $('#alert-kategori_id').html(error.responseJSON.kategori_id[0]);
                    }

                    if (error.responseJSON && error.responseJSON.hpp && error.responseJSON
                        .hpp[0]) {
                        $('#alert-hpp').removeClass('d-none');
                        $('#alert-hpp').addClass('d-block');

                        $('#alert-hpp').html(error.responseJSON.hpp[0]);
                    }

                    if (error.responseJSON && error.responseJSON.harga_jual && error.responseJSON
                        .harga_jual[0]) {
                        $('#alert-harga_jual').removeClass('d-none');
                        $('#alert-harga_jual').addClass('d-block');

                        $('#alert-harga_jual').html(error.responseJSON.harga_jual[0]);
                    }

                    if (error.responseJSON && error.responseJSON.stok && error.responseJSON
                        .stok[0]) {
                        $('#alert-stok').removeClass('d-none');
                        $('#alert-stok').addClass('d-block');

                        $('#alert-stok').html(error.responseJSON.stok[0]);
                    }

                    if (error.responseJSON && error.responseJSON.cabang_id && error.responseJSON
                        .cabang_id[0]) {
                        $('#alert-cabang_id').removeClass('d-none');
                        $('#alert-cabang_id').addClass('d-block');

                        $('#alert-cabang_id').html(error.responseJSON.cabang_id[0]);
                    }
                }
            })
        });
    </script>

    <!-- Show Modal Detail-->
    <script>
        $('body').on('click', '#button_detail_produk', function() {
            let produk_id = $(this).data('id');

            $.ajax({
                url: `/produk/${produk_id}/`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#produk_id').val(response.data.id);
                    $('#detail_gambar').val(null);
                    $('#detail_kode_produk').val(response.data.kode_produk);
                    $('#detail_nama_produk').val(response.data.nama_produk);
                    $('#detail_kategori_id').val(response.data.kategori_id);
                    $('#detail_hpp').val(response.data.hpp);
                    $('#detail_harga_jual').val(response.data.harga_jual);
                    $('#detail_stok').val(response.data.stok);
                    $('#detail_gambar_preview').attr('src', '/storage/' + response.data.gambar);
                    $('#detail_cabang_id').val(response.data.cabang_id);

                    $('#modal_detail_produk').modal('show');
                }
            });
        });
    </script>

    <!-- Edit/Update Data -->
    <script>
        $('body').on('click', '#button_edit_produk', function() {
            let produk_id = $(this).data('id');

            $.ajax({
                url: `/produk/${produk_id}/edit`,
                type: "GET",
                cache: false,
                success: function(response) {
                    $('#produk_id').val(response.data.id);
                    $('#edit_gambar').val(null);
                    $('#edit_kode_produk').val(response.data.kode_produk);
                    $('#edit_nama_produk').val(response.data.nama_produk);
                    $('#edit_kategori_id').val(response.data.kategori_id);
                    $('#edit_hpp').val(response.data.hpp);
                    $('#edit_harga_jual').val(response.data.harga_jual);
                    $('#edit_stok').val(response.data.stok);
                    $('#edit_gambar_preview').attr('src', '/storage/' + response.data.gambar);
                    $('#edit_cabang_id').val(response.data.cabang_id);

                    $('#modal_edit_produk').modal('show');
                }
            });
        });

        $('#update').click(function(e) {
            e.preventDefault();

            let produk_id = $('#produk_id').val();
            let gambar = $('#edit_gambar')[0].files[0];
            let stok_produk = $('#edit_stok_produk').val();
            let nama_produk = $('#edit_nama_produk').val();
            let kategori_id = $('#edit_kategori_id').val();
            let hpp = $('#edit_hpp').val();
            let harga_jual = $('#edit_harga_jual').val();
            let stok = $('#edit_stok').val();
            let cabang_id = $('#edit_cabang_id').val();
            let token = $("meta[name='csrf-token']").attr("content");

            let formData = new FormData();
            formData.append('gambar', gambar);
            formData.append('kode_produk', kode_produk);
            formData.append('nama_produk', nama_produk);
            formData.append('kategori_id', kategori_id);
            formData.append('hpp', hpp);
            formData.append('harga_jual', harga_jual);
            formData.append('stok', stok);
            formData.append('cabang_id', cabang_id);
            formData.append('_token', token);
            formData.append('_method', 'PUT');

            $.ajax({
                url: `/produk/${produk_id}`,
                type: "POST",
                cache: false,
                data: formData,
                contentType: false,
                processData: false,

                success: function(response) {
                    swal.fire({
                        type: 'success',
                        icon: 'success',
                        title: `${response.message}`,
                        showConfirmButton: true,
                        timer: 3000
                    });

                    $.ajax({
                        url: "/produk/get-data",
                        type: "GET",
                        dataType: 'JSON',
                        success: function(response) {
                            let counter = 1;
                            $('#table_id').DataTable().clear();
                            $.each(response.data, function(key, value) {
                                let produk = `
                                <tr class="produk-row" id="index_${value.id}">
                                    <td>${counter++}</td>
                                    <td><img src="/storage/${value.gambar}" alt="gambar" style="width: 150px"; height:"150px"></td>
                                    <td>${value.kode_produk}</td>
                                    <td>${value.nama_produk}</td>
                                    <td>${value.kategori}</td>
                                     <td><span class="badge badge-secondary">RP. ${value.hpp}</span></td>
                                    <td><span class="badge badge-secondary">RP. ${value.harga_jual}</span></td>
                                    <td>${value.stok}</td>
                                    <td>${value.cabang.cabang}</td>
                                    <td>
                                        <a href="javascript:void(0)" id="button_detail_produk" data-id="${value.id}" class="btn btn-lg btn-success mb-2"><i class="far fa-eye"></i> </a>
                                        <a href="javascript:void(0)" id="button_edit_produk" data-id="${value.id}" class="btn btn-lg btn-warning mb-2"><i class="far fa-edit"></i> </a>
                                        <a href="javascript:void(0)" id="button_hapus_produk" data-id="${value.id}" class="btn btn-lg btn-danger mb-2"><i class="fas fa-trash"></i> </a>
                                    </td>
                                </tr>
                            `;
                                $('#table_id').DataTable().row.add($(produk)).draw(
                                    false);
                                $('#modal_edit_produk').modal('hide');
                            });
                        }
                    });
                },

                error: function(error) {
                    if (error.responseJSON && error.responseJSON.gambar && error.responseJSON.gambar[
                            0]) {
                        $('#alert-gambar').removeClass('d-none');
                        $('#alert-gambar').addClass('d-block');

                        $('#alert-gambar').html(error.responseJSON.gambar[0]);
                    }

                    if (error.responseJSON && error.responseJSON.kode_produk && error.responseJSON
                        .kode_produk[0]) {
                        $('#alert-kode_produk').removeClass('d-none');
                        $('#alert-kode_produk').addClass('d-block');

                        $('#alert-kode_produk').html(error.responseJSON.kode_produk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.nama_produk && error.responseJSON
                        .nama_produk[0]) {
                        $('#alert-nama_produk').removeClass('d-none');
                        $('#alert-nama_produk').addClass('d-block');

                        $('#alert-nama_produk').html(error.responseJSON.nama_produk[0]);
                    }

                    if (error.responseJSON && error.responseJSON.kategori_id && error.responseJSON
                        .kategori_id[0]) {
                        $('#alert-kategori_id').removeClass('d-none');
                        $('#alert-kategori_id').addClass('d-block');

                        $('#alert-kategori_id').html(error.responseJSON.kategori_id[0]);
                    }

                    if (error.responseJSON && error.responseJSON.hpp && error.responseJSON
                        .hpp[0]) {
                        $('#alert-hpp').removeClass('d-none');
                        $('#alert-hpp').addClass('d-block');

                        $('#alert-hpp').html(error.responseJSON.hpp[0]);
                    }

                    if (error.responseJSON && error.responseJSON.harga_jual && error.responseJSON
                        .harga_jual[0]) {
                        $('#alert-harga_jual').removeClass('d-none');
                        $('#alert-harga_jual').addClass('d-block');

                        $('#alert-harga_jual').html(error.responseJSON.harga_jual[0]);
                    }

                    if (error.responseJSON && error.responseJSON.stok && error.responseJSON
                        .stok[0]) {
                        $('#alert-stok').removeClass('d-none');
                        $('#alert-stok').addClass('d-block');

                        $('#alert-stok').html(error.responseJSON.stok[0]);
                    }

                    if (error.responseJSON && error.responseJSON.cabang_id && error.responseJSON
                        .cabang_id[0]) {
                        $('#alert-cabang_id').removeClass('d-none');
                        $('#alert-cabang_id').addClass('d-block');

                        $('#alert-cabang_id').html(error.responseJSON.cabang_id[0]);
                    }
                }
            });
        });
    </script>

    <!-- Delete Data -->
    <script>
        $('body').on('click', '#button_hapus_produk', function() {
            let produk_id = $(this).data('id');
            let token = $("meta[name='csrf-token']").attr("content");

            Swal.fire({
                title: 'Apakah Anda Yakin ?',
                text: "ingin menghapus data ini !",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'TIDAK',
                confirmButtonText: 'YA, HAPUS!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/produk/${produk_id}`,
                        type: "DELETE",
                        cache: false,
                        data: {
                            "_token": token
                        },
                        success: function(response) {
                            Swal.fire({
                                type: 'success',
                                icon: 'success',
                                title: `${response.message}`,
                                showConfirmButton: true,
                                timer: 3000
                            });
                            $(`#index_${produk_id}`).remove();
                        }
                    })
                }
            })
        })
    </script>

    <!-- Preview Image -->
    <script>
        function previewImage() {
            preview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

    <script>
        function previewImageEdit() {
            edit_gambar_preview.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>
@endsection
