<?php 
    global $wpdb;
    if($_POST['email_submit']) {
        
        // validation
        $first_contact = $_POST['first_contact'];
        if( strlen($first_contact)<1 || strlen($first_contact)>255 ) {
            $errorFC = "Email should be of 1 to 255 chars.";            
        } else {        
            // 1 = first contact email contact
            $sql1 = "UPDATE `" .JC_TABLE_EMAIL."` SET `template`='$first_contact' WHERE `type`='1'";            
            $wpdb->query($wpdb->prepare($sql1));
        }
        
        $approved = $_POST['approved'];
        if( strlen($approved)<1 || strlen($approved)>255 ) {
            $errorAP = "Email should be of 1 to 255 chars.";            
        } else {        
            // 2 = approval email 
            $sql2 = "UPDATE `" .JC_TABLE_EMAIL."` SET `template`='$approved' WHERE `type`='2'";
            $wpdb->query($wpdb->prepare($sql2));
        }
        
        $rejected = $_POST['rejected'];
        if( strlen($rejected)<1 || strlen($rejected)>255 ) {
            $errorRJ = "Email should be of 1 to 255 chars.";            
        } else {        
            // 3 = rejection email
            $sql3 = "UPDATE `" .JC_TABLE_EMAIL."` SET `template`='$rejected' WHERE `type`='3'";
            $wpdb->query($wpdb->prepare($sql3));
        }        
    }
    
    // fetch emails from DB
    $sql = "SELECT `template` FROM `".JC_TABLE_EMAIL."` WHERE `type`='1'";
    $result = $wpdb->get_row($sql);
    $first_contact = $result->template;
    
    $sql = "SELECT `template` FROM `".JC_TABLE_EMAIL."` WHERE `type`='2'";
    $result = $wpdb->get_row($sql);
    $approved = $result->template;
    
    $sql = "SELECT `template` FROM `".JC_TABLE_EMAIL."` WHERE `type`='3'";
    $result = $wpdb->get_row($sql);
    $rejected = $result->template;    
?>
<style>
    .jc_red { color: red; text-decoration: blink; }
</style>
<div class="wrap">  
    <?php echo "<h2>" . __('Email Templates') . "</h2>"; ?>  
    <form action="" method="post">
        <table class=" page fixed" cellspacing="0">
            <tr>
                <td><strong><label for="first_contact">On First Contact:</label></strong></td>
            </tr>
            <tr>
                <td>                   
                    <textarea name="first_contact" class="jc_email_textarea" rows="10" cols="100"><?php echo (isset($first_contact)) ? ($first_contact) : null; ?></textarea>
                    <span class="jc_red"><?php echo (isset($errorFC)) ? $errorFC : null; ?></span>
                </td>
            </tr>
            <tr>
                <td><strong><label for="first_contact">Approval email:</label></strong></td>
            </tr>
            <tr>
                <td>
                    <textarea name="approved" class="jc_email_textarea" rows="10" cols="100"><?php echo (isset($approved)) ? ($approved) : null; ?></textarea>
                    <span class="jc_red"><?php echo (isset($errorAP)) ? $errorAP : null; ?></span>
                </td>
            </tr>
            <tr>
                <td><strong><label for="first_contact">Rejection email:</label></strong></td>
            </tr>
            <tr>
                <td>
                    <textarea name="rejected" class="jc_email_textarea" rows="10" cols="100"><?php echo (isset($rejected)) ? ($rejected) : null; ?></textarea>
                    <span class="jc_red"><?php echo (isset($errorRJ)) ? $errorRJ : null; ?></span>
                </td>
            </tr>
            <tr>            
                <td><input type="submit" name="email_submit" value="Update" class="button-primary"/></td>
            </tr>
        </table>
    </form>
    <br />
    <?php
        $columns = array(
            'name' => 'Legend Name',
            'code' => 'Legend Code'
        );
        register_column_headers('j-list-user', $columns);
    ?>    
    <div class="legends" style="position:absolute; top:70px; left:850px; width:300px; ">
        <table class="widefat page fixed">
            <thead>
                 <tr>
                    <?php print_column_headers('j-list-user'); ?>
                </tr>
            </thead>            
            <tr>                                
                <td>Name</td>
                <td>{{name}}</td>
            </tr>
            <tr>                
                <td>Email</td>
                <td>{{email}}</td>
            </tr>
            <tr>                
                <td>URL</td>
                <td>{{url}}</td>
            </tr>
            <tr>                
                <td>Our URL</td>
                <td>{{our_url}}</td>
            </tr>
        </table>            
    </div>
</div>