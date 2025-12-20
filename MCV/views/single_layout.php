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
</head>

<body class="hold-transition login-page">
    
    <?php 
        // $data['Page'] được truyền từ Controller (ví dụ: "auth/signin")
        if (isset($data['Page'])) {
            require_once VIEW_PATH . "/" . $data['Page'] . ".php";
        }
    ?>
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
        <script src="<?php echo _BASE_URL; ?>public/js/<?php echo $data['Script']; ?>.js?v=<?php echo time(); ?>"></script>
    <?php endif; ?>

</body>
</html>