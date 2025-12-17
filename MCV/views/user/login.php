<?php require_once "mvc/views/layout/header.php"; ?>

<h2>Đăng nhập</h2>

<?php if (!empty($error)) echo "<p style='color:red'>$error</p>"; ?>

<form method="post">
    <input type="text" name="username" placeholder="Tên đăng nhập" required><br><br>
    <input type="password" name="password" placeholder="Mật khẩu" required><br><br>
    <button type="submit">Đăng nhập</button>
</form>

<?php require_once "mvc/views/layout/footer.php"; ?>
