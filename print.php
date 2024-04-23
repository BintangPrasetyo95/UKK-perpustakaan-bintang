<?php
require("./functions.php");

$page = isset($_GET["page"]) ? $_GET["page"] : "buku";
function tab($th_temp)
{
    echo "<th>" . $th_temp . "</th>";
}

?>
<style>
    th,
    td {
        padding: 5px;
    }
</style>

<body>
    <center>
        <table border="1">
            <tr>
                <th>No.</th>
                <?php
                if ($page == "buku") {
                    $page_field = ["judul", "penulis", "kategori", "penerbit", "tahun_terbit", "total_rating", "stok"];
                } elseif ($page == "peminjaman") {
                    $page_field = ["nama_lengkap", "judul", "tanggal_pinjam", "tanggal_kembali", "status"];
                } else {
                    $page_field = ["nama_lengkap", "email", "username", "alamat"];
                }

                foreach ($page_field as $page_up) {
                    echo "<th>" . ucwords(preg_replace("/_/", " ", $page_up)) . "</th>";
                }
                ?>
            </tr>
            <?php
            if ($page == 'petugas' || $page == 'peminjam') {
                $page_query = "user";
            } elseif ($page != "peminjaman") {
                $page_query = $page;
            } else {
                $page_query = "pinjam";
            }

            if ($page == "peminjam") {
                $query_extend = "WHERE disable='0' AND role='peminjam'";
            } elseif ($page == "petugas") {
                $query_extend = "WHERE disable='0' AND role='petugas'";
            } elseif ($page == "peminjaman") {
                $query_extend = "WHERE peminjaman.disable='0' AND buku.disable='0' ORDER BY status";
            } elseif ($page == "buku") {
                $query_extend = "WHERE buku.disable='0' ORDER BY judul";
            } else {
                $query_extend = "WHERE disable='0'";
            }

            $no = 1;

            $query = Qselect(($page == "peminjaman" ? "peminjaman LEFT JOIN user ON peminjaman.id_user=user.id_user LEFT JOIN buku ON peminjaman.id_buku=buku.id_buku " : $page_query), $query_extend);

            while ($data = fetch($query)) {
                $id = $data['id_' . $page_query];
            ?>
                <tr>
                    <td><?= $no; ?></td>
                    <?php
                    $i = 1;
                    foreach ($page_field as $page_down) {
                        if ($page_down == "kategori") {
                            $query_kategori = query("SELECT nama_kategori FROM kategori_relasi LEFT JOIN kategori ON kategori_relasi.id_kategori=kategori.id_kategori WHERE id_buku='$id' AND kategori_relasi.disable='0' ");

                    ?>
                            <td>
                                <?php
                                while ($kategori = fetch($query_kategori)) {
                                    echo $kategori['nama_kategori'];
                                    echo ($i++ == rows($query_kategori) ? "" : ", ");
                                }
                                ?>
                            </td>
                        <?php
                        } elseif ($page_down == "total_rating") {
                            $rows_ulasan_mistake = Qselect("ulasan", "WHERE disable='0' AND id_buku='$id'");
                            $total_rating_query = query("SELECT SUM(rating) as ratings FROM ulasan WHERE id_buku='$id' AND disable='0'");
                            $total_rating_fetch = fetch($total_rating_query);
                            $total_rating = intval($total_rating_fetch['ratings']) / intval(rows($rows_ulasan_mistake));
                            ?>
                            <td><?= ceil($total_rating) ?>/10</td>
                            <?php
                        } else {
                        ?>
                            <td><?= $data[$page_down] ?></td>
                    <?php
                        }
                    }
                    ?>
                </tr>
            <?php
                $no++;
            }
            ?>
        </table>
    </center>
</body>