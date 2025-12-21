<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="<?php echo _BASE_URL; ?>" class="h1"><b>Trắc Nghiệm</b> Online</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Đăng nhập để bắt đầu phiên làm việc</p>

      <form id="form-signin" method="POST">
        
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Tên đăng nhập" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>

        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Ghi nhớ tôi
              </label>
            </div>
          </div>
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
          </div>
          </div>
      </form>

      <div class="social-auth-links text-center mt-2 mb-3">
         </div>

      <p class="mb-1">
        <a href="<?php echo _BASE_URL; ?>auth/recover">Quên mật khẩu?</a>
      </p>
      <p class="mb-0">
        <a href="<?php echo _BASE_URL; ?>auth/signup" class="text-center">Đăng ký tài khoản mới</a>
      </p>
    </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('form-signin');

    loginForm.addEventListener('submit', function(e) {
        // Ngăn chặn hành động submit mặc định (chuyển trang trắng)
        e.preventDefault();

        // Lấy dữ liệu từ form
        const formData = new FormData(loginForm);

        // Gửi dữ liệu đi (AJAX)
        // Lưu ý: Thay 'đường_dẫn_file_xử_lý_php' bằng đường dẫn thực tế. 
        // Nếu file xử lý nằm ngay tại trang này thì để trống hoặc dùng window.location.href
        fetch('<?php echo _BASE_URL; ?>auth/signin', { 
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Chuyển kết quả về JSON
        .then(data => {
          console.log("Dữ liệu PHP trả về:", data);
            if (data.status == true) {
                // Đăng nhập thành công
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: data.msg,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Chuyển hướng vào trang Dashboard
                    window.location.href = '<?php echo _BASE_URL; ?>'; 
                });
            } else {
                // Đăng nhập thất bại (Sai pass/user)
                Swal.fire({
                    icon: 'error',
                    title: 'Đăng nhập thất bại',
                    text: data.msg || 'Vui lòng kiểm tra lại thông tin.',
                    confirmButtonText: 'Thử lại'
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
});
</script>