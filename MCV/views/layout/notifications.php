<script>
    $(document).ready(function() {
        
        // --- CẤU HÌNH TOASTR ---
        if (typeof toastr !== 'undefined') {
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right", // Vị trí hiển thị
                "timeOut": "5000" // Tự tắt sau 5s
            };

            // 1. Hiển thị thông báo SUCCESS từ Session
            <?php if (isset($_SESSION['success'])): ?>
                toastr.success('<?php echo $_SESSION['success']; ?>');
                <?php unset($_SESSION['success']); // Xóa session ngay sau khi hiện ?>
            <?php endif; ?>

            // 2. Hiển thị thông báo ERROR từ Session
            <?php if (isset($_SESSION['error'])): ?>
                toastr.error('<?php echo $_SESSION['error']; ?>');
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>

            // 3. Hiển thị thông báo WARNING từ Session
            <?php if (isset($_SESSION['warning'])): ?>
                toastr.warning('<?php echo $_SESSION['warning']; ?>');
                <?php unset($_SESSION['warning']); ?>
            <?php endif; ?>

            // 4. Hiển thị thông báo INFO từ Session
            <?php if (isset($_SESSION['info'])): ?>
                toastr.info('<?php echo $_SESSION['info']; ?>');
                <?php unset($_SESSION['info']); ?>
            <?php endif; ?>
        }

        // --- CẤU HÌNH SWEETALERT2 (Nếu cần thông báo to giữa màn hình) ---
        if (typeof Swal !== 'undefined') {
            
            // Kiểm tra session 'swal_success'
            <?php if (isset($_SESSION['swal_success'])): ?>
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công!',
                    text: '<?php echo $_SESSION['swal_success']; ?>',
                    showConfirmButton: false,
                    timer: 2000
                });
                <?php unset($_SESSION['swal_success']); ?>
            <?php endif; ?>

            // Kiểm tra session 'swal_error'
            <?php if (isset($_SESSION['swal_error'])): ?>
                Swal.fire({
                    icon: 'error',
                    title: 'Lỗi!',
                    text: '<?php echo $_SESSION['swal_error']; ?>'
                });
                <?php unset($_SESSION['swal_error']); ?>
            <?php endif; ?>
        }
    });
</script>