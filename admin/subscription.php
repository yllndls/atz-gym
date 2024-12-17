<?php 
    require_once 'header.php'; 
    $plan_id = isset($_GET['plan_id']) ? $_GET['plan_id'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';
    $params = array(
        'plan_id' => $plan_id,
        'status' => $status
    );
    $subscription = $membershipCntrl->membership_info($params);
?>
    <div class="page-wrapper" ng-controller="GymTransactionController" ng-cloak="true">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Subscription</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="btn btn-info btn-rounded" href="subscription-form.php">
                            <i class="mdi mdi-account-plus"></i>
                            Add Subscription
                        </a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Search Subscription</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Subscription Code</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="plan_id" value="<?= $plan_id; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Status</label>
                                        <div class="col-md-9">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status" id="active" value="1" <?= $status == 1 ? 'checked':'';?>>
                                                <label class="form-check-label" for="active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status" id="inactive" value="2" <?= $status == 2 ? 'checked':'';?>>
                                                <label class="form-check-label" for="inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Search</button>
                                            <a href="subscription.php" class="btn btn-rounded pl-4 pr-4">Clear</a>
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
                            <h4 class="card-title">Membership List</h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list footable-loaded footable" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th class="footable-sortable">#</th>
                                            <th class="footable-sortable">Subscription Code</th>
                                            <th class="footable-sortable">Title</th>
                                            <th class="footable-sortable" width="300">Description</th>
                                            <th class="footable-sortable">Entry Days</th>
                                            <th class="footable-sortable">Entry Time</th>
                                            <th class="footable-sortable">Duration</th>
                                            <th class="footable-sortable">Price</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($subscription['data'] as $key => $subs) : ?>
                                            <tr>
                                                <td><?= $key + 1; ?></td>
                                                <td><?= $subs['plan_id']; ?></td>
                                                <td><?= $subs['title']; ?></td>
                                                <td><?= $subs['description']; ?></td>
                                                <td><?= $subs['entry_days']; ?></td>
                                                <td><?= $subs['entry_time']; ?></td>
                                                <td><?= $subs['days_duration']; ?></td>
                                                <td><?= $subs['price']; ?></td>
                                                <td><?= $subs['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                                                <td><a href="subscription-form.php?plan_id=<?= $subs['plan_id']; ?>" class="btn btn-sm btn-success">Update</a></td>
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
    