<div class="row">
    <div class="col-md-12">
        <div class="card mb-4 mx-4">
            <div class="card-body p-4">
                <h1>Profil</h1>
                <p class="text-body-secondary">Profil lengkap anda</p>
                <form method="post">
                    <div class="input-group mb-3"><span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>

                            </svg></span>
                        <input class="form-control" type="text" placeholder="Nama Lengkap" name="nama_lengkap" value="<?= myData('nama_lengkap') ?>">
                    </div>
                    <div class="input-group mb-3"><span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-envelope-open"></use>
                            </svg></span>
                        <input class="form-control" type="text" placeholder="Email" name="email" value="<?= myData('email') ?>">
                    </div>
                    <div class="input-group mb-3"><span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contact"></use>
                            </svg></span>
                        <input class="form-control" type="text" placeholder="Username" name="username" value="<?= myData('username') ?>">
                    </div>
                    <div class="input-group mb-3"><span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-golf"></use>
                            </svg></span>
                        <textarea name="alamat" class="form-control" placeholder="Alamat" name="alamat"><?= myData('alamat') ?></textarea>
                    </div>
                    <button class="btn btn-block btn-primary me-3 mb-3" type="submit" name="edit">Edit Profil</button>
                </form>
                <hr>
                <form method="post">
                    <div class="input-group mb-3"><span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                            </svg></span>
                        <input class="form-control" type="password" placeholder="Password Lama" name="pw_lama">
                    </div>
                    <div class="input-group mb-3"><span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                            </svg></span>
                        <input class="form-control" type="password" placeholder="Password" name="pw">
                    </div>
                    <div class="input-group mb-4"><span class="input-group-text">
                            <svg class="icon">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
                            </svg></span>
                        <input class="form-control" type="password" placeholder="Konfirmasi password" name="pw_konf">
                    </div>
                    <button class="btn btn-block btn-primary me-3" type="submit" name="password">Edit Password</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <?php
    $query = Qselect("koleksi", "LEFT JOIN buku ON koleksi.id_buku=buku.id_buku WHERE id_user='$myID' AND buku.disable='0' AND koleksi.disable='0' ");
    ?>

    <div class="card mb-4">
        <div class="card-header"><strong>Table Koleksi</strong></div>
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
                            </tr>

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
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>