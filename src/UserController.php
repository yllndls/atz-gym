<?php
    include_once 'config/helpers.php';

    class UserController extends Helpers {

        public function login($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );
            
            try {

                $query = "SELECT 
                            user.id,
                            user.type_id,
                            user.email,
                            user.fname,
                            user.lname,
                            user.password,
                            user.status,
                            user.is_verify_flg,
                            (
                                CASE 
                                    WHEN profile.filename IS NOT NULL 
                                    THEN profile.filename
                                    ELSE 'default.jpg'
                                END 
                            ) AS profile_img
                        FROM users user 
                        LEFT JOIN tmp_uploads profile ON user.id = profile.resources_id AND profile.resources = 'profile'
                        WHERE 
                            user.status = 1
                            AND user.email = '$params[email]'
                            AND user.type_id = '$params[type_id]'";

                $find_one = $this->find_one($query);

                if ($find_one) {
                    $validate_password = password_verify($params['password'], $find_one['password']);
                    if (!!$validate_password) {
                        $update_params = array(
                            'user_id' => $find_one['id'],
                            'is_online_flg' => ONLINE_FLAG,
                            'last_active' => true
                        );
                        $update_status = $this->update($update_params);

                        $return_data = array(
                            'success' => true,
                            'user_id' =>  $find_one['id'],
                            'user_type' => $find_one['type_id'],
                            'email' => $find_one['email'],
                            'fname' => $find_one['fname'],
                            'lname' => $find_one['lname'],
                            'status' => $find_one['status'],
                            'profile_img' => $find_one['profile_img'],
                            'is_verify_flg' => $find_one['is_verify_flg']
                        );
                    }
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

          return $return_data;
        }

        public function detail($user_id) {
            // - init result param
            $return_data = array(
                'success' => false
            );
            
            try {

                $query = "SELECT 
                            user.*,
                            (
                                CASE 
                                    WHEN profile.filename IS NOT NULL 
                                    THEN profile.filename
                                    ELSE 'default.jpg'
                                END 
                            ) AS profile_img
                        FROM users user 
                        LEFT OUTER JOIN tmp_uploads profile ON user.id = profile.resources_id AND profile.resources = 'profile'
                        WHERE user.id = $user_id
                        LIMIT 1";

                $find_one = $this->find_one($query);

                if ($find_one) {
                    $return_data = array(
                        'success' => true,
                        'data' =>  $find_one
                    );
                }

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
                // - SQL statement
                $sql = "INSERT INTO users(
                            type_id, 
                            fname, 
                            lname, 
                            email, 
                            password, 
                            status
                        ) VALUES (
                            $params[type_id],
                            '$params[fname]',
                            '$params[lname]',
                            '$params[email]',
                            '$params[password]',
                            1
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

        public function update($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - init set clause
                $set_clauses = [];
                // - fname
                if (isset($params['fname']) && !!$params['fname']) {
                    $set_clauses[] = "fname = '".$params['fname']."'";
                }

                // - lname
                if (isset($params['lname']) && !!$params['lname']) {
                    $set_clauses[] = "lname = '".$params['lname']."'";
                }

                // - gender
                if (isset($params['gender']) && !!$params['gender']) {
                    $set_clauses[] = "gender = '".$params['gender']."'";
                }

                // - bday
                if (isset($params['bday']) && !!$params['bday']) {
                    $set_clauses[] = "bday = '".$params['bday']."'";
                }

                // - address
                if (isset($params['address']) && !!$params['address']) {
                    $set_clauses[] = "address = '".$params['address']."'";
                }

                // - contact
                if (isset($params['contact']) && !!$params['contact']) {
                    $set_clauses[] = "contact = '".$params['contact']."'";
                }

                // - email
                if (isset($params['email']) && !!$params['email']) {
                    $set_clauses[] = "email = '".$params['email']."'";
                }

                // - password
                if (isset($params['password']) && !!$params['password']) {
                    $set_clauses[] = "password = '".$params['password']."'";
                }

                // - last active
                if (isset($params['last_active']) && !!$params['last_active']) {
                    $set_clauses[] = "last_active = NOW()";
                }

                // - online flag
                if (isset($params['is_online_flg'])) {
                    $set_clauses[] = "is_online_flg = '".$params['is_online_flg']."'";
                }

                // - verify flag
                if (isset($params['is_verify_flg'])) {
                    $set_clauses[] = "is_verify_flg = '".$params['is_verify_flg']."'";
                }

                // - membership flag
                if (isset($params['is_membership_flg'])) {
                    $set_clauses[] = "is_membership_flg = '".$params['is_membership_flg']."'";
                }

                // - is profile flag
                if (isset($params['is_profile_flg'])) {
                    $set_clauses[] = "is_profile_flg = '".$params['is_profile_flg']."'";
                }

                // - implode set clause
                $set_clause = implode(", ", $set_clauses);

                // - SQL statement
                $query = "UPDATE users SET $set_clause WHERE id = $params[user_id]";

                // - save datas
                $updated = $this->save_data($query);

                $return_data['success'] = $updated;


            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;

        }

        public function userValidation($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );

            try {
                // - search email
                if (!empty($params['email'])) {
                    $where_condition[] = "email = '". $params['email'] ."'";
                }

                // - SQL statements
                $query = "SELECT * FROM users";

                if (!empty($where_condition)) {
                    $query .= " WHERE " . implode(" AND ", $where_condition);
                }

                // - find data
                $user_data = $this->search_num($query);
                $return_data = array(
                    'succcess' => ($user_data > 0),
                    'count' => $user_data
                );
                
            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function user_list($params) {
            // - init result param
            $return_data = array(
                'success' => false
            );
            
            try {
                $where_condition = [];
                $where_condition[] = "user.type_id = 2";

                // - search last active date from
                if (!empty($params['user_id'])) {
                    $where_condition[] = "user.id = '". $params['user_id'] ."'";
                }

                // - search last active date from
                if (!empty($params['last_active_date_from'])) {
                    $from_date = date('Y-m-d H:i:s', strtotime($params['last_active_date_from'] . ' 00:00:00'));
                    $where_condition[] = "user.last_active >= '". $from_date ."'";
                }

                // - search last active date to
                if (!empty($params['last_active_date_to'])) {
                    $to_date = date('Y-m-d H:i:s', strtotime($params['last_active_date_to'] . ' 23:59:59'));
                    $where_condition[] = "user.last_active <= '". $to_date ."'";
                }

                // - search profile verification
                if (!empty($params['verify'])) {
                    $verify_flg = $params['verify'] == 1 ? 1 : 0;
                    $where_condition[] = "user.is_verify_flg = $verify_flg";
                }

                // - search profile verification
                if (!empty($params['status'])) {
                    $status_flg = $params['status'] == 1 ? 1 : 0;
                    $where_condition[] = "user.status = $status_flg";
                }

                $query = "SELECT 
                            user.*,
                            (
                                CASE 
                                    WHEN profile.filename IS NOT NULL 
                                    THEN profile.filename
                                    ELSE 'default.jpg'
                                END 
                            ) AS profile_img
                        FROM users user 
                        LEFT JOIN tmp_uploads profile ON user.id = profile.resources_id AND profile.resources = 'profile'";

                // - SQL where condition
                if (!empty($where_condition)) {
                    $query .= " WHERE " . implode(" AND ", $where_condition);
                }

                // - SQL ordering
                $query .= " ORDER BY user.id DESC ";

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