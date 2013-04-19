<?php

wp_enqueue_script('jquery');

$columns = array(
    'sno' => 'S.No.',    
    'name' => 'Name',
    'email' => 'Email',
    'description' => 'Description',
    'status' => 'Status',
    'action' => 'Action'
);
register_column_headers('j-list-user', $columns);
?>
<div class="wrap">
    <style>
        .mypaypal { text-align: right; padding-top: 10px;}
    </style>
    <div class="mypaypal">
        <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="amitmalakar2010@gmail.com">
            <input type="hidden" name="currency_code" value="USD">
            <input type="hidden" name="item_name" value="Donation">
            <input type="hidden" name="amount" value="">
            <!--<input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">-->
            <input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Make donation with PayPal - it's fast, free and secure!">
        </form>
    </div>
    <?php echo "<h2>" . __('User Listing') . "</h2>"; ?>  
    <table class="widefat page fixed" cellspacing="0">
        <thead>
            <tr>
                <?php print_column_headers('j-list-user'); ?>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <?php print_column_headers('j-list-user', false); ?>
            </tr>
        </tfoot>
        <tbody>
            <?php
            global $wpdb;
            $i = 1;
            $sql = "SELECT * FROM " . JC_TABLE_USERS . " ORDER BY `id` DESC";
            $results = $wpdb->get_results($sql) or die(mysql_error());
            //var_dump($results);
            if (count($results) > 0) {
                $display_row = null;
                foreach ($results as $result) {
                    if($result->status == 0) {
                        $status = 'Pending';
                    } else if($result->status == 1) {
                        $status = 'Approved';
                    } else if($result->status == 2) {
                        $status = 'Rejected';
                    }
                    $display_row =  "<tr id='trid".$result->id."'><td>" . $i . "</td>";
                    $display_row.= "<td>" . $result->name . "</td>";
				 	$display_row.= "<td><a href='mailto:".$result->email."'>" . $result->email . "</a></td>";
				 	$display_row.= "<td>" . $result->description . "</td>";
                    $display_row.= "<td><img id='ajax_loader' scr='".JC_URL."/images/ajax.gif' style='display:none;' /><span id='user_status".$result->id."'>" . $status . "</span></td>";
                    if($result->status==0) {
                        $display_row.= "<td><span id='ar".$result->id."'><a href='javascript:addurl(".$result->id.")'>Approve</a> ";
                        $display_row.= "| <a href='javascript:reject(".$result->id.")'>Reject</a></span>";
                        $display_row.= "<span id='done".$result->id."' style='display:none;'><input type='text' id='our_url".$result->id."' placeholder='our url'/>";
                        $display_row.= " <a href='javascript:approve(".$result->id.")'>Done</a></span>";
                        $display_row.= "</td></tr>";
                    } else {
                        $display_row.= "<td><a href='javascript:del(".$result->id.")'>Delete</a></td></tr>";
                    }                    
                    echo $display_row;
                    $i++;
                }
            }
            ?>
        </tbody>
    </table>
</div>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<script type="text/javascript">    
    function addurl(id)
    {
        jQuery('#ar'+id).hide();        
        jQuery('#done'+id).show();
    }
    function approve(id) {     
        jc_update('approve', id);    
    }
    function reject(id) {        
        jc_update('reject', id);
    }
    function del(id)
    {
        jc_update('delete', id);
    }
    function jc_update(status, id) {
        jQuery('#user_status'+id).hide();
        jQuery('#ajax_loader').show();
        jQuery.post('<?php echo get_option('siteurl') . '/wp-admin/admin-ajax.php'; ?>',
            {
                user_id: id,
                status: status,
                our_url: jQuery('#our_url'+id).val()
            },
            function (response) {                
                if(response=='deleted') {
                    jQuery('#trid'+id).remove();
                } else if(response == 'Approved'){
                    jQuery('#user_status'+id).html(response);
                    jQuery('#ajax_loader').hide();
                    jQuery('#user_status'+id).show();
                    jQuery('#done'+id).hide();
                    jQuery('#ar'+id).show();
                    var myhtml = "<a href='javascript:del(" + id + ")'>Delete</a>";
                    jQuery('#ar'+id).html(myhtml);
                } else {
                    jQuery('#ajax_loader').hide();
                    jQuery('#user_status'+id).show();
                    jQuery('#user_status'+id).html(response);
                    var myhtml = "<a href='javascript:del(" + id + ")'>Delete</a>";
                    jQuery('#ar'+id).html(myhtml);
                }
            }
        );
    }
</script>