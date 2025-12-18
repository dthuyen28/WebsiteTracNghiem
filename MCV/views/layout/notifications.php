<!-- Notifications Dropdown -->
<div data-role="tghocphan" data-action="join" class="dropdown d-inline-block">
    <button type="button" class="btn btn-alt-secondary btn-show-notifications" 
        data-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0; ?>" 
        id="page-header-notifications-dropdown"
        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fa fa-fw fa-bell"></i>
        <span class="badge rounded-pill bg-danger">!</span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" style="width: 25rem;"
        aria-labelledby="page-header-notifications-dropdown">
        <div class="bg-primary-dark rounded-top fw-semibold text-white text-center p-3">
            Thông báo
        </div>
        <ul class="nav-items my-2 list-notifications">
            <li class="text-center p-3">Đang tải...</li>
        </ul>
    </div>
</div>
<!-- END Notifications Dropdown -->