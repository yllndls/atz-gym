<?php 
    require_once 'header.php'; 
    include_once '../src/DashboardController.php';
    $dashboardCntrl = new DashboardController();

    $countUser = $dashboardCntrl->countUsers();
    $countActiveMembership = $dashboardCntrl->countActiveMembership();

    $countCheckout = $dashboardCntrl->countOrders(1);
    $countPickup = $dashboardCntrl->countOrders(2);
    $countCompleted = $dashboardCntrl->countOrders(3);
    $countCancelled = $dashboardCntrl->countOrders(4);

    $totalProductEarn = $dashboardCntrl->totalEarnings('product');
    $totalMemberEarn = $dashboardCntrl->totalEarnings('membership');
?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Dashboard</h3>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <h2>User Stats</h2>
                <div class="col-md-12">
                    <div class="card-group">
                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-account-multiple-outline text-success"></i></h2>
                                        <h3 class=""><?= $countUser['total_count']; ?></h3>
                                        <h6 class="card-subtitle">Total Users</h6></div>
                                </div>
                            </div>
                        </div>

                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-account-multiple-outline text-info"></i></h2>
                                        <h3 class=""><?= $countActiveMembership['total_count']; ?></h3>
                                        <h6 class="card-subtitle">Total Membership (Active)</h6></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Orders Stats</h2>
                <div class="col-md-12">
                    <div class="card-group">
                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-shopping text-warning"></i></h2>
                                        <h3 class=""><?= $countCheckout['total_count']; ?></h3>
                                        <h6 class="card-subtitle">Total Checkout Orders</h6></div>
                                </div>
                            </div>
                        </div>

                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-shopping text-info"></i></h2>
                                        <h3 class=""><?= $countPickup['total_count']; ?></h3>
                                        <h6 class="card-subtitle">Total Pick Up Orders</h6></div>
                                </div>
                            </div>
                        </div>

                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-shopping text-success"></i></h2>
                                        <h3 class=""><?= $countCompleted['total_count']; ?></h3>
                                        <h6 class="card-subtitle">Total Completed Orders</h6></div>
                                </div>
                            </div>
                        </div>

                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-shopping text-danger"></i></h2>
                                        <h3 class=""><?= $countCancelled['total_count']; ?></h3>
                                        <h6 class="card-subtitle">Total Cancelled Orders</h6></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h2>Earnings Stats</h2>
                <div class="col-md-12">
                    <div class="card-group">
                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-wallet text-purple"></i></h2>
                                        <h3 class=""><?= $totalProductEarn['earning']['total_earnings']; ?></h3>
                                        <h6 class="card-subtitle">Total Product Earnings</h6></div>
                                </div>
                            </div>
                        </div>

                        <div class="card col-3">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <h2 class="m-b-0"><i class="mdi mdi-wallet text-warning"></i></h2>
                                        <h3 class=""><?= $totalMemberEarn['earning']['total_earnings']; ?></h3>
                                        <h6 class="card-subtitle">Total Membership Earnings</h6></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'footer.php'; ?>
    