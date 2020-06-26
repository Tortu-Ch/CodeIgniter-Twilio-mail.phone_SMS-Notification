<?php

/**
 * get a human readable file size format from bytes 
 * 
 * @param string $bytes
 * @return fise size
 */
if (!function_exists('convert_file_size')) {

    function convert_file_size($bytes) {
        $bytes = floatval($bytes);
        $bytes_array = array(
            0 => array("unit" => "TB", "value" => pow(1024, 4)),
            1 => array("unit" => "GB", "value" => pow(1024, 3)),
            2 => array("unit" => "MB", "value" => pow(1024, 2)),
            3 => array("unit" => "KB", "value" => 1024),
            4 => array("unit" => "B", "value" => 1),
        );

        foreach ($bytes_array as $byte) {
            if ($bytes >= $byte["value"]) {
                $result = $bytes / $byte["value"];
                $result = strval(round($result, 2)) . " " . $byte["unit"];
                break;
            }
        }
        return $result;
    }

}


/**
 * get some predefined icons for some known file types 
 * 
 * @param string $file_ext
 * @return fontawesome icon class
 */
if (!function_exists('get_file_icon')) {

    function get_file_icon($file_ext = "") {
        switch ($file_ext) {
            case "jpeg":
            case "jpg":
            case "png":
            case "gif":
            case "bmp":
            case "svg":
                return "file-image-o";
                break;
            case "doc":
            case "dotx":
                return "file-word-o";
                break;
            case "xls":
            case "xlsx":
            case "csv":
                return "file-excel-o";
                break;
            case "ppt":
            case "pptx":
            case "pps":
            case "pot":
                return "file-powerpoint-o";
                break;
            case "zip":
            case "rar":
            case "7z":
            case "s7z":
            case "iso":
                return "file-zip-o";
                break;
            case "pdf":
                return "file-pdf-o";
                break;
            case "html":
            case "css":
                return "file-code-o";
                break;
            case "txt":
                return "file-text-o";
                break;
            case "mp3":
            case "wav":
            case "wma":
                return "file-sound-o";
                break;
            case "mpg":
            case "mpeg":
            case "flv":
            case "mkv":
            case "webm":
            case "avi":
            case "mp4":
            case "3gp":
                return "file-movie-o";
                break;
            default:
                return "file-o";
        };
    }

}

/**
 * check the file is a image
 * 
 * @param string $file_name
 * @return true/false
 */
if (!function_exists('is_image_file')) {

    function is_image_file($file_name = "") {
        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $image_files = array("jpg", "jpeg", "png", "gif", "bmp");
        return (in_array($extension, $image_files)) ? true : false;
    }

}


/**
 * check the file preview supported by google
 * 
 * @param string $file_name
 * @return true/false
 */
if (!function_exists('is_google_preview_available')) {

    function is_google_preview_available($file_name = "") {
        $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $image_files = array("pdf", "doc", "docx", "ppt", "pptx", "txt");
        return (in_array($extension, $image_files)) ? true : false;
    }

}

/**
 * check the file format priview is available or not
 * 
 * @param string $file_name
 * @return true/false
 */
if (!function_exists('is_viewable_image_file')) {

    function is_viewable_image_file($file_name = "") {
        $viewable_extansions = array(
            "jpeg",
            "jpg",
            "png",
            "gif",
            "bmp",
            "mp4");
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (in_array($file_extension, $viewable_extansions)) {
            return true;
        }
    }

}

/**
 * check the file format for video priview is available or not
 * 
 * @param string $file_name
 * @return true/false
 */
if (!function_exists('is_viewable_video_file')) {

    function is_viewable_video_file($file_name = "") {
        $viewable_extansions = array(
            "mp4",
            "webm",
            "ogv"
        );
        $file_extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        if (in_array($file_extension, $viewable_extansions)) {
            return true;
        }
    }

}


/**
 * upload a file to temp folder when using dropzone autoque=true
 * 
 * @param file $_FILES
 * @return void
 */
if (!function_exists('upload_file_to_temp')) {

    function upload_file_to_temp() {
        if (!empty($_FILES)) {
            $temp_file = $_FILES['file']['tmp_name'];
            $file_name = $_FILES['file']['name'];

            if (!is_valid_file_to_upload($file_name))
                return false;


            $temp_file_path = get_setting("temp_file_path");
            $target_path = getcwd() . '/' . $temp_file_path;
            if (!is_dir($target_path)) {
                if (!mkdir($target_path, 0777, true)) {
                    die('Failed to create file folders.');
                }
            }
            $target_file = $target_path . $file_name;
            copy($temp_file, $target_file);
        }
    }

}

/**
 * this method process 3 types of files
 * 1. direct upload
 * 2. move a uploaded file which has been uploaded in temp folder
 * 3. copy a text based image
 * 
 * @param string $file_name
 * @param string $target_path
 * @param string $source_path 
 * @param string $static_file_name 
 * @return filename
 */
