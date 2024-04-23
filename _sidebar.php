<?php
function sidebarActive($sidebar)
{
    global $page;

    if ($sidebar == $page) {
        return 'active';
    }
}
?>

<div class="sidebar sidebar-dark sidebar-fixed border-end" id="sidebar">
    <div class="sidebar-header border-bottom">
        <div class="sidebar-brand">
            <i class="icon cil-book"></i>
            <span class="fw-bolder">Perpustakaan Bintang</span>
        </div>
        <button class="btn-close d-lg-none" type="button" data-coreui-dismiss="offcanvas" data-coreui-theme="dark" aria-label="Close" onclick="coreui.Sidebar.getInstance(document.querySelector(&quot;#sidebar&quot;)).toggle()"></button>
    </div>
    <ul class="sidebar-nav" data-coreui="navigation" data-simplebar="">
        <li class="nav-item"><a class="nav-link <?= sidebarActive('dashboard') ?>" href="index.php">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-speedometer"></use>
                </svg> Dashboard</a></li>

        <li class="nav-title">Halaman</li>
        <li class="nav-item">
            <a class="nav-link <?= sidebarActive('buku') ?>" href="?page=buku">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-book"></use>
                </svg> Buku
            </a>
        </li>
        <?php
        if (myData('role') != 'peminjam') {
        ?>
            <li class="nav-item">
                <a class="nav-link <?= sidebarActive('kategori') ?>" href="?page=kategori">
                    <svg class="nav-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-folder-open"></use>
                    </svg> Kategori Buku
                </a>
            </li>
        <?php
        }
        ?>
        <li class="nav-item">
            <a class="nav-link <?= sidebarActive('peminjaman') ?>" href="?page=peminjaman">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-inbox"></use>
                </svg> Peminjaman Buku
            </a>
        </li>
        <?php
        if (myData('role') != 'peminjam') {
        ?>
            <li class="nav-item">
                <a class="nav-link <?= sidebarActive('peminjam') ?>" href="?page=peminjam">
                    <svg class="nav-icon">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-group"></use>
                    </svg> Akun Peminjam
                </a>
            </li>
            <?php
            if (myData('role') == 'admin') {
            ?>
                <li class="nav-item">
                    <a class="nav-link <?= sidebarActive('petugas') ?>" href="?page=petugas">
                        <svg class="nav-icon">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-group"></use>
                        </svg> Akun Petugas
                    </a>
                </li>
        <?php
            }
        }
        ?>
        <li class="nav-item">
            <a class="nav-link <?= sidebarActive('profil') ?>" href="?page=profil">
                <svg class="nav-icon">
                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                </svg> Profil
            </a>
        </li>
    </ul>
    <div class="sidebar-footer border-top d-none d-md-flex">
        <a class="sidebar-toggler me-1" title="Logout" href="./logout.php"></a>
    </div>
</div>