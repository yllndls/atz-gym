<?php
    include_once 'config/helpers.php';
    include_once 'TmpFileController.php';

    class ProductController extends Helpers {

        public function category() {
            try {
                // - SQL statement
                $query = "SELECT * FROM product_category ORDER BY id DESC";

                // - fetch data
                $data = $this->find_array($query);

                // - return data
                return $data;
 
            } catch (\Exception $e) {
                return $e;
            }
        }

        public function createCategory($params){
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $sql = "INSERT INTO product_category(name) VALUES ('$params[category_name]')";

                // - SQL save data
                $save = $this->save_data($sql);
                $return_data['success'] = $save;
    
            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function list($params) {
            $return_data = array();

            try {
                $where_condition = array();

                // - search category
                if (!empty($params['category'])) {
                    $where_condition[] = "category.id = '". $params['category'] ."'";
                }

                // - search product code
                if (!empty($params['product_code'])) {
                    $where_condition[] = "product.product_code = '". $params['product_code'] ."'";
                }

                // - search price min
                if (!empty($params['price_min'])) {
                    $where_condition[] = "product.price >= '". $params['price_min'] ."'";
                }

                // - search price max
                if (!empty($params['price_max'])) {
                    $where_condition[] = "product.price <= '". $params['price_max'] ."'";
                }

                // - search status
                if (!empty($params['status'])) {
                    $where_condition[] = "product.status <= '". $params['status'] ."'";
                }

                // - search status
                if (!empty($params['title'])) {
                    $where_condition[] = "product.title LIKE '%". $params['title'] ."%'";
                }

                // - SQL statements
                $query = "SELECT
                            product.id,
                            product.product_code,
                            product.title,
                            product.description,
                            product.quantity,
                            product.price,
                            product.created,
                            category.id AS category_id,
                            category.name AS category,
                            (CASE
                                WHEN photo.filename IS NOT NULL
                                THEN photo.filename
                                ELSE 'default-product.jpg'
                            END) AS product_photo,
                            (CASE
                                WHEN product.status = '". PRDCT_STATUS_ON_FLG ."'
                                THEN 'active'
                                ELSE 'inactive'
                            END) AS status
                        FROM products product
                        LEFT JOIN product_category category ON category.id = product.category_id
                        LEFT JOIN tmp_uploads photo ON photo.resources_id = product.id AND photo.resources = 'product'";

                // - SQL where condition
                if (!empty($where_condition)) {
                    $query .= " WHERE " . implode(" AND ", $where_condition);
                }

                // - SQL ordering
                $query .= " ORDER BY product.created DESC ";

                // - SQL limit
                if (!empty($params['limit'])) {
                    $query .= "LIMIT " . $params['limit'];
                }

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                // - return data
                $return_data = array(
                    'succcess' => true,
                    'list' => $data,
                    'count' => $data_count
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function create($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - generate code
                $params['product_code'] = $this->generateCode();

                // - SQL statement
                $sql = "INSERT INTO products(
                            category_id, 
                            product_code, 
                            title, 
                            description, 
                            quantity, 
                            price,
                            status
                        ) 
                        VALUES (
                            '$params[category]',
                            '$params[product_code]',
                            '$params[product_name]',
                            '$params[descript]',
                            $params[quantity],
                            $params[price],
                            '". PRDCT_STATUS_ON_FLG ."'
                        );";

                // - SQL save data
                $save = $this->save_data($sql);

                if (!!$save) {
                    $resources_id = $this->find_current_id();
                    $datas = array(
                        'file' => $params['file'],
                        'resources_id' => $resources_id,
                        'resources' => TMP_UPLOAD_PRODUCT,
                    );

                    // - upload photo
                    $uploadCntrl = new TmpFileController();
                    $result = $uploadCntrl->tmp_file($datas);

                    $return_data['success'] = $result;
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function update($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {  

                $sql = "UPDATE 
                            products 
                        SET 
                            category_id = $params[category], 
                            title = '$params[product_name]', 
                            description = '$params[descript]', 
                            quantity = $params[quantity], 
                            price = $params[price]
                        WHERE 
                            id = $params[product_id]";

                $updated = $this->save_data($sql);

                if (!!$updated) {
                    if (!empty($params['file']['name'])) {
                        $datas = array(
                            'file' => $params['file'],
                            'resources_id' => $params['product_id'],
                            'resources' => TMP_UPLOAD_PRODUCT,
                            'is_update_flg' => true
                        );

                         // - update uploaded photo
                        $uploadCntrl = new TmpFileController();
                        $result = $uploadCntrl->tmp_file($datas);

                        $return_data['success'] = $result;
                    }
                }


            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function generateCode() {
            // - init code & char params
            $productCode = '';
            $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

            // - generate random char
            for ($i = 0; $i < 4; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $productCode .= $characters[$index];
            }

            // - get date (MM/DD)
            $datePart = date('md');

            // - return code
            return $productCode . $datePart;
        }

        public function cart_list($user_id) {
            // - init result param
            $return_data = array(
                'success' => false
            );
            
            try {

                $query = "SELECT 
                            cart.*,
                            product.product_code,
                            product.title,
                            (CASE
                                WHEN photo.filename IS NOT NULL
                                THEN photo.filename
                                ELSE 'default-product.jpg'
                            END) AS product_photo,
                            product.quantity AS product_qty
                        FROM cart
                        LEFT JOIN products product ON product.id = cart.product_id
                        LEFT JOIN tmp_uploads photo ON photo.resources_id = product.id AND photo.resources = 'product'
                        WHERE cart.user_id = $user_id
                        ORDER BY cart.id DESC";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count,
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function cart_added($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $sql = "INSERT INTO cart(
                            user_id, 
                            product_id, 
                            price, 
                            quantity
                        ) 
                        VALUES (
                            '$params[user_id]',
                            '$params[product_id]',
                            '$params[price]',
                            '$params[quantity]'
                        );";

                // - SQL save data
                $save = $this->save_data($sql);

                if (!!$save) {
                    $return_data['success'] = true;
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function cart_validate($user_id, $product_id) {
            // - init result param
            $return_data = array(
                'success' => false
            );
            
            try {

                $query = "SELECT * FROM cart WHERE user_id = $user_id AND product_id = $product_id";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count,
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function cart_update($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $query = "UPDATE cart SET quantity = $params[quantity] WHERE user_id = $params[user_id] AND product_id = $params[product_id]";

                // - save datas
                $updated = $this->save_data($query);

                $return_data['success'] = $updated;


            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function cart_remove($cart_id) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $query = "DELETE FROM cart WHERE id = $cart_id";

                // - save datas
                $updated = $this->save_data($query);

                $return_data['success'] = $updated;


            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function order_added($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $sql = "INSERT INTO orders(
                            user_id, 
                            product_id, 
                            price, 
                            quantity,
                            order_code,
                            order_status,
                            payment_status
                        ) 
                        VALUES (
                            '$params[user_id]',
                            '$params[product_id]',
                            '$params[price]',
                            '$params[quantity]',
                            '$params[order_code]',
                            '$params[order_status]',
                            '$params[payment_status]'
                        );";

                // - SQL save data
                $save = $this->save_data($sql);

                if (!!$save) {
                    $return_data = array(
                        'success' => true
                    );
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function update_product_quantity($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $query = "UPDATE products SET quantity = $params[quantity] WHERE id = $params[product_id]";

                // - save datas
                $updated = $this->save_data($query);

                $return_data['success'] = $updated;

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function order_lists($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );
            
            try {

                $where_condition = [];

                // - search transaction code
                if (!empty($params['user_id'])) {
                    $where_condition[] = "orders.user_id = $params[user_id]";
                }

                if (!empty($params['order_code'])) {
                    $where_condition[] = "orders.order_code = '". $params['order_code'] ."'";
                }

                if (!empty($params['order_status'])) {
                    $where_condition[] = "orders.order_status = $params[order_status]";
                }

                $query = "SELECT 
                            orders.order_code, 
                            orders.user_id, 
                            orders.product_id,
                            orders.created,
                            SUM(orders.quantity) AS total_quantity, 
                            SUM(orders.price) AS total_price, 
                            (CASE 
                                WHEN orders.order_status = 1 THEN 'To Prepare'
                                WHEN orders.order_status = 2 THEN 'To Pickup'
                                WHEN orders.order_status = 3 THEN 'Completed'
                                WHEN orders.order_status = 4 THEN 'Cancelled'
                                ELSE null
                            END) AS order_status,
                            orders.order_status AS order_stats_num,
                            (CASE 
                                WHEN orders.payment_status = 0 THEN 'Unpaid'
                                WHEN orders.payment_status = 1 THEN 'For Validation'
                                WHEN orders.payment_status = 2 THEN 'Paid'
                                ELSE null
                            END) AS payment_status,
                            user.fname,
                            user.lname,
                            user.address,
                            user.email,
                            user.contact,
                            (
                            CASE 
                                WHEN profile.filename IS NOT NULL 
                                THEN profile.filename
                                ELSE 'default.jpg'
                            END 
                            ) AS profile_img,
                            transac.receipt_img,
                            transac.reference_no,
                            transac.payment_type,
                            transac.gcash_no
                        FROM orders
                        INNER JOIN users user ON user.id = orders.user_id
                        LEFT JOIN tmp_uploads profile ON profile.resources_id = user.id AND profile.resources = 'profile'
                        LEFT JOIN transactions transac ON transac.order_code = orders.order_code";

                    // - SQL where condition
                    if (!empty($where_condition)) {
                        $query .= " WHERE " . implode(" AND ", $where_condition);
                    }

                    $query .= " GROUP BY 
                                    orders.order_code, 
                                    orders.user_id
                                ORDER BY 
                                    orders.created DESC";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count,
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function order_details($order_code) {
           // - init result param
           $return_data = array(
                'success' => false
            );
            
            try {

                $query = "SELECT 
                            orders.id,
                            orders.order_code,
                            orders.product_id,
                            orders.quantity,
                            orders.price,
                            orders.order_status,
                            orders.payment_status,
                            products.product_code,
                            products.title,
                            (CASE
                                WHEN photo.filename IS NOT NULL
                                THEN photo.filename
                                ELSE 'default-product.jpg'
                            END) AS product_photo
                        FROM orders
                        LEFT JOIN products ON products.id = orders.product_id
                        LEFT JOIN tmp_uploads photo ON photo.resources_id = products.id AND photo.resources = 'product'
                        WHERE 
                            orders.order_code = '". $order_code ."'
                        ORDER BY orders.created DESC";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count,
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data; 
        }

        public function update_order_status($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $query = "UPDATE orders SET order_status = $params[order_status], payment_status = $params[payment_status]  WHERE order_code = '". $params['order_code'] ."'";

                // - save datas
                $updated = $this->save_data($query);

                $return_data['success'] = $updated;

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }
    }

?>