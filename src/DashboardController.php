<?php
    include_once 'config/helpers.php';

    class DashboardController extends Helpers {

        public function countUsers() {
            // Initialize result parameter
            $return_data = array(
                'success' => false
            );
    
            try {
                // SQL Query to count users
                $query = "SELECT * FROM users WHERE type_id = 2";
                
                // Get total count using search_num
                $data_count = $this->search_num($query);
    
                $return_data = array(
                    'success' => true,
                    'total_count' => $data_count
                );
    
            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }
    
            return $return_data;
        }

        public function countActiveMembership() {
            // Initialize result parameter
            $return_data = array(
                'success' => false
            );
    
            try {
                // SQL Query to count users
                $query = "SELECT * FROM membership WHERE is_expired_flg = 0";
                
                // Get total count using search_num
                $data_count = $this->search_num($query);
    
                $return_data = array(
                    'success' => true,
                    'total_count' => $data_count 
                );
    
            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }
    
            return $return_data;
        }

        public function countOrders($status) {
            // Initialize result parameter
            $return_data = array(
                'success' => false
            );
    
            try {
                // SQL Query to count users
                $query = "SELECT * FROM orders WHERE order_status = $status";
                
                // Get total count using search_num
                $data_count = $this->search_num($query);
    
                $return_data = array(
                    'success' => true,
                    'total_count' => $data_count
                );
    
            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }
    
            return $return_data;
        }

        public function totalEarnings($order_type) {
            // Initialize result parameter
            $return_data = array(
                'success' => false
            );
    
            try {
                // SQL Query to count users
                $query = "SELECT SUM(amount) AS total_earnings FROM transactions WHERE order_type = '".$order_type."' AND payment_status = 2;";
                
                // Get total count using search_num
                $data_count = $this->search_num($query);
                $data = $this->find_one($query);
    
                $return_data = array(
                    'success' => true,
                    'total_count' => $data_count,
                    'earning' => $data
                );
    
            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }
    
            return $return_data;
        }
    }

?>