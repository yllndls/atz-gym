<?php require_once 'header.php'; ?>
    <section class="page-category">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content auth_header">									
                        <div class="page-title">
                            <h3>REGISTER</h3>
                        </div>
                    </div>
                </div>

                <div class="container" ng-controller="GymUserController" ng-cloak="true">
                    <div class="row">
                        <div class="col-md-6">
                           <div class="card auth_box">
                                <div class="card_body">
                                <form ng-submit="registrationBtn()">
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <label for="fname">FIRSTNAME</label>
                                            <input type="text" class="form-control" id="fname" placeholder="Enter Firstname" name="fname" ng-model="user.fname" required/>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="lname">LASTNAME</label>
                                            <input type="text" class="form-control" id="lname" placeholder="Enter Lastname" name="lname" ng-model="user.lname" required/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_email">EMAIL</label>
                                        <input type="email" class="form-control" id="user_email" placeholder="Enter email" name="email" ng-model="user.email" required/>
                                        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_pass">PASSWORD</label>
                                        <input type="password" class="form-control" id="user_pass" minlength="8" maxlength="15" placeholder="Password" name="password" ng-model="user.password" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirm_pass">CONFIRM PASSWORD</label>
                                        <input type="password" class="form-control" id="confirm_pass" minlength="8" maxlength="15" placeholder="Confirm Password" name="confirm_password" ng-model="user.confirm_password" required/>
                                    </div>
                                    <br>
                                    <button type="submit" class="btn btn-danger">REGISTER</button>
                                </form>

                                </div>
                           </div>
                       </div>
                       <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </section>
    </section>
<?php require_once 'footer.php'; ?>