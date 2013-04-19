<?php
    global $wpdb;
	//define('JC_TABLE_USERS', $table_prefix . 'jc_users');
    //define('JC_TABLE_EMAIL', $table_prefix . 'jc_email_templates');        
       
    if(isset($_POST)) 
    {        
        if(isset($_POST['user_id']) && isset($_POST['status'])) {            

            $user_id = $_POST['user_id'];
            $status  = $_POST['status'];
            $our_url = $_POST['our_url'];
            $template = null;

            if($status == 'delete') {
                $query = "DELETE FROM `".JC_TABLE_USERS."` WHERE `id`='$user_id'";
                mysql_query($query);
                echo 'deleted';
            } else {             
                if($status == 'approve') {
                    $status = 1;
                    $template = 2;
                } else if($status == 'reject') {
                    $status = 2;
                    $template = 3;
                } 

                if($status) {
                    $query  = "UPDATE `".JC_TABLE_USERS."` SET `status`='$status' ";
                    if($status==1) {
                        $query.= ", `our_url`='$our_url' ";
                    }
                    $query .= " WHERE `id`='$user_id'";
                    mysql_query($query) or die(mysql_error());

                    // SEND ACCEPTION / REJECTION EMAIL
                    // fetch first contact email
                    $sql = "SELECT `template` FROM `".JC_TABLE_EMAIL."` WHERE `type`='$template'";
                    $result = $wpdb->get_row($sql);
                    $message = $result->template;
                    $our_url = 'www.google.com';
                    $message = str_replace('{{name}}', ucwords($name), $message);
                    $message = str_replace('{{email}}', ucwords($email), $message);
                    $message = str_replace('{{url}}', ucwords($url), $message);
                    $message = str_replace('{{our_url}}', ucwords($our_url), $message);
                    $to = $email;
                    $subject = 'First contact';
                    // headers
                    $headers = "MIME-Version: 1.0" . '\r\n';
                    $headers .= "Content-type:text/html;charset=iso-8859-1" . '\r\n';
                    $headers .= 'From: <'.JC_FROM_EMAIL. '> \r\n';
                    //$headers .= 'Cc: myboss@example.com' . "\r\n";

                    mail($to, $subject, $message, $headers);

                    if($status==1) { $status = 'Approved'; } else if($status==2) { $status = 'Rejected'; }                
                    echo ucfirst($status);
                    die();
                }
            }
        }         
    }    