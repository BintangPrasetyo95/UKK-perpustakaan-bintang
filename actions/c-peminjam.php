<?php
if (ifset('tambah')) {
    $nama_lengkap = finn('nama_lengkap');
    $email = finn('email');
    $username = finn('username');
    $alamat = finn('alamat');

    $pw = finn('pw');
    $pw_konf = finn('pw_konf');

    if ($pw != $pw_konf) {
        swalert("Password tidak sama!");
    } else {
        $password = password_hash($pw, PASSWORD_DEFAULT);

        $validasi = Qselect("user", "WHERE (nama_lengkap='$nama_lengkap' OR username='$username' OR email='$email') AND disable='0' ");

        if (rows($validasi) > 0) {
            swalert("Akun dengan data yang sama sudah ada!");
        } elseif (valid($nama_lengkap) || valid($email) || valid($username) || valid($alamat)) {
            swalert("Tolong isi data dengan benar!");
        } else {
            $query = Qinsert("user", "nama_lengkap='$nama_lengkap', username='$username', email='$email', alamat='$alamat', password='$password', role='peminjam' ");

            if ($query !== false) {
                swalert("Tambah data berhasil!");
            } else {
                swalert("Tambah data gagal!");
            }
        }
    }
}

if (ifset('edit')) {
    $id = post('id');
    $nama_lengkap = finn('nama_lengkap');
    $email = finn('email');
    $username = finn('username');
    $alamat = finn('alamat');

    $pw = finn('pw');
    $pw_konf = finn('pw_konf');

    if ($pw != $pw_konf) {
        swalert("Password tidak sama!");
    } else {
        if (!empty($pw)) {
            $password = password_hash($pw, PASSWORD_DEFAULT);
        }

        $validasi = Qselect("user", "WHERE id_user!='$id' AND (nama_lengkap='$nama_lengkap' OR username='$username' OR email='$email') AND disable='0' ");

        if (rows($validasi) > 0) {
            swalert("Akun dengan data yang sama sudah ada!");
        } elseif (valid($nama_lengkap) || valid($email) || valid($username) || valid($alamat)) {
            swalert("Tolong isi data dengan benar!");
        } else {
            if (valid($pw)) {
                $query = Qupdate("user", "nama_lengkap='$nama_lengkap', username='$username', email='$email', alamat='$alamat', role='peminjam' ", $id);
            } else {
                $query = Qupdate("user", "nama_lengkap='$nama_lengkap', username='$username', email='$email', alamat='$alamat', password='$password', role='peminjam' ", $id);
            }

            if ($query !== false) {
                swalert("Edit data berhasil!");
            } else {
                swalert("Edit data gagal!");
            }
        }
    }
}

if (ifset('hapus')) {
    $id = post('id');
    $query = Qdisable("user", $id);

    if ($query !== false) {
        swalert("Hapus data berhasil!");
    } else {
        swalert("Hapus data gagal!");
    }
}
