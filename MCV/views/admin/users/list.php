<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Quản lý người dùng</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?php echo _BASE_URL; ?>admin">Home</a></li>
                        <li class="breadcrumb-item active">Danh sách User</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Danh sách tài khoản hệ thống</h3>
                            <button class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-add">
                                <i class="fas fa-plus"></i> Thêm mới
                            </button>
                        </div>
                        
                        <div class="card-body">
                            <table id="tbl-users" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tên đăng nhập</th>
                                        <th>Họ và tên</th>
                                        <th>Email</th>
                                        <th>Quyền hạn</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($Data) && is_array($Data)): ?>
                                        <?php foreach ($Data as $user): ?>
                                            <tr>
                                                <td><?php echo $user['id']; ?></td>
                                                <td><?php echo $user['username']; ?></td>
                                                <td><?php echo $user['fullname']; ?></td>
                                                <td><?php echo $user['email']; ?></td>
                                                <td>
                                                    <?php if($user['role'] == 'admin'): ?>
                                                        <span class="badge badge-danger">Admin</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">Sinh viên</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="text-center">
                                                    <button class="btn btn-info btn-sm btn-edit" data-id="<?php echo $user['id']; ?>">
                                                        <i class="fas fa-pencil-alt"></i> Sửa
                                                    </button>
                                                    
                                                    <button class="btn btn-danger btn-sm btn-delete" data-id="<?php echo $user['id']; ?>">
                                                        <i class="fas fa-trash"></i> Xóa
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="modal-add">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Thêm người dùng mới</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-add">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên đăng nhập <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="username" required>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="fullname" required>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Phân quyền</label>
                        <select class="form-control" name="role">
                            <option value="student">Sinh viên</option>
                            <option value="admin">Quản trị viên (Admin)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu lại</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cập nhật thông tin</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form-edit">
                <input type="hidden" name="id" id="edit-id">
                
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tên đăng nhập</label>
                        <input type="text" class="form-control" id="edit-username" disabled>
                        <small class="text-muted">Không thể thay đổi tên đăng nhập</small>
                    </div>
                    <div class="form-group">
                        <label>Họ và tên <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="fullname" id="edit-fullname" required>
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" name="email" id="edit-email" required>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <input type="password" class="form-control" name="password" placeholder="Để trống nếu không muốn đổi pass">
                    </div>
                    <div class="form-group">
                        <label>Phân quyền</label>
                        <select class="form-control" name="role" id="edit-role">
                            <option value="student">Sinh viên</option>
                            <option value="admin">Quản trị viên (Admin)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-info">Cập nhật</button>
                </div>
            </form>
        </div>
    </div>
</div>