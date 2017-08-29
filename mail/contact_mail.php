<?php
/**
 * Created by PhpStorm.
 * User: maha
 * Date: 12.08.17
 * Time: 17:27
 */
/*
 * html form
 *form -> action page of post "" to localhost
 */
class contact_mail
{
    /*
     * if $num_order=NULL
     * for success.php
     * else
     * for SUPPORT.php
     */
    public function __construct($id, $question, $name, $email_address, $phone, $message, $vk, $fb, $num_order, $hn, $un, $pw, $db)
    {
        $question = strip_tags(htmlspecialchars($question));

        //getting string and protect
        $message = strip_tags(htmlspecialchars($message));
        // Add your email
        $to = 'mkon.masha@gmail.com';
        $tos = 'iters@yandex.ru';
        $email_subject = "Website Contact Form:  $name";
        $email_body = "You have received a new message 
    from your website contact form.\n\n" .
            "Here are the details:\n
          \nUser_id: $id\n  
        \nName: $name\n
        \nEmail: $email_address\n
        \nPhone: $phone\n
        \nVK: $vk\n
        \nFACEBOOK: $fb\n";
        //for SUPPORT.php
        $support= "\nQuestion: $question\n
        \nMessage:\n$message";

        if ($num_order!=NULL){
            //for success.php
            include_once '../authorisation/DataBase.php';
            $bd=new DataBase($hn,$un,$pw,$db);
            //get order of special number
            $result = $bd->get_order($num_order);
            $result->data_seek(0);
            $row = $result->fetch_array(MYSQLI_NUM);
            $order_ifa ="\nNumber of order: $row[0]\n
            \nUrl_landing: $row[2]\n  
            \nVK_pixel: $row[3]\n
            \nFB_pixel: $row[4]\n
            \nMETKA_pixel: $row[5]\n
            \nDate: $row[6]\n
            \nPrice: $row[7]\n  
            \nText: $row[8]\n
            \nModules: $row[9]\n
            \nUrl_download: $row[10]\n
            \nStatus:\n$row[11]\n";
            $email_body.=$order_ifa;
        } else {
            $email_body.=$support;
        }
        // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com
        $headers = "From: noreply@localhost.com\n";
        $headers .= "Reply-To: $email_address";
        //send to Maha
        $result = mail($to, $email_subject, $email_body, $headers);
        if (!$result) echo "Ваша письмо не отправилось!";
        //send to Stas
        $result = mail($tos, $email_subject, $email_body, $headers);
        if (!$result) echo "Ваша письмо не отправилось!";
    }
}

?>