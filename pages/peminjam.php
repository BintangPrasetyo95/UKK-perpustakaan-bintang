<?php
$query = Qselect("user", "WHERE role='peminjam' AND disable='0' ORDER BY nama_lengkap ");
?>

<div class="card mb-4">
    <div class="card-header"><strong>Table <?= ucwords($page) ?></strong>
        <span class="ms-2 btn btn-success btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#tambah">+ Tambah</span>
            <a class="ms-2 btn btn-primary btn-sm text-white" target="_blank" href="print.php?page=<?= $page ?>"><i class="icon cil-print"></i> Print</a>
    </div>
    <div class="card-body">
        <div class="example">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Lengkap</th>
                        <th scope="col">Email</th>
                        <th scope="col">Username</th>
                        <th scope="col">Alamat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = fetch($query)) {
                        $id = $data['id_user'];
                    ?>
                        <tr>
                            <th scope="row"><?= $no++; ?></th>
                            <td><?= $data['nama_lengkap'] ?></td>
                            <td><?= $data['email'] ?></td>
                            <td><?= $data['username'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td class="text-center">
                                <span class="btn btn-info btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#edit<?= $id ?>">Edit</span>
                                <span class="btn btn-danger btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#hapus<?= $id ?>">Hapus</span>
                            </td>
                        </tr>

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
                                            <span class="fw-bolder text-danger"><?= $data['nama_lengkap'] ?></span>
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
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit <?= ucwords($page) ?></h1>
                                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Nama Lengkap</label>
                                                <input class="form-control" name="nama_lengkap" type="text" placeholder="Masukkan Input" value="<?= $data['nama_lengkap'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Email</label>
                                                <input class="form-control" name="email" type="email" placeholder="Masukkan Input" value="<?= $data['email'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Username</label>
                                                <input class="form-control" name="username" type="text" placeholder="Masukkan Input" value="<?= $data['username'] ?>">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Alamat</label>
                                                <textarea name="alamat" class="form-control" placeholder="Masukkan Input"><?= $data['alamat'] ?></textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Password</label>
                                                <input class="form-control" name="pw" type="password" placeholder="Masukkan Input" autocomplete="off">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label" for="formGroupExampleInput">Konfirmasi Password</label>
                                                <input class="form-control" name="pw_konf" type="password" placeholder="Masukkan Input" autocomplete="off">
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
                        <label class="form-label" for="formGroupExampleInput">Nama Lengkap</label>
                        <input class="form-control" name="nama_lengkap" type="text" placeholder="Masukkan Input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Email</label>
                        <input class="form-control" name="email" type="email" placeholder="Masukkan Input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Username</label>
                        <input class="form-control" name="username" type="text" placeholder="Masukkan Input">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Alamat</label>
                        <textarea name="alamat" class="form-control" placeholder="Masukkan Input"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Password</label>
                        <input class="form-control" name="pw" type="password" placeholder="Masukkan Input" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="formGroupExampleInput">Konfirmasi Password</label>
                        <input class="form-control" name="pw_konf" type="password" placeholder="Masukkan Input" autocomplete="off">
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