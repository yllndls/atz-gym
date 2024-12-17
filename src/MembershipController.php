<?php
    include_once 'config/helpers.php';
    include_once 'UserController.php';

    class MembershipController extends Helpers {

        public function membership_info($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                $where_condition = array();

                // - search status
                if (!empty($params['status'])) {
                    $status = $params['status'] == 2 ? 0 : 1;
                    $where_condition[] = "status = $params[status]";
                }

                if (!empty($params['plan_id'])) {
                    $where_condition[] = "plan_id = '".$params['plan_id']."'";
                }

                // - SQL Statements
                $query = "SELECT * FROM membership_plan";

                // - SQL where condition
                if (!empty($where_condition)) {
                    $query .= " WHERE " . implode(" AND ", $where_condition);
                }

                $query .=" ORDER BY id DESC";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
            
        }

        public function membership($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                $where_condition = array();

                // - search user_id
                if (isset($params['user_id'])) {
                    $where_condition[] = "user_id = $params[user_id]";
                }

                // - search user_id
                if (isset($params['is_expired_flg'])) {
                    $where_condition[] = "is_expired_flg = $params[is_expired_flg]";
                }

                // - SQL Statements
                $query = "SELECT * FROM membership";

                // - SQL where condition
                if (!empty($where_condition)) {
                    $query .= " WHERE " . implode(" AND ", $where_condition);
                }

                $query .=" ORDER BY id DESC";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function create_membership($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $sql = "INSERT INTO membership(
                            user_id, 
                            membership_plan_id, 
                            membership_code, 
                            membership_status, 
                            payment_status,
                            is_expired_flg
                        ) VALUES (
                            $params[user_id],
                            '$params[plan_id]',
                            '$params[membership_code]',
                            $params[membership_status],
                            '$params[payment_status]',
                            $params[is_expired_flg]
                        )";

                // - SQL save data
                $save = $this->save_data($sql);

                if (!!$save) {
                    // - update member status
                    $update_params = array(
                        'user_id' => $params['user_id'],
                        'is_membership_flg' => $params['membership_flg'],
                    );
                    $userCntrl = new UserController();
                    $update_member_flg = $userCntrl->update($update_params);

                    $return_data = array(
                        'success' => $update_member_flg['success'],
                        'membership_id' => $this->find_current_id()
                    );
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function generate_membership_code() {
            $random_str = strtoupper(substr(bin2hex(random_bytes(3)), 0, 3));
            $random_digits = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $membership_code = "MBRSHP_" . $random_str . $random_digits;
    
            return $membership_code;
        }

        public function user_membership_list($user_id) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL Statements
                $query = "SELECT
                            membr.id,
                            membr.user_id,
                            membr.starting_date,
                            membr.expiration_date,
                            membr.membership_code,
                            (
                                CASE 
                                    WHEN membr.payment_status = 0 THEN 'Unpaid'
                                    WHEN membr.payment_status = 1 THEN 'For Verification'
                                    WHEN membr.payment_status = 2 THEN 'Paid'
                                END
                            ) AS pay_status,
                            (
                                CASE 
                                    WHEN membr.membership_status = 0
                                    THEN 'Newly'
                                    ELSE 'Renewal'
                                END
                            ) AS membership_status,
                            membr.is_expired_flg,
                            (
                                CASE 
                                    WHEN transac.payment_type = 0
                                    THEN 'Pay at counter'
                                    ELSE 'GCash'
                                END
                            ) AS pay_type,
                            transac.*
                        FROM membership membr
                        INNER JOIN transactions transac ON transac.order_code = membr.id AND transac.order_type = 'membership'
                        WHERE membr.user_id = $user_id
                        ORDER BY membr.id DESC";
  
                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function user_latest_membership($user_id) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL Statements
                $query = "SELECT * FROM membership WHERE user_id = $user_id ORDER BY id DESC LIMIT 1";

                // - fetch data
                $find_one = $this->find_one($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $find_one,
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;  
        }

        public function admin_memberhsip_list($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                $where_condition = array();

                // - search membership code
                if (!empty($params['membership_code'])) {
                    $where_condition[] = "membr.membership_code = '". $params['membership_code'] ."'";
                }

                // - search membership code
                if (!empty($params['membership_type'])) {
                    $membership_status = $params['membership_type'] == 1 ? 1 : 0;
                    $where_condition[] = "membr.membership_status = $membership_status";
                }

                // - search membership code
                if (!empty($params['status'])) {
                    $expired_flg = $params['status'] == 1 ? 1 : 0;
                    $where_condition[] = "membr.is_expired_flg = $expired_flg";
                }

                // - SQL Statements
                $query = "SELECT
                            membr.id AS membership_id,
                            membr.user_id,
                            membr.starting_date,
                            membr.expiration_date,
                            membr.membership_code,
                            membr.is_expired_flg,
                            (
                                CASE 
                                    WHEN membr.membership_status = 0
                                    THEN 'Newly'
                                    ELSE 'Renewal'
                                END
                            ) AS membership_status,
                            (
                                CASE 
                                    WHEN membr.payment_status = 0 THEN 'Unpaid'
                                    WHEN membr.payment_status = 1 THEN 'For Verification'
                                    WHEN membr.payment_status = 2 THEN 'Paid'
                                END
                            ) AS pay_status,
                            (
                                CASE 
                                    WHEN transac.payment_type = 0
                                    THEN 'Pay at counter'
                                    ELSE 'GCash'
                                END
                            ) AS pay_type,
                            transac.transaction_code,
                            transac.order_code,
                            transac.order_type,
                            transac.receipt_img,
                            transac.reference_no,
                            transac.payment_type,
                            transac.payment_status,
                            transac.amount,
                            transac.gcash_no,
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
                            plan.days_duration
                        FROM membership membr
                        INNER JOIN (
                            SELECT user_id, MAX(id) AS latest_id
                            FROM membership
                            GROUP BY user_id
                        ) latest_membr ON membr.id = latest_membr.latest_id
                        INNER JOIN membership_plan plan ON plan.plan_id = membr.membership_plan_id
                        INNER JOIN transactions transac ON transac.order_code = membr.id AND transac.order_type = 'membership'
                        INNER JOIN users user ON user.id = membr.user_id
                        LEFT JOIN tmp_uploads profile ON user.id = profile.resources_id AND profile.resources = 'profile'";

                // - SQL where condition
                if (!empty($where_condition)) {
                    $query .= " WHERE " . implode(" AND ", $where_condition);
                }

                // - SQL ordering
                $query .= " ORDER BY membr.id DESC ";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data; 
        }

        public function update_membership($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - init set clause
                $set_clauses = [];

                // - set start date
                if (isset($params['starting_date'])) {
                    $set_clauses[] = "starting_date = '".$params['starting_date']."'";
                }

                // - set expired date
                if (isset($params['expiration_date'])) {
                    $set_clauses[] = "expiration_date = '".$params['expiration_date']."'";
                }

                // - set payment_status
                if (isset($params['payment_status'])) {
                    $set_clauses[] = "payment_status = '".$params['payment_status']."'";
                }

                // - set expired flag
                if (isset($params['is_expired_flg'])) {
                    $set_clauses[] = "is_expired_flg = '".$params['is_expired_flg']."'";
                }

                // - implode set clause
                $set_clause = implode(", ", $set_clauses);

                // - SQL statement
                $query = "UPDATE membership SET $set_clause WHERE id = $params[membership_id]";

                // - save datas
                $updated = $this->save_data($query);

                $return_data['success'] = $updated;


            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function membership_history($user_id) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL Statements
                $query = "SELECT * FROM membership WHERE user_id = $user_id ORDER BY id DESC";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function expired_membership($expired_date) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL Statements
                $query = "SELECT * FROM membership WHERE expiration_date = '". $expired_date ."' AND is_expired_flg = 0";

                // - count & fetch data
                $data_count = $this->search_num($query);
                $data = $this->find_array($query);

                $return_data = array(
                    'success' => true,
                    'data' =>  $data,
                    'total_count' => $data_count
                );

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }


        public function create_subscription($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $sql = "INSERT INTO membership_plan(
                            plan_id, 
                            title, 
                            description, 
                            entry_days, 
                            entry_time,
                            days_duration,
                            price,
                            status
                        ) VALUES (
                            '$params[plan_id]',
                            '$params[title]',
                            '$params[description]',
                            '$params[entry_days]',
                            '$params[entry_time]',
                            $params[days_duration],
                            $params[price],
                            $params[status]
                        )";

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

        public function update_subscription($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {  

                $sql = "UPDATE 
                            membership_plan 
                        SET 
                            title = '$params[title]', 
                            description = '$params[description]', 
                            entry_days = '$params[entry_days]', 
                            entry_time = '$params[entry_time]',
                            days_duration = $params[days_duration],
                            price = $params[price],
                            status = $params[status]
                        WHERE 
                            plan_id = '$params[plan_id]'";

                $updated = $this->save_data($sql);

                if (!!$updated) {
                    $return_data['success'] = true;
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function generate_subscription_code() {
            $random_str = strtoupper(substr(bin2hex(random_bytes(3)), 0, 3));
            $random_digits = str_pad(rand(0, 999), 3, '0', STR_PAD_LEFT);
            $subscription_code = "MBR_PLN_" . $random_str . $random_digits;
    
            return $subscription_code;
        }
    }

?>