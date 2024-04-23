<?php
if (ifset('tambah')) {
    $nama_kategori = finn('kategori');

    $validasi = Qselect("kategori", "WHERE nama_kategori='$nama_kategori' AND disable='0' ");

    if (rows($validasi) > 0) {
        swalert("Kategori dengan nama ini sudah ada!");
    } elseif (valid($nama_kategori)) {
        swalert("Tolong isi data dengan benar!");
    } else {
        $query = Qinsert("kategori", "nama_kategori='$nama_kategori' ");

        if ($query !== false) {
            swalert("Tambah data berhasil!");
        } else {
            swalert("Tambah data gagal!");
        }
    }
}

if (ifset('edit')) {
    $id = post('id');
    $nama_kategori = finn('kategori');

    $validasi = Qselect("kategori", "WHERE id_kategori!='$id' AND nama_kategori='$nama_kategori' AND disable='0' ");

    if (rows($validasi) > 0) {
        swalert("Kategori dengan nama ini sudah ada!");
    } elseif (valid($nama_kategori)) {
        swalert("Tolong isi data dengan benar!");
    } else {
        $query = Qupdate("kategori", "nama_kategori='$nama_kategori' ", $id);

        if ($query !== false) {
            swalert("Edit data berhasil!");
        } else {
            swalert("Edit data gagal!");
        }
    }
}

if (ifset('hapus')) {
    $id = post('id');
    $query = Qdisable("kategori", $id);

    if ($query !== false) {
        swalert("Hapus data berhasil!");
    } else {
        swalert("Hapus data gagal!");
    }
}
