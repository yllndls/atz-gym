<?php 
    require_once 'header.php'; 
    $user_id = isset($_GET['user_id']) ? $_GET['user_id'] : '';
    $last_active_date_from = isset($_GET['last_active_date_from']) ? $_GET['last_active_date_from'] : '';
    $last_active_date_to = isset($_GET['last_active_date_to']) ? $_GET['last_active_date_to'] : '';
    $verify = isset($_GET['verify']) ? $_GET['verify'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';

    $search_params = array(
        'user_id' => $user_id,
        'last_active_date_from' => $last_active_date_from,
        'last_active_date_to' => $last_active_date_to,
        'verify' => $verify,
        'status' => $status
    );

    $user_list = $userCntrl->user_list($search_params);
?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Users</h3>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Search Users</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">User ID</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="user_id" value="<?= $user_id; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Last Active Date</label>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="last_active_date_from" value="<?= $last_active_date_from; ?>">
                                        </div>
                                        <div class="col-md-1 text-center">~</div>
                                        <div class="col-md-4">
                                            <input type="date" class="form-control" name="last_active_date_to" value="<?= $last_active_date_to; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Profile Verification</label>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="verify" id="verify" value="1" <?= $verify == 1 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="verify">Verify</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="verify" id="not_verify" value="2" <?= $verify == 2 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="not_verify">Not Verify</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Status</label>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status" id="inactive" value="1" <?= $status == 1 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="inactive">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status" id="active" value="2" <?= $status == 2 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="active">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Search</button>
                                            <a href="users.php" class="btn btn-rounded pl-4 pr-4">Clear</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">User List</h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list footable-loaded footable" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th class="footable-sortable">#</th>
                                            <th class="footable-sortable">Name</th>
                                            <th class="footable-sortable">Email</th>
                                            <th class="footable-sortable">Contact</th>
                                            <th class="footable-sortable">Address</th>
                                            <th class="footable-sortable">Profile Verification</th>
                                            <th class="footable-sortable">Last active date</th>
                                            <th class="footable-sortable">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($user_list['data'] as $key => $user) : ?>
                                            <tr class="footable-even">
                                                <td><?= $key + 1;?></td>
                                                <td>
                                                    <a href="javascript:void(0)">
                                                        <i class="mdi mdi-checkbox-blank-circle text-<?= $user['is_online_flg'] == 0 ? 'secondary':'success'; ?>"></i> 
                                                        <img src="../public/assets/image/profile/<?= $user['profile_img']; ?>" alt="user" class="img-circle" style="width:40px; height:40px;"> 
                                                        <?= $user['fname'].' '.$user['lname']; ?>
                                                    </a>
                                                </td>
                                                <td><?= $user['email']; ?></td>
                                                <td><?= $user['contact']; ?></td>
                                                <td><?= $user['address']; ?></td>
                                                <td>
                                                    <span class="label label-<?= $user['is_verify_flg'] == 0 ? 'warning':'primary'; ?>">
                                                        <?= $user['is_verify_flg'] == 0 ? 'Not verify' : 'Verified'; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                <?= ($user['last_active'] == '0000-00-00 00:00:00') ? '---' : $user['last_active']; ?>
                                                </td>
                                                <td>
                                                    <?= $user['status'] == 0 ? 'Inactive':'Active'; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'footer.php'; ?>
    