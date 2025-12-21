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
        submitHandler: function (form) {

            $.ajax({
                url: BASE_URL + "auth/signin", // ✅ ĐÚNG
                type: "POST",
                data: $(form).serialize(),
                dataType: "json",

                beforeSend: function () {
                    $('button[type="submit"]').prop('disabled', true).text('Đang xử lý...');
                },

                success: function (res) {
                    if (res.status) {
                        toastr.success(res.msg);

                        // ✅ REDIRECT ĐÚNG
                        setTimeout(function () {
                            window.location.href = BASE_URL + "home";
                        }, 1000);

                    } else {
                        toastr.error(res.msg);
                        $('button[type="submit"]').prop('disabled', false).text('Đăng nhập');
                    }
                },

                error: function () {
                    toastr.error("Lỗi kết nối máy chủ!");
                    $('button[type="submit"]').prop('disabled', false).text('Đăng nhập');
                }
            });
        }
    });
});
