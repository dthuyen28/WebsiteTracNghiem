<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $data['Title'] ?? 'Hệ thống Trắc nghiệm'; ?></title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <?php if(isset($data['Plugin']['datatables'])): ?>
      <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
  <?php endif; ?>
  <?php require_once VIEW_PATH . "/layout/notifications.php"; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

  <link rel="stylesheet" href="<?php echo _BASE_URL; ?>public/css/style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <?php require_once VIEW_PATH . "/layout/header.php"; ?>

  <?php require_once VIEW_PATH . "/layout/menu.php"; ?>
  <div class="content-wrapper">
  <?php 
      // Load view con động dựa trên biến $data['Page']
      if (isset($data['Page'])) {
          require_once VIEW_PATH . "/" . $data['Page'] . ".php";
      }
  ?>
  </div>

  <?php require_once VIEW_PATH . "/layout/footer.php"; ?>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<?php if(isset($data['Plugin']['datatables'])): ?>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>
<?php endif; ?>

<?php if(isset($data['Plugin']['sweetalert2'])): ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php endif; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php if(isset($data['Script'])): ?>
    <script src="<?php echo _BASE_URL; ?>public/js/<?php echo $data['Script']; ?>.js?v=<?php echo time(); ?>"></script>
<?php endif; ?>

</body>
</html>