if (!function_exists('move_temp_file')) {

    function move_temp_file($file_name, $target_path, $related_to = "", $source_path = NULL, $static_file_name = "") {

        //to make the file name unique we'll add a prefix
        $filename_prefix = $related_to . "_" . uniqid("file") . "-";


        //if not provide any source path we'll find the default path
        if (!$source_path) {
            $source_path = getcwd() . "/" . get_setting("temp_file_path") . $file_name;
        }

        //check destination directory. if not found try to create a new one
        if (!is_dir($target_path)) {
            if (!mkdir($target_path, 0777, true)) {
                die('Failed to create file folders.');
            }
            //create a index.html file inside the folder
            copy(getcwd() . "/" . get_setting("system_file_path") . "index.html", $target_path . "index.html");
        }

        //remove unsupported values from the file name
        $new_filename = $filename_prefix . preg_replace('/\s+/', '-', $file_name);

        $new_filename = str_replace("’", "-", $new_filename);
        $new_filename = str_replace("'", "-", $new_filename);
        $new_filename = str_replace("(", "-", $new_filename);
        $new_filename = str_replace(")", "-", $new_filename);

        //overwrite extisting logic and use static file name
        if ($static_file_name) {
            $new_filename = $static_file_name;
        }

        //check the file type is data or file. then copy to destination and remove temp file
        if (starts_with($source_path, "data")) {
            if (get_setting("file_copy_type") === "copy") {
                copy($source_path, $target_path . $new_filename);
            } else {
                copy_text_based_image($source_path, $target_path . $new_filename);
            }

            return $new_filename;
        } else {
            if (file_exists($source_path)) {
                copy($source_path, $target_path . $new_filename);
                unlink($source_path);
                return $new_filename;
            }
        }
        return false;
    }

}


/**
 * Convert to a file from text based image
 * 
 * @param string $source_path 
 * @param string $target_path
 * @return file size
 */
if (!function_exists('copy_text_based_image')) {

    function copy_text_based_image($source_path, $target_path) {

        if (ini_get('allow_url_fopen')) {

            $buffer_size = 3145728;
            $byte_number = 0;
            $file_open = fopen($source_path, "rb");
            $file_wirte = fopen($target_path, "w");
            while (!feof($file_open)) {
                $byte_number += fwrite($file_wirte, fread($file_open, $buffer_size));
            }
            fclose($file_open);
            fclose($file_wirte);
            return $byte_number;
        } else {

            $file = explode(",", $source_path);
            $base64 = get_array_value($file, 1);
            if ($base64) {
                return file_put_contents($target_path, base64_decode($base64));
            }
        }
    }

}

/**
 * remove file name prefix which was added by move_temp_file() method
 * 
 * @param string $file_name
 * @return filename
 */
if (!function_exists('remove_file_prefix')) {

    function remove_file_prefix($file_name = "") {
        return substr($file_name, strpos($file_name, "-") + 1);
    }

}


/**
 * copy a directory to another directoryformat_to_datetime
 * 
 * @param string $src
 * @param string $dst
 * @return void
 */
