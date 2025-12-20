$(document).ready(function () {
    // 1. Khởi tạo DataTables
    $("#tbl-users").DataTable({
        "responsive": true, 
        "lengthChange": false, 
        "autoWidth": false,
        "language": {
            "search": "Tìm kiếm:",
            "paginate": {
                "next": "Sau",
                "previous": "Trước"
            },
            "info": "Hiển thị _START_ đến _END_ của _TOTAL_ mục"
        }
    });

    // 2. Xử lý Thêm mới (Form Submit)
    $("#form-add").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'User/store', // Gọi đến UserController function store
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function (res) {
                if (res.status) {
                    toastr.success(res.msg); // Notify thành công
                    setTimeout(() => location.reload(), 1000); // Load lại trang
                } else {
                    toastr.error(res.msg);
                }
            }
        });
    });

    // 3. Xử lý khi bấm nút Sửa (Lấy thông tin đổ vào Modal)
    $(".btn-edit").click(function () {
        let id = $(this).data('id');
        $.ajax({
            url: 'User/getDetail',
            type: 'POST',
            data: { id: id },
            dataType: 'JSON',
            success: function (res) {
                // Đổ dữ liệu vào form modal edit
                $("#edit-id").val(res.id);
                $("#edit-username").val(res.username);
                $("#edit-fullname").val(res.fullname);
                $("#edit-email").val(res.email);
                $("#edit-role").val(res.role);
                
                // Mở Modal
                $("#modal-edit").modal('show');
            }
        });
    });

    // 4. Xử lý Cập nhật (Form Edit Submit)
    $("#form-edit").submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: 'User/update',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'JSON',
            success: function (res) {
                if (res.status) {
                    toastr.success(res.msg);
                    setTimeout(() => location.reload(), 1000);
                } else {
                    toastr.error(res.msg);
                }
            }
        });
    });

    // 5. Xử lý Xóa User
    $(".btn-delete").click(function () {
        let id = $(this).data('id');
        
        // Hiển thị SweetAlert xác nhận
        Swal.fire({
            title: 'Bạn có chắc chắn?',
            text: "Hành động này không thể hoàn tác!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Vâng, xóa nó!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'User/delete',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'JSON',
                    success: function (res) {
                        if (res.status) {
                            Swal.fire('Đã xóa!', res.msg, 'success');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            Swal.fire('Lỗi!', res.msg, 'error');
                        }
                    }
                });
            }
        })
    });
});