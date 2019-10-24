<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

function theme_enqueue_styles() {

    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array('bootstrap'));
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array('parent-style', 'bootstrap')
    );
}

function wpb_adding_scripts() {

      wp_register_script('my_amazing_script', plugins_url('responsive-tables.js', FILE), array('jquery'),'1.1', true);
     wp_enqueue_script('my_amazing_script');
 } 

add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' ); 

//Вывод атрибутов на странице товара


remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 40 );
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 55 );

function custom_woocommerce_catalog_orderby_remove( $orderby ) {

unset($orderby["popularity"]);
unset($orderby["rating"]);
unset($orderby["price"]);
unset($orderby["price-desc"]);
return $orderby;
}
add_filter( "woocommerce_catalog_orderby", "custom_woocommerce_catalog_orderby_remove", 20 );


function tutsplus_excerpt_in_product_archives() {

 global $product;

// Получаем элементы таксономии атрибута artist

$attribute_names = get_the_terms($product->get_id(), 'pa_artist');
$attribute_name = "pa_artist";
if ($attribute_names) {

// Вывод имени атрибута artist
// Выборка значения заданного атрибута

foreach ($attribute_names as $attribute_name):

// Вывод значений атрибута artist

echo $attribute_name->name;echo('</br>');
endforeach;
} 
}
add_action( 'woocommerce_after_shop_loop_item_title', 'tutsplus_excerpt_in_product_archives', 2 );

// Определяем место вывода атрибута

// Функция вывода атрибута

function productItem() {
global $product;

// Получаем элементы таксономии атрибута artist

$attribute_names = get_the_terms($product->get_id(), 'pa_artist');
$attribute_name = "pa_artist";
if ($attribute_names) {
  
// Вывод имени атрибута artist

echo wc_attribute_label($attribute_name);echo(': ');

// Выборка значения заданного атрибута

foreach ($attribute_names as $attribute_name):

// Вывод значений атрибута artist

echo $attribute_name->name;echo('</br>');
endforeach;
}
}

// Определяем место вывода атрибута

add_action('woocommerce_single_product_summary', 'productItem', 11);



add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab_status' );
function woo_new_product_tab_status( $tabs ) {
	
// Adds the new tab
	
	$tabs['test_tab1'] = array(
		'title' 	=> __( 'Locations', 'woocommerce' ),
		'priority' 	=> 51,
		'callback' 	=> 'woo_new_product_tab_content_status'
	);

	return $tabs;

}


add_filter( 'woocommerce_product_tabs', 'woo_new_product_tab_archive' );
function woo_new_product_tab_archive( $tabs ) {
	
	// Adds the new tab
	
	$tabs['test_tab2'] = array(
		'title' 	=> __( 'Archive', 'woocommerce' ),
		'priority' 	=> 51,
		'callback' 	=> 'woo_new_product_tab_content_archive'
	);

	return $tabs;

}


add_filter( 'woocommerce_product_tabs', 'devise_woo_rename_reviews_tab', 98);
function devise_woo_rename_reviews_tab($tabs) {

$tabs['additional_information']['title'] = 'Details';

return $tabs;
}

add_filter( 'woocommerce_product_tabs', 'devise_woo_rename_reviews_tab1', 98);
function devise_woo_rename_reviews_tab1($tabs) {

$tabs['description']['title'] = 'Info';

return $tabs;
}


function my_woocommerce_account_menu_items($items) {

    $items['dashboard'] = " ";
    $inventory = array( 'Inventory' => 'Inventory' );
   
    $notification = array( 'Notifications' => 'Notifications' );
    $account = array( 'Account' => 'Account details' );
    $change = array( 'Change' => 'Change Password' );
 	  $logout = array( 'Logout' => 'Log out' );

	  $items = array_slice( $items, 0, 1, true ) 
	+ $notification
	+ $account
	+ $change
	+ $logout
	+ $inventory
	+ array_slice( $items, 1, NULL, true );
 

    return $items;

}
add_filter( 'woocommerce_account_menu_items', 'my_woocommerce_account_menu_items', 10 );

add_filter( 'woocommerce_get_endpoint_url', 'misha_hook_endpoint', 10, 4 );
function misha_hook_endpoint( $url, $endpoint, $value, $permalink ){
 
	if( $endpoint === 'inventory' ) {
 
	
		$url = site_url('shop');
 
	}

if( $endpoint === 'History' ) {
 		
		$url = site_url('hystory');
 
	}
	if( $endpoint === 'Notif' ) {
		
		$url = site_url('notifications');
 
	}

if( $endpoint === 'Change' ) {
 		
		$url = site_url('lost-password');
 
	}

	if( $endpoint === 'logout' ) {
 
		$url = site_url('logout');
 
	}
	return $url;

	if( $endpoint === 'Change' ) {
 
		$url = site_url('changepass');
 
	}
	return $url;
 
}

 function my_dashboard_welcome_message( $current_user ) {
  echo 'hello ' . $current_user->display_name;
 }

add_filter( 'lostpassword_url', function( $url, $redirect )
{
    remove_all_filters( 'lostpassword_url' );

    return wp_lostpassword_url( $redirect );
}, PHP_INT_MAX, 2 );

function wcfmvm_0310_vendor_dashboard_username( $vendor_id ) {
	$wcfm_membership_id = get_user_meta( $vendor_id, 'wcfm_membership', true );
	if( $wcfm_membership_id && wcfm_is_valid_membership( $wcfm_membership_id ) ) {
		$next_schedule = get_user_meta( $vendor_id, 'wcfm_membership_next_schedule', true );
		$current_time = strtotime( 'midnight', current_time( 'timestamp' ) );
		
		if( $next_schedule ) {
			$date = date( 'Y-m-d', $current_time );
			$renewal_date = date( 'Y-m-d', $next_schedule );
			$datetime1 = new DateTime( $date );
			$datetime2 = new DateTime( $renewal_date );
			$interval = $datetime1->diff( $datetime2 );
			$interval = $interval->format( '%r%a' );
			
			echo '<span class="wcfm_welcomebox_member">( ' . __( 'Expire In', 'wc-multivendor-membership' ) . ': <mark>' . $interval . '</mark> days)</span>';
		}
	}
}
add_action( 'wcfm_dashboard_after_username', 'wcfmvm_0310_vendor_dashboard_username', 50 );


?>


