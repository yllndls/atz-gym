<?php require_once 'header.php'; ?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Membership</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="membership.php">Back to membership list</a></li>
                    <li class="breadcrumb-item">Form</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body wizard-content">
                            <h4 class="card-title">Membership Form</h4>
                            <h6 class="card-subtitle">Register new membership</h6>
                            <form action="#" class="tab-wizard wizard-circle">
                                <!-- Step 1 -->
                                <h6>Personal Info</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="firstName1">First Name :</label>
                                                <input type="text" class="form-control" id="firstName1" name="fname"> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="lastName1">Last Name :</label>
                                                <input type="text" class="form-control" id="lastName1" name="lname"> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="emailAddress1">Email Address :</label>
                                                <input type="email" class="form-control" id="emailAddress1" name="email"> </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="phoneNumber1">Phone Number :</label>
                                                <input type="tel" class="form-control" id="phoneNumber1" name="phone"> </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="location1">Select City :</label>
                                                <select class="custom-select form-control" id="location1" name="city">
                                                    <option value="">Select City</option>
                                                    <option value="Amsterdam">India</option>
                                                    <option value="Berlin">USA</option>
                                                    <option value="Frankfurt">Dubai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date1">Date of Birth :</label>
                                                <input type="date" class="form-control" id="date1" name="bdate">
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 2 -->
                                <h6>Job Status</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jobTitle1">Job Title :</label>
                                                <input type="text" class="form-control" id="jobTitle1" name="job">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="videoUrl1">Company Name :</label>
                                                <input type="text" class="form-control" id="videoUrl1" name="company">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="shortDescription1">Job Description :</label>
                                                <textarea name="shortDescription" id="shortDescription1" rows="6" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 3 -->
                                <h6>Interview</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="int1">Interview For :</label>
                                                <input type="text" class="form-control" id="int1" name="interview">
                                            </div>
                                            <div class="form-group">
                                                <label for="intType1">Interview Type :</label>
                                                <select class="custom-select form-control" id="intType1" data-placeholder="Type to search cities" name="intType1">
                                                    <option value="normal">Normal</option>
                                                    <option value="difficult">Difficult</option>
                                                    <option value="hard">Hard</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="Location1">Location :</label>
                                                <select class="custom-select form-control" id="Location1" name="location">
                                                    <option value="">Select City</option>
                                                    <option value="India">India</option>
                                                    <option value="USA">USA</option>
                                                    <option value="Dubai">Dubai</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="jobTitle2">Interview Date :</label>
                                                <input type="date" class="form-control" id="jobTitle2" name="idate">
                                            </div>
                                            <div class="form-group">
                                                <label>Requirements :</label>
                                                <div class="m-b-10">
                                                    <label class="custom-control custom-radio">
                                                        <input id="radio1" name="radio" type="radio" class="custom-control-input">
                                                        <span class="custom-control-label">Employee</span>
                                                    </label>
                                                    <label class="custom-control custom-radio">
                                                        <input id="radio2" name="radio" type="radio" class="custom-control-input">
                                                        <span class="custom-control-label">Contract</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                                <!-- Step 4 -->
                                <h6>Remark</h6>
                                <section>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="behName1">Behaviour :</label>
                                                <input type="text" class="form-control" id="behName1" name="beh">
                                            </div>
                                            <div class="form-group">
                                                <label for="participants1">Confidance</label>
                                                <input type="text" class="form-control" id="participants1" name="con">
                                            </div>
                                            <div class="form-group">
                                                <label for="participants1">Result</label>
                                                <select class="custom-select form-control" id="participants1" name="res">
                                                    <option value="">Select Result</option>
                                                    <option value="Selected">Selected</option>
                                                    <option value="Rejected">Rejected</option>
                                                    <option value="Call Second-time">Call Second-time</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="decisions1">Comments</label>
                                                <textarea name="decisions" id="decisions1" rows="4" class="form-control"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Rate Interviwer :</label>
                                                <div class="c-inputs-stacked">
                                                    <label class="inline custom-control custom-checkbox block">
                                                        <input type="checkbox" class="custom-control-input"> <span class="custom-control-label ml-0">1 star</span>
                                                    </label>
                                                    <label class="inline custom-control custom-checkbox block">
                                                        <input type="checkbox" class="custom-control-input"> <span class="custom-control-label ml-0">2 star</span>
                                                    </label>
                                                    <label class="inline custom-control custom-checkbox block">
                                                        <input type="checkbox" class="custom-control-input"> <span class="custom-control-label ml-0">3 star</span>
                                                    </label>
                                                    <label class="inline custom-control custom-checkbox block">
                                                        <input type="checkbox" class="custom-control-input"> <span class="custom-control-label ml-0">4 star</span>
                                                    </label>
                                                    <label class="inline custom-control custom-checkbox block">
                                                        <input type="checkbox" class="custom-control-input"> <span class="custom-control-label ml-0">5 star</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php require_once 'footer.php'; ?>
    