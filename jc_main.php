<?php
	
/*
	 Plugin Name: jConjact
	 Plugin URI: www.njoy.wordpress.com
	 Description: The jContact plugin allows admin to manage visitor's contact information, with email notification. Use shortcode [j-contact].
	 Author: Amit Malakar (JOY)
	 Version: 1.0
	 Author URI: http://www.njoy.wordpress.com
	 Created by JOY.
	 (website: www.njoy.wordpress.com	email: njoy.mca@gmail.com)	 
*/

	$siteurl = get_option('siteurl');
	define('JC_FOLDER', dirname(plugin_basename(__FILE__)));
	define('JC_URL', $siteurl . '/wp-content/plugins/' . JC_FOLDER);
	define('JC_FILE_PATH', dirname(__FILE__));
	define('JC_DIR_NAME', basename(JC_FILE_PATH));

	// this is the table prefix
	global $wpdb, $table_prefix;
	define('JC_TABLE_USERS', $table_prefix . 'jc_users');
    define('JC_TABLE_EMAIL', $table_prefix . 'jc_email_templates');
    
    // from email address
    define('JC_FROM_EMAIL', 'no-reply@wordpress.com');
	
	register_activation_hook(__FILE__, 'jc_install');
	register_deactivation_hook(__FILE__, 'jc_deactivate');
    register_uninstall_hook(__FILE__, 'jc_uninstall');
	
	function jc_install()
	{		
		global $wpdb;
		// Create USERS table
		$jc_table_users = JC_TABLE_USERS;
		if ($wpdb->get_var("show tables like '$jc_table_users'") != $jc_table_users)
		{
			$sql0  = "CREATE TABLE IF NOT EXISTS `" . $jc_table_users . "` ( ";
			$sql0 .= "  `id`  int(11)   NOT NULL auto_increment, ";
			$sql0 .= "  `name` varchar(50) NOT NULL, ";
			$sql0 .= "  `email` varchar(50) NOT NULL, ";
			$sql0 .= "  `url` varchar(100) NOT NULL, ";            
			$sql0 .= "  `description` text NOT NULL, ";
            $sql0 .= "  `our_url` varchar(100) NOT NULL, ";
			$sql0 .= "  `status` int(11) NOT NULL, ";
			$sql0 .= "  `date` datetime NOT NULL, ";
			$sql0 .= "  PRIMARY KEY `id` (`id`) ";
			$sql0 .= ") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
			#We need to include this file so we have access to the dbDelta function below (which is used to create the table)
			require_once(ABSPATH . '/wp-admin/upgrade-functions.php');
			dbDelta($sql0);
		}
		
        // Create EMAIL TEMPLATE table
        $jc_table_email = JC_TABLE_EMAIL;
        if($wpdb->get_var("show tables like '$jc_table_email'") != $jc_table_email)
        {
            $sql0 = "CREATE TABLE IF NOT EXISTS `".JC_TABLE_EMAIL."` (";
            $sql0.= " `id` int(11) NOT NULL AUTO_INCREMENT,";
            $sql0.= " `type` varchar(50) NOT NULL,";
            $sql0.= " `template` text NOT NULL,";
            $sql0.= " PRIMARY KEY (`id`)";
            $sql0.= ") ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
            require_once(ABSPATH . '/wp-admin/upgrade-functions.php');
            dbDelta($sql0) or die(mysql_error());
        }
        
		// Set DEFAULT configuration
		$sql = "INSERT INTO `".JC_TABLE_EMAIL."` (`type`, `template`) VALUES
		('1', 'Hi {{name}},

            This email will shoot on first contact.
            Your link is {{url}}
            Our generated link is {{our_url}}'), 
        ('2', 'Hi {{name}},

            This email will shoot on first contact.
            Your link is {{url}}
            Our generated link is {{our_url}}'), 
        ('3', 'Hi {{name}},

            This email will shoot on first contact.
            Your link is {{url}}
            Our generated link is {{our_url}}')";
		$wpdb->query($wpdb->prepare($sql)) or die(mysql_error()); 
		
	}
	
	function jc_deactivate()
	{
        //die('deactivation hook');
		global $wpdb;
		$del_albums = "DROP TABLE IF EXISTS `". JC_TABLE_USERS. "`";
		$wpdb->query($wpdb->prepare($del_albums));
        
        $del_albums = "DROP TABLE IF EXISTS `". JC_TABLE_EMAIL. "`";
		$wpdb->query($wpdb->prepare($del_albums));
	}
    
    function jc_uninstall()
    {
        die('uninstallation hook');        
    }
	
	// ALSO INSERT ALL DEFAULT SETTINGS - MYSQL INSERT COMMAND
	
	// Hook for adding admin menus
	// add_action('admin_menu', 'mt_add_pages');
	add_action('admin_menu', 'jcontact_pages');
	
	// action function for above hook
	function jcontact_pages()
	{
		// Add a new top-level menu (ill-advised):
		add_menu_page(__('jContact', 'jc-test'), __('jContact', 'jc-test'), 'manage_options', 'jc-top-level-handle', '', '../wp-content/plugins/jcontact/images/J.png', '512');        
		// Add a second submenu to the custom top-level menu:
		add_submenu_page('jc-top-level-handle', __('User Info', 'menu-test'), __('User Info', 'menu-test'), 'manage_options', 'jc-top-level-handle', 'jc_userinfo');
        // Add a submenu to the custom top-level menu:
		//add_submenu_page('jc-top-level-handle', __('Contact Form', 'jc-test'), __('Contact Form', 'menu-test'), 'manage_options', 'editform', 'jc_form_page');
        // Email message
        add_submenu_page('jc-top-level-handle', __('Email Templates', 'jc-email'), __('Email Templates', 'menu-test'), 'manage_options', 'email', 'jc_email_template');
        // Add a second submenu to donate
		add_submenu_page('jc-top-level-handle', __('Donate', 'menu-test'), __('Donate', 'menu-test'), 'manage_options', 'donate', 'jc_donate');
	}
	
    function jc_donate()
    {
        include 'jc_donate.php';        
    }    
    function jc_userinfo()
	{
		include 'jc_userinfo.php';
	}    
    function jc_email_template()
    {
        include 'jc_email_template.php';
    }	
    function prefix_on_deactivate() 
    {
        $table_name = $wpdb->prefix. JC_TABLE_EMAIL;
        $sql = "DROP TABLE $table_name";
        require_once '';
    }
    
    // Hook for adding ajax calls for approve and reject
    require_once 'jc_action.php';
    add_action('approve_reject', 'jc_approve_reject');
    
    function jc_approve_reject()
    {
        include 'jc_action.php';
    }
    
    
	// shortcode form
	require_once 'jc_ui_form.php';
	
	