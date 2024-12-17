<?php 
    require_once 'header.php'; 

	$membership_data = array();
	$membership_count = 0;
	$membership_result = $membershipCntrl->user_membership_list($user_id);
	if (!!$membership_result['success']) {
		$membership_data = $membership_result['data'];
		$membership_count = $membership_result['total_count'];
	}
?>
    <section class="page-category">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content slide-container">									
                        <div class="page-title">
                            <h3>MY PLAN</h3>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="page-content">					
            <!-- Breadcrumbs -->
            <div class="breadcrumbs">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <ul>
                                <li class="home"><a href="#"><i class="fa fa-home"></i> Home</a></li>
                                <li><span>/</span></li>
                                <li class="category-2"><a href="#">My Plan</a></li>								
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <section class="price-table">
                <div class="container">
                    <div class="row">
                        <?php  if ($membership_count > 0) :  ?>
                            <div class="col-md-12">
                                <table class="table table-bordered table-dark">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Membership Code</th>
                                            <th scope="col">Starting Date</th>
                                            <th scope="col">Expiration Date</th>
                                            <th scope="col">Membership Type</th>
                                            <th scope="col">Payment Type</th>
                                            <th scope="col">Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($membership_data as $key => $member) : ?>
                                            <tr class="<?= $member['is_expired_flg'] == EXPIRED_FLAG_ON ? 'bg-expired':'bg-dark'; ?>">
                                                <td><?= $key+1; ?></td>
                                                <td><?= $member['membership_code']; ?></td>
                                                <td><?= !empty($member['starting_date']) ? $member['starting_date'] : '--'; ?></td>
                                                <td><?= !empty($member['expiration_date']) ? $member['expiration_date'] : '--'; ?></td>
                                                <td><?= $member['membership_status']; ?></td>
                                                <td><?= $member['pay_type']; ?></td>
                                                <td><?= $member['pay_status']; ?></td>
                                            </tr>
                                            <?php if (empty($member['starting_date']) && empty($member['expiration_date'])) : ?>
                                                <tr class="alert alert-info">
                                                    <td colspan="7" class="text-center">
                                                        <span>To activate your membership, please visit our facilities. Your starting date will be scheduled based on your availability.</span>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else : ?>
                            <div class="text-center">
                                <h2>NO DATA FOUND</h2>
                                <br/>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </section>			
        </div>
    </section>
<?php require_once 'footer.php'; ?>