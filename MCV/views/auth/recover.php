<div class="card card-outline card-primary">
  <div class="card-header text-center">
    <a href="#" class="h1"><b>Hệ thống</b> Trắc nghiệm</a>
  </div>
  <div class="card-body">
    <p class="login-box-msg">Bạn quên mật khẩu? Nhập email để lấy lại.</p>
    <form id="form-recover" method="post">
      <div class="input-group mb-3">
        <input type="email" name="email" class="form-control" placeholder="Email của bạn">
        <div class="input-group-append">
          <div class="input-group-text"><span class="fas fa-envelope"></span></div>
        </div>
      </div>
      <div class="row">
        <div class="col-12">
          <button type="submit" class="btn btn-primary btn-block">Gửi mã xác nhận</button>
        </div>
      </div>
    </form>
    <p class="mt-3 mb-1">
      <a href="<?php echo _BASE_URL; ?>auth/signin">Đăng nhập</a>
    </p>
  </div>
</div>