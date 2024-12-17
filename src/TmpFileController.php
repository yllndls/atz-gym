<?php
    include_once 'config/helpers.php';

    class TmpFileController extends Helpers {

        public function tmp_file($params) {
            // - file params
            $tmp_file = $params['file'];
            $tmp_name = $tmp_file['tmp_name'];
            $org_name = $tmp_file['name'];
            $org_type = $tmp_file['type'];
            $org_size = $tmp_file['size'];

            // - validate type
            $validate_type = [
                'image/jpeg',
                'image/jpg',
                'image/png',
                'image/gif',
            ];

            if (!in_array($org_type, $validate_type)) {
                return $result_data['success'] = false;
            }

            $file_stored = "../../public/assets/image/".$params['resources']."/";

            $file_name = uniqid() . '_' . $org_name;
            $file_path = $file_stored . $file_name;
            $file_move = move_uploaded_file($tmp_name, $file_path);

            if (!!$file_move) {
                $stored_data = array(
                    'resources_id' => $params['resources_id'],
                    'resources' => $params['resources'],
                    'file_name' => $file_name,
                    'org_name' => $org_name,
                    'org_type' => $org_type,
                    'org_size' => $org_size
                );

                if (!isset($params['is_update_flg'])) {
                    $res = $this->saveUpload($stored_data);
                } else {
                    $res = $this->updateUpload($stored_data);
                }

                $result_data = array(
                    'success' => $res,
                    'filename' => $file_name
                );

                return $result_data;
            }
        }

        public function saveUpload($params) {
            // - init params
            $return_data = array(
                'success' => false
            );

            try {
                $sql = "INSERT INTO tmp_uploads(
                            resources_id, 
                            resources, 
                            filename, 
                            org_name, 
                            org_type, 
                            org_size
                        ) VALUES (
                            $params[resources_id],
                            '$params[resources]',
                            '$params[file_name]',
                            '$params[org_name]',
                            '$params[org_type]',
                            $params[org_size]
                        )";

                $save = $this->save_data($sql);

                if (!!$save) {
                   $return_data['success'] = true;
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }

        public function updateUpload($params) {
            // - init params
            $return_data = array(
                'success' => false
            );

            try {
                $sql = "UPDATE 
                            tmp_uploads
                        SET 
                            filename = '$params[file_name]',
                            org_name = '$params[org_name]',
                            org_type = '$params[org_type]',
                            org_size = $params[org_size]
                        WHERE 
                            resources_id = $params[resources_id] AND
                            resources = '$params[resources]'";


                $updated = $this->save_data($sql);

                if (!!$updated) {
                   $return_data['success'] = true;
                }

            } catch (\Exception $e) {
                $return_data['error'] = $e->getMessage();
            }

            return $return_data;
        }
    }
?>