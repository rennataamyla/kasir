<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir CI4</title>
    <script src="<?=base_url('asset/jquery-3.7.1.min.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('asset/bootstrap-5.0.2-dist/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('asset/fontawesome-free-6.6.0-web/css/all.min.css')?>">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center">Data Pelanggan</h3>
            <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahPelanggan">
                <i class="fa-solid fa-user"></i> Tambah Pelanggan
            </button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">
            <table class="table table-bordered" id="pelangganTabel">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>No Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <!-- Data akan dimasukkan melalui AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Pelanggan -->
<div class="modal fade" id="modalTambahPelanggan" tabindex="-1" aria-labelledby="modalTambahPelangganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalTambahPelangganLabel">Tambah Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formTambahPelanggan">
                    <div class="mb-3">
                        <label for="namaPelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="namaPelanggan" name="namaPelanggan">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat">
                    </div>
                    <div class="mb-3">
                        <label for="noTelepon" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="noTelepon" name="noTelepon">
                    </div>
                    <button type="button" id="simpanPelanggan" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Pelanggan -->
<div class="modal fade" id="modalEditPelanggan" tabindex="-1" aria-labelledby="modalEditPelangganLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalEditPelangganLabel">Edit Pelanggan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditPelanggan">
                    <input type="hidden" id="editPelangganId">
                    <div class="mb-3">
                        <label for="editNamaPelanggan" class="form-label">Nama Pelanggan</label>
                        <input type="text" class="form-control" id="editNamaPelanggan" name="editNamaPelanggan">
                    </div>
                    <div class="mb-3">
                        <label for="editAlamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="editAlamat" name="editAlamat">
                    </div>
                    <div class="mb-3">
                        <label for="editNoTelepon" class="form-label">No Telepon</label>
                        <input type="text" class="form-control" id="editNoTelepon" name="editNoTelepon">
                    </div>
                    <button type="button" id="updatePelanggan" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="<?=base_url('asset/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js')?>"></script>
<script>
    function tampilPelanggan() {
        $.ajax({
            url: '<?= base_url("pelanggan/tampil") ?>',
            type: "GET",
            dataType: "json",
            success: function(response) {
                var pelangganTable = $('#pelangganTabel tbody');
                pelangganTable.empty();
                var no = 1;
                response.pelanggan.forEach(function(item) {
                    pelangganTable.append(`
                        <tr>
                            <td>${no++}</td>
                            <td>${item.nama_pelanggan}</td>
                            <td>${item.alamat}</td>
                            <td>${item.no_tlp}</td>
                            <td>
                                <button class="btn btn-warning btn-edit editPelanggan" data-id="${item.id}">Edit</button>
                                <button class="btn btn-danger btn-hapus" data-id="${item.id}">Hapus</button>
                            </td>
                        </tr>
                    `);
                });
            },
            error: function() {
                alert("Gagal memuat data pelanggan.");
            }
        });
    }

    $(document).ready(function() {
        tampilPelanggan();

        $("#simpanPelanggan").click(function() {
            var data = {
                nama_pelanggan: $("#namaPelanggan").val(),
                alamat: $("#alamat").val(),
                no_tlp: $("#no_tlp").val()
            };

            $.ajax({
                url: '<?= base_url("pelanggan/simpan") ?>',
                type: "POST",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        Swal.fire("Berhasil!", "Data pelanggan berhasil disimpan.", "success");
                        $('#modalTambahPelanggan').modal('hide');
                        tampilPelanggan();
                    } else {
                        Swal.fire("Gagal!", "Data pelanggan gagal disimpan.", "error");
                    }
                },
                error: function() {
                    Swal.fire("Error!", "Terjadi kesalahan server.", "error");
                }
            });
        });

        $(document).on("click", ".editPelanggan", function() {
            var id = $(this).data("id");
            $.ajax({
                url: '<?= base_url("pelanggan/edit") ?>/' + id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $("#editPelangganId").val(data.id);
                    $("#editNamaPelanggan").val(data.nama_pelanggan);
                    $("#editAlamat").val(data.alamat);
                    $("#editNoTelepon").val(data.no_tlp);
                    $("#modalEditPelanggan").modal("show");
                }
            });
        });

        $("#updatePelanggan").click(function() {
            var data = {
                id: $("#editPelangganId").val(),
                nama_pelanggan: $("#editNamaPelanggan").val(),
                alamat: $("#editAlamat").val(),
                no_tlp: $("#editno_tlp").val()
            };

            $.ajax({
                url: '<?= base_url("pelanggan/update") ?>',
                type: "POST",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        Swal.fire("Berhasil!", "Data pelanggan berhasil diperbarui.", "success");
                        $('#modalEditPelanggan').modal('hide');
                        tampilPelanggan();
                    } else {
                        Swal.fire("Gagal!", "Data pelanggan gagal diperbarui.", "error");
                    }
                }
            });
        });

        $(document).on("click", ".btn-hapus", function() {
            var id = $(this).data("id");
            Swal.fire({
                title: "Yakin?",
                text: "Data pelanggan akan dihapus!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url("pelanggan/hapus") ?>/' + id,
                        type: "POST",
                        success: function(response) {
                            Swal.fire("Berhasil!", "Data pelanggan berhasil dihapus.", "success");
                            tampilPelanggan();
                        }
                    });
                }
            });
        });
    });
</script>
    <script src="<?=base_url('asset/bootstrap-5.0.2-dist/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('asset/fontawesome-free-6.6.0-web/js/all.min.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
