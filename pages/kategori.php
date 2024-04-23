<?php
$query = Qselect("kategori", "WHERE disable='0' ORDER BY nama_kategori ");
?>

<div class="card mb-4">
    <div class="card-header"><strong>Table <?= ucwords($page) ?></strong>
        <span class="ms-2 btn btn-success btn-sm text-white" data-coreui-toggle="modal" data-coreui-target="#tambah">+ Tambah</span>
    </div>
    <div class="card-body">
        <div class="example">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Kategori</th>
                        <th scope="col">Jumlah Buku</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($data = fetch($query)) {
                        $id = $data['id_kategori'];
                    ?>
                        <tr>
                            <th scope="row"><?= $no++; ?></th>
                            <td><?= $data['nama_kategori'] ?></td>
                            <td>
                                <?php
                                $cek_buku = Qselect("kategori_relasi", "LEFT JOIN buku ON kategori_relasi.id_buku=buku.id_buku WHERE id_kategori='$id' AND kategori_relasi.disable='0' AND buku.disable='0' ");
                                echo rows($cek_buku);
                                ?>
                            </td>
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
                                            <span class="fw-bolder text-danger"><?= $data['nama_kategori'] ?></span>
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
                                                <label class="form-label" for="formGroupExampleInput">Kategori</label>
                                                <input class="form-control" name="kategori" type="text" placeholder="Masukkan Input" value="<?= $data['nama_kategori'] ?>">
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
                        <label class="form-label" for="formGroupExampleInput">Kategori</label>
                        <input class="form-control" name="kategori" type="text" placeholder="Masukkan Input">
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