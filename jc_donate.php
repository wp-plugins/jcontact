<?php
$columns = array(
    'description' => '',
    'user details' => ''
);
register_column_headers('j-list-user', $columns);
?>
<h1>jContact Form</h1>
<div class="wrap">
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
            <tr>
                <td>If you liked this plugin and want to appreciate my work please donate.</td>
                <td>
                    <form name="_xclick" action="https://www.paypal.com/cgi-bin/webscr" method="post">
                        <input type="hidden" name="cmd" value="_xclick">
                        <input type="hidden" name="business" value="amitmalakar2010@gmail.com">
                        <input type="hidden" name="currency_code" value="USD">
                        <input type="hidden" name="item_name" value="Donation">
                        <input type="hidden" name="amount" value="">
                        <!--<input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_buynow_LG.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!">-->
                        <input type="image" src="http://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="Make donation with PayPal - it's fast, free and secure!">
                    </form>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>For any assistance or any specific modifications to the plugin that suits your requirement please contact me @ with subject <strong>"jContact"</strong></td>
                <td><a href="mailto:amitmalakar2010@gmail.com">amitmalakar2010@gmail.com</a></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>
