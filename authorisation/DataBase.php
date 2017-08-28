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
     * adding new user to bd
     */
    function user_add($data){
        $id = null;
        $name = null;
        $email = null;
        $phone = null;
        if (isset($data['uid'])){//vk
            $id = $data['uid'].'_vk';
            $name = $data['first_name'].' '.$data['last_name'];
            $email = $data['email'];
            $phone = $data['mobile_phone'].' '.$data['home_phone'];

        } elseif (isset($data['id'])){//fb
            $id = $data['id'].'_fb';
            $name = $data['name'];
            $email = $data['email'];
        }
        //add id and name of user to sesstion
        $this->add_session($id, $name);
        if (!$this->user_is($id)) {
            $query ="INSERT INTO users VALUES(NULL, '$id', '$name', '$email', '$phone', NULL, NULL);";
            $result = $this->conn->query($query);
            if (!$result) die ("Database access failed: " . $this->conn->error);
        }
    }

    /*
     * update date of current user
     */
    function update($name, $email, $phone, $vk, $fb){
        $name = $this->sanitizeMySQL($this->conn, $name);
        $email = $this->sanitizeMySQL($this->conn, $email);
        $phone = $this->sanitizeMySQL($this->conn, $phone);
        $vk = $this->sanitizeMySQL($this->conn, $vk);
        $fb = $this->sanitizeMySQL($this->conn, $fb);
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
        if ($vk!=NULL) {
            $query = "UPDATE users SET vk='$vk' WHERE id='$id'";
            $result = $this->conn->query($query);
            if (!$result) die ("Database access failed: " . $this->conn->error);
        }
        if ($fb!=NULL) {
            $query = "UPDATE users SET fb='$fb' WHERE id='$id'";
            $result = $this->conn->query($query);
            if (!$result) die ("Database access failed: " . $this->conn->error);
        }
    }

    /*
     * update order of current use
     * change status not paid on paid
     */
    function paid_order($num_order){
        $query = "UPDATE orders SET status='paid' WHERE number='$num_order'";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
    }

    /*
     * add date to table 'orders' of current user
     * column url_download is 'в работе'
     * column status is 'not paid'
     */
    function add_order($url_landing, $vk_pixel, $fb_pixel, $metka_pixel, $date, $total_price, $text, $modules){
        $this->start_session();
        $id = $_SESSION['id'];
        $url_landing = $this->sanitizeMySQL($this->conn, $url_landing);
        $text = $this->sanitizeMySQL($this->conn, $text);
        $query ="INSERT INTO orders VALUES(NULL, '$id', '$url_landing', '$vk_pixel', 
'$fb_pixel', '$metka_pixel', '$date', '$total_price', '$text', '$modules', 'в работе', 'not paid');";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
        $result->close();
    }

    /*
     * return all orders of current user
     */
    function out_orders(){
        $this->start_session();
        $id = $_SESSION['id'];
        $query = "SELECT * FROM orders WHERE id='$id'";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
        return $result;
    }

    /*
     * return an order of special number
     */
    function get_order($number){
        $query = "SELECT * FROM orders WHERE number='$number'";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
        return $result;
    }

    /*
     * checking is current user in table users
     * return true if is else false
     */
    function user_is($id){
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
     * if user is in system
     */
    function is_authorisation(){
        $this->start_session();
        if (isset($_SESSION['id'])){
            echo "Вы авторизированны";
        }
    }

    /*
     * add session of current user
     * name and id are in session
     */
    function add_session($id, $name){
        //$this->destroy_session_and_data();
        $this->start_session();
        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
    }

    /*
     * return data of current user from the table 'users'
     */
    function take_inf(){
        $this->start_session();
        $id = $_SESSION['id'];
        $query = "SELECT * FROM users WHERE id='$id'";
        $result = $this->conn->query($query);
        if (!$result) die ("Database access failed: " . $this->conn->error);
        return $result;
    }

    /*
     * hash safety
     */
    private function myhash($password){
        $salt1 ="maha";
        $salt2 ="stas";
        return hash('ripemd128', "$salt1$password$salt2");
    }

    function destroy_session_and_data()
    {
        $_SESSION = array();
        setcookie(session_name(), '', time() - 2592000, '/');
        session_destroy();
    }
    /*
     * start sesseion with more safety
     */
    function start_session(){
        session_start();
        if (!isset($_SESSION['initiated']))
        {
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
    function different_user(){
        $this->destroy_session_and_data();
        echo "Ввойдите занова";
    }

    /*
     * safety out
     */
    function mysql_entities_fix_string($conn, $string){
        return htmlentities(mysql_fix_string($conn, $string));
    }

    function mysql_fix_string($conn, $string){
        if (get_magic_quotes_gpc()) $string = stripslashes($string);
        return $conn->real_escape_string($string);
    }

    /*
     * safety in
     */
    function sanitizeString($var){
        //$var =stripslashes($var);
        $var = strip_tags($var);
        $var = htmlentities($var);
        return $var;
    }

    function sanitizeMySQL($connection, $var){
        $var = $connection->real_escape_string($var);
        $var = $this->sanitizeString($var);
        return $var;
    }

    function __destruct(){
        $this->conn->close();
    }

}

?>