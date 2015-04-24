<?php

class DB_Functions {

    private $db;

    //put your code here
    // constructor
    function __construct() {
        require_once 'db_connect.php';
        // connecting to database
        $this->db = new db_connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {

    }

    /**
     * Get all pictures
     */
    public function getPictures() {
        $result = mysqli_query($this->db->connect(),"SELECT * FROM zoof_pictures ORDER BY likes DESC LIMIT 9") or die(mysqli_error($this->db->connect()));
        // check for result
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            //Return pictures
            return $result;

        } else {
            // pictures not found
            return false;
        }
    }

        /**
     * Get all pictures
     */
    public function getWipeTime() {
        $result = mysqli_query($this->db->connect(),"SELECT * FROM zoof_system") or die(mysqli_error($this->db->connect()));
        // check for result
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            //Return wipetime
            return mysqli_fetch_array($result, MYSQLI_BOTH);

        } else {
            // no wipetime found
            return false;
        }
    }

    /**
     * Check if pictures exist
     */
    public function picturesExist($pid) {

        $result = mysqli_query($this->db->connect(),"SELECT pid from zoof_pictures WHERE pid = '$pid'") or die(mysqli_error($this->db->connect()));
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            // picture exist

            return true;
        } else {
            // picture not exist

            return false;
        }
    }

    /**
     * Storing new picture
     */
    public function storePicture($tag, $url, $id) {

      

        $result = mysqli_query($this->db->connect(), "INSERT INTO zoof_pictures(tag, uid, likes, url, created_at) VALUES('$tag', '$id', 0, '$url', NOW())") or die( mysqli_error($this->db->connect()));

        // check for successful store
        if ($result) {
            $result = mysqli_query($this->db->connect(),"SELECT * FROM zoof_pictures WHERE uid = '$id'") or die(mysqli_error($this->db->connect()));

            return mysqli_fetch_array($result, MYSQLI_BOTH);
        } else {
            return false;
        }
    }

    /**
     * Check if id exist
     */
    public function PhoneIdExist($id) {

        $result = mysqli_query($this->db->connect(),"SELECT phone_id from zoof_users WHERE phone_id = '$id'") or die(mysqli_error($this->db->connect()));
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            // id exist

            return true;
        } else {
            // id not exist

            return false;
        }
    }

    /**
     * Storing phone_id
     */
    public function storePhoneId($id) {

        $result = mysqli_query($this->db->connect(), "INSERT INTO zoof_users(phone_id) VALUES('$id')") or die( mysqli_error($this->db->connect()));

        // if success
        if ($result) {
            $result = mysqli_query($this->db->connect(),"SELECT * FROM zoof_users WHERE phone_id = '$id'") or die(mysqli_error($this->db->connect()));

            return mysqli_fetch_array($result, MYSQLI_BOTH);
        } else {
            return false;
        }
    }

    /**
     * Check if list exist
     */
    public function ListExist($id, $tag) {

        $result = mysqli_query($this->db->connect(),"SELECT uid from zoof_userlist WHERE uid = '$id' AND tag = '$tag'") or die(mysqli_error($this->db->connect()));
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            // id exist

            return true;
        } else {
            // id not exist
            return false;
        }
    }


    /**
     * Storing userList
     */
    public function storeUserList($id, $tag) {

    $tagExist = mysqli_query($this->db->connect(),"SELECT tag from zoof_pictures WHERE tag = '$tag'") or die(mysqli_error($this->db->connect()));
    $no_of_rows = mysqli_num_rows($tagExist);
    if($no_of_rows > 0){
       $result = mysqli_query($this->db->connect(), "INSERT INTO zoof_userlist(uid, tag, start_photo ,created_at ) VALUES('$id','$tag',1, NOW())") or die( mysqli_error($this->db->connect()));
    }
    else{
        $result = false;
    }



    if($result){


        $showPicture = mysqli_query($this->db->connect(), "SELECT url, pid FROM zoof_pictures WHERE tag = '$tag'  ") or die( mysqli_error($this->db->connect()));
        return mysqli_fetch_array($showPicture, MYSQLI_BOTH);
    }
    else{
        return false;
    }
 }

    /**
     * Storing userList
     */
    public function updateUserList($id, $tag) {
        //Update


        $startPhoto = mysqli_query($this->db->connect(), "SELECT start_photo FROM zoof_userlist WHERE tag= '$tag' AND uid = '$id'") or die( mysqli_error($this->db->connect()));
        while ($row = $startPhoto->fetch_assoc()) {
            $end = $row['start_photo'];
        }
        $futureEnd = $end -1;



        //All pictures
        $pictures = mysqli_query($this->db->connect(),"SELECT url FROM zoof_pictures WHERE tag = '$tag' ") or die(mysqli_error($this->db->connect()));
        $rowcount = mysqli_num_rows($pictures);

        if($futureEnd == $rowcount){
            return false;
        }
        else{

//            echo "UPDATE";
            $end = $end +1;
            $from = $end -1;
            $to = $end +1;

//            echo "END " . $end;
//            echo "FROM " . $from;
//            echo "TO " . $to;

//            $from = $futureEnd -1;
//            $to = $futureEnd +1;
//
//            echo "FROM" . $from;
//            echo "TO". $to;

            $showPicture = mysqli_query($this->db->connect(), "SELECT url, pid FROM zoof_pictures WHERE tag = '$tag' LIMIT $from , $to") or die( mysqli_error($this->db->connect()));
            $result = mysqli_query($this->db->connect(), "UPDATE zoof_userlist SET start_photo = start_photo +1 , updated_at = NOW() WHERE uid = '$id' AND tag = '$tag'") or die( mysqli_error($this->db->connect()));



//            echo "NUMMER 2";
            return mysqli_fetch_array($showPicture, MYSQLI_BOTH);

        }

    }

    /**
     * Update like
     */
    public function updateLike($pid) {

        //Update
        $result = mysqli_query($this->db->connect(), "UPDATE zoof_pictures SET likes = likes +1  WHERE pid = '$pid' ") or die( mysqli_error($this->db->connect()));

        if($result){
             return true;
        }
        else{
            return false;
        }

    }

    /**
     * Update like
     */
    public function dataWipe() {

        $result = mysqli_query($this->db->connect(),"SELECT * FROM zoof_system") or die(mysqli_error($this->db->connect()));
        // check for result
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            $result = mysqli_fetch_array($result, MYSQLI_BOTH);
        } else {
            // no wipetime found
            return false;
        }

        $now = new DateTime();

        $tomorrow = new DateTime('tomorrow');
        $tomorrow->setTime($result['wipetime'], 00, 00);

        $interval = date_diff($now,$tomorrow);
        $msHour = $interval->format('%H')*3600000;
        $msMin = $interval->format('%i')*60000;
        $msTotal = $msHour+$msMin;

        //if($msTotal < 60000 || $msTotal > 85200000 ){
            //Delete
            $result = mysqli_query($this->db->connect(), "DELETE FROM zoof_pictures") or die( mysqli_error($this->db->connect()));
            $result2 = mysqli_query($this->db->connect(), "DELETE FROM zoof_userlist") or die( mysqli_error($this->db->connect()));
            $result3 = mysqli_query($this->db->connect(), "DELETE FROM zoof_userComments") or die( mysqli_error($this->db->connect()));

            if($result && $result2 && $result3){
                return true;
            } else{
                return false;
            }
        //}

    }




    /**
     * Update like
     */
    public function discoverTag() {

        $result = mysqli_query($this->db->connect(),"SELECT DISTINCT tag from zoof_pictures ORDER BY RAND() LIMIT 0,1") or die(mysqli_error($this->db->connect()));

        if($result){
            return mysqli_fetch_array($result, MYSQLI_BOTH);
        }
        else{
            return false;
        }

    }

    public function profileTag($phone_id) {

        $result = mysqli_query($this->db->connect(),"SELECT alias FROM zoof_users WHERE phone_id = '$phone_id'") or die(mysqli_error($this->db->connect()));

        if($result){
            return mysqli_fetch_array($result, MYSQLI_BOTH);
        }
        else{
            return false;
        }

    }

    public function updateProfileTag($phone_id, $new_alias) {

        $result = mysqli_query($this->db->connect(), "UPDATE zoof_users SET alias = '$new_alias'  WHERE phone_id = '$phone_id'") or die( mysqli_error($this->db->connect()));
        $result2 = mysqli_query($this->db->connect(),"SELECT alias FROM zoof_users WHERE phone_id = '$phone_id'") or die(mysqli_error($this->db->connect()));


        if($result2 && $result){
            return mysqli_fetch_array($result2, MYSQLI_BOTH);
        }
        else{
            return false;
        }

    }

    /**
     * Upload comment
     */
    public function uploadComment($id, $pid, $comment) {

        //Upload
        $result = mysqli_query($this->db->connect(), "INSERT INTO zoof_userComments(uid, pid, comment ,created_at ) VALUES('$id','$pid','$comment', NOW())") or die( mysqli_error($this->db->connect()));

        if($result){
            return true;
        }
        else{
            return false;
        }

    }

    /**
     * Get comments
     */
    public function GetComments($pid) {

        $result = mysqli_query($this->db->connect(),"SELECT * FROM zoof_userComments WHERE pid = '$pid'") or die(mysqli_error($this->db->connect()));
        // check for result
        $no_of_rows = mysqli_num_rows($result);
        if ($no_of_rows > 0) {
            //Return pictures
            return $result;

        } else {
            // pictures not found
            return false;
        }

    }


}

