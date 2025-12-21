<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?= _BASE_URL ?>" class="brand-link">
        <span class="brand-text font-weight-light">Trắc nghiệm</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= _BASE_URL ?>/public/img/user.png" class="img-circle elevation-2">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $_SESSION['user']['fullname'] ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column">

                <?php if ($_SESSION['user']['role'] === 'student'): ?>
                    <li class="nav-item">
                        <a href="<?= _BASE_URL ?>/exam/do" class="nav-link">
                            <i class="nav-icon fas fa-pencil-alt"></i>
                            <p>Làm bài thi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= _BASE_URL ?>/result" class="nav-link">
                            <i class="nav-icon fas fa-chart-bar"></i>
                            <p>Xem kết quả</p>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a href="<?= _BASE_URL ?>/auth/logout" class="nav-link text-danger">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Đăng xuất</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>
