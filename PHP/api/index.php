<?php

/**
 * File to handle all API requests
 * Accepts GET and POST
 *
 * Each request will be identified by TAG
 * Response will be JSON data

/**
 * check for POST request
 */
if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include db handler
    require_once 'include/db_functions.php';
    $db = new db_functions();

    // response Array
    $response = array("tag" => $tag, "success" => 0, "error" => 0);


    switch (true) {

        //Get popular pictures
        case ($tag == 'getPictures'):
            if($db->getPictures() !== false) {
                $pictures = $db->getPictures();
                $response["pictures"] = array();

                while($row = mysqli_fetch_array( $pictures, MYSQLI_BOTH )) {

                    // Create PicturesArray
                    $picturesArray = array(
                        'pid' => $row['pid'],
                        'tag' => $row['tag'],
                        'uid' => $row["uid"],
                        'likes' => $row["likes"],
                        'url' => "http://zoofzoof.nl/pictures/".$row["url"],
                        'created_at' => $row['created_at']
                    );
                    array_push($response["pictures"], $picturesArray);
                }
                $response['success'] = 1;

                // JSON encode
                echo json_encode($response);

            }

            else {
                $response["success"] = 0;
                $response["pictures"] = "No pictures found";
                echo json_encode($response);
            }

            break;

        // Upload picture
        case ($tag == 'upload_picture'):

            //Upload directory
            define('UPLOAD_DIR', '../pictures/');
            //Get base64 value
            $img = $_POST['base64'];
            //Replace characters
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            //Image name
            $name = uniqid(). '.png';
            $file = UPLOAD_DIR . $name;
            $success = file_put_contents($file, $data);

            //Get tag
            $tag = $_POST['tag_value'];

            $id = $_POST['id'];

            // store picture
            $db->storePicture($tag, $name, $id);

            //Response
            $response['url'] = "http://zoofzoof.nl/pictures/".$name;
            $response['success'] = 1;

            // JSON encode
            echo json_encode($response);
        break;

        case ($tag == 'save_phone'):


             //Get phone_id
            $phone_id = $_POST['id'];

            //If picture exist
            if($db->PhoneIdExist($phone_id)) {

                $response['success'] = 0;
                $response['message'] = 'Id already saved.';

                echo json_encode($response);
            }
            //Save id
            else {

                if($db->storePhoneId($phone_id) !== false) {

                    //Response
                    $response['success'] = 1;

                    // JSON encode
                    echo json_encode($response);
                }
            //Error handling
                else{
                    $response['success'] = 0;
                    $response['message'] = 'Something went wrong.';

                    echo json_encode($response);
                }
            }

        break;

        case ($tag == 'picture_random'):

        //Get tag
        $tag = $_POST['search_tag'];

        //Get id
        $id = $_POST['id'];

        //If list exist
        if($db->ListExist($id, $tag)) {

            $response['success'] = 0;
            $response['message'] = 'Id already saved.';

            //Update
            if($update = $db->updateUserList($id, $tag)){
                $response['success'] = 1;
                $response['url'] = $update['url'];
                $response['pid'] = $update['pid'];
                $response['message'] = 'Userlist updated.';
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'No more pictures available';
                echo json_encode($response);
            }


        }
        //List not exist
        else{
            if($stored = $db->storeUserList($id, $tag)) {
                $response['success'] = 1;
                $response['message'] = 'Userlist stored.';
                $response['url'] =  $stored['url'];
                $response['pid'] =  $stored['pid'];
                echo json_encode($response);
            }
            else {
                $response['success'] = 0;
                $response['message'] = 'No images with this tag';

                echo json_encode($response);
            }

        }

        break;
        case ($tag == 'get_wipetime'):

            if($time = $db->getWipeTime()){

                $now = new DateTime();
                //echo $now->format('Y-m-d H:i:s');    // MySQL datetime format

                $tomorrow = new DateTime('tomorrow');
                $tomorrow->setTime($time['wipetime'], 00, 00);

                $interval = date_diff($now,$tomorrow);
                $msHour = $interval->format('%H')*3600000;
                $msMin = $interval->format('%i')*60000;
                $msSec = $interval->format('%s')*1000;
                $msTotal = $msHour+$msMin+$msSec;

                $response['success'] = 1;
                $response['wipetime'] = $msTotal;
                $response['message'] = 'Time is returned';
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'Time is not returned';
                echo json_encode($response);
            }
        
        break;

        case ($tag == 'picture_like'):

            $pid = $_POST['pid'];

            if($like = $db->updateLike($pid)){
                $response['success'] = 1;
                $response['message'] = 'Like added.';
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'Like could not be added.';
                echo json_encode($response);
            }

            break;

        case ($tag == 'discover_tag'):

            if($discover = $db->discoverTag()){
                $response['success'] = 1;
                $response['message'] = 'Tag discovered.';
                $response['discover_tag'] = $discover['tag'];
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'No tag could be found.';
                echo json_encode($response);
            }
            break;
        // profile get
        case ($tag == 'profile'):
            $phone_id = $_POST['id'];

            if($profile = $db->profileTag($phone_id)){
                $response['success'] = 1;
                $response['message'] = 'Profile found.';
                $response['alias'] = $profile['alias'];
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'No profile found.';
                echo json_encode($response);
            }
            break;
        // profile update
        case ($tag == 'update_profile'):

            $phone_id = $_POST['id'];
            $new_alias = $_POST['alias'];

            if($profile = $db->UpdateProfileTag($phone_id,$new_alias)){
                $response['success'] = 1;
                $response['message'] = 'Profile found and updated.';
                $response['alias'] = $new_alias;
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'No profile found and not updated.';
                echo json_encode($response);
            }
            break;

        case ($tag == 'upload_comment'):

            $phone_id = $_POST['id'];
            $picture_id = $_POST['pid'];
            $comment = $_POST['comment'];

            if($uploadComment = $db->UploadComment($phone_id,$picture_id, $comment)){
                $response['success'] = 1;
                $response['message'] = 'Comment successful uploaded.';
                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'Comment could not be uploaded.';
                echo json_encode($response);
            }
            break;

        case ($tag == 'get_comments'):

               $picture_id = $_POST['pid'];


            if($getComments = $db->GetComments($picture_id)){

                $response["comments"] = array();

                while($row = mysqli_fetch_array($getComments, MYSQLI_BOTH )) {
                    // Create PicturesArray
                    $commentsArray = array(
                        'pid' => $row['pid'],
                        'uid' => $row["uid"],
                        'comment' => $row["comment"],
                        'created_at' => $row['created_at']
                    );

                    $alias = $db->profileTag($row["uid"]);
                    $userAlias = $alias['alias'];

                    $commentsArray['alias']=$userAlias;


                    array_push($response["comments"], $commentsArray);
                }



                $response['success'] = 1;
                $response['message'] = 'Comments successfully recovered.';

                echo json_encode($response);
            }
            else{
                $response['success'] = 0;
                $response['message'] = 'Comments could not be recovered.';
                echo json_encode($response);
            }
            break;

        default:
            echo "Invalid Request";
            break;

    }

  //Default
} else {
    echo "Access Denied";
}
?>