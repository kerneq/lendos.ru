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
    public function __construct($id, $question, $name, $email_address, $phone, $message, $vk, $fb)
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
        \nFACEBOOK: $fb\n
        \nQuestion: $question\n
        \nMessage:\n$message";
        // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com
        $headers = "From: noreply@localhost.com\n";
        $headers .= "Reply-To: $email_address";
        $result = mail($to, $email_subject, $email_body, $headers);

        if (!$result) echo "Ваша письмо не отправилось!";
        $result = mail($tos, $email_subject, $email_body, $headers);

        if (!$result) echo "Ваша письмо не отправилось!";
    }
}

?>