<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>kasirci4</title>
    <script src="<?=base_url('asset\jquery-3.7.1.min.js')?>"></script>
    <link rel="stylesheet" href="<?=base_url('asset/bootstrap-5.0.2-dist/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('asset/fontawesome-free-6.6.0-web/css/all.min.css')?>">
</head>
<body>
<div class="container mt-5"> 
    <div class="row mt-3">
     <div class="col-12">
        <h3 class="text-center"> Donat Enak </h3>
         <button type="button" class="btn btn-success float-end" data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
            <i class="fa-solid fa-cart-plus">
            </i> Tambah Data </button>
    </div>
</div> 
<div class="row">
    <div class="col-12">
        <div class="container mt-5">
            <table class="table table-bordered" id="produkTabel">
                <thead> 
                 <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                <!-- data akan dimasukkan melalui ajax-->
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal tambah produk-->
<div class="modal fade" id="modalTambahProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modelTambahProduk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"> 
                <h1 class="modal-title fs-5" id="modalTambahProdukLabel"> Tambah Produk </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProduk">
                    <div class="row mb-3">
                        <label for="namaProduk" class="col-sm-4 col-from-tabel"> Nama Produk </label>
                        <div class="col-sm-8"> 
                            <input type="text" class="from-control" id="namaProduk" name="namaProduk">
                        </div>
                    </div>
                    <div class="row nb-3"> 
                        <label form="hargaProduk" class="col-sm-4 col-form-label">Harga</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" class="from-control" id="hargaProduk">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="stokProduk" class="col-sm-4 col-from-label">Stok</label>
                        <div class="col-sm-8">
                            <input type="number" class="from-control" id="stokProduk">
                        </div>
                    </div>
                    <button type="button" id="simpanProduk" class="btn btn-primary float-end">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProduk" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modelEditProduk" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white"> 
                <h1 class="modal-title fs-5" id="modalEditProdukLabel"> Edit Produk </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formProduk">
                    <input type="hidden" id="editProdukId">
                    <div class="row mb-3">
                        <label for="editnamaProduk" class="col-sm-4 col-from-tabel"> Nama Produk </label>
                        <div class="col-sm-8"> 
                            <input type="text" class="from-control" id="editnamaProduk" name="editnamaProduk">
                        </div>
                    </div>
                    <div class="row nb-3"> 
                        <label form="edithargaProduk" class="col-sm-4 col-form-label">Harga</label>
                        <div class="col-sm-8">
                            <input type="number" step="0.01" class="from-control" id="edithargaProduk" name="edithargaProduk">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="editstokProduk" class="col-sm-4 col-from-label">Stok</label>
                        <div class="col-sm-8">
                            <input type="number" class="from-control" id="editstokProduk" name="editstokProduk">
                        </div>
                    </div>
                    <button type="button" id="updateProduk" class="btn btn-primary float-end">edit</button>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
        function tampilProduk() { //Fungsi ini digunakan untuk menampilkan daftar produk ke dalam tabel. Fungsi ini memanggil server untuk mengambil data produk menggunakan AJAX.
            $.ajax({ //Digunakan untuk melakukan request ke server. 
                url: '<?= base_url('produk/tampil'); ?>', // URL yang digunakan adalah base url ini  , yang mengarah pada endpoint produk/tampil di server.
                type: "GET",
                dataType: 'json', //Mengharuskan respons server untuk berupa format JSON.
                success: function(hasil) { //Jika request berhasil, data produk yang diterima akan diproses dan ditampilkan dalam tabel.
                    if (hasil.status === "success") {
                        var produkTable = $('#produkTabel tbody');
                        produkTable.empty();
                        var produk = hasil.produk;
                        var no = 1;

                        produk.forEach(function(item) { //Looping setiap produk untuk menambahkannya ke dalam tabel.
                            var row = `<tr>
                                <td>${no}</td>
                                <td>${item.nama_produk}</td>
                                <td>${item.harga}</td>
                                <td>${item.stok}</td>
                                <td>
                                    <button class="btn btn-warning btn-edit editProduk" data-bs-toggle="modal" data-bs-target="#modalEditProduk" data-id="${item.produk_id}"><i class="fa-solid fa-pen-to-square"></i>Edit</button> 
                                    <button class="btn btn-danger btn-hapus" data-id="${item.produk_id}"><i class="fa-solid fa-trash-can"></i>Hapus</button>
                                </td>
                            </tr>`;
                            produkTable.append(row);
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
            tampilProduk(); //Memanggil fungsi untuk menampilkan daftar produk yang ada di tabel.

            $("#simpanProduk").on("click", function() { // Event handler untuk tombol "Simpan" di modal tambah produk. Ketika tombol ini diklik, data yang dimasukkan ke dalam form akan dikirim ke server menggunakan AJAX.
                var formData = { //Mengambil nilai dari input form untuk nama produk, harga, dan stok.
                    nama_produk: $("#namaProduk").val(),
                    harga: $('#hargaProduk').val(),
                    stok: $('#stokProduk').val()
                };

                $.ajax({ //Mengirimkan data ke server dengan method POST ke URL
                    url: '<?= base_url('produk/simpan'); ?>',
                    type: "POST",
                    data: formData,
                    dataType: 'json',
                    success: function(hasil) { //Jika berhasil, modal ditutup dan data produk di-refresh (tabel diperbarui).
                        if (hasil.status === 'success') {
                            Swal.fire({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success"
                                });
                            $('#modalTambahProduk').modal("hide");
                            $('#formProduk')[0].reset();
                            tampilProduk();
                        } else {
                            alert('Gagal menyimpan data: ' + JSON.stringify(hasil.errors));
                        }
                    },
                    error: function(xhr, status, error) { //Menangani error jika terjadi masalah saat mengirim data.
                        alert('Terjadi kesalahan: ' + error);
                    }
                });
            });

            $(document).on('click', '.btn-hapus', function() { //Event handler ketika tombol hapus diklik. ID produk yang akan dihapus diambil dari atribut data-id.
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
                        url: '<?= base_url('produk/hapus/') ?>' + id,
                        type: "DELETE",
                        dataType: 'json',
                        success: function(response) { //Jika berhasil, baris produk akan dihapus dari tabel dan tabel diperbarui.
                            console.log(response);
                            if (response.success) {
                                row.remove();
                                alert("Produk berhasil dihapus.");
                                tampilProduk();
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

            $(document).on("click", ".editProduk", function(){ //Event handler untuk tombol edit produk. Ketika tombol edit diklik, ID produk diambil dan digunakan untuk mengambil data produk dari server untuk diedit.
                    var id = $(this).data("id"); // Ambil ID dari tombol yang diklik
                    $.ajax({//Request GET ke server untuk mengambil data produk berdasarkan ID yang dikirimkan.
                        url: '<?= base_url('produk/edit')?>',
                        type: 'GET',
                        data: { id: id }, // Kirim ID ke server
                        dataType: 'json',
                        success: function(hasil) {
                            if (hasil) { // Isi input modal dengan data produk
                                $("#editProdukId").val(hasil.produk_id); // Pastikan ID diisi
                                $("#editnamaProduk").val(hasil.nama_produk);
                                $("#edithargaProduk").val(hasil.harga);
                                $("#editstokProduk").val(hasil.stok);
                                $("#modalEditProduk").modal("show"); //Menampilkan modal edit produk dengan data yang sudah diisi.
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
        $("#updateProduk").on("click", function(e){
            var form={
                nama_produk: $("#editnamaProduk").val(),
                harga: $("#edithargaProduk").val(),
                stok: $("#editstokProduk").val(),
                produk_id:$('#editProdukId').val()
            }   

            $.ajax({
                url:"<?=base_url("produk/update")?>",
                data:form,
                dataType:'json',
                type:'POST',
                success:function(hasil){
                    Swal.fire({
                                title: "Good job!",
                                text: "You clicked the button!",
                                icon: "success"
                                });
                    $("#modalEditProduk").modal("hide");
                    tampilProduk()
                },

            })
        });

   
        $(document).on("click", ".hapusProduk", function(){ //Tombol ini diidentifikasi dengan kelas hapusProduk yang ada di dalam baris produk.
            var id = $(this).data("id"); //Mengambil ID produk yang ingin dihapus dari atribut data-id tombol hapus yang diklik.
            if (confirm("apakah anda yakin untuk menghapus data ini?")){ //Menampilkan dialog konfirmasi kepada pengguna untuk memastikan bahwa mereka benar-benar ingin menghapus produk.

            }
        });
    </script>
    <script src="<?=base_url('asset/bootstrap-5.0.2-dist/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('asset/fontawesome-free-6.6.0-web/js/all.min.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
</html>
