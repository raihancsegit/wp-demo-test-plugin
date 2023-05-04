<?php 
/**
 * @wordpress-plugin
 * Plugin Name:       WordPress Demo Plugin
 * Plugin URI:        wpdemoplugin.com
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Raihan Islam
 * Author URI:        raihan.website
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wdp
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
class WDP {

    public function __construct()
    {
        add_action('admin_menu',array(&$this,'register_wordpress_demo_plugin_menu'));
        add_action('admin_init',array(&$this,'register_setting_options'));
       // add_action( 'admin_enqueue_scripts',array(&$this,'admin_register_script') );
        add_action( 'template_redirect',array(&$this,'my_login') );
        add_shortcode('custom-login',array(&$this,'custom_login_form'));
        $wdp_enable = '';
        $wdp_enable = get_option('wdp_enable') ? get_option('wdp_enable') : '';
        if($wdp_enable == 1){
            add_filter( 'login_url', array(&$this,'my_custom_login_url' ));
        }
    }


    public function register_wordpress_demo_plugin_menu()
    {
        add_submenu_page( 
        'options-general.php', 
        'WP Demo Plugin', 
        'WP Demo Plugin', 
        'manage_options', 
        'wp-demo-plugin', 
        array(&$this,'init_wp_demo_plugin')
        );
    }

    public function init_wp_demo_plugin(){
        ?>
<div class="product-sales-count">
    <h2>WP Test Demo</h2>
    <form action="options.php" method="post">
        <div class="main-setting-section-wdp">
            <table cellpadding="10">
                <tr>
                    <td valign="top"
                        style="background: #fff;box-shadow: 10px 10px 20px 10px #f5f5f5;padding-left: 20px;"
                        width="500">
                        <p>
                            <input type="checkbox" id="wdp_enable" name="wdp_enable" value="1"
                                <?php checked(get_option('wdp_enable'),1);?> />
                            <label> Active/Deactive Custom Login Option</label>
                        </p>
                        <p>
                            <label> Chose Form Template</label>
                            <select name="wdp_login_tem" id="wdp_login_tem">
                                <option value="1" <?php selected( get_option('wdp_login_tem'), 1 )?>>Login
                                    Teamplate 1 </option>
                                <option value="2" <?php selected( get_option('wdp_login_tem'), 2 )?>>Login
                                    Teamplate 2 </option>
                            </select>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <span class="submit-btn">
            <?php _e( get_submit_button('Save Settings','button-primary','submit','','') , 'wdp');?>
        </span>
        </p>
        <?php settings_fields('wdp_options'); ?>
    </form>
</div>
<?php
    }

    public function register_setting_options(){
        register_setting( 'wdp_options', 'wdp_enable', 'sanitize_text_field');
        register_setting( 'wdp_options', 'wdp_login_tem', 'sanitize_text_field');
         
    }

    public function custom_login_form(){
        ob_start();
        
        include 'pub/login.php';
        $html = ob_get_clean();
        return $html;
     }

     public function my_login(){
        if(isset($_POST['user_login'])){
            $username = esc_sql( $_POST['username'] );
            $pass = esc_sql( $_POST['pass'] );
    
            $credentials = array(
                    'user_login' =>  $username,
                    'user_password' =>$pass,
            );
            $user = wp_signon( $credentials);
    
            if(!is_wp_error( $user )){
                if($user->roles[0] == 'adminstrator'){
                    wp_redirect( admin_url() );
                    exit;
                }
                else {
                    wp_redirect( site_url() );
                }
                
            }else {
                echo $user->get_error_message();
            }
        }
     }

     public function my_custom_login_url(){
        return home_url( 'login' );
    }
    
    

}
if(class_exists('WDP')):
    $wdpobj = new WDP;
    endif;