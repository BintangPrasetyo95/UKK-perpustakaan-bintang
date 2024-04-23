<?php
if (ifset('tambahUlasan')) {
    $id = post('id');
    $text = finn('text');
    $rating = post('rating');

    $cek_spam = Qselect("ulasan", "WHERE disable='0' AND ulasan LIKE '%$text%' ");
    echo 'a';

    if (rows($cek_spam) > 3) {
        swalert("Komentar ini ditandai sebagai spam");
    } else {
        $query = Qinsert("ulasan", "id_user='$myID', id_buku='$id', ulasan='$text', rating='$rating' ");

        if ($query !== false) {
            swalert("Berhasil menambahkan ulasan!");
        } else {
            swalert("Gagal menambahkan ulasan!");
        }
    }
}

if (ifset("editUlasan")) {
    $id = post('id');
    $text = finn('text');
    $rating = post('rating');

    $cek_spam = Qselect("ulasan", "WHERE id_ulasan!='$id' AND disable='0' AND ulasan LIKE '%$text%' ");

    if (rows($cek_spam) > 3) {
        swalert("Komentar ini ditandai sebagai spam");
    } else {
        $query = Qupdate("ulasan", "ulasan='$text', rating='$rating' ", $id);

        if ($query !== false) {
            swalert("Berhasil mengubah ulasan!");
        } else {
            swalert("Gagal mengubah ulasan!");
        }
    }
}

if (ifset("hapusUlasan")) {
    $id = post("id");

    $query = Qdisable("ulasan", $id);
    if ($query !== false) {
        swalert("Berhasil menghapus ulasan!");
    } else {
        swalert("Gagal menghapus ulasan!");
    }
}
