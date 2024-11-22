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
        $.ajax({ //Digunakan untuk melakukan request ke server. 
                url: '<?= base_url('/pelanggan/tampil'); ?>', // URL yang digunakan adalah base url ini  , yang mengarah pada endpoint produk/tampil di server.
                type: "GET",
                dataType: 'json', //Mengharuskan respons server untuk berupa format JSON.
                success: function(hasil) { 
                    console.log(hasil);//Jika request berhasil, data produk yang diterima akan diproses dan ditampilkan dalam tabel.
                    if (hasil.status === "success") {
                        var pelangganTable = $('#pelangganTabel tbody');
                        pelangganTable.empty();
                        var produk = hasil.produk;
                        var no = 1;

                        produk.forEach(function(item) { //Looping setiap produk untuk menambahkannya ke dalam tabel.
                            var row = `<tr>
                                <td>${no}</td>
                                <td>${item.nama_pelanggan}</td>
                                <td>${item.alamat}</td>
                                <td>${item.no_tlp}</td>
                                <td>
                                    <button class="btn btn-warning btn-edit editPelanggan" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan" data-id="${item.id_pelanggan}"><i class="fa-solid fa-pen-to-square"></i>Edit</button> 
                                    <button class="btn btn-danger btn-hapus hapusPelanggan " data-id="${item.id_pelanggan}"><i class="fa-solid fa-trash-can"></i>Hapus</button>
                                </td>
                            </tr>`;
                            pelangganTable.append(row);
                            no++;
                        });
                    } else {
                        alert('Gagal mengambil data.');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        }


        $(document).ready(function() { // Panggil fungsi saat halaman dimuat
            tampilPelanggan(); //Memanggil fungsi untuk menampilkan daftar produk yang ada di tabel.

            $("#simpanPelanggan").on("click", function() { // Event handler untuk tombol "Simpan" di modal tambah produk. Ketika tombol ini diklik, data yang dimasukkan ke dalam form akan dikirim ke server menggunakan AJAX.
                var formData = { //Mengambil nilai dari input form untuk nama produk, harga, dan stok.
                    nama_pelanggan: $("#namaPelanggan").val(),
                    alamat: $('#alamat').val(),
                    no_tlp: $('#noTelepon').val()
                };

                $.ajax({
                url: '<?= base_url('/pelanggan/simpan'); ?>',
                type: "POST",
                data: formData,
                dataType: 'json',
                success: function(hasil) {
                    if (hasil.status === 'success') {
                        Swal.fire({
                            title: "Good job!",
                            text: "Pelanggan berhasil disimpan!",
                            icon: "success"
                        });
                        $('#modalTambahPelanggan').modal("hide");
                        $('#formTambahPelanggan')[0].reset();  // Reset form setelah simpan
                        tampilPelanggan();  // Update tampilan daftar pelanggan
                    } else {
                        alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                    }
                },
                error: function(xhr, status, error) {
                    alert('Terjadi kesalahan: ' + error);
                }
            });
        });

            $(document).on('click', '.hapusPelanggan', function() { //Event handler ketika tombol hapus diklik. ID produk yang akan dihapus diambil dari atribut data-id.
                var row = $(this).closest('tr');
                document.get
                var id = $(this).data('id');
                if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {//Memunculkan konfirmasi kepada pengguna untuk memastikan apakah mereka yakin ingin menghapus produk.
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                            });
                        }
                        });
                    $.ajax({ //Memunculkan konfirmasi kepada pengguna untuk memastikan apakah mereka yakin ingin menghapus produk.
                        url: '<?= base_url('/pelanggan/hapus/') ?>' + id,
                        type: "DELETE",
                        dataType: 'json',
                        success: function(response) { //Jika berhasil, baris produk akan dihapus dari tabel dan tabel diperbarui.
                            console.log(response);
                            if (response.success) {
                                row.remove();
                                alert("Produk berhasil dihapus.");
                                tampilPelanggan();
                            } else {
                                alert("Gagal menghapus produk.");
                            }
                        },
                        error: function(xhr, status, error) {
                            alert("Terjadi kesalahan saat menghapus: " + error);
                        }
                    });
                }
            });

            $(document).on("click", ".editPelanggan", function(){ //Event handler untuk tombol edit produk. Ketika tombol edit diklik, ID produk diambil dan digunakan untuk mengambil data produk dari server untuk diedit.
                    var id = $(this).data("id"); // Ambil ID dari tombol yang diklik
                    $.ajax({//Request GET ke server untuk mengambil data produk berdasarkan ID yang dikirimkan.
                        url: '<?= base_url('/pelanggan/edit')?>',
                        type: 'GET',
                        data: { id: id }, // Kirim ID ke server
                        dataType: 'json',
                        success: function(hasil) {
                            console.log(hasil);
                            if (hasil) { // Isi input modal dengan data produk
                                $("#editPelangganId").val(hasil.id_pelanggan); // Pastikan ID diisi
                                $("#editNamaPelanggan").val(hasil.nama_pelanggan);
                                $("#editAlamat").val(hasil.alamat);
                                $("#editNoTelepon").val(hasil.no_tlp);
                                $("#modalEditPelanggan").modal("show"); //Menampilkan modal edit produk dengan data yang sudah diisi.
                            } else {
                                alert('Gagal mengambil data untuk diedit.');
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('Terjadi kesalahan: ' + error);
                        }
                        
                    });
                });
        });
        //klik event untuk tombol update produk"
        $("#updatePelanggan").on("click", function(e){
            var form={
                nama_pelanggan: $("#editNamaPelanggan").val(),
                alamat: $("#editAlamat").val(),
                no_tlp: $("#editNoTelepon").val(),
                id_pelanggan:$('#editPelangganId').val()
            }   

            $.ajax({
                url:"<?=base_url("/pelanggan/update")?>",
                data:form,
                dataType:'json',
                type:'POST',
                success:function(hasil){
                    Swal.fire({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success"
                                });
                    $("#modalEditPelanggan").modal("hide");
                    tampilPelanggan()
                },

            })
        });

   
        $(document).on("click", ".hapusProduk", function(){ //Tombol ini diidentifikasi dengan kelas hapusProduk yang ada di dalam baris produk.
            var id = $(this).data("id"); //Mengambil ID produk yang ingin dihapus dari atribut data-id tombol hapus yang diklik.
            if (confirm("apakah anda yakin untuk menghapus data ini?")){ //Menampilkan dialog konfirmasi kepada pengguna untuk memastikan bahwa mereka benar-benar ingin menghapus produk.

            }
        });</script>
    <script src="<?=base_url('asset/bootstrap-5.0.2-dist/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('asset/fontawesome-free-6.6.0-web/js/all.min.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
