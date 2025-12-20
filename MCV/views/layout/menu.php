<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="<?php echo _BASE_URL; ?>home" class="brand-link">
        <img src="<?php echo _BASE_URL; ?>public/dist/img/AdminLTELogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">TN Online Test</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo _BASE_URL; ?>public/dist/img/avatar5.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="<?php echo _BASE_URL; ?>account" class="d-block"><?php echo $_SESSION['user_fullname'] ?? 'Guest'; ?></a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="<?php echo _BASE_URL; ?>home" class="nav-link <?php echo (strpos($data['Page'], 'home/') !== false) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin'): ?>
                    <li class="nav-header">QUẢN TRỊ HỆ THỐNG</li>
                    
                    <li class="nav-item">
                        <a href="<?php echo _BASE_URL; ?>admin" class="nav-link <?php echo ($data['Page'] == 'admin/dashboard') ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>Thống kê chung</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="<?php echo _BASE_URL; ?>user" class="nav-link <?php echo (strpos($data['Page'], 'admin/users') !== false) ? 'active' : ''; ?>">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Quản lý Người dùng</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Ngân hàng câu hỏi
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?php echo _BASE_URL; ?>subject" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Môn học</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo _BASE_URL; ?>question" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Danh sách câu hỏi</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'student'): ?>
                    <li class="nav-header">KHU VỰC THI</li>
                    
                    <li class="nav-item">
                        <a href="<?php echo _BASE_URL; ?>exam" class="nav-link">
                            <i class="nav-icon fas fa-pen-nib"></i>
                            <p>Vào thi ngay</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="<?php echo _BASE_URL; ?>history" class="nav-link">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Lịch sử làm bài</p>
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-header">CÁ NHÂN</li>
                <li class="nav-item">
                    <a href="<?php echo _BASE_URL; ?>account" class="nav-link <?php echo (strpos($data['Page'], 'account/') !== false) ? 'active' : ''; ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>Thông tin tài khoản</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo _BASE_URL; ?>auth/logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Đăng xuất</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>