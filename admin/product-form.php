<?php 
    require_once 'header.php'; 

    // - init form flag
    $formSaveFlag = FORM_FLAG_SAVE;

    // - set product detail
    if (isset($_GET['product_code'])) {
        $formSaveFlag = FORM_FLAG_EDIT;
        $search_params['product_code'] = $_GET['product_code'];
        $product = $productCntrl->list($search_params);
        
        $detail = isset($product['list'][0]) ? $product['list'][0] : array();  
    }

    // - image path
    $imagePath = isset($detail['product_photo']) ? '../public/assets/image/product/' . $detail['product_photo'] : '';
?>

    <div class="page-wrapper">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h3 class="text-themecolor">Product</h3>
            </div>
            <div class="col-md-7 align-self-center">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="product.php">Back to product list</a></li>
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
    
            <div class="col-md-12">
                <form action="../src/providers/ProductSave.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $formSaveFlag; ?>" name="form_saving_flg">
                    <input type="hidden" value="<?= isset($detail['id']) ?  $detail['id'] : ''; ?>" name="product_id">
                    <input type="hidden" value="<?= isset($detail['product_code']) ?  $detail['product_code'] : ''; ?>" name="product_code">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white">Product Form</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-7">
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Product Name</label>
                                        <div class="col-md-9">
                                            <input type="text" class="form-control" name="product_name" value="<?= isset($detail['title']) ?  $detail['title'] : ''; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Category</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="category" required>
                                                <option selected value="">--</option>
                                                <?php foreach($productCntrl->category() as $data) : ?>
                                                    <option value="<?= $data['id']; ?>" <?= isset($detail['category_id']) && $detail['category_id'] == $data['id'] ? 'selected':''; ?>><?= $data['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="10" name='description' placeholder="Enter description" required><?= isset($detail['description']) ?  $detail['description'] : ''; ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Quantity</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" min="1" name="quantity" value="<?= isset($detail['quantity']) ?  $detail['quantity'] : ''; ?>" required/>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="control-label col-md-3">Price</label>
                                        <div class="col-md-4">
                                            <input type="number" class="form-control" min="1" name="price" value="<?= isset($detail['price']) ?  $detail['price'] : ''; ?>"   required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="input-file-now">Upload Photo</label>
                                    <div class="dropify-wrapper dropify-main">
                                        <div class="dropify-message">
                                            <p>Drag and drop a file here or click</p>
                                            <p class="dropify-error">Ooops, something wrong appended.</p>
                                        </div>
                                        <div class="dropify-infos-inner"></div>
                                        <input type="file" id="input-file-now" class="dropify" name="tmp_file" accept=".jpg, .jpeg, .png, .gif" data-default-file="<?= $imagePath ?>"   <?= $formSaveFlag !== FORM_FLAG_EDIT ? 'required':'';?>>
                                        <button type="button" class="dropify-clear">Remove</button>
                                        <div class="dropify-preview">
                                            <span class="dropify-render"></span>
                                            <div class="dropify-infos">
                                                <div class="dropify-infos-inner">
                                                    <p class="dropify-infos-message">Drag and drop or click to replace</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
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
    