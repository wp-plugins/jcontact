<?php
    // add shortcode 
    add_shortcode('j-contact', 'j_contact');

    function j_contact($atts, $content = null)
    {
        extract(shortcode_atts(array(
            'id' => '',
            'bg' => '',
            'text' => '',
            ), $atts)); 
            global $wpdb;
            // shortcode values will be $id, $bg, $text
             
            if(isset($_POST['jc_submit'])){
//                echo '<pre>';
//                var_dump($_POST);
//                echo '</pre>';                
                
                $inputValidate = true;
                $errorName = null;
                $errorEmail = null;
                $errorUrl = null;
                $errorDescription = null;
                
                // name validation
                $name = $_POST['jc_name'];
                if( strlen($name)<1 || strlen($name)>50 ) {
                    $errorName = "Name length should be 1 to 50 chars.";
                    $inputValidate = false;                    
                } else {
                    if(!ctype_alpha($name)) {                        
                        $errorName = "Name should be only alphabets.";
                        $inputValidate = false;                        
                    }
                }
                
                // email validation
                $email = $_POST['jc_email'];
                if(!filter_var($email, FILTER_VALIDATE_EMAIL) ) {
                    $errorEmail = "Email is not valid.";
                    $inputValidate = false;                    
                }
                
                // url validation
                $url = $_POST['jc_url'];
                if( strlen($url)<1 || strlen($url)>50 ) {
                    $errorUrl = "Url length should be 1 to 50 chars.";
                    $inputValidate = false;                    
                }
                // description validation
                $description = $_POST['jc_description'];
                if( strlen($description)<1 || strlen($description)>255 ) {
                    $errorDescription = "Description length should be 1 to 255 chars.";
                    $inputValidate = false;                    
                }
                
                // if validated
                if($inputValidate) {
                    $date = date('Y-m-d G:i:s');
                    $name = mysql_real_escape_string($name);                    
                    $url = mysql_real_escape_string($url);
                    $description = mysql_real_escape_string($description);
                    
                    $sql = "INSERT INTO `".JC_TABLE_USERS."` 
                        (`name`, `email`, `url`, `description`, `status`, `date`) 
                        VALUES ('$name', '$email', '$url', '$description', '$status', '$date')";
                    $wpdb->query($wpdb->prepare($sql)) or die('Could not insert data.' . mysql_error());
                    
                    // SEND EMAIL
                    // fetch first contact email
                    $sql = "SELECT `template` FROM `".JC_TABLE_EMAIL."` WHERE `type`='1'";
                    $result = $wpdb->get_row($sql);
                    $message = $result->template;
                    $message = str_replace('{{name}}', ucwords($name), $message);
                    $message = str_replace('{{email}}', ucwords($email), $message);
                    $message = str_replace('{{url}}', ucwords($url), $message);
                    $to = $email;
                    $subject = 'First contact';
                    // headers
                    $headers  = "MIME-Version: 1.0" . '\r\n';
                    $headers .= "Content-type:text/html;charset=iso-8859-1" . '\r\n';
                    $headers .= 'From: <'.JC_FROM_EMAIL. '> \r\n';
                    //$headers .= 'Cc: myboss@example.com' . "\r\n";

                    if(mail($to, $subject, $message, $headers)) {
                        echo 'Email has been sent successfully, please check your email.';
                    } else {
                        echo 'Email failed, Please try again!';
                    }
                }                
            }
?>        
<style>
    .jc_red { color: red; text-decoration: blink; }
</style>
      <div id="container">
            <div id="jc_form" class="">
                <form action="" method="post">
                    <table>
                       <tr>
                           <td>Name:</td>
                           <td>
                               <input type="text" name="jc_name" id="jc_name" class="jc_textbox" value="<?php if(isset($name)) { echo $name; } ?>" />
                               <span class="jc_red"><?php echo (isset($errorName)) ? $errorName : ''; ?></span>
                           </td>                           
                       </tr>        
                       <tr>
                           <td>Email:</td>
                           <td>
                               <input type="text" name="jc_email" id="jc_email" class="jc_textbox" value="<?php if(isset($email)) { echo $email; } ?>" />
                               <span class="jc_red"><?php echo (isset($errorEmail)) ? $errorEmail : ''; ?></span>
                           </td>
                       </tr>
                       <tr>
                           <td>URL:</td>
                           <td>
                               <input type="text" name="jc_url" id="jc_url" class="jc_textbox" value="<?php if(isset($url)) { echo $url; } ?>" />
                               <span class="jc_red"><?php echo (isset($errorUrl)) ? $errorUrl : ''; ?></span>
                           </td>
                       </tr>
                       <tr>
                           <td>Description:</td>
                           <td>
                               <textarea name="jc_description" id="jc_description" class="jc_textarea"><?php if(isset($description)) { echo $description; } ?></textarea>
                               <span class="jc_red"><?php echo (isset($errorDescription)) ? $errorDescription : ''; ?><span>
                           </td>
                       </tr>
                       <tr>
                           <td></td>
                           <td><input type="submit" name="jc_submit" class="submit" value="Submit" /></td>
                       </tr>
                    </table>
                </form>                
            </div>
          </div>
 <?php } ?>