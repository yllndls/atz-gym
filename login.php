<?php require_once 'header.php'; ?>
    <section class="page-category">
        <section class="page-heading">
            <div class="title-slide">
                <div class="container">
                    <div class="banner-content auth_header">									
                        <div class="page-title">
                            <h3>LOGIN</h3>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="panel panel-danger <?= !!$sess_result_flg ? 'show':'hide'; ?>">
                                <div class="panel-heading"><?= $sess_header; ?></div>
                                <div class="panel-body text-danger"><?= $sess_mssg; ?></div>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-md-6">
                           <div class="card auth_box">
                                <div class="card_body">
                                    <form method="POST" action="src/providers/Login.php">
                                        <input type="hidden" name="type_id" value="2">
                                        <div class="form-group">
                                            <label for="user_email">EMAIL</label>
                                            <input type="email" class="form-control" id="user_email" placeholder="Enter email" name="email" required/>
                                            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                        </div>
                                        <div class="form-group">
                                            <label for="user_pass">PASSWORD</label>
                                            <input type="password" class="form-control" id="user_pass" placeholder="Password" name="password" required/>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                            <label class="form-check-label" for="exampleCheck1">Remember Me</label>
                                        </div>
                                        <button type="submit" class="btn btn-danger" type="submit" name="login">LOGIN</button>
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