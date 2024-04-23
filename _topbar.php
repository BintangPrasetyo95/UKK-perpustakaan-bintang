<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button" onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()" style="margin-inline-start: -14px;">
            <svg class="icon icon-lg">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
        </button>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
                <li class="breadcrumb-item"><a href="#">Home</a>
                </li>
                <li class="breadcrumb-item active"><span><?= ucwords($page) ?></span>
                </li>
            </ol>
        </nav>
        <ul class="header-nav ms-auto"></ul>
        <ul class="header-nav">
            <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md"><img class="avatar-img" src="assets/img/avatars/10.png" alt="user@email.com"></div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                        <div class="fw-semibold"><?= myData('nama_lengkap') ?></div>
                    </div><a class="dropdown-item" href="?page=profil">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                        </svg> Profile</a><a class="dropdown-item" href="?page=profil">
                        <svg class="icon me-2">
                            <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                        </svg> Settings</a><a class="dropdown-item" href="?page=profil">
                        <div class="dropdown-divider"></div>
                        <?php
                        if (myData('role') != 'petugas') {
                        ?>
                            <a class="dropdown-item" href="./register.php">
                                <svg class="icon me-2">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                                </svg> Register
                            </a>
                        <?php
                        }
                        ?>
                        <a class="dropdown-item" href="./logout.php">
                            <svg class="icon me-2">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                            </svg> Logout
                        </a>
                </div>
            </li>
        </ul>
    </div>
</header>