<?php
if (ifset('favorit')) {
    $id = post('id');

    $query = Qinsert("koleksi", "id_buku='$id', id_user='$myID' ");
    if ($query === false) {
        swalert("Penambahan data ke koleksi gagal, silahkan coba lagi");
    }
}

if (ifset('unfavorit')) {
    $id_fav = post('id_fav');

    $query = Qdisable('koleksi', $id_fav);
    if ($query === false) {
        swalert("Penarikan data dari koleksi gagal, silahkan coba lagi");
    }
}