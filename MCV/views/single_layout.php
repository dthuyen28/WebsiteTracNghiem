<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo isset($data['Title']) ? $data['Title'] : 'Hệ thống Trắc nghiệm'; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/icheck-bootstrap/3.0.1/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <?php if(isset($data['Plugin']) && isset($data['Plugin']['notify'])): ?>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <?php endif; ?>

  <link rel="stylesheet" href="<?php echo _BASE_URL; ?>public/css/style.css">

  <script>
      var BASE_URL = "<?php echo _BASE_URL; ?>";
  </script>
  </head>

<body class="hold-transition <?php echo isset($_SESSION['user']) ? 'sidebar-mini layout-fixed' : 'login-page'; ?>">

<?php if (isset($_SESSION['user'])): ?>
    <?php require_once VIEW_PATH . '/layout/header.php'; ?>
    <?php require_once VIEW_PATH . '/layout/menu.php'; ?>
<?php endif; ?>

<?php if (isset($_SESSION['user'])): ?>
    <div class="content-wrapper">
        <?php 
            if (isset($data['Page'])) {
                require_once VIEW_PATH . "/" . $data['Page'] . ".php";
            }
        ?>
    </div>
<?php else: ?>
    <?php 
        if (isset($data['Page'])) {
            require_once VIEW_PATH . "/" . $data['Page'] . ".php";
        }
    ?>
<?php endif; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <?php if(isset($data['Plugin']) && isset($data['Plugin']['jquery-validate'])): ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <?php endif; ?>

    <?php if(isset($data['Plugin']) && isset($data['Plugin']['notify'])): ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <?php endif; ?>

    <?php if(isset($data['Script'])): ?>
        <script src="<?php echo _BASE_URL; ?>public/js/pages/<?php echo $data['Script']; ?>.js?v=<?php echo time(); ?>"></script>
    <?php endif; ?>

</body>
</html>