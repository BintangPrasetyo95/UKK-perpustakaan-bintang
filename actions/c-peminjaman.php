<?php
if (ifset('tambah')) {
    $user = post('user');
    $buku = post('buku');
    $date = post('date');

    $validasi = Qselect("peminjaman", "WHERE id_user='$user' AND id_buku='$buku' AND disable='0' ");

    if (rows($validasi) > 0) {
        swalert("Data ini sudah ada!");
    } elseif (valid($user) || valid($buku) || valid($date)) {
        swalert("Tolong isi data dengan benar!");
    } else {
        $query = Qinsert("peminjaman", "id_user='$user', id_buku='$buku', tanggal_pinjam='$date' ");

        if ($query !== false) {
            $kembalikan_buku = Qupdate("buku", "stok=stok-1", $buku);

            if ($kembalikan_buku !== false) {
                swalert("Tambah data berhasil!");
            } else {
                swalert("Terjadi kesalahan saat mengurangi stok buku");
            }
        } else {
            swalert("Tambah data gagal!");
        }
    }
}

if (ifset('edit')) {
    $id = post('id');
    $user = post('user');
    $buku = post('buku');
    $buku_old = post('buku_old');
    $date = post('date');

    $validasi = Qselect("peminjaman", "WHERE id_pinjam!='$id' AND id_user='$user' AND id_buku='$buku' AND disable='0' ");

    if (rows($validasi) > 0) {
        swalert("Data ini sudah ada!");
    } elseif (valid($user) || valid($buku) || valid($date)) {
        swalert("Tolong isi data dengan benar!");
    } else {
        $query = query("UPDATE peminjaman SET id_user='$user', id_buku='$buku', tanggal_pinjam='$date' WHERE id_pinjam='$id' ");

        if ($query !== false) {
            if ($buku != $buku_old) {
                $pinjam_buku = Qupdate("buku", "stok=stok-1", $buku);
                if ($pinjam_buku !== false) {
                    $kembalikan_buku = Qupdate("buku", "stok=stok+1", $buku_old);
                } else {
                    swalert("Terjadi kesalahan saat mengurangi stok buku");
                }
            } else {
                $kembalikan_buku = true;
            }

            if ($kembalikan_buku !== false) {
                swalert("Edit data berhasil!");
            } else {
                swalert("Terjadi kesalahan saat mengurangi stok buku");
            }
        } else {
            swalert("Edit data gagal!");
        }
    }
}

if (ifset('hapus')) {
    $id = post('id');
    $buku = post('buku');
    $query = query("UPDATE peminjaman SET disable='1' WHERE id_pinjam='$id' ");

    if ($query !== false) {
        $kembalikan_buku = Qupdate("buku", "stok=stok+1", $buku);

        if ($kembalikan_buku !== false) {
            swalert("Hapus data berhasil!");
        }
    } else {
        swalert("Hapus data gagal!");
    }
}

if (ifset('kembali')) {
    $id = post('id');
    $buku = post('buku');
    $query = query("UPDATE peminjaman SET status='terkembalikan', tanggal_kembali='$today' WHERE id_pinjam='$id' ");

    if ($query !== false) {
        $kembalikan_buku = Qupdate("buku", "stok=stok+1", $buku);

        if ($kembalikan_buku !== false) {
            swalert("Pengembalian buku berhasil!");
        }
    } else {
        swalert("Pengembalian buku gagal!");
    }
}
