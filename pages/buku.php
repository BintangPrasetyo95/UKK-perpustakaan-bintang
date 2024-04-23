<?php
$query = Qselect("buku", "WHERE disable='0' ORDER BY judul ");

if (ifset('pinjam')) {
    $user = $myID;
    $buku = post('id');
    $date = $today;

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
                swalert("Peminjaman buku berhasil!");
            } else {
                swalert("Terjadi kesalahan saat mengurangi stok buku");
            }
        } else {
            swalert("Peminjaman buku gagal!");
        }
    }
}
?>

<div class="card mb-4">
    <div class="card-header"><strong>Table Buku</strong>
        <?php
        if (myData("role") != "peminjam") {
        ?>
            <span class="ms-2 btn btn-success btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#tambah">+ Tambah</span>
            <a class="ms-2 btn btn-primary btn-sm text-white" target="_blank" href="print.php?page=<?= $page ?>"><i class="icon cil-print"></i> Print</a>
        <?php
        }
        ?>
    </div>
    <div class="card-body">
        <div class="example">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Judul</th>
                        <th scope="col">Penulis</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Penerbit</th>
                        <th scope="col">Tahun Terbit</th>
                        <th scope="col">Ulasan</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Koleksi</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = fetch($query)) {
                        $id = $data['id_buku'];
                    ?>
                        <tr>
                            <th scope="row"><?= $no++; ?></th>
                            <td><?= $data['judul'] ?></td>
                            <td><?= $data['penulis'] ?></td>
                            <td>
                                <?php
                                $query_kategori = Qselect("kategori_relasi", "LEFT JOIN kategori ON kategori_relasi.id_kategori=kategori.id_kategori WHERE id_buku='$id' AND kategori_relasi.disable='0' AND kategori.disable='0' ");

                                if (rows($query_kategori) > 0) {
                                    while ($kategori = fetch($query_kategori)) {
                                ?>
                                        <span class="btn btn-primary btn-sm"><?= $kategori['nama_kategori'] ?></span>
                                <?php
                                    }
                                }
                                ?>
                            </td>
                            <td><?= $data['penerbit'] ?></td>
                            <td><?= $data['tahun_terbit'] ?></td>
                            <?php
                            $query_ulasan = Qselect('ulasan', "LEFT JOIN user ON ulasan.id_user=user.id_user WHERE id_buku='$id' AND user.disable='0' AND ulasan.disable='0' ");
                            ?>
                            <td><span class="btn btn-primary btn-sm" data-coreui-toggle="modal" data-coreui-target="#ulasan<?= $id ?>"><?= rows($query_ulasan) ?> Ulasan...</span></td>
                            <td><?= $data['stok'] ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <div class="favorit">
                                        <?php
                                        $query_favorit = Qselect("koleksi", "WHERE id_buku='$id' AND id_user='$myID' AND disable='0' ");
                                        if (rows($query_favorit) == 0) {
                                        ?>
                                            <button class="favoritIdle" name="favorit">
                                                <i class="icon cil-star"></i>
                                            </button>
                                        <?php
                                        } else {
                                            $fetch_favorit = fetch($query_favorit);
                                        ?>
                                            <input type="hidden" name="id_fav" value="<?= $fetch_favorit['id_koleksi'] ?>">
                                            <button class="favoritActive" name="unfavorit">
                                                <i class="icon cil-check"></i>
                                            </button>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </form>
                            </td>
                            <?php
                            if (myData("role") != "peminjam") {
                            ?>
                                <td class="text-center">
                                    <span class="btn btn-info btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#edit<?= $id ?>">Edit</span>
                                    <span class="btn btn-danger btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#hapus<?= $id ?>">Hapus</span>
                                </td>
                            <?php
                            } elseif ($data['stok'] == '0') {
                            ?>
                                <td>
                                    <span class="text-muted">Stok Habis</span>
                                </td>
                                <?php
                            } else {
                                $query_pinjam = Qselect("peminjaman", "WHERE id_user='$myID' AND id_buku='$id' AND status='terpinjam' AND disable='0' ");
                                if (rows($query_pinjam) > 0) {
                                ?>
                                    <td>
                                        <span class="text-muted">Terpinjam</span>
                                    </td>
                                <?php
                                } else {
                                ?>
                                    <td>
                                        <span class="btn btn-primary btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#pinjam<?= $id ?>">Pinjam</span>
                                    </td>
                            <?php
                                }
                            }
                            ?>
                        </tr>

                        <!-- Modal Pinjam -->
                        <div class="modal fade" id="pinjam<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Pinjam Buku</h1>
                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            Apakah anda yakin ingin meminjam buku ini? <br>
                                            <span class="fw-bolder text-danger"><?= $data['judul'] ?></span>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="pinjam">Pinjam</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Ulasan -->
                        <div class="modal fade" id="ulasan<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Ulasan Buku</h1>
                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <?php
                                            $total_rating_query = query("SELECT SUM(rating) as ratings FROM ulasan WHERE id_buku='$id' AND disable='0'");
                                            $total_rating_fetch = fetch($total_rating_query);
                                            $total_rating = intval($total_rating_fetch['ratings']) / intval(rows($query_ulasan));
                                            ?>
                                            Total rating : <?= ceil($total_rating) ?>/10
                                            <hr>
                                            <?php
                                            $in = 1;
                                            while ($ulasan = fetch($query_ulasan)) {
                                            ?>
                                                <?= $ulasan['rating'] ?>/10 <span class="text-info"><?= $ulasan['nama_lengkap'] ?></span> berkomentar : <br>
                                                <span class="fw-bolder"><?= $ulasan['ulasan'] ?></span> <br>
                                                <?php
                                                if (myData("role") != "peminjam" || $ulasan['id_user'] == $myID) {
                                                ?>
                                                    <button type="button" class="btn btn-info text-white" data-coreui-toggle="modal" data-coreui-target="#editUlasan<?= $ulasan['id_ulasan'] ?>">Edit</button>
                                                    <button type="button" class="btn btn-danger text-white" data-coreui-toggle="modal" data-coreui-target="#hapusUlasan<?= $ulasan['id_ulasan'] ?>">Hapus</button>
                                                <?php
                                                }
                                                ?>
                                            <?php
                                                if ($in++ != rows($query_ulasan)) {
                                                    echo '<hr>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                        <button type="button" class="btn btn-success text-white" data-coreui-toggle="modal" data-coreui-target="#tambahUlasan<?= $id ?>">+ Tambah Ulasan</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        $query_ulasan2 = Qselect('ulasan', "LEFT JOIN user ON ulasan.id_user=user.id_user WHERE id_buku='$id' AND user.disable='0' AND ulasan.disable='0' ");
                        while ($ulasan2 = fetch($query_ulasan2)) {
                            if (myData("role") != "peminjam" || $ulasan2['id_user'] == $myID) {
                        ?>
                                <!-- Modal Hapus Ulasan -->
                                <div class="modal fade" id="hapusUlasan<?= $ulasan2['id_ulasan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Ulasan</h1>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post">
                                                <div class="modal-body">
                                                    Apakah anda yakin ingin <span class="text-danger">menghapus</span> data ini? <br>
                                                    <span class="fw-bolder"><?= $ulasan2['rating'] ?>/10 <br><?= $ulasan2['ulasan'] ?></span>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="id" value="<?= $ulasan2['id_ulasan'] ?>">
                                                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="hapusUlasan">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Edit Ulasan -->
                                <div class="modal fade" id="editUlasan<?= $ulasan2['id_ulasan'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Ulasan</h1>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form method="post">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label" for="formGroupExampleInput2">Text Ulasan</label>
                                                        <input class="form-control" name="text" type="text" placeholder="Masukkan Input" value="<?= $ulasan2['ulasan'] ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label" for="formGroupExampleInput2">Rating (#/10)</label>
                                                        <input class="form-range" id="customRange3" type="range" name="rating" min="0" max="10" value="<?= $ulasan2['rating'] ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" name="id" value="<?= $ulasan2['id_ulasan'] ?>">
                                                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="editUlasan">Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                        <?php
                            }
                        }
                        ?>

                        <!-- Modal Tambah Ulasan -->
                        <div class="modal fade" id="tambahUlasan<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Ulasan</h1>
                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput2">Text Ulasan</label>
                                                <input class="form-control" name="text" type="text" placeholder="Masukkan Input">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput2">Rating (#/10)</label>
                                                <input class="form-range" id="customRange3" name="rating" type="range" min="0" max="10" value="5">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="tambahUlasan">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                        <?php
                        if (myData("role") != "peminjam") {
                        ?>
                            <!-- Modal Hapus -->
                            <div class="modal fade" id="hapus<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Buku</h1>
                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                                Apakah anda yakin ingin menghapus data ini? <br>
                                                <span class="fw-bolder text-danger"><?= $data['judul'] ?></span>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="hapus">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Edit -->
                            <div class="modal fade" id="edit<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Buku</h1>
                                            <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="post">
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label" for="formGroupExampleInput">Judul</label>
                                                    <input class="form-control" name="judul" type="text" placeholder="Masukkan Input" value="<?= $data['judul'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formGroupExampleInput">Kategori <span class="text-secondary">(Tahan CTRL saat memilih Kategori)</span></label>
                                                    <select class="form-select" name="kategori[]" multiple="" aria-label="multiple select example">
                                                        <?php
                                                        $kategori_query = Qselect("kategori", "WHERE disable='0' ORDER BY nama_kategori ");
                                                        while ($kategori = fetch($kategori_query)) {
                                                            $cek_buku = Qselect("kategori_relasi", "WHERE id_buku='$id' AND id_kategori='" . $kategori['id_kategori'] . "' AND disable='0'");
                                                        ?>
                                                            <option value="<?= $kategori['id_kategori'] ?>" <?= (rows($cek_buku) > 0 ? 'selected' : '') ?>><?= $kategori['nama_kategori'] ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formGroupExampleInput2">Penulis</label>
                                                    <input class="form-control" name="penulis" type="text" placeholder="Masukkan Input" value="<?= $data['penulis'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formGroupExampleInput2">Penerbit</label>
                                                    <input class="form-control" name="penerbit" type="text" placeholder="Masukkan Input" value="<?= $data['penerbit'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formGroupExampleInput2">Tahun Terbit</label>
                                                    <input class="form-control" name="tahun_terbit" type="number" placeholder="Masukkan Input" value="<?= $data['tahun_terbit'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="formGroupExampleInput2">Stok</label>
                                                    <input class="form-control" name="stok" type="number" placeholder="Masukkan Input" value="<?= $data['stok'] ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" name="id" value="<?= $id ?>">
                                                <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary" name="edit">Simpan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Buku</h1>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Judul</label>
                        <input class="form-control" name="judul" type="text" placeholder="Masukkan Input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Kategori <span class="text-secondary">(Tahan CTRL saat memilih Kategori)</span></label>
                        <select class="form-select" multiple name="kategori[]" aria-label="multiple select example">
                            <?php
                            $kategori_query = Qselect("kategori", "WHERE disable='0' ORDER BY nama_kategori ");
                            while ($kategori = fetch($kategori_query)) {
                            ?>
                                <option value="<?= $kategori['id_kategori'] ?>"><?= $kategori['nama_kategori'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput2">Penulis</label>
                        <input class="form-control" name="penulis" type="text" placeholder="Masukkan Input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput2">Penerbit</label>
                        <input class="form-control" name="penerbit" type="text" placeholder="Masukkan Input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput2">Tahun Terbit</label>
                        <input class="form-control" name="tahun_terbit" type="number" placeholder="Masukkan Input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput2">Stok</label>
                        <input class="form-control" name="stok" type="number" placeholder="Masukkan Input">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="tambah">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>