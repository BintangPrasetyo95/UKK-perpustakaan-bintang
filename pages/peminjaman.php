<?php
$query = Qselect("peminjaman", "LEFT JOIN buku ON peminjaman.id_buku=buku.id_buku LEFT JOIN user ON peminjaman.id_user=user.id_user WHERE " . (myData('role') == 'peminjam' ? "peminjaman.id_user='$myID' AND" : "") . " peminjaman.disable='0' ORDER BY status ");
?>

<div class="card mb-4">
    <div class="card-header"><strong>Table <?= ucwords($page) ?></strong>
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
                        <th scope="col">Peminjam</th>
                        <th scope="col">Buku</th>
                        <th scope="col">Tanggal Pinjam</th>
                        <th scope="col">Tanggal Kembali</th>
                        <th scope="col" class="text-center">Status</th>
                        <?php
                        if (myData("role") != "peminjam") {
                        ?>
                            <th></th>
                        <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = fetch($query)) {
                        $id = $data['id_pinjam'];
                    ?>
                        <tr>
                            <th scope="row"><?= $no++; ?></th>
                            <td><?= $data['nama_lengkap'] ?></td>
                            <td><?= $data['judul'] ?></td>
                            <td><?= $data['tanggal_pinjam'] ?></td>
                            <td><?= $data['tanggal_kembali'] ?></td>
                            <td class="text-center">
                                <?php
                                if ($data['status'] == 'terpinjam') {
                                ?>
                                    <span class="btn btn-warning text-dark">Terpinjam</span>
                                <?php
                                } else {
                                ?>
                                    <span class="btn btn-primary text-white">Terkembalikan</span>
                                <?php
                                }
                                ?>
                            </td>
                            <?php
                            if (myData("role") != "peminjam") {
                            ?>
                                <td class="text-end">
                                    <?php
                                    if ($data['status'] == 'terpinjam') {
                                    ?>
                                        <span class="btn btn-primary btn-sm me-3 text-white" data-coreui-toggle="modal" data-coreui-target="#kembali<?= $id ?>">Kembali</span>
                                    <?php
                                    }
                                    ?>
                                    <span class="btn btn-info btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#edit<?= $id ?>">Edit</span>
                                    <span class="btn btn-danger btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#hapus<?= $id ?>">Hapus</span>
                                </td>
                            <?php
                            }
                            ?>
                        </tr>

                        <!-- Modal Kembali -->
                        <div class="modal fade" id="kembali<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus <?= ucwords($page) ?></h1>
                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            Konfirmasi pengembalian data buku. <br>
                                            <span class="fw-bolder text-primary"><?= $data['nama_lengkap'] ?></span> - <span class="fw-bolder text-primary"><?= $data['judul'] ?></span>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="buku" value="<?= $data['id_buku'] ?>">
                                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="kembali">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapus<?= $id ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus <?= ucwords($page) ?></h1>
                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            Apakah anda yakin ingin menghapus data ini? <br>
                                            <span class="fw-bolder text-danger"><?= $data['nama_lengkap'] ?></span> - <span class="fw-bolder text-danger"><?= $data['judul'] ?></span>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="buku" value="<?= $data['id_buku'] ?>">
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
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit <?= ucwords($page) ?></h1>
                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Peminjam</label>
                                                <select class="form-select" name="user" aria-label="Default select example">
                                                    <option value="" hidden>Pilih...</option>
                                                    <?php
                                                    $query_user = Qselect("user", "WHERE role='peminjam' AND disable='0' ORDER BY nama_lengkap ");
                                                    while ($user = fetch($query_user)) {
                                                    ?>
                                                        <option value="<?= $user['id_user'] ?>" <?= ($data['id_user'] == $user['id_user'] ? 'selected' : '') ?>><?= $user['nama_lengkap'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Buku</label>
                                                <select class="form-select" name="buku" aria-label="Default select example">
                                                    <option value="" hidden>Pilih...</option>
                                                    <?php
                                                    $query_buku = Qselect("buku", "WHERE disable='0' ORDER BY judul ");
                                                    while ($buku = fetch($query_buku)) {
                                                    ?>
                                                        <option value="<?= $buku['id_buku'] ?>" <?= ($data['id_buku'] == $buku['id_buku'] ? 'selected' : '') ?>><?= $buku['judul'] ?>, Stok: <?= $buku['stok'] ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Tanggal Peminjaman</label>
                                                <input class="form-control" name="date" type="date" value="<?= $today ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <input type="hidden" name="id" value="<?= $id ?>">
                                            <input type="hidden" name="buku_old" value="<?= $data['id_buku'] ?>">
                                            <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" name="edit">Simpan</button>
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

<!-- Modal Tambah -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah <?= ucwords($page) ?></h1>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Peminjam</label>
                        <select class="form-select" name="user" aria-label="Default select example">
                            <option value="" hidden>Pilih...</option>
                            <?php
                            $query_user = Qselect("user", "WHERE role='peminjam' AND disable='0' ORDER BY nama_lengkap ");
                            while ($user = fetch($query_user)) {
                            ?>
                                <option value="<?= $user['id_user'] ?>"><?= $user['nama_lengkap'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Buku</label>
                        <select class="form-select" name="buku" aria-label="Default select example">
                            <option value="" hidden>Pilih...</option>
                            <?php
                            $query_buku = Qselect("buku", "WHERE disable='0' ORDER BY judul ");
                            while ($buku = fetch($query_buku)) {
                            ?>
                                <option value="<?= $buku['id_buku'] ?>"><?= $buku['judul'] ?>, Stok: <?= $buku['stok'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Tanggal Peminjaman</label>
                        <input class="form-control" name="date" type="date" value="<?= $today ?>">
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