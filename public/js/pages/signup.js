$(document).ready(function () {
    $("#form-signup").validate({
        rules: {
            username: { required: true, minlength: 4 },
            fullname: { required: true },
            email: { required: true, email: true },
            password: { required: true, minlength: 6 },
            repassword: { required: true, equalTo: "#password" },
            terms: { required: true }
        },
        messages: {
            username: {
                required: "Vui lòng nhập tên đăng nhập",
                minlength: "Tên đăng nhập tối thiểu 4 ký tự"
            },
            fullname: "Vui lòng nhập họ tên",
            email: "Vui lòng nhập email hợp lệ",
            password: {
                required: "Vui lòng nhập mật khẩu",
                minlength: "Mật khẩu tối thiểu 6 ký tự"
            },
            repassword: {
                required: "Vui lòng nhập lại mật khẩu",
                equalTo: "Mật khẩu nhập lại không khớp"
            },
            terms: "Bạn phải đồng ý với điều khoản"
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
            $.ajax({
                url: 'signup', // Gửi đến Auth/signup
                type: 'POST',
                data: $(form).serialize(),
                dataType: 'JSON',
                beforeSend: function() {
                    $('button[type="submit"]').attr('disabled', true).text('Đang đăng ký...');
                },
                success: function (res) {
                    if (res.status) {
                        toastr.success(res.msg);
                        // Chuyển hướng về trang đăng nhập sau 1.5s
                        setTimeout(function(){
                             window.location.href = 'signin'; 
                        }, 1500);
                    } else {
                        toastr.error(res.msg);
                        $('button[type="submit"]').attr('disabled', false).text('Đăng ký');
                    }
                },
                error: function() {
                    toastr.error("Có lỗi xảy ra, vui lòng thử lại!");
                    $('button[type="submit"]').attr('disabled', false).text('Đăng ký');
                }
            });
        }
    });
});
