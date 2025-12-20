<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="<?php echo _BASE_URL; ?>home" class="nav-link">Trang chủ</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Liên hệ</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo _BASE_URL; ?>public/dist/img/avatar5.png" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline"><?php echo $_SESSION['user_fullname'] ?? 'User'; ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header bg-primary">
                    <img src="<?php echo _BASE_URL; ?>public/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
                    <p>
                        <?php echo $_SESSION['user_fullname'] ?? 'User'; ?>
                        <small><?php echo ($_SESSION['user_role'] == 'admin') ? 'Quản trị viên' : 'Sinh viên'; ?></small>
                    </p>
                </li>
                <li class="user-footer">
                    <a href="<?php echo _BASE_URL; ?>account" class="btn btn-default btn-flat">Hồ sơ</a>
                    <a href="<?php echo _BASE_URL; ?>auth/logout" class="btn btn-default btn-flat float-right">Đăng xuất</a>
                </li>
            </ul>
        </li>
    </ul>
</nav>