if (!function_exists('copy_recursively')) {

    function copy_recursively($src, $dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while (false !== ( $file = readdir($dir))) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if (is_dir($src . '/' . $file)) {
                    copy_recursively($src . '/' . $file, $dst . '/' . $file);
                } else {
                    copy($src . '/' . $file, $dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

}


/**
 * move file to a parmanent direnctory from the temp dirctory
 * 
 * dropzone file post data example
 * the input should be named as file_names and file_sizes
 * 
 * for old borwsers which doesn't supports dropzone the files will be handaled using manual process
 * the post data should be named as manualFiles
 * 
 * @param string $target_path
 * @param string $name
 * 
 * @return array of file ids
 */
if (!function_exists('move_files_from_temp_dir_to_permanent_dir')) {

    function move_files_from_temp_dir_to_permanent_dir($target_path = "", $related_to = "") {

        $ci = get_instance();

        //process the fiiles which has been uploaded by dropzone
        $files_data = array();
        $file_names = $ci->input->post("file_names");
        $file_sizes = $ci->input->post("file_sizes");

        if ($file_names && get_array_value($file_names, 0)) {
            foreach ($file_names as $key => $file_name) {
                $new_file_name = move_temp_file($file_name, $target_path, $related_to);
                $files_data[] = array(
                    "file_name" => $new_file_name,
                    "file_size" => get_array_value($file_sizes, $key)
                );
            }
        }

        //process the files which has been submitted manually
        if ($_FILES) {
            $files = $_FILES['manualFiles'];
            if ($files && count($files) > 0) {
                foreach ($files["tmp_name"] as $key => $file) {
                    $temp_file = $file;
                    $file_name = $files["name"][$key];
                    $file_size = $files["size"][$key];

                    $new_file_name = move_temp_file($file_name, $target_path, $related_to, $temp_file);
                    $files_data[] = array(
                        "file_name" => $new_file_name,
                        "file_size" => $file_size,
                    );
                }
            }
        }
        return serialize($files_data);
    }

};


/**
 * check post file is valid or not
 * 
 * @param string $file_name
 * @return json data of success or error message
 */
if (!function_exists('validate_post_file')) {

    function validate_post_file($file_name = "") {
        if (is_valid_file_to_upload($file_name)) {
            echo json_encode(array("success" => true));
        } else {
            echo json_encode(array("success" => false, 'message' => lang('invalid_file_type') . " ($file_name)"));
        }
    }

}


/**
 * check the file type is valid for upload
 * 
 * @param string $file_name
 * @return true/false
 */
if (!function_exists('is_valid_file_to_upload')) {

    function is_valid_file_to_upload($file_name = "") {

        if (!$file_name)
            return false;

        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $file_formates = explode(",", get_setting("accepted_file_formats"));
        if (in_array($file_ext, $file_formates)) {
            return true;
        }
    }

}

/**
 * delete file 
 * @param String file_path
 * @return void
 */
if (!function_exists('delete_file_from_directory')) {

    function delete_file_from_directory($file_path = "") {
        $source_path = getcwd() . "/" . $file_path;
        if (file_exists($source_path)) {
            unlink($source_path);
        }
    }

}


/**
 * download files. If there is one file then don't archive the file otherwise archive the files.
 * 
 * @param string $file_path
 * @param string $serialized_file_data 
 * @return download files
 */
if (!function_exists('download_app_files')) {

    function download_app_files($directory_path, $serialized_file_data) {
        $ci = get_instance();

        $file_exists = false;
        if ($serialized_file_data) {

            $files = unserialize($serialized_file_data);
            $total_files = count($files);

            //for only one file we'll download the file without archiving
            if ($total_files === 1) {
                $ci->load->helper('download');
            } else {
                $ci->load->library('zip');
            }


            $file_path = getcwd() . '/' . $directory_path;

            foreach ($files as $file) {
                $file_name = get_array_value($file, 'file_name');
                $output_filename = remove_file_prefix($file_name);

                $path = $file_path . $file_name;
                if (file_exists($path)) {

                    //if there exists only one file then don't archive the file otherwise archive the file
                    if ($total_files === 1) {

                        $data = file_get_contents($path);
                        force_download($output_filename, $data);
                        exit();
                    } else {

                        $ci->zip->read_file($path, $output_filename);
                        $file_exists = true;
                    }
                }
            }
        }

        if ($file_exists) {
            $ci->zip->download(lang('download_zip_name') . '.zip');
        } else {
            die(lang("no_such_file_or_directory_found"));
        }
    }

}


/**
 * get file path
 * 
 * @param string $file_path
 * @param string $serialized_file_data 
 * @return array
 */
if (!function_exists('prepare_attachment_of_files')) {

    function prepare_attachment_of_files($directory_path, $serialized_file_data) {
        $result = array();
        if ($serialized_file_data) {

            $files = unserialize($serialized_file_data);
            $file_path = getcwd() . '/' . $directory_path;

            foreach ($files as $file) {
                $file_name = get_array_value($file, 'file_name');
                $output_filename = remove_file_prefix($file_name);

                $path = $file_path . $file_name;
                if (file_exists($path)) {
                    $result[] = array("file_path" => $path, "file_name" => $output_filename);
                }
            }
        }
        return $result;
    }

}


/**
 * delete save files/ include new files
 * 
 * @param string $file_path
 * @param string $serialized_file_data 
 * @return remaining files array
 */
if (!function_exists('update_saved_files')) {

    function update_saved_files($file_path, $serialized_file_data, $new_files_array) {
        $ci = get_instance();

        if ($serialized_file_data && $file_path) {
            $files_array = unserialize($serialized_file_data);

            //is deleted any file?
            $delete_files = $ci->input->post("delete_file");
            if (!is_array($delete_files)) {
                $delete_files = array();
            }

            if (!is_array($new_files_array)) {
                $new_files_array = array();
            }

            //delete files from directory and update the database array
            foreach ($files_array as $file) {
                $file_name = get_array_value($file, "file_name");
                if (in_array($file_name, $delete_files)) {
                    delete_file_from_directory($file_path . $file_name);
                } else {
                    array_push($new_files_array, $file);
                }
            }
        }
        return $new_files_array;
    }

}


/**
 * return a file path of general files based on context
 * 
 * @param string $context   client/team_member/...
 * @param integer $context_id   client_id/team_member_id/...
 * @return string of file path
 */
if (!function_exists('get_general_file_path')) {

    function get_general_file_path($context, $context_id) {
        if ($context && $context_id) {
            $target_path = get_setting("general_file_path");
            if (!$target_path) {
                $target_path = 'files/general/';
            }

            return $target_path . $context . "/" . $context_id . "/";
        }
    }

}


/**
 * return a list of language by scanning the files from language directory.

 * @return array
 */
if (!function_exists('get_language_list')) {

    function get_language_list() {
        $language_dropdown = array();
        $dir = "./application/language/";
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    if ($file && $file != "." && $file != ".." && $file != "index.html") {
                        $language_dropdown[$file] = ucfirst($file);
                    }
                }
                closedir($dh);
            }
        }
        return $language_dropdown;
    }

}
                           