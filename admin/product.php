<?php 
    require_once 'header.php'; 

    $product_code = isset($_GET['product_code']) ? $_GET['product_code'] : '';
    $category = isset($_GET['category']) ? $_GET['category'] : '';
    $price_min = isset($_GET['price_min']) ? $_GET['price_min'] : '';
    $price_max = isset($_GET['price_max']) ? $_GET['price_max'] : '';

    $search_params = array(
        'product_code' => $product_code,
        'category' => $category,
        'price_min' => $price_min,
        'price_max' => $price_max,
    );

    $product = $productCntrl->list($search_params);
?>
    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Product</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a class="btn btn-info btn-rounded" href="product-form.php">
                            <i class="mdi mdi-account-plus"></i>
                            Add Product
                        </a>
                    </li>
                </ol>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Search Product</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Product Code</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="product_code" value="<?= $product_code; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Category</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="category">
                                                <option selected value="">--</option>
                                                <?php foreach($productCntrl->category() as $data) : ?>
                                                    <option value="<?= $data['id']; ?>" <?= $category == $data['id'] ? 'selected': ''?>><?= $data['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Price Range</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" name="price_min" value="<?= $price_min; ?>">
                                        </div>
                                        <div class="text-center">~</div>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" name="price_max" value="<?= $price_max; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3"></label>
                                        <div class="col-md-9">
                                            <button class="btn btn-info btn-rounded pl-4 pr-4">Search</button>
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
                            <h4 class="card-title p-0 m-0">Product List</h4>
                            <small><i>Show results no. <?= $product['count']; ?></i></small>
                            <div class="table-responsive">
                                <table id="demo-foo-addrow" class="table m-t-30 table-hover contact-list footable-loaded footable" data-page-size="10">
                                    <thead>
                                        <tr>
                                            <th class="footable-sortable">#</th>
                                            <th class="footable-sortable">Product Code</th>
                                            <th class="footable-sortable">Product Name</th>
                                            <th class="footable-sortable">Category</th>
                                            <th class="footable-sortable">Quantity</th>
                                            <th class="footable-sortable">Price</th>
                                            <th class="footable-sortable">Status</th>
                                            <th class="footable-sortable">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($product['list'] as $key => $list) :?>
                                            <tr class="footable-even">
                                                <td><?= $key + 1; ?></td>
                                                <td><?= $list['product_code']; ?></td>
                                                <td>
                                                    <img src="../public/assets/image/product/<?= $list['product_photo']; ?>" > 
                                                    <?= $list['title']; ?>
                                                </td>
                                                <td><?= $list['category']; ?></td>
                                                <td class="text-center">
                                                    <span class="label label-info"><?= $list['quantity']; ?></span>
                                                </td>
                                                <td class="text-center">
                                                    <strong><?= number_format($list['price']); ?></strong>
                                                </td>
                                                <td>
                                                    <span class="label label-<?= $list['status'] == 'active' ? 'success':'danger'?>"><?= ucwords($list['status']); ?></span>
                                                </td>
                                                <td>
                                                    <a href="product-form.php?product_code=<?= $list['product_code']; ?>" class="btn btn-sm btn-outline-info">
                                                        <i class="mdi mdi-pencil"></i> Update
                                                    </a>
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
    </div>
<?php require_once 'footer.php'; ?>
    