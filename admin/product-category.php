<?php require_once 'header.php'; ?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Product</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="product.php">Back to product list</a></li>
                    <li class="breadcrumb-item">Category</li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="alert alert-<?= $sess_mssg_type; ?> <?= !!$sess_result_flg ? 'd-block':'d-none'?>" role="alert">
                        <h4 class="alert-heading"><?= $sess_header; ?></h4>
                        <p><?= $sess_mssg; ?></p>
                    </div>

                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Add Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="../src/providers/CategorySave.php" method="POST">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-4">Category Name</label>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="category_name" required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Category List</h4>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list footable-loaded footable" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th class="footable-sortable">#</th>
                                            <th class="footable-sortable">Category</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($productCntrl->category() as $key => $data) : ?>
                                            <tr class="footable-even">
                                                <td><?= $key+1; ?></td>
                                                <td><?= $data['name']; ?></td>
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
    