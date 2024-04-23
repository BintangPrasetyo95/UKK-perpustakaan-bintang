<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header fw-bolder">Dashboard</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="border-start border-start-4 border-start-info px-3 mb-3">
                                    <div class="small text-body-secondary text-truncate">Total Akun Peminjam</div>
                                    <?php
                                    $query_peminjam = Qselect("user", "WHERE disable='0' AND role='peminjam' ");
                                    ?>
                                    <div class="fs-5 fw-semibold"><?= rows($query_peminjam) ?></div>
                                </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-6">
                                <div class="border-start border-start-4 border-start-danger px-3 mb-3">
                                    <div class="small text-body-secondary text-truncate">Total Buku</div>
                                    <?php
                                    $query_buku = Qselect("buku", "WHERE disable='0' ");
                                    ?>
                                    <div class="fs-5 fw-semibold"><?= rows($query_buku) ?></div>
                                </div>
                            </div>
                            <!-- /.col-->
                        </div>
                    </div>
                    <!-- /.col-->
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-6">
                                <div class="border-start border-start-4 border-start-warning px-3 mb-3">
                                    <div class="small text-body-secondary text-truncate">Total Stok Buku tersedia</div>
                                    <?php
                                    $query_stok = query("SELECT SUM(stok) as stoks FROM buku WHERE disable='0'");
                                    $fetch_stok = fetch($query_stok);
                                    ?>
                                    <div class="fs-5 fw-semibold"><?= $fetch_stok['stoks'] ?></div>
                                </div>
                            </div>
                            <!-- /.col-->
                            <div class="col-6">
                                <div class="border-start border-start-4 border-start-success px-3 mb-3">
                                    <div class="small text-body-secondary text-truncate">Anda login sebagai</div>
                                    <div class="fs-5 fw-semibold"><?= ucwords(myData('role')) ?></div>
                                </div>
                            </div>
                            <!-- /.col-->
                        </div>
                        <br>
                    </div>
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table border mb-0">
                                <thead class="fw-semibold text-nowrap">
                                    <tr class="align-middle">
                                        <th class="bg-body-secondary text-center">
                                        </th>
                                        <th class="bg-body-secondary">Peminjam Terakhir</th>
                                        <th class="bg-body-secondary text-center">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $query = Qselect("peminjaman", "LEFT JOIN user ON peminjaman.id_user=user.id_user WHERE peminjaman.disable='0' ORDER BY tanggal_pinjam DESC LIMIT 6 ");
                                    while ($data = fetch($query)) {
                                    ?>
                                        <tr class="align-middle">
                                            <td class="text-center">
                                                <svg class="icon">
                                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-people"></use>
                                                </svg>
                                            </td>
                                            <td>
                                                <div class="text-nowrap"><?= $data['nama_lengkap'] ?></div>
                                                <div class="small text-body-secondary text-nowrap"><span><?= $data['email'] ?></div>
                                            </td>
                                            <td>
                                                <div class="fw-semibold text-nowrap text-center">
                                                    <?php
                                                    if ($data['tanggal_pinjam'] == $today) {
                                                        echo "Hari ini";
                                                    } else {
                                                        echo $data['tanggal_pinjam'];
                                                    }
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->