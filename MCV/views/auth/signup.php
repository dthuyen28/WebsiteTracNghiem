<div class="register-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?php echo _BASE_URL; ?>" class="h1"><b>Trắc Nghiệm</b> Online</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Đăng ký thành viên mới</p>

      <form id="form-signup" class="js-validation-signup" method="POST">
        
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập (viết liền không dấu)" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="text" name="fullname" class="form-control" placeholder="Họ và tên đầy đủ" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-id-card"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="repassword" class="form-control" placeholder="Nhập lại mật khẩu" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="agreeTerms" name="terms" value="agree" required>
              <label for="agreeTerms">
               Tôi đồng ý với <a href="#">điều khoản</a>
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
          </div>
          </div>
      </form>

      <div class="social-auth-links text-center">
        </div>

      <a href="<?php echo _BASE_URL; ?>auth/signin" class="text-center">Tôi đã có tài khoản</a>
    </div>
    </div></div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Lấy form dựa theo ID đã sửa ở Bước 1
    const signupForm = document.getElementById('form-signup');

    if (signupForm) {
        signupForm.addEventListener('submit', function(e) {
            e.preventDefault(); // Ngăn load lại trang

            const formData = new FormData(signupForm);

            // Gửi đến hàm signup trong AuthController
            fetch('<?php echo _BASE_URL; ?>auth/signup', { 
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) 
            .then(data => {
                console.log(data); // Kiểm tra log nếu có lỗi

                // AuthController trả về status là true (boolean)
                if (data.status === true) { 
                    Swal.fire({
                        icon: 'success',
                        title: 'Đăng ký thành công!',
                        text: data.msg, // "Vui lòng đăng nhập"
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        // Đăng ký xong thì chuyển về trang Đăng nhập
                        window.location.href = '<?php echo _BASE_URL; ?>auth/signin'; 
                    });
                } else {
                    // Lỗi (VD: Mật khẩu không khớp, User đã tồn tại...)
                    Swal.fire({
                        icon: 'error',
                        title: 'Đăng ký thất bại',
                        text: data.msg,
                        confirmButtonText: 'Kiểm tra lại'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi hệ thống',
                    text: 'Không thể kết nối đến máy chủ.',
                });
            });
        });
    }
});
</script>