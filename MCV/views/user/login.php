


<link rel="stylesheet" href="<?php echo _BASE_URL; ?>/public/css/themes/style.css">
<link rel="stylesheet" href="/Tracnghiem/WebsiteTracNghiem/public/css/themes/style.css">

<div class="login-container">
    <div class="login-left">
        <div class="login-form-box">
            <h1 class="brand-title">TN <span class="blue-text">Test</span></h1>
            <p class="sub-title">ĐĂNG NHẬP</p>

            <form action="process_login.php" method="POST">
                <div class="input-group">
                    <input type="text" name="student_id" placeholder="Mã sinh viên" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="Mật khẩu" required>
                </div>
                
                <button type="submit" class="btn-login">
                    <i class="fa-solid fa-right-to-bracket"></i> ĐĂNG NHẬP
                </button>

                <button type="button" class="btn-google">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" alt="Google">
                    Đăng nhập với Google
                </button>
            </form>

            <div class="form-footer">
                <a href="#" class="forgot-pass"><i class="fa-solid fa-triangle-exclamation"></i> Quên mật khẩu</a>
                <a href="#" class="new-account"><i class="fa-solid fa-plus"></i> Đăng ký</a>
            </div>
        </div>
    </div>

    <div class="login-right">
        <div class="overlay">
            <div class="banner-content">
                <h2>Welcome to the Tracnghiem Test</h2>
                <p>Copyright © 2025</p>
            </div>
        </div>
    </div>
</div>





