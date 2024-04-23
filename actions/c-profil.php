<?php
if (ifset('edit')) {
    $nama_lengkap = finn('nama_lengkap');
    $email = finn('email');
    $username = finn('username');
    $alamat = finn('alamat');

    $cek_user = Qselect("user", "WHERE id_user!='$myID' AND (nama_lengkap='$nama_lengkap' OR email='$email' OR username='$username') AND disable='0' ");
    if (valid($nama_lengkap) || valid($email) || valid($username) || valid($alamat)) {
        swalert("Tolong isi data dengan benar!");
    } elseif (rows($cek_user) > 0) {
        swalert("Akun dengan data yang sama sudah ada!");
    } else {
        $query = Qupdate("user", "nama_lengkap='$nama_lengkap', email='$email', username='$username', alamat='$alamat' ", $myID);

        $refresh = Qselect("user", "WHERE id_user='$myID' ");
        $_SESSION['perpus_bintang'] = fetch($refresh);
        if ($query !== false) {
            swalert("Berhasil mengubah data");
        } else {
            swalert("Gagal mengubah data");
        }
    }
}

if (ifset('password')) {
    $pw = finn('pw');
    $pw_lama = finn('pw_lama');
    $pw_konf = finn('pw_konf');

    if (valid($pw) || valid($pw_lama) || valid($pw_konf)) {
        swalert("Tolong isi data dengan benar!");
    } elseif ($pw != $pw_konf) {
        swalert('Password tidak sama!');
    } else {
        $password_cek = password_verify($pw_lama, myData('password'));

        if ($password_cek === false) {
            swalert("Password lama salah");
        } else {
            $password = password_hash($pw, PASSWORD_DEFAULT);
            $query = Qupdate("user", "password='$password' ", $myID);

            $refresh = Qselect("user", "WHERE id_user='$myID' ");
            $_SESSION['perpus_bintang'] = fetch($refresh);
            if ($query !== false) {
                swalert("Berhasil mengubah password!");
            } else {
                swalert("Gagal mengubah password!");
            }
        }
    }
}
