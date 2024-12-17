<?php require_once 'header.php'; ?>
    <section class="page-product">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content">									
                        <div class="page-title">
                            <h3>Account Setting</h3>
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
                                <li class="home"><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
                                <li><span>/</span></li>
                                <li class="category-2"><a href="#">Account Settings</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-list" ng-controller="GymUserController" ng-cloak="true">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-<?= $sess_mssg_type == 'info' ? 'info':'danger'; ?> <?= !!$sess_result_flg ? 'show':'hide'; ?>">
                                <div class="panel-heading"><?= $sess_header; ?></div>
                                <div class="panel-body text-<?= $sess_mssg_type == 'info' ? 'info':'danger';?>"><?= $sess_mssg; ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="card auth_box verify_box <?= (isset($detail['is_verify_flg']) && $detail['is_verify_flg'] == 1) ? 'verify_box':'notverify_box'; ?>" style="padding: 2.5rem;">
                        <div class="card_Body">
                            <?php if (isset($detail['is_verify_flg']) && $detail['is_verify_flg'] == 1) : ?>
                                <div class="badge badge-verify">
                                    <i class="fa fa-certificate" aria-hidden="true"></i> VERIFIED PROFILE
                                </div>
                            <?php else : ?>
                                <div class="badge badge-notverify">
                                    <i class="fa fa-certificate" aria-hidden="true"></i> NOT VERIFY PROFILE
                                </div>
                            <?php endif;?>
                                    
                            <form action="src/providers/UpdateDetail.php" method="POST" enctype="multipart/form-data">
                                <br>
                                <input type="hidden" name="user_id" value="<?= isset($detail['id']) ? $detail['id'] : '';?>">
                                <input type="hidden" name="is_profile_flg" value="<?= isset($detail['is_profile_flg']) ? $detail['is_profile_flg'] : '';?>">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="fname">FIRSTNAME</label>
                                            <input type="text" class="form-control" id="fname" placeholder="Enter Firstname" name="fname" value="<?= !empty($detail['fname']) ? $detail['fname'] : '';?>" required/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lname">LASTNAME</label>
                                            <input type="text" class="form-control" id="lname" placeholder="Enter Lastname" name="lname" value="<?= !empty($detail['lname']) ? $detail['lname'] : '';?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="gender">GENDER</label>
                                            <select class="form-control" name="gender" required>
                                                <option selected value="">--</option>
                                                <option value="male" <?= !empty($detail['gender']) && $detail['gender'] == 'male' ? 'selected' : '';?>>Male</option>
                                                <option value="female" <?= !empty($detail['gender']) && $detail['gender'] == 'female' ? 'selected' : '';?>>Female</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="bday">BIRTHDATE</label>
                                            <input type="date" class="form-control" id="bday" name="bday" value="<?= !empty($detail['bday']) ? $detail['bday'] : '';?>" required/>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="contact">CONTACT</label>
                                            <input type="text" class="form-control" id="contact" placeholder="Enter Contact" name="contact" value="<?= !empty($detail['contact']) ? $detail['contact'] : '';?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="address">ADDRESS</label>
                                            <input type="text" class="form-control" id="address" placeholder="Street, Barangay, Municipality/City" name="address" value="<?= !empty($detail['address']) ? $detail['address'] : '';?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="profile">UPLOAD PROFILE</label>
                                    <div id="imagePreview">
                                        <img id="previewImg" src="public/assets/image/profile/<?= isset($detail['profile_img']) ? $detail['profile_img'] : 'default.png';?>" alt="Image Preview"/>
                                    </div>
                                    <input type="file" id="profile" class="dropify" name="tmp_file" accept=".jpg, .jpeg, .png, .gif" onchange="previewImage(event)"/>
                                </div>
                                <div class="clearfix"></div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-danger">UPDATE</button>
                                </div>
                                <br/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php require_once 'footer.php'; ?>