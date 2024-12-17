<?php 
    require_once 'header.php'; 

    $membership_code = isset($_GET['membership_code']) ? $_GET['membership_code'] : '';
    $membership_type = isset($_GET['membership_type']) ? $_GET['membership_type'] : '';
    $status = isset($_GET['status']) ? $_GET['status'] : '';

    $search_params = array(
        'membership_code' => $membership_code,
        'membership_type' => $membership_type,
        'status' => $status,
    );

    $membership_list = $membershipCntrl->admin_memberhsip_list($search_params);
?>
    <div class="page-wrapper" ng-controller="GymTransactionController" ng-cloak="true">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Membership</h3>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-7">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Search Membership</h4>
                        </div>
                        <div class="card-body">
                            <form action="" method="GET">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-5">Memberhip Code</label>
                                        <div class="col-md-7">
                                            <input type="text" class="form-control" name="membership_code">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-5">Memembership Type</label>
                                        <div class="col-md-7    ">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="membership_type" id="newly" value="2" <?= $membership_type == 1 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="newly">Newly</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="membership_type" id="renewal" value="1" <?= $membership_type == 2 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="renewal">Renewal</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-5">Membership Status</label>
                                        <div class="col-md-7">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status" id="ongoing" value="2" <?= $status == 2 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="ongoing">Ongoing</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" class="form-check-input" name="status" id="expired" value="1" <?= $status == 1 ? 'checked':''; ?>>
                                                <label class="form-check-label" for="expired">Expired</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Search</button>
                                            <a href="membership.php" class="btn btn-rounded pl-4 pr-4">Clear</a>
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
                                            <th class="footable-sortable">Name</th>
                                            <th class="footable-sortable">Membership Code</th>
                                            <th class="footable-sortable">Starting Date</th>
                                            <th class="footable-sortable">Expiration Date</th>
                                            <th class="footable-sortable">Payment Type</th>
                                            <th class="footable-sortable">Payment Status</th>
                                            <th class="footable-sortable"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($membership_list['data'] as $key => $list) :?>
                                            <tr class="footable-even <?= $list['is_expired_flg'] == EXPIRED_FLAG_ON ? 'bg_expired':'bg_ongoing'; ?>">
                                                <td><?= $key + 1; ?></td>
                                                <td>
                                                    <a href="javascript:void(0)">
                                                        <img src="../public/assets/image/profile/<?= $list['profile_img']; ?>" alt="user" class="img-circle" style="width:40px; height:40px;"> 
                                                        <?= $list['fname'].' '.$list['lname']; ?>
                                                    </a>
                                                </td>
                                                <td><?= $list['membership_code']?></td>
                                                <td><?= !empty($list['starting_date']) ? $list['starting_date'] : '--'; ?></td>
                                                <td><?= !empty($list['expiration_date']) ? $list['expiration_date'] : '--'; ?></td>
                                                <td><?= $list['pay_type']; ?></td>
                                                <td>
                                                    <?php if ($list['payment_status'] == PAYMENT_STATUS_PAID) : ?>
                                                        <span class="label label-success"><?= $list['pay_status']; ?></span>
                                                    <?php elseif ($list['payment_status'] == PAYMENT_STATUS_VERIFY) : ?>
                                                        <span class="label label-info"><?= $list['pay_status']; ?></span>
                                                    <?php else : ?>
                                                        <span class="label label-danger"><?= $list['pay_status']; ?></span>
                                                    <?php endif;  ?>
                                                </td>
                                                <td>
                                                    <?php if ($list['payment_status'] != PAYMENT_STATUS_PAID) : ?>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#checMembership" ng-click="membershipModal(<?= htmlspecialchars(json_encode($list)) ?>)">
                                                            <i class="mdi mdi-pencil"></i> For Verification 
                                                        </a>
                                                    <?php else : ?>
                                                        <a href="javascript:void(0)" class="btn btn-sm btn-primary"  data-toggle="modal" data-target="#membershipDetail" ng-click="membershipDetailModal(<?= htmlspecialchars(json_encode($list)) ?>)">
                                                            <i class="mdi mdi-history"></i> View History
                                                        </a>
                                                    <?php endif;  ?>
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
        
        <!-- FOR VERIFICATION MODAL -->
        <div class="modal fade" id="checMembership" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">MEMBERSHIP VERIFICATION</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-2 text-center">
                                                    <img ng-src="../public/assets/image/profile/{{ memberInfo.profile_img }}" alt="user" class="img-circle" style="width:50px; height:50px;">     
                                                </div>
                                                <div class="col-md-10">
                                                    <h5 class="m-0 p-0">{{ memberInfo.fname }} {{ memberInfo.lname }}</h5>
                                                    <small>{{ memberInfo.address }}</small><br/>
                                                    <code>{{ memberInfo.email }}</code><br/>
                                                    <code>{{ memberInfo.contact }}</code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card" ng-if="memberInfo.payment_type == 1">
                                    <div class="card-body">
                                        <div ng-if="memberInfo.receipt_img">
                                            <a href="../public/assets/image/receipt/{{ memberInfo.receipt_img }}" download="GCASH_RECEIPT_{{ memberInfo.transaction_code }}.jpg">
                                                <div class="row">
                                                    <div class="col-md-2 text-center">
                                                        <span class="mdi mdi-file-cloud" style="font-size:40px;"></span>
                                                    </div>
                                                    <div class="col-md-10">
                                                        <h5 class="m-0 p-0">GCash ~ Receipt</h5>
                                                        <p>{{ memberInfo.gcash_no }}</p>
                                                        <small>
                                                            <i class="mdi mdi-cloud-download"></i> 
                                                            Download receipt
                                                        </small>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div ng-if="memberInfo.reference_no">
                                            <h5>GCash ~ Reference No.</h5>
                                            <code>{{ memberInfo.reference_no }}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <form ng-submit="receivedMembershipTransaction()">
                                    <input type="hidden" name="membership_id" ng-model="selectedMembership.membership_id">
                                    <input type="hidden" name="received_by" value="<?= $_SESSION['user_id']?>">
                                    <div class="form-group">
                                        <label for="starting-date" class="control-label">Starting Date:</label>
                                        <input type="date" class="form-control border_error" id="starting-date" 
                                            ng-model="selectedMembership.starting_date" 
                                            ng-change="calculateExpirationDate()" required>
                                        <small ng-if="!!isPastDateFlg" class="text-danger">Starting date is in the past</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="expiration-date" class="control-label">Expiration Date:</label>
                                        <input type="date" class="form-control" id="expiration-date" 
                                            ng-model="selectedMembership.expiration_date" readonly required>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount-received" class="control-label">Amount to be received:</label>
                                        <input type="number" class="form-control" id="amount-received" 
                                            ng-model="selectedMembership.amount_received" readonly>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Received</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- MEMBERSHIP DETAILS -->
        <div class="modal fade" id="membershipDetail" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">MEMBERSHIP HISTORY</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-2 text-center">
                                                    <img ng-src="../public/assets/image/profile/{{ memberInfo.profile_img }}" alt="user" class="img-circle" style="width:50px; height:50px;">     
                                                </div>
                                                <div class="col-md-10">
                                                    <h5 class="m-0 p-0">{{ memberInfo.fname }} {{ memberInfo.lname }}</h5>
                                                    <small>{{ memberInfo.address }}</small><br/>
                                                    <code>{{ memberInfo.email }}</code><br/>
                                                    <code>{{ memberInfo.contact }}</code>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list footable-loaded footable" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th class="footable-sortable">#</th>
                                            <th class="footable-sortable">Membership Code</th>
                                            <th class="footable-sortable">Starting Date</th>
                                            <th class="footable-sortable">Expiration Date</th>
                                            <th class="footable-sortable">Membership Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="history in arr_history_data" ng-class="{'bg_expired': history.is_expired_flg == 1}">
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ history.membership_code }}</td>
                                            <td>{{ history.starting_date ? (history.starting_date | date:'yyyy-MM-dd') : '--' }}</td>
                                            <td>{{ history.expiration_date ? (history.expiration_date | date:'yyyy-MM-dd') : '--' }}</td>
                                            <td>
                                                <div ng-if="history.membership_status == 0" class="label label-success">Newly</div>
                                                <div ng-if="history.membership_status == 1" class="label label-primary">Renewal</div>
                                            </td>
                                        </tr>
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
    