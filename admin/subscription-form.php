<?php 
    require_once 'header.php'; 

    $is_upldated_flg = FORM_FLAG_SAVE;
    if (isset($_GET['plan_id']) && !empty($_GET['plan_id'])) {
        $is_upldated_flg = FORM_FLAG_EDIT;
        $params = array(
            'plan_id' => $_GET['plan_id'],
        );
        $subscription = $membershipCntrl->membership_info($params);

        $detail = isset($subscription['data'][0]) ? $subscription['data'][0] : array(); 
    }
?>

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Subscription</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="subscription.php">Back to Subscription list</a></li>
                    <li class="breadcrumb-item">Form</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="col-md-12">
                <div class="alert alert-<?= $sess_mssg_type; ?> <?= !!$sess_result_flg ? 'd-block':'d-none'?>" role="alert">
                    <h4 class="alert-heading"><?= $sess_header; ?></h4>
                    <p><?= $sess_mssg; ?></p>
                </div>
            </div>
    
            <div class="col-md-6">
                <form action="../src/providers/SubscriptionSave.php" method="POST" >
                   <input type="hidden" name="is_update_flg" value="<?= $is_upldated_flg; ?>">
                   <input type="hidden" name="plan_id" value="<?= isset($detail['plan_id']) ? $detail['plan_id'] : ''; ?>">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Subscription Form</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Title</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="title" value="<?= isset($detail['title']) ?  $detail['title'] : ''; ?>"  required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="10" name='description'><?= isset($detail['description']) ?  $detail['description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <?php
                                                    $weekdays = ["MON", "TUE", "WED", "THU", "FRI", "SAT", "SUN"];

                                                    $entry_days = isset($detail['entry_days']) ? $detail['entry_days'] : '';
                                                    $days = explode("~", $entry_days);

                                                    $day_from = isset($days[0]) ? trim($days[0]) : '';
                                                    $day_to = isset($days[1]) ? trim($days[1]) : '';
                                                ?>
                                                <label class="control-label col-md-3">Entry Days</label>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="days_from" required>
                                                        <option selected value="">--</option>
                                                        <?php foreach ($weekdays as $day): ?>
                                                            <option value="<?php echo $day; ?>" <?php echo ($day === $day_from) ? 'selected' : ''; ?>>
                                                                <?php echo $day; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <col-md-1>~</col-md-1>
                                                <div class="col-md-4">
                                                    <select class="form-control" name="days_to" required>
                                                        <option selected value="">--</option>
                                                        <?php foreach ($weekdays as $day): ?>
                                                            <option value="<?php echo $day; ?>" <?php echo ($day === $day_to) ? 'selected' : ''; ?>>
                                                                <?php echo $day; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <?php 
                                                    $entry_time = isset($detail['entry_time']) ? $detail['entry_time'] : '';
                                                    $time = explode("~", $entry_time);

                                                    $time_from = isset($time[0]) ? $time[0] : '';
                                                    $time_to = isset($time[1]) ? $time[1] : '';
                                                ?>
                                                <label class="control-label col-md-3">Entry Time</label>
                                                <div class="col-md-4">
                                                    <input type="time" class="form-control" name="time_from" value="<?= isset($time_from) ? $time_from : ''; ?>" required/>
                                                </div>
                                                <col-md-1>~</col-md-1>
                                                <div class="col-md-4">
                                                    <input type="time" class="form-control" name="time_to" value="<?= isset($time_to) ? $time_to : ''; ?>" required/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Days Duration</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" min="1" name="days_duration" value="<?= isset($detail['days_duration']) ?  $detail['days_duration'] : ''; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Price</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" min="1" name="price" value="<?= isset($detail['price']) ?  $detail['price'] : ''; ?>" required/>
                                        </div>
                                    </div>
                                    <?php if (isset($_GET['plan_id'])) : ?>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Status</label>
                                            <div class="col-md-4">
                                                <select class="form-control" name="status" required>
                                                    <option selected value="">--</option>
                                                    <option value="1" <?= isset($detail['status']) && $detail['status'] == 1 ? 'selected':''; ?>>Active</option>
                                                    <option value="0" <?= isset($detail['status']) && $detail['status'] == 0 ? 'selected':''; ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php require_once 'footer.php'; ?>
    