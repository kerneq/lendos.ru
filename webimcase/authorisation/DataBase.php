<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 19.08.17
 * Time: 12:36
 */

class DataBase
{
    private $conn='';

    /*
     * connect to bd
     */
    function __construct($hn, $un, $pw, $db){
        $this->conn = new mysqli($hn, $un, $pw, $db);
        if ($this->conn->connect_error) die($this->conn->connect_error);
    }

    /*
     * adds new user to bd
     */
    function user_add($data, $data1) {
        $id = $data['uid'];
        $name = $data['first_name'].' '.$data['last_name'];
        $email = $data['email'];
        $phone = $data['mobile_phone'].' '.$data['home_phone'];

        //add id and name of user to sesstion
        $this->add_session($id, $name);

        if (!$this->user_is($id)) {
            $query ="INSERT INTO users VALUES('$id', '$name', '$email', '$phone');";
            $result = $this->conn->query($query);
            if (!$result) die ("Database access failed: " . $this->conn->error);
            //add friends of current user
            for ($j = 0 ; $j < count($data1) ; ++$j) {
                $this->addFriend($data1[$j], $id);
            }
        }
    }

    /*
     * adds current users  5 friends to TABLE friends
     */
    private function addFriend($friend, $user_id) {
        $id = $friend['uid'];
        $name = $friend['first_name'].' '.$friend['last_name'];
        $photo = $friend['photo_200'];
        $query ="INSERT INTO friends VALUES('$id', '$name', '$photo', '$user_id');";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
    }

    /*
     * update date of current user
     */
    function update($name, $email, $phone) {
        $name = $this->sanitizeMySQL($this->conn, $name);
        $email = $this->sanitizeMySQL($this->conn, $email);
        $phone = $this->sanitizeMySQL($this->conn, $phone);

        $this->start_session();
        $id = $_SESSION['id'];

        if ($name!=NULL) {
            $query = "UPDATE users SET name='$name' WHERE id='$id'";
            $result = $this->conn->query($query);
            if (!$result) die ("Database access failed: " . $this->conn->error);
        }

        if ($email!=NULL) {
            $query = "UPDATE users SET email='$email' WHERE id='$id'";
            $result = $this->conn->query($query);
            if (!$result) die ("Database access failed: " . $this->conn->error);
        }

        if ($phone!=NULL) {
            $query = "UPDATE users SET phone='$phone' WHERE id='$id'";
            $result = $this->conn->query($query);
            if (!$result) die ("Database access failed: " . $this->conn->error);
        }
    }

    /*
     * checks is current user in table users
     * returns true if is else false
     */
    function user_is($id) {
        $query ="SELECT EXISTS(SELECT id FROM users WHERE id = '$id')";
        $result = $this->conn->query($query);

        if (!$result) die ("Database access failed: " . $this->conn->error);

        $result->data_seek(0);
        if ($result->fetch_array(MYSQLI_NUM)[0]) {
            $result->close();
            return true;
        } else {
            $result->close();
            return false;
        }
    }

    /*
     * return all friends of current user
     */
    function out_friends(){
        $this->start_session();
        $id = $_SESSION['id'];
        $query = "SELECT * FROM users U INNER JOIN friends F ON U.id = F.is_friend_with WHERE U.id = '$id';";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
        return $result;
    }

    /*
     * adds session of current user
     * name and id are in session
     */
    function add_session($id, $name) {
        $this->start_session();
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
    }

    /*
     * returns data of current user from the table 'users'
     */
    function take_inf() {
        $this->start_session();
        $id = $_SESSION['id'];

        $query = "SELECT * FROM users WHERE id='$id'";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
        return $result;
    }

    function destroy_session_and_data() {
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }

    /*
     * starts sesseion with more safety
     */
    function start_session() {
        session_start();

        if (!isset($_SESSION['initiated'])) {
            session_regenerate_id();
            $_SESSION['initiated'] = 1;
        }

        if (!isset($_SESSION['count'])) $_SESSION['count'] = 0;
        else ++$_SESSION['count'];
    }

    /*
     * if someone use id of our users
     * now dont use this function
     */
    function different_user() {
        $this->destroy_session_and_data();
        echo "Ввойдите занова";
    }

    /*
     * safety out
     */
    function mysql_entities_fix_string($conn, $string) {
        return htmlentities(mysql_fix_string($conn, $string));
    }

    function mysql_fix_string($conn, $string) {
        if (get_magic_quotes_gpc()) $string = stripslashes($string);

        return $conn->real_escape_string($string);
    }

    /*
     * safety in
     */
    function sanitizeString($var){
        $var = strip_tags($var);
        $var = htmlentities($var);

        return $var;
    }

    function sanitizeMySQL($connection, $var) {
        $var = $connection->real_escape_string($var);
        $var = $this->sanitizeString($var);

        return $var;
    }

    function __destruct(){
        $this->conn->close();
    }
}

?>