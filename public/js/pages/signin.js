$(document).ready(function () {
    $("#form-signin").validate({
        rules: {
            username: { required: true },
            password: { required: true, minlength: 5 }
        },
        messages: {
            username: "Vui lòng nhập tên đăng nhập",
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu phải từ 5 ký tự trở lên"
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.input-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function(form) {
            // Xử lý Ajax khi form hợp lệ
            $.ajax({
                url: "<?php echo _BASE_URL; ?>auth/signin", // Gửi đến Action signin của AuthController
                type: 'POST',
                data: $(form).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('button[type="submit"]').attr('disabled', true).text('Đang xử lý...');
                },
                success: function (res) {
                    console.log(res);
                    if (res.status) {
                        toastr.success(res.msg);
                        // Chuyển hướng sau 1 giây
                        setTimeout(function(){
                             window.location.href = '../home/index'; 
                        }, 1000);
                    } else {
                        toastr.error(res.msg);
                        $('button[type="submit"]').attr('disabled', false).text('Đăng nhập');
                    }
                },
                error: function() {
                    toastr.error("Lỗi kết nối máy chủ!");
                    $('button[type="submit"]').attr('disabled', false).text('Đăng nhập');
                }
            });
        }
    });
});
