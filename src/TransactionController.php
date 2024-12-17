<?php
    include_once 'config/helpers.php';

    class TransactionController extends Helpers {

        public function create_transaction($params) {
            // - set params
            $receipt_img = isset($params['receipt_img']) ? $params['receipt_img'] : '';
            $reference_no = isset($params['reference_no']) ? $params['reference_no'] : '';
            $gcash_no = isset($params['gcash_no']) ? $params['gcash_no'] : '';

            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - SQL statement
                $sql = "INSERT INTO transactions(
                            user_id, 
                            transaction_code, 
                            order_code, 
                            order_type, 
                            payment_type,
                            payment_status,
                            receipt_img,
                            reference_no,
                            amount,
                            gcash_no
                        ) VALUES (
                            $params[user_id],
                            '$params[transaction_code]',
                            '$params[order_code]',
                            '$params[order_type]',
                            '$params[payment_type]',
                            $params[payment_status],
                            '$receipt_img',
                            '$reference_no',
                            $params[amount],
                            '$gcash_no'
                        )";

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

        public function update_transaction($params) {
             // - init result param
             $return_data = array(
                'success' => false
            );

            try {
                // - init set clause
                $set_clauses = [];

                // - set checked_by
                if (isset($params['payment_status'])) {
                    $set_clauses[] = "payment_status = '".$params['payment_status']."'";
                }

                // - set start date
                if (isset($params['amount_received'])) {
                    $set_clauses[] = "amount_received = '".$params['amount_received']."'";
                }

                // - set received_by
                if (isset($params['received_by'])) {
                    $set_clauses[] = "received_by = '".$params['received_by']."'";
                }

                // - implode set clause
                $set_clause = implode(", ", $set_clauses);

                // - SQL statement
                $query = "UPDATE transactions SET $set_clause WHERE order_code = '". $params['order_code'] ."'";

                // - save datas
                $updated = $this->save_data($query);

                $return_data['success'] = $updated;


            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function generate_transaction_code() {
            $random_str = strtoupper(substr(bin2hex(random_bytes(3)), 0, 3));
            $random_digits = str_pad(rand(0, 999), 4, '0', STR_PAD_LEFT);
            $transaction_code = "TRNSCTN_" . $random_str . $random_digits;
    
            return $transaction_code;
        }

        public function transaction_list($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );
            
            try {
                $where_condition = [];
                $where_condition[] = "transac.payment_status = 2";

                // - search transaction code
                if (!empty($params['transaction_code'])) {
                    $where_condition[] = "transac.transaction_code = '". $params['transaction_code'] ."'";
                }

                // - search transac date
                if (!empty($params['date_to'])) {
                    $to_date = date('Y-m-d H:i:s', strtotime($params['date_to'] . ' 23:59:59'));
                    $where_condition[] = "transac.created <= '". $to_date ."'";
                }

                // - search transac date
                if (!empty($params['date_from'])) {
                    $from_date = date('Y-m-d H:i:s', strtotime($params['date_from'] . ' 00:00:00'));
                    $where_condition[] = "transac.created >= '". $from_date ."'";
                }

                // - search order type
                if (!empty($params['order_type'])) {
                    $where_condition[] = "transac.order_type = '". $params['order_type'] ."'";
                }

                // - search payment type
                if (!empty($params['payment_type'])) {
                    $payment_type = $params['payment_type'] == 1 ? 1 : 0;
                    $where_condition[] = "transac.payment_type = $payment_type";
                }

                $query = "SELECT 
                            transac.*,
                            (
                                CASE 
                                    WHEN transac.payment_type = 0
                                    THEN 'Pay at counter'
                                    ELSE 'GCash'
                                END
                            ) AS pay_type,
                            member.fname,
                            member.lname,
                            member.address,
                            member.contact,
                            member.email,
                            admin.fname AS admin_fname,
                            admin.lname AS admin_lname
                        FROM transactions transac
                        LEFT JOIN users member ON member.id = transac.user_id AND member.type_id = 2
                        LEFT JOIN users admin ON admin.id = transac.received_by AND admin.type_id = 1";

                // - SQL where condition
                if (!empty($where_condition)) {
                    $query .= " WHERE " . implode(" AND ", $where_condition);
                }

                // - SQL ordering
                $query .= " ORDER BY transac.created DESC";

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
    }
?>