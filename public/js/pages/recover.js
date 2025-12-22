$(document).ready(function () {

    // --- 1. XỬ LÝ FORM GỬI OTP (Trang auth/recover) ---
    if ($("#form-recover").length > 0) {
        $("#form-recover").validate({
            rules: {
                email: { required: true, email: true }
            },
            messages: {
                email: "Vui lòng nhập địa chỉ email hợp lệ"
            },
            submitHandler: function (form) {
                $.ajax({
                    url: BASE_URL + "auth/sendOtp",
                    type: "POST",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Đang gửi...');
                    },
                    success: function (res) {
                        if (res.status) {
                            toastr.success(res.msg);
                            setTimeout(function () {
                                window.location.href = BASE_URL + "auth/otp";
                            }, 1000);
                        } else {
                            toastr.error(res.msg);
                            $('button[type="submit"]').prop('disabled', false).text('Gửi mã xác nhận');
                        }
                    },
                    error: function () {
                        toastr.error("Lỗi kết nối server!");
                        $('button[type="submit"]').prop('disabled', false).text('Gửi mã xác nhận');
                    }
                });
            }
        });
    }

    // --- 2. XỬ LÝ FORM NHẬP MÃ OTP (Trang auth/otp) ---
    if ($("#form-otp").length > 0) {
        $("#form-otp").validate({
            rules: {
                otp: { required: true, minlength: 6, maxlength: 6, number: true }
            },
            messages: {
                otp: "Vui lòng nhập mã OTP 6 số"
            },
            submitHandler: function (form) {
                $.ajax({
                    url: BASE_URL + "auth/checkOtp",
                    type: "POST",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).text('Đang kiểm tra...');
                    },
                    success: function (res) {
                        if (res.status) {
                            toastr.success(res.msg);
                            setTimeout(function () {
                                window.location.href = BASE_URL + "auth/changepass";
                            }, 1000);
                        } else {
                            toastr.error(res.msg);
                            $('button[type="submit"]').prop('disabled', false).text('Xác nhận');
                        }
                    }
                });
            }
        });
    }

    // --- 3. XỬ LÝ FORM ĐỔI MẬT KHẨU (Trang auth/changepass) ---
    if ($("#form-changepass").length > 0) {
        $("#form-changepass").validate({
            rules: {
                password: { required: true, minlength: 6 },
                repassword: { required: true, equalTo: "#password" }
            },
            messages: {
                password: { required: "Nhập mật khẩu mới", minlength: "Tối thiểu 6 ký tự" },
                repassword: { required: "Nhập lại mật khẩu", equalTo: "Mật khẩu không khớp" }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: BASE_URL + "auth/handleChangepass",
                    type: "POST",
                    data: $(form).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $('button[type="submit"]').prop('disabled', true).text('Đang xử lý...');
                    },
                    success: function (res) {
                        if (res.status) {
                            toastr.success(res.msg);
                            setTimeout(function () {
                                window.location.href = BASE_URL + "auth/signin";
                            }, 1500);
                        } else {
                            toastr.error(res.msg);
                            $('button[type="submit"]').prop('disabled', false).text('Đổi mật khẩu');
                        }
                    }
                });
            }
        });
    }
});