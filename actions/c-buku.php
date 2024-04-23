<?php
if (ifset('tambah')) {
    $judul = finn('judul');
    $penulis = finn('penulis');
    $penerbit = finn('penerbit');
    $tahun_terbit = post('tahun_terbit');
    $stok = post('stok');

    $kategori = post('kategori');

    $validasi = Qselect("buku", "WHERE judul='$judul' AND disable='0' ");

    if (rows($validasi) > 0) {
        swalert("Buku dengan judul ini sudah ada!");
    } elseif (valid($judul) || valid($penulis) || valid($penerbit) || valid($tahun_terbit)) {
        swalert("Tolong isi data dengan benar!");
    } else {
        $query = Qinsert("buku", "judul='$judul', penulis='$penulis', penerbit='$penerbit', tahun_terbit='$tahun_terbit', stok='$stok' ");

        if ($query !== false) {
            swalert("Tambah data berhasil!");

            if (!empty($kategori)) {
                $cek_buku = Qselect("buku", "WHERE judul='$judul' AND disable='0' ");
                $fetch_buku = fetch($cek_buku);
                $id = $fetch_buku['id_buku'];

                if (rows($cek_buku) != 1) {
                    swalert("Terjadi Kesalahan saat mengkonfigurasi kategori pada buku");
                } else {
                    foreach ($kategori as $key => $value) {
                        $query_kategori = Qinsert("kategori_relasi", "id_buku='$id', id_kategori='$value'");

                        if ($query_kategori === false) {
                            swalert("Terjadi Kesalahan saat mengkonfigurasi kategori pada buku");
                            break;
                        }
                    }
                }
            }
        } else {
            swalert("Tambah data gagal!");
        }
    }
}

if (ifset('edit')) {
    $id = post('id');
    $judul = finn('judul');
    $penulis = finn('penulis');
    $penerbit = finn('penerbit');
    $tahun_terbit = post('tahun_terbit');
    $stok = post('stok');

    $kategori = post('kategori');

    $validasi = Qselect("buku", "WHERE id_buku!='$id' AND judul='$judul' AND disable='0' ");

    if (rows($validasi) > 0) {
        swalert("Buku dengan judul ini sudah ada!");
    } elseif (valid($judul) || valid($penulis) || valid($penerbit) || valid($tahun_terbit)) {
        swalert("Tolong isi data dengan benar!");
    } else {
        $query = Qupdate("buku", "judul='$judul', penulis='$penulis', penerbit='$penerbit', tahun_terbit='$tahun_terbit', stok='$stok' ", $id);

        if ($query !== false) {
            swalert("Edit data berhasil!");

            $refresh_kategori = query("UPDATE kategori_relasi SET disable='1' WHERE id_buku='$id' ");

            if ($refresh_kategori !== false) {
                if (!empty($kategori)) {
                    foreach ($kategori as $value) {
                        $query_kategori = Qinsert("kategori_relasi", "id_buku='$id', id_kategori='$value'");

                        if ($query_kategori === false) {
                            swalert("Terjadi Kesalahan saat mengkonfigurasi kategori pada buku");
                            break;
                        }
                    }
                }
            } else {
                swalert("Terjadi Kesalahan saat mengkonfigurasi kategori pada buku");
            }
        } else {
            swalert("Edit data gagal!");
        }
    }
}

if (ifset('hapus')) {
    $id = post('id');
    $query = Qdisable("buku", $id);

    if ($query !== false) {
        swalert("Hapus data berhasil!");
    } else {
        swalert("Hapus data gagal!");
    }
}
