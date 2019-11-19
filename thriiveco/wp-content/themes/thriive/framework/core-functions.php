<?php 
	if ( ! function_exists( 'thriive_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	
	function thriive_setup() {		
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on thriive, use a find and replace
		 * to change 'thriive' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'thriive', get_template_directory() . '/languages' );

		session_start();
		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'menu-1' => esc_html__( 'Primary', 'thriive' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		// Set up the WordPress core custom background feature.
		add_theme_support( 'custom-background', apply_filters( 'thriive_custom_background_args', array(
			'default-color' => 'ffffff',
			'default-image' => '',
		) ) );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support( 'custom-logo', array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		) );
	}
endif;


/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function thriive_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'thriive_content_width', 640 );
}

function wpdocs_after_setup_theme() {
    add_theme_support( 'html5', array( 'search-form' ) );
}

function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}

//Image regenerate
function thriive_image_sizes() 
{
    add_image_size('home_banner', 807, 367, true);
    add_image_size('home_banner_mobile', 372, 169, true);
    add_image_size('full_banner', 777, 333, false);
    add_image_size('blog_ailment_detail', 369, 152, true);
    add_image_size('event_img_gallery', 381, 210, true);
    add_image_size('blog_feature_img', 450, 250, true);
    add_image_size('related_blog', 540, 208, true); 
    add_image_size('featured_post_mobile', 94, 94, true);
    add_image_size('featured_blog', 330, 200, true);
    add_image_size('featured_blog_mobile', 185, 150, true);  	
}

function custom_image_sizes_choose($sizes) 
{
    $custom_sizes = array(
        'home_banner' => 'Home banner',
        'home_banner_mobile' => 'Home banner mobile',
        'full_banner' => 'Full Banner',
        'blog_ailment_detail' => 'Blog ailment detail',
        'event_img_gallery' => 'Event image gallery',
        'blog_feature_img' => 'Blog feature image',
        'related_blog' => 'Related Blog',
        'featured_blog' => 'featured blog',
        'featured_blog_mobile' => 'featured blog mobile'
    );
    return array_merge($sizes, $custom_sizes);
}

function add_taxonomy_menu() {
    global $menu;
    $menu[5] = array( __('Therapy'), 'edit_pages', 'edit-tags.php?taxonomy=therapy&post_type=wsp', '', 'menu-top menu-icon-page', 'menu-pages', 'dashicons-admin-page' );
    $menu[10] = array( __('Ailments'), 'edit_pages', 'edit-tags.php?taxonomy=ailment&post_type=wsp', '', 'menu-top menu-icon-page', 'menu-pages', 'dashicons-admin-page' );
}

function includeFiles(){
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/media.php' );	
}

function wpse_custom_upload_dir( $dir_data ) 
{
    // $dir_data already you might want to use
    $dir = wp_upload_dir();
    return [
        'path' => $dir['path'] . '/',
        'url' => $dir['url'] . '/',
        'subdir' => $dir['subdir'] . '/',
        'basedir' => $dir['basedir'] . '/',
        'error' => $dir['error'] . '/',
    ];
}

function user_form_handler(){
	$response = '';
	if(isset($_POST['signup_submit'])){
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'signup' ) ){
		//	die('Failed security check' );
		//} else{
			$response = signup($_POST);
		//}
	}else if(isset($_POST['personal_details_submit'])) {
		//printData($_POST);
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		$response = savePersonalDetails($_POST);
	}else if(isset($_POST['submit_package_details'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'package_details' ) ){
		//	die('Failed security check' );
		//}else{
			$response = savePackageDetails($_POST);
		//}
	}else if(isset($_POST['submit_about_yourself'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'about_yourself' ) ){
		//	die('Failed security check' );
		//}else{
			$response = saveSocialNetworkDetails($_POST);
		//}
	}else if(isset($_POST['submit_verification_details'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'verification_details' ) ){
		//	die('Failed security check' );
		//}else{
			$response = saveVerificationDetails($_POST);
		//}
	}else if(isset($_POST['login_submit'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'user_login' ) ){
		//	die('Failed security check' );
		//}else{
			$response = login($_POST);
		//}
	}else if(isset($_POST['feedback_submit'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'nonce_feedback' ) ){
		//	die('Failed security check' );
		//}else{
			$response = submitFeedback($_POST);
		//}
	}else if(isset($_POST['signup_seeker_submit'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'signup_seeker' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = signup_seeker($_POST);
		//}
	}else if(isset($_POST['submit_edit_therapies'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'edit_therapies' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = saveEditedTherapies($_POST);
		//}
	}else if(isset($_POST['update_seeker_submit'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'update_seeker' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = update_seeker($_POST);
		//}
	}else if(isset($_POST['submit_review'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'add_review' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = submit_review($_POST);
		//}
	}else if(isset($_POST['submit_add_image'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'add_gallery_image' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = addGalleryImage($_POST,$_FILES);
		//}	
	}else if(isset($_POST['submit_add_video'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'add_video_link' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = addGalleryVideo($_POST);
		//}	
	}else if(isset($_POST['btnDeleteGalleryImg'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'delete_gallery_img' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = deleteGalleryImg($_POST);
		//}	
	}else if(isset($_POST['delete_video'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'delete_video_link' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = deleteGalleryVideo($_POST);
		//}	
	}
	else if(isset($_POST['requestForBlog'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'request_for_blog' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = requestForBlog($_POST);
		//}	
	}else if(isset($_POST['submit_request_news_letter'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'request_news_letter' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = requestForNewsLetter($_POST);
		//}	
	}else if(isset($_POST['btnConnectWithHealer'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'connect_with_healer' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = connectWithHealer($_POST);
		//}	
	}else if(isset($_POST['submit_create_event'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'nonce_create_event' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = createEvent($_POST);
		//}	
	}else if(isset($_POST['btnForgotPassword'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'forgot_password' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = forgotPassword($_POST);
		//}	
	}else if(isset($_POST['btnResetPassword'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'reset_password' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = resetPassword($_POST);
		//}
	}else if(isset($_POST['btnChangePassword'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'reset_password' ) ){
		//	die('Failed security check'.$retrieved_nonce );
		//}else{
			$response = changePassword($_POST);
		//}
	}else if(isset($_POST['btnMyBlog'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'my_blog' ) ){
		//	die('Failed security check' );	
		//}else{
			$response = saveMyBlog($_POST);
		//}
	}else if(isset($_POST['btnFAQSubmit'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'faqQuery' ) ){
		//	die('Failed security check' );
		//}else{
			$response = faqQuery($_POST);
		//}
	}else if(isset($_POST['btnContactUs'])) {
		//$retrieved_nonce = $_REQUEST['_wpnonce'];
		//if (!wp_verify_nonce($retrieved_nonce, 'faqQuery' ) ){
		//	die('Failed security check' );
		//}else{
			$response = contactUs($_POST);
		//}
	}else if(isset($_POST['review_submit'])){
		$response = saveReview($_POST);
	}
	
	return $response;
}

function saveUsertoQSNT($postdata){
	global $qsmsg;
	$url = "https://qsserver.com/APIPublic/Register?Role=".$postdata['user_role']."&Name=".$postdata['name']."&DOB=".$postdata['dob']."&Email=".$postdata['email']."&Mobile=".$postdata['mobile']."&Password=".$postdata['password']."&ConfirmPassword=".$postdata['c_password']."&Agree=true&Address=".$postdata['address']."&CountryCode=".$postdata['country'];
	$url = str_replace(" ", '%20', $url);
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, TRUE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $response = curl_exec($ch);
    $decode_response = json_decode($response);
    print_r($decode_response);
   	if($decode_response[0]->Msg == 'OK'){
   		$user_id = username_exists( $input['email'] );
		if ( !$user_id and email_exists($input['email']) == false ) 
		{
		   	$seekerDetails = array(
			    'user_login' =>  $postdata['email'],
			    'user_email'  =>  $postdata['email'],
			    'user_pass'  =>  $postdata['password'],
			    'user_url' => "quantum-wellness"
			);
			$user_id = wp_insert_user($seekerDetails);
			$user_id->add_role('subscriber');
			update_user_meta($user_id, 'first_name', $postdata['name']);
			update_user_meta($user_id, 'mobile', $postdata['mobile']);
			update_user_meta($user_id, 'address', $postdata['address']);
			update_user_meta($user_id, 'dob', $postdata['dob']);
			auto_login_new_user($user_id);
		}
		$qsmsg = "Success: Your userid or password has been sent to your email id please check your email.";
   	}
   	//  else {
   	// 	$qsmsg = $decode_response[0]->Msg;
   	// }
    curl_close($ch);
    echo json_encode(array('qsmsg'=>$qsmsg));
	wp_die();
}

function calculateAvgRating($post_id,$pcount){
	if (get_post_meta($post_id, 'review_details')) {
		while ( have_rows('review_details', $post_id) ) : the_row();
	    	$totalRating += intval( get_sub_field('rating' ) );
	  	endwhile;
	}
	$avgrating = $totalRating / $pcount;
	return $avgrating;
}

function saveReview($postdata){
	global $rr_msg; 
	$existingRows = 0;
	$totalRating = 0;
	$therapist = get_page_by_path( $postdata['post_id'], OBJECT, 'therapist' );
	if (get_post_meta($therapist->ID, 'review_details')) {
		$existingRows = get_post_meta($therapist->ID, 'review_details', true);
	}
	$ailment = get_term_by( 'name', $postdata['ailment'], 'ailment');
	$value = array(
        "by" => $postdata['user_id'],
        "rating" => $postdata['rate'],
        "issues" => $ailment->term_id,
        "recommendation" => $postdata['recommend'] == "yes" ? "1" : "0",
        "review" => $postdata['review'],
        "status" => "0"
    );
	update_row( 'review_details',$existingRows+1, $value, $therapist->ID );
	$user_details = get_userdata( $postdata['user_id'] );
	$subject = "Added a Review";
	$msg = "Hello Thriive Team,<br/><br/>".$user_details->data->user_email." has added a review to ".$therapist->post_title;
	sendEmail('pooja@thriive.in', $subject, $msg);
	$rr_msg = "Rating and Review successfully saved.";
	$avgrate = calculateAvgRating($therapist->ID,$existingRows+1);
	update_field('avg_rating',$avgrate,$therapist->ID);
}

function sendEmailWithInvoice($to, $subject, $msg, $post_users_id, $status)
{		
	$path = get_stylesheet_directory();
	// Require composer autoload
	require_once $path.'/vendor/autoload.php';

	// Create an instance of the class:
	$mpdf = new \Mpdf\Mpdf();
	
	ob_start();
	include get_stylesheet_directory().'/invoices/invoice.php'; 
	$template = ob_get_contents();
	$stylesheet = file_get_contents($path.'/invoices/invoice.css');
	ob_end_clean();
	
	// Write some HTML code:
	$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
	$mpdf->WriteHTML($template, \Mpdf\HTMLParserMode::HTML_BODY);
	$location = get_stylesheet_directory().'/invoices';
	$date = time();
	$pdf = $location.'/Invoice_'.$date.'.pdf';
	$mpdf->Output($pdf, 'F');	
	
	$attachments = array( $pdf );
	
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $to, $subject, $msg, $headers, $attachments);
	
	// Delete pdf file after mail is sent
    if (file_exists($pdf)) {
    	unlink($pdf);
   	}	
}


function faqQuery($input)
{
	if(isset($input['txtFAQQuery']) && isset($input['txtEventID']))
	{
		$event_id = $input['txtEventID'];
		$questions = urlencode($input['txtFAQQuery']);
		$event_title = get_the_title($event_id);
		
		if(is_user_logged_in())
		{
			$current_user = wp_get_current_user();
			$user_email = $current_user->user_email;
			global $result;
			$result = saveFAQQuery($event_id,$questions,$user_email);
		} 
		else 
		{
			//global $result;
			//$result = "Unable to submit your query. Please try again letter.";
			$seeker_register_page = site_url() . "/seeker-regsiter-landing-page/?event_id=$event_id&query=$questions";
			wp_redirect($seeker_register_page);
			exit;
		}
	}
}

function saveFAQQuery($event_id,$questions,$user_email)
{
	if(is_user_logged_in())
	{
		$current_user = wp_get_current_user();
		$user_email = $current_user->user_email;
		
		$event_title = get_the_title($event_id);
		
		$faq_row = array('questions' => $questions,'users_email' => $user_email);
		$resultData = add_row('frequently_asked_questions', $faq_row, $event_id);
		
		$isThriiveEvent = get_post_meta($event_id, 'thriive_event',true);
		
		$therapist = get_field("therapist",$event_id);
		$therapist_post_id = $therapist[0]->ID;
		$therapist_account = get_users(array('meta_key' => 'post_id', 'meta_value' => $therapist_post_id))[0];
		$therapist_user_email = $therapist_account->user_email;
		$therapist_username = ($therapist_account->first_name) ? $therapist_account->first_name . ' ' . $therapist_account->last_name : $therapist_user_email;
		
		$subject = "New FAQ on your Event $event_title";
		if($isThriiveEvent)
		{
			$msg = "
				Dear Event Manager, <br><br>
				New FAQ on your Thrrive Event $event_title:<br><br>
				Question : $questions<br>
				User Email: $user_email<br><br>
				Love & light,<br>
				Team Thriive<br><br>
				<em style='color: #615c5c;'>
					Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
				<em>
			";
			sendEmail("accountmanager1@thriive.in", $subject, $msg);
		}
		else
		{
			$msg = "
				Dear $therapist_username, <br><br>
				New FAQ on your Event $event_title:<br><br>
				Question : $questions<br>
				User Email: $user_email<br><br>
				Love & light,<br>
				Team Thriive<br><br>
				<em style='color: #615c5c;'>
					Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
				<em>
			";
			sendEmail($therapist_user_email, $subject, $msg);
		}
		return "Your query has been submitted successfully.";
	}
}

function addGalleryImage($input,$file){
	if(isset($file['gallery_picture']['tmp_name']) && isset($input['gallery_title']))
	{
		if(is_user_logged_in())
		{
			includeFiles();
			$current_user = wp_get_current_user();
			$userPost = get_post($current_user->post_id);
			$imageCount =  (($userPost->gallery ) ? $userPost->gallery :0);
			$keyValue = 'gallery_'.$imageCount.'_images';
			$identity_picture_id = media_handle_upload( 'gallery_picture', $current_user->post_id );
			//Adding images in gallery repeater fields
			$gallery_row = array('images' => $identity_picture_id,'gallery_title' => $input['gallery_title']);
			$resultData = add_row('gallery',$gallery_row,$current_user->post_id);
			$newCount = $imageCount+1;
			$resultDatasp=update_post_meta($current_user->post_id,'gallery',$newCount,true);
			return generateJSON('success','Image added successfully','');			  
		} 
		else 
		{
			return generateJSON('error','Please login to proceed','');
		}
	}
	else 
	{
		 return generateJSON('error','Enter required fields','');
	}
}

function addGalleryVideo($input){
	if(isset($input['video_link']) && isset($input['video_title'])){
		if(is_user_logged_in()){
			$current_user = wp_get_current_user();
			$userPost = get_post($current_user->post_id);
			$videoCount =  (($userPost->videos ) ? $userPost->videos :0);
			$keyValue = 'videos_'.$videoCount.'_video_link';
			//Adding video in gallery repeater fields
			$gallery_row = array('video_link' => $input['video_link'],'video_title' => $input['video_title']);
			$resultData = add_row('videos',$gallery_row,$current_user->post_id);
			$newCount = $videoCount+1;
			update_post_meta($current_user->post_id,'videos',$newCount,true);
			return generateJSON('success','Video added successfully','');			  
		} else {
			return generateJSON('error','Please login to proceed','');
		}
	} else {
		 return generateJSON('error','Enter required fields','');
	}
}

function deleteGalleryVideo($input) {
	if(is_user_logged_in()) {
		$current_user = wp_get_current_user();
		$post_id = $current_user->post_id;
		$row_index = $input['row_index'] + 1;
		delete_row('videos', $row_index, $post_id);
	}
}

function deleteGalleryImg($input)
{
	if(is_user_logged_in()) 
	{
		$current_user = wp_get_current_user();
		$post_id = $current_user->post_id;
		$row_index = $input['row_index'] + 1;
		delete_row('gallery', $row_index, $post_id);
	}
}

function deleteCertificate()
{
	if(is_user_logged_in()) 
	{
		$row_index = $_POST['row_index'];

		$current_user = wp_get_current_user();
		$post_id = $current_user->post_id;
		$isDelete = delete_row('certificates', $row_index, $post_id);

		$certificates = get_field('certificates',$post_id);
		$results = array('<i class="fa fa-spinner"></i>');
		$x = 0;
		foreach($certificates as $certificate)
		{
			//$results[] =  $certificate['certificate'];
			$imgId =  $certificate['certificate'];
  			ob_start();
  			if(get_post_mime_type($imgId) == 'application/pdf')
			{
				?>
				<div class="preview_wrap">
					<span class="close" data-id="<?php echo $imgId; ?>" data-row_id="<?php echo $x+1; ?>">x</span>
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/pdf_thumbnail.png" class="pdf_certificate" style="max-width:200px;max-height:200px;" alt="">
				</div>
				<?php
			}
			else
			{
				?>
				<div class="preview_wrap">
					<span class="close" data-id="<?php echo $imgId; ?>" data-row_id="<?php echo $x+1; ?>">x</span>
					<?php
						echo wp_get_attachment_image( $imgId, array(120,120), '', array( "class" => "") );
					?>
				</div>
				<?php
			}
  			$results[] = ob_get_clean();
  			$x++;
		}
		$results = implode('', $results);
		//print_r($results);
	}
	echo $results;
	exit;
}

function requestForBlog()
{
	if(is_user_logged_in())
	{
		$current_user = wp_get_current_user();
		$healerName = $current_user->first_name . ' ' . $current_user->last_name;
		$healerEmail = $current_user->user_email;
		$healerMobile = $current_user->mobile;
		$currentDate = date("dS M, Y");
		
		//Email To Therapist
		$to = $healerEmail;
		$subject = "We're going to write about you!";
		$msg = "Dear $healerName,<br><br>
			It's wonderful to hear from you! And we, here at Thriive, are always intrigued when we get a blog request. Words can open up worlds for so many people. Our user base grows every day, and we've already reached a following of more than 28,000 on Facebook & 16,000+ on Instagram. Imagine the impact of our messages. Our dream is to inspire millions everywhere to unleash their potential and Thriive.  With your messages, we come that much closer to making our dream come true. For this, you will always have our gratitude.<br><br>			 
			Our Content Editor will be in touch with you shortly to organize a telephone or personal interview for the blog. <br><br>		 
			Love & Light<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>";
		sendEmail($to, $subject, $msg);
		
		//Email to admin
		$to = "accountmanager1@thriive.in";
		$subject = "$healerName has requested for a blog";
		$msg = "Dear Account Manager,<br><br>
			$healerName has sent a request for a blog.<br><br> 				
			Love & light,<br>
			Team Thriive
			";
		sendEmail($to, $subject, $msg);
		
		//Email to content writer
		$to = "contentmanager@thriive.in";
		$subject = "$healerName has requested for a blog";
		$msg = "Dear Content Editor,<br><br>
			Please review the following request for a blog article:<br>
			Name: $healerName <br>
			Ph. No: $healerMobile <br>
			Email: $healerEmail <br>
			Date: $currentDate <br><br>
			You will need to contact them to conduct a phone or personal interview based upon the topic.<br><br> 
			Love & light,<br>
			Team Thriive ";
		sendEmail($to, $subject, $msg);
		
		$userPost = get_post($current_user->post_id);
		$blogRequestCount =  (($userPost->request_for_blog) ? $userPost->request_for_blog :0);
		$blogRequestCount++;
		$resultDatasp=update_post_meta($current_user->post_id,'request_for_blog',$blogRequestCount,true);
			
		echo "Thank you! We've received your request and will get in touch with you shortly.";
		exit;
	}
}

function requestForNews()
{
	if(is_user_logged_in())
	{		
		$current_user = wp_get_current_user();
		$healerName = $current_user->first_name . ' ' . $current_user->last_name;
		$healerEmail = $current_user->user_email;
		$healerMobile = $current_user->mobile;
		$currentDate = date("dS M, Y");

		//Email To Therapist
		$to = $healerEmail;
		$subject = "We’re excited to feature you in our newsletter";
		$msg = "Dear $healerName,<br><br>
			It’s wonderful to hear from you! And we, here at Thriive, are happy to feature you in our newsletter. 
Our user base grows every day, and we’ve already reached a following of more than 28,000 on Facebook,16,000+ on Instagram and a database of more than 40,000. Imagine the impact of our messages. <br>
			We will get inform you in advance of the date you will be featured in our newsletter.<br><br>	 
			Love & Light<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>";
		sendEmail($to, $subject, $msg);
		
		
		//Email to admin
		$to = "accountmanager1@thriive.in";
		$subject = "$healerName has requested for a banner in the newsletter.";
		$msg = "Dear Account Manager,<br><br>
			$healerName has sent a request for a banner in the newsletter. Please do the needful.<br><br> 				
			Love & light,<br>
			Team Thriive
			";
		sendEmail($to, $subject, $msg);
				
		$userPost = get_post($current_user->post_id);
		$newslRequestCount =  (($userPost->request_for_news_letter) ? $userPost->request_for_news_letter :0);
		$newslRequestCount++;
		$resultDatasp=update_post_meta($current_user->post_id,'request_for_news_letter',$newslRequestCount,true);
		
		echo "Thank you! We’ve received your request and will get in touch with you shortly.";
		exit;
	}
}


function contactAccountManager()
{
	if(is_user_logged_in())
	{		
		$current_user = wp_get_current_user();
		$healerName = $current_user->first_name . ' ' . $current_user->last_name;
		$healerEmail = $current_user->user_email;
		$healerMobile = $current_user->mobile;
		$currentDate = date("dS M, Y");
		$accountManager = $_POST["accountManager"];
				
		//Email to admin
		$to = "accountmanager1@thriive.in";
		$subject = "A message from $healerName";
		$msg = "Dear Account Manager,<br><br>
			$healerName has sent you this message:<br><br> 	
			$accountManager<br><br>
			Please respond appropriately at the earliest.<br><br>			
			Love & light,<br>
			Team Thriive
			";
		sendEmail($to, $subject, $msg);
				
		echo "We’ve received and forwarded your request to the Account Manager. They will get in touch with you shortly.";
		exit;
	}
}


function connectMsgToSeeker($healer_id)
{
	//Seeker details
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	$current_username = ucwords(get_user_meta($current_user_id, 'first_name', true)) . " " . ucwords(get_user_meta($current_user_id, 'last_name', true));
	$seeker_mobile_number = get_user_meta($current_user_id, 'mobile', true);
	$userEmail = $current_user->user_email;
	
	//Healer Details
	$healer_data = get_userdata($healer_id);
	$healer_username = ucwords(get_user_meta($healer_id, 'first_name', true)) . " " . ucwords(get_user_meta($healer_id, 'last_name', true));
	//$healer_mobile_number = get_user_meta($healer_id, 'mobile', true);
	//$healer_email = $healer_data->user_email;
	
	if(get_field('thriive_contact','option')) {
		$healer_mobile_number = get_field('thriive_contact','option');
	}
	if(get_field('thriive_contact_email','option')) {
		$healer_email = get_field('thriive_contact_email','option');
	}
	
	//Sending Email
	$emailMsg = "
		Dear $current_username,<br><br>
		Thank you for your interest in connecting with our Thriive-verified Therapist '$healer_username'.<br><br>
		Here are their contact details:<br>
		Name: $healer_username<br>
		Email: $healer_email<br>
		Mobile No.: $healer_mobile_number <br><br>
		Keep Thriiving!<br>
		Love & light,<br>
		Team Thriive<br><br>
		<em style='color: #615c5c;'>
			Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
		<em>	
	";
	sendEmail($userEmail, 'Connect with Therapist', $emailMsg);
/*
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $toEmail, $subject, $msg, $headers);
	doConnectEmail($userEmail, 'Connect with Therapist', $current_username, 'Therapist', $healer_mobile_number);
*/
	
	//Sending SMS
	$msg = "Thank you for your interest in connecting with our Thriive-verified Therapist '$healer_username'. Here are their contact details: Name: $healer_username, Email: $healer_email, Mobile number: $healer_mobile_number. Keep Thriiving!";
	sendSMS($seeker_mobile_number,$msg);
}
function connectMsgToHealer($healer_id)
{
	//Seeker Detail
	$current_user = wp_get_current_user();
	$current_user_id = $current_user->ID;
	$seeker_mobile_number = get_user_meta($current_user_id, 'mobile', true);
	$seeker_username = ucwords(get_user_meta($current_user_id, 'first_name', true)) . " " . ucwords(get_user_meta($current_user_id, 'last_name', true));
	$seeker_Email = $current_user->user_email;
	
	//Healer detail
	$healer_data = get_userdata($healer_id);
	$healer_username = ucwords(get_user_meta($healer_id, 'first_name', true)) . " " . ucwords(get_user_meta($healer_id, 'last_name', true));
	$healer_mobile_number = get_user_meta($healer_id, 'mobile', true);
	$healer_email = $healer_data->user_email;
/*
	if(get_field('thriive_contact','option')) {
		$healer_mobile_number = get_field('thriive_contact','option');
	}
	if(get_field('thriive_contact_email','option')) {
		$healer_email = get_field('thriive_contact_email','option');
	}
*/
	//Sending Email
	$emailMsg = "
		Dear $healer_username,<br><br>
		'$seeker_username' has asked to connect with you.<br><br>
		Here are their contact details:<br>
		Name: $seeker_username<br>
		Email: $seeker_Email<br>
		Mobile No.: $seeker_mobile_number <br><br>
		We have shared your details with them. They might get in touch with you.<br><br>
		Keep Thriiving!<br>
		Love & light,<br>
		Team Thriive<br><br>
		<em style='color: #615c5c;'>
			Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
		<em>	
	";
	sendEmail($healer_email, 'Connect with Therapist', $emailMsg);
	//doConnectEmail($healer_email, 'Connect with Therapist', $healer_username, 'Seeker', $seeker_mobile_number);
	
	//Sending SMS
	$msg = "$seeker_username has asked to connect with you.Here are their contact details:Name: $seeker_username, Email: $seeker_Email, Mobile No.: $seeker_mobile_number. We have shared your details with them. They might get in touch with you. Keep Thriiving!";
	sendSMS($healer_mobile_number,$msg);
}

function doConnectEmail($toEmail, $subject, $name, $shareOf, $shareNumber)
{
	$msg = "
		Dear $name,<br><br>
		
		Here is the $shareOf's mobile number $shareNumber.<br><br>
		
		Love & light,<br>
		Team Thriive		
	";
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $toEmail, $subject, $msg, $headers);

}

function sendEmail($to, $subject, $msg)
{
	$headers = array('Content-Type: text/html; charset=UTF-8');
	wp_mail( $to, $subject, $msg, $headers);

}

function generateTherapistFields()
{
	$current_user = wp_get_current_user();
	$userPost = get_post($current_user->post_id);
	$package = get_post($userPost->select_package[0]);
	
	$count = $_POST['total_therapies'];
	
	if($count < $package->number_of_therapies)
	{
		$therapy_terms = get_terms(array(
	      'taxonomy' => 'therapy',
	      'hide_empty' => false ));
		$count++;
		$therapy_option = '';
		foreach($therapy_terms as $therapy) 
		{
			$therapy_option .='<option value="' . $therapy->term_id . '-' . $therapy->name . '">' . $therapy->name . '</option>';
		}
		$field_block = '
				<div class="form-group">
					<label for="therapy-1">Therapy ' . $count  . '*</label>
					<select class="form-control select-list-item select-dropdown-list" id="therapy-list_' . $count  . '" name="t_name_' . $count  . '">' . $therapy_option . '</select>
				</div>
				<div class="form-group">
					<label for="experience">Experience(in years)*</label>
					<input data-parsley-required="true" type="text" data-parsley-required-message="Experience is required." class="date_picker form-control" id="experience_' . $count  . '" name="t_experience_' .$count  . '">
				</div>
				<div class="form-group">
					<label for="charges">Charges</label>
					<input type="number" class="form-control" id="charges_' . $count  . '" name="t_charges_' . $count  . '">
				</div><br>';
		echo $field_block;
	}
	else
	{
		//If condition become false
		echo "FALSE";
	}
	exit;
}

function myplugin_registration_save($user_id) 
{	
	if(isset($_SERVER['QUERY_STRING']))
	{
		$str = $_SERVER['QUERY_STRING'];
		
	    if (strpos($str, 'Facebook') !== false) 
	    {
	        $facebook_sign_up = 'true';
	        if(isset($_SERVER['HTTP_REFERER']))
	        {
		        $facelogin_from = explode("/", $_SERVER['HTTP_REFERER']);	        
		    }
	    }
		$searchArray = array("%3A", "%2F");
	    $replaceArray = array(":", "/");
	    
		$str = str_replace($searchArray,$replaceArray,$str);
	    $page_slug = explode("/", $str);
	    //print_r($page_slug);echo "<hr>----";
	}
	
	if(!empty($_POST)) {
		$first_name = $_POST['firstname'];
		$last_name= $_POST['lastname'];
		$email= $_POST['email'];
	} else {
		$first_name = get_userdata($user_id)->first_name;
		$last_name = get_userdata($user_id)->last_name;	
		$email = get_userdata($user_id)->user_email;	
	}
	
	update_user_meta($user_id, 'first_name',  $first_name);		  
	// update_user_meta($user_id, 'last_name',  $last_name);
	update_user_meta($user_id, 'is_mobile_verify',  0);
	update_user_meta($user_id, 'mobileOTP',  "");
	
	if($_POST['_wp_http_referer'] == '/seeker-regsiter-landing-page/' || ($page_slug[3] == 'seeker-regsiter-landing-page' && $page_slug[6] == 'www.googleapis.com') || ($facebook_sign_up == 'true' && $facelogin_from[3] == 'seeker-regsiter-landing-page') || ($page_slug[3] == 'therapist' && $page_slug[8] == 'www.googleapis.com') || ($facebook_sign_up == 'true' && $facelogin_from[3] == 'therapist'))
	{
/*
		if(!empty($_POST)) 
		{
			$city = $_POST['city'];
		} 
		else 
		{
			$city = get_userdata($user_id)->locale;
		}
		update_user_meta($user_id, 'locale',  $city);
*/
		$user = new WP_User($user_id);  
	    $user->set_role('subscriber');
	}
	else if($_POST['_wp_http_referer'] == '/therapist-landing-page' || ($page_slug[3] == 'therapist-landing-page&code=4' && $page_slug[6] == 'www.googleapis.com') || ($facebook_sign_up == 'true' && $facelogin_from[3] == 'therapist-landing-page'))
	{
		$post_id = wp_insert_post(array (
		  'post_type' => 'therapist',
		  'post_title' => $first_name.' '.$last_name,
		  'post_author' => $user_id,
		  'post_content' => ' ',	
		  'post_status' => 'draft'
		));
		update_user_meta($user_id, 'post_id',  $post_id);
		update_user_meta($user_id, 'stage',  1);
		update_user_meta($user_id, 'last_name',  $last_name);
		update_user_meta($user_id, 'completed_stages',  array('0','0','0','0'));
		//wp_update_user( array ( 'ID' => $user_id, 'user_login' => $email ) ) ;
/*
		global $wpdb;
		$wpdb->update($wpdb->users, array('user_login' => $email), array('ID' => $user_id));
*/
		$user = new WP_User($user_id);  
	    $user->remove_role('subscriber'); 
	    $user->add_role('therapist'); 
	    $user->add_role('author');
	    $rfa_data = array(
		    'firstname'	=> $first_name,
		    'lastname'	=> $last_name,
		    'email'		=> $email
	    );
	    send_email_to_admin_on_therapist_register($rfa_data);
	}
/*
	print_r($_SERVER);
	echo "<hr>";
	print_r($_POST);
	echo "<hr>";
	print_r($page_slug);
	exit;
*/
}


function login($input){
	if(isset($input['email']) && isset($input['password']))
	{
		$user_id = email_exists($input['email']);
		global $error_login;

		if ( !$user_id and username_exists($input['email']) == false ) 
		{
			//exit;
			$error_login = 'Sorry! Your email ID or password is incorrect or this account doesn\'t exist. Please reset your password or create a new account.';
		} 
		else 
		{
			$login_via = get_user_meta($user_id,'thechamp_provider', true);
			if($login_via == "facebook")
			{
				$error_login = 'You chose the Facebook log-in option when you created your account. Please click Login with <strong>Facebook</strong>';
			}
			else if($login_via == "google")
			{
				$error_login = 'You chose the Google log-in option when you created your account. Please click Login with <strong>Google</strong>';
			}
			else
			{
				$userInfo = wp_authenticate( $input['email'], $input['password'] );
				$user_id = $userInfo->ID;
				//print_r($userInfo); exit;
				
				if(!is_wp_error($userInfo))
				{
					//echo "<pre>";print_r($userInfo);echo "</pre>";
					//if(($userInfo->roles[0]) == 'therapist')
					if(in_array("pending_delete", $userInfo->roles))
					{
						$error_login = "You have deleted your account. Please contact administrative  at <u><a href='mailto:accountmanager1@thriive.in'> accountmanager1@thriive.in </a></u>";
					}
					else if(in_array("therapist", $userInfo->roles))
					{
						if(get_post_status(get_user_meta($user_id,'post_id')[0]) == 'pending')
						{
							//echo get_post_status(get_user_meta($user_id,'post_id')[0]);exit;
							$error_login = "You can't login now as your account is in review, you will be notified once it is completed.";
						}
						else						
						{
							auto_login_new_user($user_id);
							wp_redirect('/therapist-account-dashboard/');
							exit();
						}
					}
					else if(in_array("subscriber", $userInfo->roles)) //if(($userInfo->roles[0]) == 'subscriber')
					{
						auto_login_new_user($user_id);
						if(isset($input['call_consult'])){
							wp_redirect($input['call_consult']);
						}else{
							wp_redirect('/my-account-page/');
						}
						exit();
					}
					else
					{
						$error_login = 'Invalid user role.';
					}
				}	
				else 
				{
						$error_login = 'Sorry! Your email ID or password is incorrect or this account doesn\'t exist. Please reset your password or create a new account.';
				}		
			    return generateJSON('error','User already exists, Please login','');
			}
		}
	} else{
		 return generateJSON('error','Enter required fields','');
	}
}

function addLogoutLinkInNavigation($items, $args) 
{
	if($args->theme_location == 'menu-1')
	{
	    if (is_user_logged_in()) 
	    {
			$items .= '<li><a href="' . wp_logout_url('/login/') . '">Logout</a></li>';
		}
	}
	return $items;
}

function generateValidUrl($url, $scheme = 'http://')
{
	if(!empty($url))
	{
		return parse_url($url, PHP_URL_SCHEME) === null ? $scheme . $url : $url;
	}
	else
	{
		return $url;
	}	
}

function submitFeedback($input){
	if(isset($input['feedback']) && isset($input['user_id']) && isset($input['feed_ref']))
	{
		$ref_user = get_userdata($input['user_id']);
		update_user_meta($input['user_id'], $input['feed_ref'],  $input['feedback']);
		
		if($input['feed_ref'] == "ref_1")
		{
			$review_field = "first_reference_review";
		}
		else if($input['feed_ref'] == "ref_2")
		{
			$review_field = "second_reference_review";
		}
		else if($input['feed_ref'] == "ref_3")
		{
			$review_field = "third_reference_review";
		}
		update_field($review_field,$input['feedback'],$ref_user->post_id);
		
		//Sending Email to Admin
		
	  	$userName = $ref_user->first_name . " " . $ref_user->last_name;
	  	$feedback = $input['feedback'];
	  	$msg = "
	  	Dear Account Manager,<br><br>
	  	You have received a review for $userName. Here it is: REVIEW.<br><br>	
	  	$feedback <br><br>
		Love & light,<br>
		Team Thriive
		";
		sendEmail('accountmanager1@thriive.in', 'Reviews are in!', $msg);
		//echo '<script type="text/javascript">$(document).ready(function(){ $("#account_in_review_modal").modal(); });</script>';
					
		//wp_redirect(home_url());
		//exit;
	} else {
		return generateJSON('error','Something went wrong','');
	}
}

function wpse8170_activate_user() {
	if ( is_page() && get_the_ID() == 510 ) {
		$user_id = filter_input( INPUT_GET, 'user', FILTER_VALIDATE_INT, array( 'options' => array( 'min_range' => 1 ) ) );
    }
    else if(is_page() && get_the_ID() == 274)	//274 => healer-register.php
    {
	    if($_GET['token_id'])
	    {
		    $token = $_GET['token'];
		    $token_for = $_GET['token_for'];
		    $token_id = $_GET['token_id'];
		    if($token != "" && $token_id !="" && $token_for != "")
		    {
			    $current_user = wp_get_current_user();
				$current_user_id = $current_user->ID;
				if($current_user_id == $token_id)
				{
					//Retrieving user data
					$user_data = get_userdata($token_id);
				    if($user_data->payment_token == $token && $user_data->user_email == $token_for && $user_data->ID == $token_id)
					{
						delete_user_meta($token_id, 'payment_token',  $token);
					}
				}
				else
				{
					//echo '<script type="text/javascript">$(document).ready(function(){ $("#account_in_review_modal").modal(); });</script>';
					return generateJSON('error','Invalid payment link','');
				}
		    }
			else
			{
				return generateJSON('error','The payment link has been expired.','');
			}
	    }
		else
		{
			return generateJSON('error','Invalid payment link','');
		}
    }
}

//Therapist signup
function signup($input){
	//print_r($input);exit;
	if(username_exists( $input['email'] ) && email_exists($input['email'])){
		global $signUp_login;
		$link = get_permalink(419);
		$signUp_login = "<div class='error-msg form-error'>Email id already exists,<a href='$link' style='text-decoration:underline;'>click here to login</a></div>";
		return $signUp_login;
	} else {
		if(isset($input['firstname']) && isset($input['lastname']) && isset($input['email']) && isset($input['password']) && isset($input['g-recaptcha-response']) && !empty($input['g-recaptcha-response'])){
/*
			$user_id = username_exists( $input['email'] );
			if ( !$user_id and email_exists($input['email']) == false ) {
			   
*/			$secret = RECAPTCHA_SITE_SECRET;
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$input['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if($responseData->success){
                $user_id = wp_create_user($input['email'],$input['password'],$input['email']);
                auto_login_new_user($user_id);
                //send_email_to_admin_on_therapist_register($input);
                return generateJSON('success','You have successfully signed up.',array('user_id'=>$user_id));
            }else{
                 return generateJSON('error','Enter required fields','');
            }

/*
			} else {
				//update_user_meta($user_id, 'stage',  1);
				//auto_login_new_user($user_id);
				global $signUp_login;
				$link = get_permalink(419);
				$signUp_login = "Email id already exists,<a href='$link' style='text-decoration:underline;'>click here to login</a>";
				//echo $signUp_login;exit;
			    return generateJSON('error','User already exists, Please login','');
			}
*/
		} else {
			 return generateJSON('error','Enter required fields','');
		}
	}
}

function send_email_to_admin_on_therapist_register($input)
{
	$first_name = $input['firstname'];
	$last_name= $input['lastname'];
	$email = $input['email'];
	
	$msg = "
	  	Dear Account Manager,<br><br>				  	
		You have received the registration form from a web applicant. Please review to process their application within two working days. Details are as follows<br><br>					 
		Name of Therapist: $first_name $last_name<br><br>					 
		Email of Therapist: $email<br><br>					
		Love & light,<br>
		Team Thriive
	";
	sendEmail('accountmanager1@thriive.in', "$first_name $last_name has started the registration process!", $msg);
}

function forgotPassword($input)
{
	if(isset($input['email']))
	{
		global $result;
		$email = $input['email'];
		$user_id = email_exists($email);
		if($user_id)
		{
			$codeD = $email.$user_id . time();  
		    $code = sha1( $codeD );
		    $activation_link = add_query_arg( array('token' => $code, 'token_id' => $user_id,'token_for' => $email ), get_permalink( 1781 ));
		    update_user_meta($user_id, 'forgot_password_token',  $code);
		    $msg = "Hey,<br><br>
		    	You sent us a request to reset your password.<br><br>
				Click on the link below for the new password.<br><br>
				$activation_link <br><br>
				You didn't send the request? Ignore this email and log into your account as usual.<br><br>
				Love & light,<br>
				Team Thriive<br><br>
				<em style='color: #615c5c;'>
					Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
				<em>";
			$result = 'Your reset password link has been sent to your email. Kindly check your inbox for further procedure.';
		    sendEmail($email, "Request for password reset", $msg);		    
		}
		else
		{
			$result = 'Sorry! Your email ID doesn’t exist. Please try logging in with Facebook or Google or Create a New Account';
			return generateJSON('error','Sorry! Your email ID doesn’t exist. Please try logging in with Facebook or Google or Create a New Account','');
		}
	}
	else 
	{
		return generateJSON('error','Enter required fields','');
	}
}

function resetPassword($input)
{
	//print_r($input);
	if(isset($input['token_id']) && isset($input['token']) && isset($input['token_for']) && isset($input['password']))
	{
		$user_id = email_exists($input['token_for']);
		if($user_id)
		{
			$token_id = $input['token_id'];
			$token = $input['token'];
			$token_for = $input['token_for'];
			$password = $input['password'];
			
			//Retrieving user role
			$user_data = get_userdata($token_id);
			$user_role = $user_data->roles;
			$user_role[0];

			if($user_data->forgot_password_token == $token && $user_data->user_email == $token_for && $user_data->ID == $token_id)
			{
				$update_user = wp_update_user( array (
                        'ID' => $token_id, 
                        'user_pass' => $password
                    )
                );
                if($update_user)
                {
	                $msg = "Hey,<br><br>
						Your password has beeen changed.<br><br>		    	
						We'll always let you know when there is any activity on your Thriive account. This helps keep your account safe.<br><br>
						If you didn’t make the request, please contact us on <a href='tel:+912266666036'>+91 22 6666 6036</a> <br><br>
						Love & light,<br>
						Team Thriive<br><br>
						<em style='color: #615c5c;'>
							Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
						<em>";	
	                sendEmail($token_for, "Your Thriive account password has been changed", $msg);
	                //auto_login_new_user($token_id);
	                //wp_redirect(get_permalink(548));
	                global $reset_pwd_msg;
	                $link = get_permalink(419);
	                $reset_pwd_msg = "You have successfully reset your Thriive password. <a href='$link' style='text-decoration:underline;'>click here to login</a>";
                }    
			}
			else
			{
				return generateJSON('error','The link has been expired.','');
			}
		}	
		else
		{
			return generateJSON('error','User doesn\'t exist','');
		}			
	}
}

function changePassword($input)
{
	//echo "<pre>";print_r($input);echo "</pre>";
	global $change_pwd_msg;
	if(isset($input['oldPassword']) && isset($input['newPassword']) && isset($input['confNewPassword']))
	{
		$oldPassword = $input['oldPassword'];
		$newPassword = $input['newPassword'];
		
		$current_user = wp_get_current_user();
		$isOldPwdCorerct = wp_check_password($oldPassword, $current_user->user_pass, $current_user->ID);
		if($isOldPwdCorerct)
		{
			if($oldPassword != $newPassword)
			{
				$update_user = wp_update_user( array (
		            'ID' => $current_user->ID, 
		            'user_pass' => $newPassword
		        ));
		        if($update_user)
	            {
		            $current_user = wp_get_current_user();	
					$username = $current_user->first_name . ' ' . $current_user->last_name;
					$useremail = $current_user->user_email; 
		            $msg = "
		            	Dear $username,<br><br>
						This notice confirms that your password was changed on Thriive.<br><br>						
						If you did not change your password, please contact at accountmanager1@thriive.in<br><br>					
						This email has been sent to $useremail<br><br>						
						Love & light,<br>
						Team Thriive<br><br>
						<em style='color: #615c5c;'>
							Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
						<em>";
					sendEmail($current_user->user_email, "Notice of Password Change", $msg);
		            $change_pwd_msg = "<div style='color:green'>You have successfully change your password.</div><br>";
		        }
		        else
	            {
		            $change_pwd_msg = "<div style='color:red'>Unable to change your password. Please try again later.</div><br>";
		        }
			}
			else
			{
				$change_pwd_msg = "<div style='color:red'>Old password and new password should not be same.</div><br>";
			}
		}
		else
		{
			$change_pwd_msg = "<div style='color:red'>Incorrect old password.</div><br>";
		}
	}
	else
	{
		$change_pwd_msg = "<div style='color:red'>All fields are required.</div><br>";
	}
}

function contactUs($input)
{
	global $form_msg;
	
	if(isset($input['txtFirstName']) && isset($input['txtLastName']) && isset($input['txtEmail']) && isset($input['txtMobile']) && isset($input['txtMessage']))
	{
		$firstName = $input['txtFirstName'];
		$lastName = $input['txtLastName'];
		$email = $input['txtEmail'];
		$mobile = $input['txtMobile'];
		$message = $input['txtMessage'];
		
		//Send email to admin
		$emailMessage = "
			Dear Account Manager,<br><br>	
						  	
			$firstName $lastName trying to contact you. Details are as follows:<br><br>	
							 
			First Name: $firstName<br>					 
			Last Name: $lastName<br>				 
			Email: $email<br>			 
			Mobile: $mobile<br>	
			Message: $message<br><br>
			
			Love & light,<br>
			Team Thriive
		";
		sendEmail("accountmanager1@thriive.in", "Contact us", $emailMessage);
		
		//Send email to user
		$emailMessage = "
			Dear $firstName $lastName,<br><br>
			Thank you for contacting us. Our team will get back to you shortly. <br><br>
			Love & light,<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>
		";
		sendEmail($email, "Contact us", $emailMessage);
		
		$form_msg = "<div style='color:green'>Your message has been sent successfully<br><br></div>";
	}
	else
	{
		$form_msg = "<div style='color:red'>Unable to send your message. Please try again later.<br><br></div>";
	}
}

function savePersonalDetails($input){
/*
	echo '<pre>';
	print_r($input);echo '</pre>';
	exit();
*/
	if(isset($input['firstname']) && isset($input['lastname']) && isset($input['gender']) && isset($input['dob']) && isset($input['nationality']) && isset($input['address']) && isset($input['country']) && isset($input['state']) && isset($input['city']) && isset($input['zipcode'])){
	  		if(is_user_logged_in()){
		  	    $current_user = wp_get_current_user();
			    $user_id = $current_user->ID;
/*
			    $addressObj->addressline1 = $input['addressline1'];
			    $addressObj->addressline2 = $input['addressline2'];
*/
			    $addressObj->street = $input['street'];
			    $addressObj->city = $input['city'];
			    $addressObj->state = $input['state'];
			 	$addressObj->zipcode = $input['zipcode'];
			  	$addressObj->country = $input['country'];
			  	
			  	update_field('address', $input['address'], $current_user->post_id);
			  	update_field('zipcode', $input['zipcode'], $current_user->post_id);
			  	
			 	$address = json_encode($addressObj);
			 	
			    update_user_meta($user_id, 'first_name',  $input['firstname']);		  
				update_user_meta($user_id, 'last_name',  $input['lastname']);
				update_user_meta($user_id, 'gender', $input['gender']);
				update_user_meta($user_id, 'dob',  $input['dob']);
				update_user_meta($user_id, 'nationality',  $input['nationality']);		  
				update_user_meta($user_id, 'address',  $address);
				update_user_meta($user_id, 'stage',  2);
				saveStage($user_id,1);
				saveLocationTaxonomy($input['country'], $input['state'], $input['city'], $current_user->post_id); // Create Taxonomy for Country, State, City
				return generateJSON('success','Personal details added successfully','');			  
			} else {
				return generateJSON('error','Please login to proceed','');
			}
	} else {
		 return generateJSON('error','Enter required fields','');
	}
}

// Create Taxonomy for Country, State, City
function saveLocationTaxonomy($country, $state, $city, $id) {
	$country_name = $country;
	$state_name = $state;
	$city_name = $city;
	$taxonomy_name = 'location';
	$parent_id = '';
	
	//Country
	$country_exists = term_exists($country_name, $taxonomy_name);
	if(empty($country_exists)) {
		$result = wp_insert_term(
		    $country_name,   // the term 
		    $taxonomy_name, // the taxonomy
		    array('parent' => 0)
		);
		$country_exists = term_exists($country_name, $taxonomy_name);
		$parent_id = $country_exists['term_id'];
	} else {
		$parent_id = $country_exists['term_id'];
	}	
	wp_set_post_terms($id, $parent_id, $taxonomy_name);
	
	//State
	
	if($state_name != 'not_available') {
		$state_exists = term_exists($state_name, $taxonomy_name);
		if(empty($state_exists)) {	
			wp_insert_term(
			    $state_name,   // the term 
			    $taxonomy_name, // the taxonomy
			    array('parent' => $parent_id)
			);
			$state_exists = term_exists($state_name, $taxonomy_name);
			$parent_id = $state_exists['term_id'];
		} else {
			$parent_id = $state_exists['term_id'];
		}	
		wp_set_post_terms($id, $parent_id, $taxonomy_name, true);
	}
	
	if($city_name != 'not_available') {
		//City
		$city_exists = term_exists($city_name, $taxonomy_name);
		if(empty($city_exists)) {
			wp_insert_term(
			    $city_name,   // the term 
			    $taxonomy_name, // the taxonomy
			    array('parent' => $parent_id)
			);
			$city_exists = term_exists($city_name, $taxonomy_name);
			$parent_id = $city_exists['term_id'];
		} else {
			$parent_id = $city_exists['term_id'];
		}		
		wp_set_post_terms($id, $parent_id, $taxonomy_name, true);
	}	
	
	
/*
	$terms = get_terms([
	    'taxonomy' => $taxonomy_name,
	    'hide_empty' => false,
	]);
*/
}

function getTherapistExperience($practiceSince) 
{
	$practiceSinceDate = new DateTime($practiceSince);
	$currentDate = new DateTime( date( 'Y-m-d' ) );	
	$experience = $currentDate->diff($practiceSinceDate);	
	
	$year = ($experience->y > 1) ? 'years' : 'year';
	$month = ($experience->m > 1) ? 'months' : 'month';
	
	if($experience->y <= 0)
	{
		$total_experience = $experience->m . " $month";
	}
	else
	{
		$total_experience = $experience->y . " $year";
	}
	if($practiceSinceDate > $currentDate)
	{
		return '-' . $total_experience;
	}
	return $total_experience;
}
function rfa_add_admin_inline_js()
{
	//Disable future date in datepicker for therapist's therapy experience fields.
	?>
	<script type='text/javascript'>;
		jQuery( document ).ready( function( $ ) 
		{
			let $datepicker = $( '.acf-field-5bc5cf61e819d .acf-date-picker input.input' );	
			$datepicker.datepicker( 'option', 
			{
				maxDate: new Date()
			});
		});
	</script>
	<?php
}
add_action( 'admin_print_scripts', 'rfa_add_admin_inline_js' , PHP_INT_MAX);

function formatTherapistExperienceDate($date)
{
	$time = strtotime($date);
	$userExp = date('d/m/Y',$time);
	return $userExp;
}

function signup_seeker($input)
{
	global $seeker_msg;
	if ( username_exists( $input['email'] ) && email_exists($input['email'])) {
		global $signUp_login;
		$link = get_permalink(419);
		$seeker_msg = "<div class='error-msg form-error'>Email id already exists,<a href='$link' style='text-decoration:underline;'>click here to login</a></div>";
    	return $seeker_msg;
	} else {
		if(isset($input['firstname']) && isset($input['email']) && isset($input['password']) && isset($input['g-recaptcha-response']) && !empty($input['g-recaptcha-response']))
		{
			$secret = RECAPTCHA_SITE_SECRET;
            $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$input['g-recaptcha-response']);
            $responseData = json_decode($verifyResponse);
            if(!$responseData->success){
	            return generateJSON('error','Enter required fields','');
			}
			$user_id = username_exists( $input['email'] );
			if ( !$user_id and email_exists($input['email']) == false ) 
			{
			   	$seekerDetails = array(
				    'user_login' =>  $input['email'],
				    'user_email'  =>  $input['email'],
				    'user_pass'  =>  $input['password'],
				);
				$user_id = wp_insert_user($seekerDetails);
				
				// $addressObj->country = $input['country'];
				// $addressObj->state = $input['state'];
				// $addressObj->city = $input['city'];
				// $address = json_encode($addressObj);
				// update_user_meta($user_id, 'address',  $address);
			  	
	/*
				update_user_meta($user_id, 'country',  $input['country']);
				update_user_meta($user_id, 'state',  $input['state']);
				update_user_meta($user_id, 'city',  $input['city']);
	*/
				
				auto_login_new_user($user_id);
				if($input['txtEventId'] != "" && $input['txtQuery'] != "")
				{
					$event_id = $input['txtEventId'];
					$question = $input['txtQuery'];
					$current_user = wp_get_current_user();
					$user_email = $current_user->user_email;
					$result = saveFAQQuery($event_id,$question,$user_email);
					wp_redirect(get_permalink($event_id) . "?event_query=saved");
					exit;
				}
				return generateJSON('success','You have successfully signed up.',array('user_id'=>$user_id));
			} 
			else 
			{
				update_user_meta($user_id, 'stage',  1);
				auto_login_new_user($user_id);
			    return generateJSON('error','User already exists, Please login','');
			}
		} 
		else 
		{
			 return generateJSON('error','Enter required fields','');
		}
    }
}

function update_seeker($input)
{
	//$current_user = wp_get_current_user();
	//print_r($current_user); exit;
	if( isset($input['firstname']) && isset($input['mobile']) )
	{
		$current_user = wp_get_current_user();
		$current_user_id = $current_user->ID;
		$seekerDetails = array(
			'ID' => $current_user_id,
		    //'user_login'  =>  $input['email'],
		    'first_name'  =>  $input['firstname'],
		    'last_name'  =>  $input['lastname'],
		);
		$user_id = wp_update_user($seekerDetails);
		update_user_meta($user_id, 'mobile',  $_POST['mobile']);
		
		// Update Address
		// $addressObj->city = $input['city'];
		// $addressObj->state = $input['state'];
		// $addressObj->country = $input['country'];	  	
		// $address = json_encode($addressObj);
	  	// update_user_meta($user_id, 'address',  $address);	

		return generateJSON('success','Your profile successfully updated.',array('user_id'=>$user_id));	
	} 
	else 
	{
		echo "else";
		 return generateJSON('error','Enter required fields','');
	}
}

function deleteUser()
{
	$current_user = wp_get_current_user();		
	$username = $current_user->first_name . ' ' . $current_user->last_name;
	$useremail = $current_user->user_email;
	$mobileNo = $current_user->mobile;
	
	if($_POST['activity'] == 'deleting_account')
	{
		$u = new WP_User($current_user->ID);
		$u->set_role('pending_delete');
		
		if($current_user->post_id)
		{
			$my_post = array(
		      'ID'           => $current_user->post_id,
		      'post_status'  => 'pending-delete',
		      'post_type' => 'therapist'
			);
			wp_update_post( $my_post );
		}
		$msg = "
			$username has deleted their account. Their details are as follows:<br><br>
			Name: $username <br>
			Phone No: $mobileNo <br>
			Email: $useremail <br><br>
			
			Love & light,<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>";
		sendEmail("accountmanager1@thriive.in", "$username has deleted their account.", $msg);
		echo "1";
	}
	else if($_POST['activity'] == 'unsubscribe')
	{
		$reason = $_POST['reason'];
		$tell_us_more = $_POST['tell_us_more'];
		$msg = "
			$username has submitted account deleted reason.The reason are as follows:<br><br>
			Reason: $reason <br>
			Message: $tell_us_more <br><br>
			
			Love & light,<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>";
		sendEmail("accountmanager1@thriive.in", "$username has submitted account deleted reason.", $msg);
		echo "1";
	}	
	exit;
}

function deleteMyBlog()
{
	$current_user = wp_get_current_user();
	$post_id = $current_user->post_id;	
	$row_index = $_POST['row_index'];	
	delete_row('my_blogs', $row_index, $post_id);
	echo "1";
	exit;
}

function submit_review($input)
{
	if(isset($input['txtReview']) && isset($input['txtPostId']))
	{
		$current_user = wp_get_current_user();
        $comment = $input['txtReview'];

        $time = current_time('mysql');

        $data = array(
            'comment_post_ID' => $input['txtPostId'],
            'comment_author' => $current_user->first_name . ' ' .  $current_user->last_name,
            'comment_author_email' => $current_user->user_email,
            'comment_author_url' => get_author_posts_url($current_user->ID),
            'comment_content' => $comment,
            'user_id' => $current_user->ID,
		    'comment_author_IP' => $_SERVER['REMOTE_ADDR'],
            'comment_date' => $time,
            'comment_approved' => 1,
        );
        wp_insert_comment($data);
	}
}
function saveMyBlog($input)
{
	if(isset($input['txtTitle']) && isset($input['txtLink']) && isset($_FILES['event_banner_img']))
	{
		$current_user = wp_get_current_user();
		$post_id = $current_user->post_id;
		
		$title = $input['txtTitle'];
		$link = $input['txtLink'];
		includeFiles();
		
		//If row_index exist it means update the blog , otherwise add the blog
		if(isset($input['row_index']))
		{
			$index = $input['row_index'];
			update_post_meta($post_id,'my_blogs_' . $index . '_blog_title',$title);
			update_post_meta($post_id,'my_blogs_' . $index . '_blog_link',$link);
			if($_FILES['event_banner_img']['name'] != "")
			{
				$img_id = media_handle_upload( 'event_banner_img', $post_id );
				update_field('my_blogs_' . $index . '_blog_image',$img_id,$post_id);
			}
		}
		else
		{
			$img_id = media_handle_upload( 'event_banner_img', $post_id );
			$new_blog = array(
				'blog_title'	=> $title,
				'blog_image'	=> $img_id,
				'blog_link'	=> $link
			);
			add_row('my_blogs', $new_blog,$post_id);
		}
		wp_redirect(get_permalink(1873));
	}
	
}
function getTherapistCommunicationMode()
{
	$post_id = $_POST['post_id'];
	$communication_modes = get_field('communication_mode',$post_id);
	ob_start();
	foreach($communication_modes as $communication_mode) 
	{
		?>						
			<div class="checkbox-wrapper col-6">
				<input type="checkbox" name="communication[]" value="<?php echo $communication_mode ?>" id="<?php echo $communication_mode ?>" data-parsley-multiple="communication" data-parsley-errors-container="#message-holder" required>
				<label for="<?php echo $communication_mode ?>"><?php echo $communication_mode ?></label>
			</div>
		<?php 
	}
	echo $communication_mode = ob_get_clean();
	exit;
}
function connectWithHealer($input)
{
	if (!is_user_logged_in()) 
	{ 
		wp_redirect(get_permalink(419));	//Sending seeker to login page
		exit();
	} 
	else
	{
		//print_r($input['communication']);exit;
		if(isset($input['communication']))
		{
			//Collecting User's details
			$current_user = wp_get_current_user();
			$current_user_id = $current_user->ID;
			$healer_email = "";
			
			//Collecting Therapist's details by post id if exist
			$healer_details = get_users(array('meta_key' => 'post_id','meta_value' => $input['postId']));
			if($healer_details)
			{				
				foreach($healer_details as $healer_detail)
				{
					$healer_id = $healer_detail->ID;
					$healer_email = $healer_detail->user_email;
				}
				
				for($i=0; $i< count($input['communication']); $i++)
				{
					$connect_healer_by = strtolower("connect_with_healer_by_" . str_replace(' ','_',$input['communication'][$i]));
					$connect_healer_with = $healer_id;

					$connect_seeker_by = strtolower("connect_with_seeker_by_" . str_replace(' ','_',$input['communication'][$i]));
					$connect_seeker_with = $current_user_id;
					
					//Updating seeker's account
					$havemeta = get_user_meta($current_user_id, $connect_healer_by, true);
					if($havemeta)
					{	
						if (strpos((string)$havemeta, (string)$healer_id) === false) 
					    {
					        $connect_healer_with = $havemeta . ',' . $healer_id;
							update_user_meta($current_user_id, $connect_healer_by,  $connect_healer_with);
					    }
					}
					else
					{
						update_user_meta($current_user_id, $connect_healer_by,  $connect_healer_with);						
					}
					
					//Updating therapist's account
					$havemetaHealer = get_user_meta($healer_id, $connect_seeker_by, true);
					if($havemetaHealer)
					{	
						if (strpos((string)$havemetaHealer, (string)$current_user_id) === false) 
					    {
					        $connect_seeker_with = $havemetaHealer . ',' . $current_user_id;
							update_user_meta($healer_id, $connect_seeker_by,  $connect_seeker_with);
					    }
					}
					else
					{
						update_user_meta($healer_id, $connect_seeker_by,  $connect_seeker_with);						
					}
					
					//Counting contacted therapist and saving in usermeta table
					$totalContactedTherapist = get_user_meta($current_user_id, 'contacted_therapist_id', true);
					if($totalContactedTherapist)
					{
						if (strpos((string)$totalContactedTherapist, (string)$healer_id) === false) 
					    {
					    	//Updating id
						    $connect_healer_with = $totalContactedTherapist . ',' . $healer_id;
							update_user_meta($current_user_id, 'contacted_therapist_id',  $connect_healer_with);

							//Updating date
							$contacted_therapist_date = get_user_meta($current_user_id,'contacted_therapist_date',true);
							$contacted_therapist_date = $contacted_therapist_date . ', ' . date("Y-m-d");
							update_user_meta($current_user_id, 'contacted_therapist_date', $contacted_therapist_date);

							//Updating time
							$contacted_therapist_time = get_user_meta($current_user_id,'contacted_therapist_time',true);
							$contacted_therapist_time = $contacted_therapist_time . ', ' . date("h:i:sa");
							update_user_meta($current_user_id, 'contacted_therapist_time', $contacted_therapist_time);
						}
					}
					else
					{
					    //Updating id
						update_user_meta($current_user_id, 'contacted_therapist_id', $connect_healer_with);
						//Updating date
						update_user_meta($current_user_id, 'contacted_therapist_date', date("Y-m-d"));
						//Updating time
						update_user_meta($current_user_id, 'contacted_therapist_time', date("h:i:sa"));
					}
					
					
					//Counting contacted seeker and saving in usermeta table
					$totalContactedSeeker = get_user_meta($healer_id, 'contacted_seeker_id', true);
					if($totalContactedSeeker)
					{
						if (strpos((string)$totalContactedSeeker, (string)$current_user_id) === false) 
					    {
					    	//Updating id
						    $connect_seeker_with = $totalContactedSeeker . ',' . $current_user_id;
							update_user_meta($healer_id, 'contacted_seeker_id',  $connect_seeker_with);

							//Updating date
							$contacted_seeker_date = get_user_meta($healer_id,'contacted_seeker_date',true);
							$contacted_seeker_date = $contacted_seeker_date . ', ' . date("Y-m-d");
							update_user_meta($healer_id, 'contacted_seeker_date', $contacted_seeker_date);

							//Updating time
							$contacted_seeker_time = get_user_meta($healer_id,'contacted_seeker_time',true);
							$contacted_seeker_time = $contacted_seeker_time . ', ' . date("h:i:sa");
							update_user_meta($healer_id, 'contacted_seeker_time', $contacted_seeker_time);
						}
					}
					else
					{
					    //Updating id
						update_user_meta($healer_id, 'contacted_seeker_id', $connect_seeker_with);	
						//Updating date
						update_user_meta($healer_id, 'contacted_seeker_date', date("Y-m-d"));
						//Updating time
						update_user_meta($healer_id, 'contacted_seeker_time', date("h:i:sa"));				
					}					
				}

				//connectMsgToSeeker($healer_id);
				//connectMsgToHealer($healer_id);
				//send masked number to both seeker and healer
				consult_online_thriive_therapist($healer_email,$current_user->user_email);
				
				global $connect_msg;
				$connect_msg = "true";
				global $connect_post_id;
				$connect_post_id = $input['postId'];
				return generateJSON('error','Connect request has been sent to therapist.','');
			}
			else
			{
				return generateJSON('error','User doesn\'t exist','');
			}				
		}
	}
}

// Update seq no in options
function wpse_check_settings( $old_value, $new_value )
{
	if($old_value != $new_value) {
		update_option('invoice_seq_no', 1);
	}    
}

function saveStage($user_id,$stage){
	$data = wp_get_current_user()->completed_stages;
	$data[$stage-1]=1;
	update_user_meta($user_id, 'completed_stages',  $data);
}

function isStageCompleted($user_id){
	
	$name = wp_get_current_user()->first_name . " " . wp_get_current_user()->last_name;
	
	$data = wp_get_current_user()->completed_stages;
	if (in_array("0", $data)) {
		$position = array_search(0,$data);
		update_user_meta($user_id, 'stage',  ($position+1));
		$my_post = array(
	      'ID'           => wp_get_current_user()->post_id,
	      'post_status'  => 'draft',
	      'post_type' => 'therapist'
		);
		
		// Update the post into the database
		  wp_update_post( $my_post );
		return  0;
	} else {
		update_user_meta($user_id, 'stage',  5);
		$userPost = get_post(wp_get_current_user()->post_id);
	   for ($x = 1; $x < 4; $x++) {
			  $email = '';
		
			  if($x==1){
				  $email = $userPost->first_reference_email;
			  } else if($x==2){
				  $email = $userPost->second_reference_email;
			  } else if($x==3){
				  $email = $userPost->third_reference_email;
			  }
			$codeD = $email.wp_get_current_user()->ID . time();  
		    $code = sha1( $codeD );
		    $activation_link = add_query_arg( array( 'key' => $code, 'user' => wp_get_current_user()->ID,'feed_ref' => 'ref_'.$x ), get_permalink( 510 ));
	       $resultData =  update_user_meta( wp_get_current_user()->ID, 'ref_'.$x, $code );
	       //$link = $activation_link . " User email address : " . $email;
	       
	       $msg = "Hello from Thriive Art & Soul! We are India’s leading digital wellness portal that verifies and registers Therapists.  As part of our verification process all our eligible Therapists need to provide us with referrals whom we may contact independently. Your name has been given as a reference for $name.  Please follow the link given below to complete your review. It will take about 2 minutes of your time.<br><br>
		       		
		       		$activation_link <br><br> 
	 
	If you’re in the mood for change, do visit www.thriive.in. A new universe awaits you within these digital walls. Transformation begins at our doorstep (or URL). Whether you’re just exploring or are a serious seeker you will find our free library of talks, articles and guided meditations practical and useful. If wellness overwhelms you we will show you the best way to wellness designed for you! Enlightening events and workshops worldwide are just a click away. Every soul craves evolution.<br><br>
	
	Thank you so much for taking the time to fill out the review! We are grateful to you!<br><br>
	 
	Love & light,<br>
	Team Thriive<br><br>
	<em style='color: #615c5c;'>
		Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
	<em>";
	       sendEmail( $email, "Do you know $name? Let’s chat!", $msg);
		}
		return 1;
	}
}

function getHash($input){
	$retHashSeq = SALT.'|'.$input["status"].'|||||||||'.$input["udf2"].'|'.$input["udf1"].'|'.$input["email"].'|'.$input["firstname"].'|'.$input["productinfo"].'|'.					$input["amount"].'|'.$input["txnid"].'|'.$input["key"];
	$hashKey = hash("sha512", $retHashSeq);
	return $hashKey;
}

function updateUserDetails($input){
	$txId= $input['txnid'];
	$amount = $input['amount'];
	$paymentAction = $input['udf1'];	// udf1 have payment action type (Renew, upgrade, purchase)
	$package_id = $input['udf2'];  // udf2 have package Id
	
	if(!empty($txId)){
	  		if(is_user_logged_in()){

		  		$user_id = wp_get_current_user()->ID;
		  		$userPost = get_post(wp_get_current_user()->post_id);
		  		$package = get_post($userPost->select_package[0]);
				
				$date = new DateTime('now');
				$post_id = wp_insert_post(array (
				  'post_type' => 'transaction',
				  'post_title' => $user_id.'-'.$txId,
				  'post_author' => $user_id,
				  'post_content' => ' Payment successful',
				  'post_status' => 'draft'
				));
				
				update_field('transaction_id',$txId,$post_id);
				update_field('product_id',$package_id,$post_id);	//changed
				update_field('product_type',188,$post_id);
				update_field('date',date('F d, Y'),$post_id);
				update_field('payment_mode','Online',$post_id);
				update_field('payment_gateway','payu',$post_id);
				update_field('start_date',date('F d, Y'),$post_id);
				update_field('end_date',$date->modify('+12 month')->format('F d, Y'),$post_id);
				update_field('total_amount',$amount,$post_id); 	//changed				
				//update_field('package_expiry_date',$date->modify('+12 month')->format('F d, Y'),wp_get_current_user()->post_id); 	//changed
								
				update_user_meta($user_id, 'transaction',  $post_id);
				update_user_meta($user_id, 'stage',  6);
				update_user_meta($user_id, 'is_mobile_verify',  1);
				update_user_meta($user_id, 'completed_stages',  array('1','1','1','1'));
				$my_post = array(
				      'ID'           => wp_get_current_user()->post_id,
				      'post_status'  => 'publish',
				      'post_type' => 'therapist'
					);	
				// Update the post into the database
				wp_update_post( $my_post );
				if($paymentAction == "upgrade_package" || $paymentAction == "renew_package")
				{
					//Get Package detail
					$get_package = get_field("select_package",wp_get_current_user()->post_id);
				    $oldPackageName = $get_package[0]->post_title;
					update_post_meta(wp_get_current_user()->post_id, 'old_package', $oldPackageName);
					
					update_field('select_package',$package_id,wp_get_current_user()->post_id);
				}
				
				//Degrading the package
				if($paymentAction == "renew_package")
				{
					degradingUserPackage();
				}
/*
				else if($paymentAction == "renew_package")
				{
					update_field('select_package',$package_id,wp_get_current_user()->post_id);
				}
*/
				return generateJSON('success','payment successful','');			  
			} else {
				return generateJSON('error','payment failed','');
			}
	} else {
		 return generateJSON('error','Enter required fields','');
	}
}
function updateFreeUserDetails($input)
{
	if(is_user_logged_in())
	{
		$paymentAction = $input['udf1'];	// udf1 have payment action type (Renew, upgrade, purchase)
		$package_id = $input['udf2'];  // udf2 have package Id
		
		$user_id = wp_get_current_user()->ID;
  		$userPost = get_post(wp_get_current_user()->post_id);
  		$package = get_post($userPost->select_package[0]);
  		
  		update_user_meta($user_id, 'stage',  6);
		update_user_meta($user_id, 'is_mobile_verify',  1);
		update_user_meta($user_id, 'completed_stages',  array('1','1','1','1'));
		
		$my_post = array(
	      'ID'           => wp_get_current_user()->post_id,
	      'post_status'  => 'publish',
	      'post_type' => 'therapist'
		);
		wp_update_post( $my_post );
		
		if($paymentAction == "upgrade_package" || $paymentAction == "renew_package")
		{
			update_field('select_package',$package_id,wp_get_current_user()->post_id);
		}
		
		//Degrading the package
		if($paymentAction == "renew_package")
		{
			degradingUserPackage();
		}
/*
		else if($paymentAction == "renew_package")
		{
			update_field('select_package',$package_id,wp_get_current_user()->post_id);
		}
*/
		return generateJSON('success','payment successful','');
	} 
	else 
	{
		return generateJSON('error','payment failed','');
	}
}

function degradingUserPackage()
{
	$post_id = wp_get_current_user()->post_id;
	$userPost = get_post($post_id);
	$package = get_post($userPost->select_package[0]);
	
	//Therapies
	if($userPost->therapy > $package->number_of_therapies)
	{
		$total_allowed = $package->number_of_therapies + 1;
		for($i = $total_allowed; $i <= $userPost->therapy; $i = $total_allowed)
		{
			delete_row('therapy', $i, $post_id);	
			//echo $i . "<br>";	
		}
	}
	
	//Gallery images
	if($userPost->gallery > $package->number_of_images)
	{
		$total_allowed = $package->number_of_images + 1;
		for($i = $total_allowed; $i <= $userPost->gallery; $i = $total_allowed)
		{
			delete_row('gallery', $i, $post_id);	
			//echo $i . "<br>";	
		}
	}
	
	//Gallery videos
	if($userPost->videos > $package->number_of_videos)
	{
		$total_allowed = $package->number_of_videos + 1;
		for($i = $total_allowed; $i <= $userPost->videos; $i = $total_allowed)
		{
			delete_row('videos', $i, $post_id);	
			//echo $i . "<br>";	
		}
	}
	
	//Events					
	$createdThriiveEvent = explode(",",get_user_meta($current_user->ID,'my_events',true));
	$totalCreatedThriiveEvent = count(array_filter($createdThriiveEvent));
	if($totalCreatedThriiveEvent > $package->number_of_events)
	{
		$total_allowed = $package->number_of_events;
		for($i = $total_allowed; $i < $totalCreatedThriiveEvent; $i++)
		{
			//Deleting the post
			wp_delete_post($createdThriiveEvent[$i]);							
			//Searching the key
			$key = array_search($createdThriiveEvent[$i], $createdThriiveEvent);
			//Removing the key from the array
			unset($createdThriiveEvent[$key]);
			//convert array to comma separated string
			$createdThriiveEvent = implode(",", $createdThriiveEvent);
			//Updating in user meta
			update_user_meta(wp_get_current_user()->ID, 'my_events', $createdThriiveEvent);
		}
	}
}

// Registering custom post status
function wpb_custom_post_status(){
    register_post_status('pending_payment', array(
        'label'                     => _x( 'Pending payment', 'therapist' ),
        'public'                    => true,
        'exclude_from_search'       => false,
        'show_in_admin_all_list'    => true,
        'show_in_admin_status_list' => true,
        'label_count'               => _n_noop( 'Pending payment <span class="count">(%s)</span>', 'Pending payment <span class="count">(%s)</span>' ),
    ) );
}



 
// Using jQuery to add it to post status dropdown
function wpb_append_post_status_list(){
	global $post;
	$complete = '';
	$label = '';
	if($post->post_type == 'therapist'){
		if($post->post_status == 'pending_payment'){
			$complete = ' selected="selected"';
			$label = '<span id="post-status-display"> Pending payment</span>';
		}
		echo '
		<script>
		jQuery(document).ready(function($){
		$("select#post_status").append("<option value=\"pending_payment\" '.$complete.'>Pending payment</option>");
		$(".misc-pub-section label").append("'.$label.'");
		});
		</script>
		';
	}
}

function getDefaultPackageTherapyCount(){
	$pCount = 0;
	$packageArgs = array( 'post_type' => 'packages', 'posts_per_page' => 10, 'orderby'   => 'meta_value', 'order' => 'ASC' );
    $packages = new WP_Query( $packageArgs );
    
    while ( $packages->have_posts() ) : $packages->the_post();  
    	if(get_field('isdefault') == '1') {
	    	$pCount = get_field('number_of_therapies');
    	} 
	endwhile;	
	wp_reset_postdata();
	return $pCount;	
}

function getTherapyList(){
	$current_user = wp_get_current_user();
	$userPost = get_post($current_user->post_id);
	?>
	<p>If the therapy you practice is not listed here, please get in touch with us at accountmanager1@thriive.in</p>
	<?php
	if(empty($_POST['therapy_count'])) {
		$totalTherapies = getDefaultPackageTherapyCount();
	} else {
		$totalTherapies = intval( $_POST['therapy_count'] );
	}
	if(!empty($_POST['package_name'])) {
		$package_name = $_POST['package_name'];
	}
		
	//$totalTherapies = 3;
	$taxonomyArray = array(
      'taxonomy' => 'therapy',
      'hide_empty' => false 
    );
      	
    $therapy_terms = get_terms($taxonomyArray);
    //echo '<pre>';print_r($therapy_terms);echo '</pre>';
	for ($x = 0; $x < $totalTherapies; $x++) {
		$varExp = 'therapy_'.$x.'_experience';
		$varCharge = 'therapy_'.$x.'_charges';
		$varName = 'therapy_'.$x.'_therapy_name';
		?>
		<div class="add_therapy_section">
			<div class="form-group sel">
				<label for="therapy-1" class="d-block">Therapy <?php echo $x+1;echo ($x == 0)?'*':'' ?></label>
					<select class="form-control select-list-item select-dropdown-list<?php echo ($x == 0)?'':' therapy-select'?>" id="therapy-list_<?php echo $x+1; ?>" name="t_name_<?php echo $x+1; ?>" data-parsley-required-message="Therapy is required." data-parsley-errors-container="#select-therapy-error_<?php echo $x+1; ?>" <?php echo ($x == 0)?'required':''?>>
						<option value="">Select Therapy</option>
						<?php foreach($therapy_terms as $therapy) { 
							if($therapy->parent != 0){
						?>
								<option value="<?php echo $therapy->term_id .'-'. $therapy->name; ?>" 
								<?php
									if(!empty($userPost->$varName)) { echo (($userPost->$varName[0])==($therapy->term_id))?'selected':''; }
								?>								
								><?php echo $therapy->name;?></option>
						<?php }} ?>
					</select>
					<div id="select-therapy-error_<?php echo $x+1; ?>"></div>
			</div>
 	  		<div class="form-group exp">
				<label for="experience">Experience (Practices since)<?php echo ($x == 0)?'*':''?></label>
			    <input type="text" class="date_picker form-control<?php echo ($x == 0)?'':' therapy-exp'?>" id="experience_<?php  echo $x+1; ?>" name="t_experience_<?php  echo $x+1; ?>" value="<?php echo $userPost->$varExp;?>" data-parsley-required-message="Experience is required." <?php echo ($x == 0)?'required':''?> readonly>
	  		</div>			  		
	  		<div class="form-group">
				<label for="charges">Charges</label>
			    <input type="number" class="form-control" id="charges_<?php echo $x+1; ?>" name="t_charges_<?php  echo $x+1; ?>" value="<?php echo $userPost->$varCharge;?>">
	  		</div>
	  	</div>
<?php
	} 
	if($package_name == 'Fire') { ?>
		<p>If you have selected Fire package you can add more than 5 therapies after the registration process is completed.</p>
	<?php }
	if(!empty($_POST['therapy_count'])) { 
		wp_die();
	}
	//wp_die();
}

function savePackageDetails($input){
	//echo "<pre>"; print_r($input);echo "</pre>";
	//exit;
	if(isset($input['total_therapies']) && isset($input['package']) && isset($input['communication'])){
			if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				$post_id = $current_user->post_id;
				$total_therapies = intval($input['total_therapies']);
				//$therapy_count_final = 0;
				$i=0;
				for ($x = 0; $x < $total_therapies; $x++) 
				{		
					//Update therapy acf field if therapy name exist
					if(!empty($input['t_name_'.($x+1)]))
					{
						$therapy = explode('-',$input['t_name_'.($x+1)]);
						
						update_field('therapy_'.$i.'_therapy_name', array($therapy[0]),$post_id);
						update_field('therapy_'.$i.'_experience',$input['t_experience_'.($x+1)],$post_id);
						update_field('therapy_'.$i.'_charges',$input['t_charges_'.($x+1)],$post_id);
						$i++;
						//echo "<pre>";print_r($therapy[0]);echo "</pre>";
						$therapy_id[] = $therapy[0];
						wp_set_post_terms($current_user->post_id, $therapy_id, 'therapy' );
					}														
				}
				
				if($input['package'] == "")
				{
					update_field('select_package',129,$post_id);
				}
				else
				{
					update_field('select_package',$input['package'],$post_id);					
				}
				
				update_field('communication_mode',$input['communication'],$post_id);
				//update_post_meta($post_id,'therapy_count',$total_therapies);	
				//update_post_meta($post_id, 'therapy', $therapy_count_final);	
				update_post_meta($post_id, 'therapy', $i);			
				update_user_meta($current_user->ID, 'stage',  3);
				saveStage($current_user->ID,2);
				return generateJSON('success','Package details added successfully','');			  
			} else {
				return generateJSON('error','Please login to proceed','');
			}
	} else {
		return generateJSON('error','Enter required fields','');
	}
}

function saveEditedTherapies($input){
	if(isset($input['total_therapies'])){
		if(is_user_logged_in()){
			$current_user = wp_get_current_user();
			$post_id = $current_user->post_id;
			$total_therapies = intval($input['total_therapies']);
			
			for ($x = 0; $x < $total_therapies; $x++) {				
				update_field('therapy_'.$x.'_charges', $input['t_charges_'.($x+1)], $post_id);				
			}	
			$page = get_page_by_path('edit-therapies');
			wp_redirect(get_permalink($page->ID).'?updated=1');
			return generateJSON('success','Therapies edited successfully','');			  
		} else {
			return generateJSON('error','Please login to proceed','');
		}
	} else {
		return generateJSON('error','Enter required fields','');
	}
}

function saveSocialNetworkDetails($input){
		if(is_user_logged_in()){	
				$current_user = wp_get_current_user();
				$post_id = $current_user->post_id;
				
				//Updating therapist's get_the_content()
				$my_post = array(
				    'ID'           => $post_id,
				    'post_content' => $input['about_you'],
				);
				wp_update_post($my_post);
			 	
			 	//Therapist language
			    if($input['language'])
			    {
				    $getLanguage = str_replace(" ","",$input['language']);
				    $languages = explode(",",$getLanguage);
				    foreach($languages as $language)
				    {
				        $isTermExist = term_exists($language,'language');
						if($isTermExist)
						{
							$language_term_id[] = $isTermExist['term_id'];
						}
						else
						{
							$result = wp_insert_term($language,'language');
							$language_term_id[] = $result['term_id'];
						}
				    }
				    //set term to post
				    wp_set_post_terms($current_user->post_id, $language_term_id, 'language' );
				    $language_term_id = json_encode($language_term_id);
				    update_user_meta($user_id, 'language', $language_term_id);
			    }
				
				update_field('website_url',generateValidUrl($input['website']),$post_id);
				update_field('therapist_title',$input['therapistTitle'],$post_id);
				update_field('facebook_url',generateValidUrl($input['facebook']),$post_id);
				update_field('twitter_url',generateValidUrl($input['twitter']),$post_id);
				update_field('instagram_url',generateValidUrl($input['instagram']),$post_id);
				update_field('linkedin_url',generateValidUrl($input['linkedIn']),$post_id);
				update_field('skype_call',generateValidUrl($input['skype_call']),$post_id);
				update_field('youtube',generateValidUrl($input['youtube']),$post_id);
				//update_field('experience_profile',$input['experience_profile'],$post_id);
				update_user_meta($current_user->ID, 'stage',  4);
				saveStage($current_user->ID,3);
			return generateJSON('success','Details added successfully','');			  
		} else {
			return generateJSON('error','Please login to proceed','');
			wp_die();
		}
}

function saveVerificationDetails($input){
	//print_r($_FILES);
		//print_r($_FILES['identity_picture']['name']);
		//exit;

	if(/* isset($input['identity_option']) && */ isset($input['ref_email_1']) && isset($input['ref_email_2']) && isset($input['ref_email_3']) /* && isset($input['identity_doc_number']) */){
		if(is_user_logged_in()){
				$current_user = wp_get_current_user();
				$post_id = $current_user->post_id;
				$post_status = get_post_status($post_id);
				
				update_field('first_reference_name',$input['reference_name_1'],$post_id);
				update_field('first_reference_email',$input['ref_email_1'],$post_id);
				update_field('second_reference_name',$input['reference_name_2'],$post_id);
				update_field('second_reference_email',$input['ref_email_2'],$post_id);
				update_field('third_reference_name',$input['reference_name_3'],$post_id);
				update_field('third_reference_email',$input['ref_email_3'],$post_id);
				//update_field('select_identity_proof',$input['identity_option'],$post_id);
				//update_field('identity_number',$input['identity_doc_number'],$post_id);
				update_field('gstin_number', $input['gstin_number'], $post_id);
				
				includeFiles();
				
				
				if($_FILES['identity_picture']['name'] != "")
				{
					$identity_picture_id = media_handle_upload( 'identity_picture', $post_id );
					$returnData = update_field('select_identity_image',$identity_picture_id,$post_id);
				}
				
				
				if($_FILES['profile_picture']['name'] != "")
				{
					$profile_picture_id = media_handle_upload( 'profile_picture', $post_id );
					set_post_thumbnail( $post_id, $profile_picture_id );
					update_field('profile_picture',$profile_picture_id,$post_id);
				}
				
				
/*
				if($_FILES['address_picture']['name'] != "")
				{
					$address_picture_id = media_handle_upload( 'address_picture', $post_id );
					update_field('address_proof',$address_picture_id,$post_id);
				}
*/
				
				$files = $_FILES['certificate_picture'];
				
				$total_images=0;
				foreach ($files['name'] as $key => $value) {
					if ($files['name'][$key]) {
			            $file = array(
			                'name' => $files['name'][$key],
			                'type' => $files['type'][$key],
			                'tmp_name' => $files['tmp_name'][$key],
			                'error' => $files['error'][$key],
			                'size' => $files['size'][$key]
			            );
			       
			            $_FILES = array('certificates_'.$key.'_certificate' => $file);
			            //print_r($_FILES);
			            $attachment_id = media_handle_upload( 'certificates_'.$key.'_certificate', wp_get_current_user()->post_id );
			            //echo $attachment_id;
			            $certificate_row = array('certificate' => $attachment_id);
						$resultData = add_row('certificates', $certificate_row, wp_get_current_user()->post_id);
			            //$res = update_field('certificates_'.$key.'_certificate',$attachment_id,wp_get_current_user()->post_id);
			        }
			    $total_images = $key;
			    }
		        
		        //update_post_meta(wp_get_current_user()->post_id,'certificates',($total_images+1),true);
        
				//update_field('identity_number',$input['identity_doc_number'],$post_id);
								
				if($post_status != "publish" && $post_status != "pending-payments")
				{
					saveStage($current_user->ID,4);
					$returnData = isStageCompleted($current_user->ID);
					if($returnData==1) {
						//if(get_post_status($current_user->post_id) != "publish" || get_post_status($current_user->post_id) != "pending-payments")
						//{
							$my_post = array(
						      'ID'           => wp_get_current_user()->post_id,
						      'post_status'  => 'pending',
						      'post_type' => 'therapist'
							);
						//}
						/*$my_post = array(
					      'ID'           => wp_get_current_user()->post_id,
					      'post_status'  => 'pending',
					      'post_type' => 'therapist'
						);*/
					
						// Update the post into the database
						wp_update_post( $my_post );
						
						$therapistMetaData = get_user_meta($current_user->ID);
						$theraistMobileNumber = $therapistMetaData['mobile'][0];
					  	$userName = $current_user->first_name . " " . $current_user->last_name;
					  	$userEmail = $current_user->user_email;
						//echo "Id= " . $theraistMobileNumber;
					  
						//Sending SMS & Email to Therapist
						$customer_msg = "Thank you for submitting your registration form for Thriive Art & Soul. Our team is verifying your form and will contact you as soon as it's complete.";
						sendSMS($theraistMobileNumber, $customer_msg);
						$msg = "
							Dear $userName,<br><br>
							$customer_msg <br><br>
							Love & light,<br>
							Team Thriive<br><br>
							<em style='color: #615c5c;'>
								Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
							<em>			
						";
						sendEmail($userEmail, 'Your Thriive registration form is in verification!', $msg);
						
						
						//Sending Email to Admin
					  	$userName = $current_user->first_name . " " . $current_user->last_name;
					  	$userEmail = $current_user->user_email;
					  	$msg = "
						  	Dear Account Manager,<br><br>				  	
							You have received the registration form from a web applicant. Please review to process their application within two working days. Details are as follows:<br><br>					 
							Name of Therapist: $userName<br><br>					 
							Email of Therapist: $userEmail<br><br>					 
							Please login to Admin Dashboard to view the details.<br>
							We have sent emails with review links to three reviewers submitted by Therapist. Acknowledgement will be sent once they are received.<br><br>					
							Love & light,<br>
							Team Thriive
						";
						sendEmail('accountmanager1@thriive.in', $userName . ' has submitted the registration form!', $msg);
					}
				}
			return generateJSON('success','Verification details saved successfully','');
		} else {
			return generateJSON('error','Please login to proceed','');
		}
	} else{
		return generateJSON('error','Enter required fields','');
	}
}

function getTherapistLocation($id)
{
	$locations = get_terms('location', array('parent' => 0, 'object_ids' => $id));
	if($locations)
	{
		$country_id = $locations[0]->term_id;
		$country_name = $locations[0]->name;
		
		$state = get_terms('location', array('parent' => $country_id, 'object_ids' => $id));
		if($state)
		{
			$state_id = $state[0]->term_id;
			$state_name = $state[0]->name;
		
			$city = get_terms('location', array('parent' => $state_id, 'object_ids' => $id));
			if($city)
			{
				$city_name = $city[0]->name;
			}
		}
		if(empty($city_name)) 
		{
			if(!empty($state_name))
			{
				$state_name = $state_name . ", ";
			}
			$therapist_location = $state_name . $country_name;
		} else {
			$therapist_location = $city_name . ", " . $country_name;
		} 
	}
	else
	{
		$therapist_location = "";
	}
	return $therapist_location;
}
function getTherapistCity($id)
{
	$locations = get_terms('location', array('parent' => 0, 'object_ids' => $id));
	if($locations)
	{
		$country_id = $locations[0]->term_id;
		$country_name = $locations[0]->name;
		
		$state = get_terms('location', array('parent' => $country_id, 'object_ids' => $id));
		if($state)
		{
			$state_id = $state[0]->term_id;
			$state_name = $state[0]->name;
		
			$city = get_terms('location', array('parent' => $state_id, 'object_ids' => $id));
			if($city)
			{
				$city_name = $city[0]->name;
			}
		}
		if(!empty($city_name)) 
		{
			$therapist_city = $city_name;
		} 
		else 
		{
			$therapist_city = "";
		} 
	}
	else
	{
		$therapist_city = "";
	}
	return $therapist_city;
}
function getTherapistCountry($id)
{
	$locations = get_terms('location', array('parent' => 0, 'object_ids' => $id));
	if($locations)
	{
		$country_name = $locations[0]->name;
	}
	else
	{
		$country_name = "";
	}
	return $country_name;
}

function getTherapistLanguage($post_id)
{
	$languages = get_field("language",$post_id);
	if($languages)
	{
		foreach($languages as $language)
		{
			$tr = get_term( $language, "language");
			$therapist_lang[] = $tr->name;
		}
		$therapist_lang = implode(", ", $therapist_lang);
	}
	else
	{
		$therapist_lang = '';
	}
	echo $therapist_lang;
}

function generateJSON($status,$resMessage,$resData){
	$responseObj->resStatus = $status;
	$responseObj->resMessage = $resMessage;
	$responseObj->resData = $resData;	
	return json_encode($responseObj);
}

function auto_login_new_user( $user_id ) {
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);
}

function generatePIN(){
    $i = 0; //counter
    $pin = ""; //our default pin is blank.
    while($i < 4){
        //generate a random number between 0 and 9.
        $pin .= mt_rand(0, 9);
        $i++;
    }
    return $pin;
}

function verifyOTP(){
	$OTPNumber =  intval($_POST['mobile_otp']);
	if(is_user_logged_in()){
		if((wp_get_current_user()->mobileOTP)==$OTPNumber){
			update_user_meta(wp_get_current_user()->ID, 'is_mobile_verify',  1);
			echo generateJSON('success','OTP verified successfully.','');
			 wp_die();
		} else{
			 echo generateJSON('error','Please enter valid OTP','');
			 wp_die();
		}
	} else {
		echo  generateJSON('error','Please login to proceed','');
		wp_die();
	}	
}

function changeStage(){
	$stage =  intval($_POST['stage_number']);
	if(is_user_logged_in()){
		if((get_post_status(wp_get_current_user()->post_id )=='draft')&&($stage<5)){
			update_user_meta(wp_get_current_user()->ID, 'stage',  $stage);
			echo generateJSON('success','Stage changed.','');
			wp_die();
		} else {
			echo  generateJSON('error','Hold state','');
			wp_die();
		}	
	} else {
		echo  generateJSON('error','Please login to proceed','');
		wp_die();
	}
}

function sendOTP(){
	$countrycode = intval($_POST['country_code']);
	$mobileNumber = intval($_POST['mobile_number']);
	//$mobileNumber =  $countrycode . intval($_POST['mobile_number']);
/*
	$args = array(
		'meta_key'     => 'mobile',
		'meta_value'   => $mobileNumber,
		'meta_compare' => '=',
		'exclude' => array( wp_get_current_user()->ID )
	);
*/
	$args = array(
		'meta_query' => array(
	    	array(
	        	'key' => 'mobile',
				'value' => $mobileNumber,
				'compare' => '=',
			),
			array(
	        	'key' => 'countryCode',
				'value' => $countrycode,
				'compare' => '='
			)
		),
		'exclude' => array( wp_get_current_user()->ID )
	);
	$user_query = new WP_User_Query( $args );
	// Get the results
	$isMobileExist = $user_query->get_results();

	// Check for results
	if ( !empty( $isMobileExist ) )
	{
		$data = array(); 
    	$mobileExist = "This mobile number is already registered.";
    	$data['msg'] = $mobileExist;
    	$data['success'] = false;
    	echo json_encode($data);
    	wp_die();
    } else {
	    if(is_user_logged_in()){
			update_user_meta(wp_get_current_user()->ID, 'mobile', $mobileNumber);
			update_user_meta(wp_get_current_user()->ID, 'countryCode', $countrycode);
			update_field('mobile_number',$countrycode . $mobileNumber,wp_get_current_user()->post_id);
			$generatedPin = generatePIN();
			update_user_meta(wp_get_current_user()->ID, 'mobileOTP', $generatedPin);
			if(wp_get_current_user()->post_id > 0) {
				$msg = $generatedPin . ' is the one time password (OTP) for your online registration as Therapist with Thriive Art & Soul. This is usable once & valid for 15 min';
			} else {
				$msg = $generatedPin . ' is the one time password (OTP) for your online registration on Thriive Art & Soul. This is usable once & valid for 15 min';
			}
			
			$result = sendSMS($countrycode . $mobileNumber, $msg);
			echo generateJSON('success','OTP sent successfully.','');
			wp_die();
		} else {
			echo generateJSON('error','Please login to proceed','');	
			wp_die();
		}
    }
}


function sendSMS($mobileNo, $msg)
{
	$url = SMS_URL."destination=".$mobileNo."&message=".urlencode($msg);
	$result = file_get_contents($url);
	return $result;
}

function getChildTermByParentTerm($term_id,$taxonomy)
{
	$get_child_taxonomy = get_term_children($term_id, $taxonomy);
	return $get_child_taxonomy;
}
function getSubTherapy_load()
{
	$taxonomy = $_POST['taxonomy'];
	$term_id = (int)$_POST['term_id'];
	$get_child_taxonomy = get_term_children($term_id, $taxonomy);
	
	$terms = get_terms($taxonomy, array(
	    'include' => $get_child_taxonomy,
	    'hide_empty' => false,
	) );
	
	foreach($terms as $term)
	{
		$therapyArr = array();
		$therapy_image = wp_get_attachment_image_src(get_field('therapy_image','therapy_'.$term->term_id), 'thumbnail')[0];
		if(empty($therapy_image)){ $therapy_image = ""; }
		
        $therapyArr['name'] = $term->name;
        $therapyArr['description'] = substr($term->description,0,50);
        $therapyArr['slug'] = $term->slug;
        $therapyArr['img'] = $therapy_image;
        $finalDetails[] = $therapyArr;
	}
	
	echo json_encode($finalDetails); wp_die();
}
function getMainTaxonomyDetails(){
	$taxonomy = $_POST['taxonomy'];
	$parent = (int)$_POST['parent'];
	$filter = $_POST['filter'];
	$finalDetails = array();
	
	$taxonomyArray = array('taxonomy' => $taxonomy,'parent' => $parent,  'hide_empty' => false );
	if($filter != 'all') {
		$sterm  = get_term_by('name',$filter,'ailment');
		$taxonomyArray['meta_query'] = array (
  			array(
		        'key'           => 'ailment', // custom field
		        'compare'       => 'LIKE',
		        'value'         => $sterm->term_id
			)
		);
	}
	$therapy_terms = new WP_Term_Query($taxonomyArray);
	//echo '<pre>'; print_r($therapy_terms); echo '</pre>';
	
	foreach($therapy_terms->get_terms() as $therapy_term){ 
		$therapyArr = array();
		$term_children = get_terms(array('taxonomy' => $taxonomy,'parent' => 0,  'hide_empty' => false));		
		$therapy_image = wp_get_attachment_image_src(get_field('therapy_image','therapy_'.$therapy_term->term_id), 'thumbnail')[0];
		if(empty($therapy_image)){ $therapy_image = ""; }
		$therapist_args =  array(
			'post_type' => 'therapist',
			'posts_per_page' => -1,
			'tax_query' => array(
				array(
					'taxonomy' => 'therapy',
					'field'    => 'slug',
					'terms'    => $therapy_term->slug,
				),
			),
		);
		$therapists = get_posts($therapist_args);
/*
		// Child Terms for ailment Count
		//$termchildren = get_term_children( $therapy_term->term_id, 'therapy');
		//echo '<pre>';print_r($termchildren);echo'</pre>';	
		foreach($term_children as $x) {
			//$ailment_count_child = 0;
			$term_data = get_term_by('id', $x, 'therapy');
			//echo '<pre>';print_r($k);echo '</pre>';
			$ailments = get_field('ailment',$term_data);
			$ailment_count_child += empty($ailments)?0:count($ailments);
		}			

		$ailments = get_field('ailment',$therapy_term);
		$ailment_count_parent += empty($ailments)?0:count($ailments);
*/

		$get_therapy_child_term = getChildTermByParentTerm($therapy_term->term_id,'therapy');
		
		$all_ailments = getMapAilmentByTherapy($therapy_term->term_id);
		//$ailment_count_parent += empty($all_ailments)?0:count($all_ailments);	
		
		$therapyArr['term_id'] = $therapy_term->term_id;
        $therapyArr['name'] = htmlspecialchars_decode($therapy_term->name);
        $therapyArr['slug'] = $therapy_term->slug;
        $therapyArr['term_group'] = $therapy_term->term_group;
        $therapyArr['term_taxonomy_id'] = $therapy_term->term_taxonomy_id;
        $therapyArr['taxonomy'] = $therapy_term->taxonomy;
        $therapyArr['description'] = substr($therapy_term->description,0,50);
        $therapyArr['parent'] = $therapy_term->parent;
        $therapyArr['count'] = $therapy_term->count;
        $therapyArr['filter'] = $therapy_term->filter;
		$therapyArr['therapy_image'] = $therapy_image;
		$therapyArr['sub_cats'] = $term_children;
		$therapyArr['sub_cats_count'] = count($get_therapy_child_term);
		$therapyArr['therapist'] = $therapists;
		$therapyArr['therapist_count'] = count($therapists);
		$therapyArr['ailment'] = $ailments;
		//$therapyArr['ailment_count'] = $ailment_count_parent+$ailment_count_child;
		$therapyArr['ailment_count'] = count($all_ailments);
		$finalDetails[] = $therapyArr;
	} 
	echo json_encode($finalDetails); wp_die();
}

function getSubTaxonomyDetails(){
	$taxonomy = $_POST['taxonomy'];
	$parent = (int)$_POST['parent'];
	$finalDetails = array();
	
	$taxonomyArray = array('taxonomy' => $taxonomy,'parent' => $parent,  'hide_empty' => false);
	$therapy_terms = get_terms($taxonomyArray);
	
	foreach($therapy_terms as $therapy_term){ 
		$therapyArr = array();
		$term_children = get_terms(array('taxonomy' => $taxonomy,'parent' => $therapy_term->term_id,  'hide_empty' => false));		
		$therapy_image = get_field('therapy_image','therapy_'.$therapy_term->term_id);
		$therapist_args =  array(
		'post_type' => 'therapist',
		'tax_query' => array(
			array(
				'taxonomy' => 'therapy',
				'field'    => 'slug',
				'terms'    => $therapy_term->slug,
			),
			),
		);
		$therapists = get_posts($therapist_args);
		$ailments = get_field('ailment',$therapy_term);
		
		$therapyArr['term_id'] = $therapy_term->term_id;
        $therapyArr['name'] = htmlspecialchars_decode($therapy_term->name);
        $therapyArr['slug'] = $therapy_term->slug;
        $therapyArr['term_group'] = $therapy_term->term_group;
        $therapyArr['term_taxonomy_id'] = $therapy_term->term_taxonomy_id;
        $therapyArr['taxonomy'] = $therapy_term->taxonomy;
        $therapyArr['description'] = $therapy_term->description;
        $therapyArr['parent'] = $therapy_term->parent;
        $therapyArr['count'] = $therapy_term->count;
        $therapyArr['filter'] = $therapy_term->filter;
		$therapyArr['therapy_image'] = $therapy_image;
		$therapyArr['sub_cats'] = $term_children;
		$therapyArr['sub_cats_count'] = count($term_children);
		$therapyArr['therapist'] = $therapists;
		$therapyArr['therapist_count'] = count($therapists);
		$therapyArr['ailment'] = $ailments;
		$therapyArr['ailment_count'] = count($ailments);
		$finalDetails[] = $therapyArr;
		
	} 
	echo json_encode($finalDetails); wp_die();
}

function getTherapyByAilmentTerm()
{
	$term_id = $_POST['parent'];
	$therapies = get_field("therapies", 'ailment_' . $term_id);
	$finalDetails = array();
	
	foreach($therapies as $therapy)
	{ 
		$therapyArr = array();
		$therapy_image = wp_get_attachment_image_src(get_field('therapy_image', $therapy), 'thumbnail')[0];
		if(empty($therapy_image)){ $therapy_image = ""; }
		$therapyArr['name'] = htmlspecialchars_decode($therapy->name);
		$therapyArr['slug'] = $therapy->slug;
		$therapyArr['description'] = wp_trim_words($therapy->description,20,"...");
		$therapyArr['img'] = $therapy_image;
		$finalDetails[] = $therapyArr;
	}
	echo json_encode($finalDetails); wp_die();
}

function getTherapyDetailTherapist()
{
	$therapist = $_POST['therapist'];
	$term_id = $_POST['parent'];
	$get_terms = get_term($term_id);
	$therapist_args =  array(
		'post_type' => $therapist,
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
			'taxonomy' => 'therapy',
			'field'    => 'term_id',
			'terms'    => $term_id,
				),
			),
		);
	$therapists = get_posts($therapist_args);
	$finalDetails = array();
	
	foreach($therapists as $therapist)
	{
		$post_wsp_thumb_id = get_post_thumbnail_id( $therapist->ID ); 
		$post_wsp_image = wp_get_attachment_image_src( $post_wsp_thumb_id ); 
		if(empty($post_wsp_image)){ $post_wsp_image = ""; }
		
		$therapyArr = array();
		$therapyArr['therapist_name'] = htmlspecialchars_decode($therapist->post_title);
		$therapyArr['location'] = getTherapistLocation($therapist->ID);
		$therapyArr['therapist_title'] = $therapist->therapist_title;
		$therapyArr['link'] = get_permalink($therapist->ID);
		//$therapyArr['slug'] = $get_terms->name;
		//$therapyArr['description'] = wp_trim_words($therapist->post_content,7);
		$therapyArr['image_url'] = $post_wsp_image[0];
		$finalDetails[] = $therapyArr;
	}
	//print_r($finalDetails);
	echo json_encode($finalDetails); wp_die();
}

function getTherapyDetailAilment()
{
	$taxonomy = $_POST['taxonomy'];
	$term_id = $_POST['parent'];
	
	$all_ailments = getMapAilmentByTherapy($term_id);
	
	foreach($all_ailments as $ailment)
	{
		$ailment_image = wp_get_attachment_image_src(get_field('ailment_image', $ailment), 'thumbnail')[0];
		if(empty($ailment_image)){ $ailment_image = ""; }
		$link = get_term_link( $ailment->slug, 'ailment' );
		
		$therapyArr = array();
		$therapyArr['ailment_name'] = $ailment->name;
		$therapyArr['link'] = $link;
		$therapyArr['image_url'] = $ailment_image;
		$finalDetails[] = $therapyArr;
	}
	//print_r($finalDetails);
	echo json_encode($finalDetails); wp_die();
}

function getMapAilmentByTherapy($term_id)
{
	$termchildren = get_term_children($term_id, 'therapy');
	//echo "<pre>";print_r($termchildren);echo "</pre>";
	//
	$all_ailments = array();
	foreach($termchildren as $x) 
	{
		$term_data = get_term_by('id', $x, 'therapy');
		//echo "<pre>";print_r($term_data);echo "</pre>";
		$ailments = get_field('ailment',$term_data);
		//echo "<pre>";print_r($ailments);echo "</pre>";
		foreach($ailments as $ailment)
		{
			if(is_numeric($ailment))
			{
				$ailment = get_term_by('id', $ailment, 'ailment');
			}
			if($ailment->term_id)
			{
				array_push($all_ailments,$ailment);
			}		
		}
	}
	//echo "<pre>";print_r($all_ailments);echo "</pre>";
	//Parent therapy data
	$term = get_term_by('id', $term_id, 'therapy');
	$ailments = get_field('ailment',$term);
	//echo "<pre>";print_r($ailments);echo "</pre>";
	
	foreach($ailments as $ailment)
	{
		if(is_numeric($ailment))
		{
			$ailment = get_term_by('id', $ailment, 'ailment');
		}
		array_push($all_ailments,$ailment);
	}
	//Removing duplicate arrray from multi-dimentional array
	$all_ailments = array_map("unserialize", array_unique(array_map("serialize", $all_ailments)));
	
	return $all_ailments;
}

/*
function getTherapistData(){
	$post_type = $_POST['post_type'];
	$taxonomy = $_POST['taxonomy'];
	$filter = explode(',',$_POST['filter']);
	$finalDetails = array();
	
	$therapist_args =  array(
		'post_type' => $post_type,
		'post_status' => 'publish',
		'posts_per_page' => '-1',
		'meta_key' => 'featured_post',
		'orderby' => 'meta_value',
		'order' => 'DESC',
		'tax_query' => true,
	);
	
	if($filter != 'all,all,all') {
		if($filter[0] != 'all') {
			$therapist_args['tax_query'] = array(
	            array(
	                'taxonomy' => 'therapy',
	                'field' => 'name',
	                'terms' => array($filter[0]),
	                'operator' => 'IN',
	            )
	        );
		}
		if($filter[1] != 'all') {
			$therapist_args['tax_query'] = array(
	            array(
	                'taxonomy' => 'location',
	                'field' => 'name',
	                'terms' => array($filter[1]),
	                'operator' => 'IN',
	            )
	        );
		}
		if($filter[2] != 'all') {
			$therapist_args['tax_query'] = array(
	            array(
	                'taxonomy' => 'language',
	                'field' => 'name',
	                'terms' => array($filter[2]),
	                'operator' => 'IN',
	            )
	        );
		}
	}
	$therapists = get_posts($therapist_args);
	
	foreach($therapists as $therapist){ 
		$therapistArr = array();
		$url = get_the_post_thumbnail_url( $therapist->ID, 'thumbnail' );
		//$location = get_field('location_city',$therapist->ID);	//getTherapistLanguage($therapist->ID);
		$therapist_title = get_field('therapist_title',$therapist->ID);
		$location = getTherapistLocation($therapist->ID);
		$therapistArr['ID'] = $therapist->ID;
		$therapistArr['slug'] = $therapist->post_slug;
        $therapistArr['post_author'] = $therapist->post_author;
        $therapistArr['post_date'] = $therapist->post_date;
        $therapistArr['post_date_gmt'] = $therapist->post_date_gmt;
        $therapistArr['post_content'] = substr($therapist->post_content,0,50);
        $therapistArr['post_title'] = $therapist->post_title;
        $therapistArr['post_excerpt'] = $therapist->post_excerpt;
        $therapistArr['post_status'] = $therapist->post_status;
        $therapistArr['comment_status'] = $therapist->comment_status;
        $therapistArr['ping_status'] = $therapist->ping_status;
        $therapistArr['post_password'] = $therapist->post_password;
        $therapistArr['post_name'] = $therapist->post_name;
        $therapistArr['to_ping'] = $therapist->to_ping;
        $therapistArr['pinged'] = $therapist->pinged;
        $therapistArr['post_modified'] = $therapist->post_modified;
        $therapistArr['post_modified_gmt'] = $therapist->post_modified_gmt;
        $therapistArr['post_content_filtered'] = $therapist->post_content_filtered;
        $therapistArr['post_parent'] = $therapist->post_parent;
        $therapistArr['guid'] = $therapist->guid;
        $therapistArr['menu_order'] = $therapist->menu_order;
        $therapistArr['post_type'] = $therapist->post_type;
        $therapistArr['post_mime_type'] = $therapist->post_mime_type; 
        $therapistArr['comment_count'] = $therapist->comment_count;
        $therapistArr['filter'] = $therapist->filter;
        $therapistArr['location'] = $location;
        $therapistArr['therapist_title'] = $therapist_title;
        $therapistArr['image'] = $url;
        $finalDetails[] = $therapistArr;
	} 
	//print_r($therapists);exit;
	echo json_encode($finalDetails); wp_die();
}
*/

function getAilmentsData()
{
	$taxonomy = $_POST['taxonomy'];
	$numposts = $_POST['numposts'];
	$page = $_POST['page'];
	$filter = $_POST['filter'];
	$total = $numposts * $page;
	
	$finalDetails = array();
	
	$ailment_args = array(
	    'taxonomy' => 'ailment', 
	    'hide_empty' => false,
	    'meta_query' => true
	);
	if($filter != 'all') {
		$sterm  = get_term_by('name',$filter,'therapy');
		$ailment_args['meta_query'] = array (
  			array(
		        'key'           => 'therapies', // custom field
		        'compare'       => 'LIKE',
		        'value'         => $sterm->term_id
			)
		);
	}
	$ailment_terms = new WP_Term_Query($ailment_args);
	
	foreach($ailment_terms->get_terms() as $ailment_term){ 
		$ailmentArr = array();	
		$ailment_image = get_field('ailment_image','ailment_'.$ailment_term->term_id);
		$therapies = get_field('therapies',$ailment_term);
		
		$ailmentArr['term_id'] = $ailment_term->term_id;
        $ailmentArr['url'] = get_term_link($ailment_term->term_id);
        $ailmentArr['name'] = $ailment_term->name;
        $ailmentArr['image_url'] = get_field('ailment_image', $ailment_term);
        $ailmentArr['slug'] = $ailment_term->slug;
        $ailmentArr['term_group'] = $ailment_term->term_group;
        $ailmentArr['term_taxonomy_id'] = $ailment_term->term_taxonomy_id;
        $ailmentArr['taxonomy'] = $ailment_term->taxonomy;
        $ailmentArr['description'] = substr($ailment_term->description,0,50);
        $ailmentArr['parent'] = $ailment_term->parent;
        $ailmentArr['count'] = $ailment_term->count;
        $ailmentArr['filter'] = $ailment_term->filter;
		$ailmentArr['ailment_image'] = $ailment_image;
		$ailmentArr['therapies'] = $therapies;
		$finalDetails[] = $ailmentArr;
	} 
	echo json_encode($finalDetails); wp_die();
}

function getSingleTherapistData(){
	$post_id = $_POST['post_id'];
	$finalDetails = array();
	
	$therapist = get_post($post_id);
	$location = get_field('location_city',$post_id);
	$therapy = get_field('therapy',$post_id);
	if($therapy){
		while($therapy){
			$st_arr = array();
			$st_arr['therapy_name'] = the_sub_field('therapy_name');
			$st_arr['experience'] = the_sub_field('experience');
			$st_arr['charges'] = the_sub_field('charges');
		}		
	}
	
	echo $location; print_r($st_arr); wp_die();
}

function getEventsByTherapist(){
	$post_id = $_POST['post_id'];
	$post_type = $_POST['post_type'];
	$finalDetails = array();
	$event_args =  array(
		'post_type' => $post_type,
		'post_status' => 'publish'
	);
	$events = get_posts($event_args);
	foreach($events as $event){
		$therapists = get_field('healer',$event->ID);
		foreach($therapists as $therapist){
			$eventArr = array();
			if($therapist->ID == $post_id){
				$url = get_the_post_thumbnail_url( $therapist->ID, 'thumbnail' );
				$eventArr['ID'] = $event->ID;
				$eventArr['slug'] = $event->post_slug;
		        $eventArr['post_author'] = $event->post_author;
		        $eventArr['post_date'] = $event->post_date;
		        $eventArr['post_date_gmt'] = $event->post_date_gmt;
		        $eventArr['post_content'] = $event->post_content;
		        $eventArr['post_title'] = $event->post_title;
		        $eventArr['post_excerpt'] = $event->post_excerpt;
		        $eventArr['post_status'] = $event->post_status;
		        $eventArr['comment_status'] = $event->comment_status;
		        $eventArr['ping_status'] = $event->ping_status;
		        $eventArr['post_password'] = $event->post_password;
		        $eventArr['post_name'] = $event->post_name;
		        $eventArr['to_ping'] = $event->to_ping;
		        $eventArr['pinged'] = $event->pinged;
		        $eventArr['post_modified'] = $event->post_modified;
		        $eventArr['post_modified_gmt'] = $event->post_modified_gmt;
		        $eventArr['post_content_filtered'] = $event->post_content_filtered;
		        $eventArr['post_parent'] = $event->post_parent;
		        $eventArr['guid'] = $event->guid;
		        $eventArr['menu_order'] = $event->menu_order;
		        $eventArr['post_type'] = $event->post_type;
		        $eventArr['post_mime_type'] = $event->post_mime_type; 
		        $eventArr['comment_count'] = $event->comment_count;
		        $eventArr['filter'] = $event->filter;
		        $eventArr['image'] = $url;
				$finalDetails[] = $eventArr;
			}
		}
	}
	echo json_encode($finalDetails); 
	wp_die();
}

/**
 * Created option page in ACF.
 *
 * This function created option page in ACF.
 *
 * @since 0.0.1
 */
if (function_exists('acf_add_options_page')) {
    $option_page = acf_add_options_page(array(
        'page_title' => 'Options',
        'menu_title' => 'Options',
        'menu_slug' => 'options-settings',
        'capability' => 'edit_posts',
        'redirect' => false
    ));
}


function calculateProgress($complete, $total){
	$totalProgress = (100*$complete)/$total;
	return $totalProgress;
}

function getEventCountById($user_id){
	$myEvents = array();
	$thriiveEvents = array();
	$event_args =  array(
		'post_type' => 'event',
		'post_status' => 'publish'
	);
	$events = get_posts($event_args);
	foreach($events as $event){
		$therapists = get_field('healer',$event->ID);
		foreach($therapists as $therapist){
			if($therapist->ID == $user_id){
				if($event->thriive_event==true){
					$thriiveEvents[] = $event;					
				} else {
					$myEvents[] = $event;
				}
			}
		}
	}
	return count($thriiveEvents);
}

function getEventById($user_id,$isThriive){
	$myEvents = array();
	$thriiveEvents = array();
	$event_args =  array(
		'post_type' => 'event',
		'post_status' => 'publish'
	);
	$events = get_posts($event_args);
	foreach($events as $event){
		$therapists = get_field('healer',$event->ID);
		foreach($therapists as $therapist){
			if($therapist->ID == $user_id){
				if($event->thriive_event==true){
					$thriiveEvents[] = $event;					
				} else {
					$myEvents[] = $event;
				}

			}
		}
	}
	
	if($isThriive){
		return $thriiveEvents;
	} else {
		return $myEvents;
	}
}

function getEventMonths(){
    $calender_events_args = array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'meta_key' => 'start_date_',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => true,
        'tax_query' => true,
    );
	$calender_events_args['meta_query'] = array(
	        array(
	            'key' => 'start_date_',
				'value' => date('Ymd'),
				'type' => 'DATE',
				'compare' => '>=',
	        ),
	);
	$all_upcoming_events = get_posts($calender_events_args);
    $currentMonth = date('M Y');
    $event_start_date = array();
    $i=0;
	foreach ($all_upcoming_events as $key=>$event){
        $get_date = date("M Y", strtotime(get_field("start_date_",$event->ID)));        
        //Ignoring past event date
        if(strtotime($get_date) >= strtotime($currentMonth))
        {
            $event_start_date[$i] = $get_date;			                    
            $i++;
        }       
	}
    //Removing dublicate date
  	$event_start_date = array_unique($event_start_date);
    //Sorting date in ascending order
    function sortFunction( $a, $b ) 
    {
	    return strtotime($a) - strtotime($b);
	}
	usort($event_start_date, "sortFunction");	
	
	return $event_start_date;
}

function filterEvents() {
    $event_date = $_POST['event_date'];
    $event_location = $_POST['event_location'];
    $event_data = false;
    
    $calender_events_args = array(
        'post_type' => 'event',
        'post_status' => 'publish',
        'posts_per_page' => '-1',
        'meta_key' => 'start_date_',
        'orderby' => 'meta_value_num',
        'order' => 'ASC',
        'meta_query' => true,
        'tax_query' => true,
    );
	
	if ($event_date == 'all') {
		$calender_events_args['meta_query'] = array(
	        array(
	            'key' => 'start_date_',
				'value' => date('Ymd'),
				'type' => 'DATE',
				'compare' => '>=',
	        ),
	    );
	} else if(date('m',strtotime($event_date)) == date('m')){
		$calender_events_args['meta_query'] = array(
	        array(
	            'key' => 'start_date_',
				'value' => array(date('Ymd'), date('Ymt',strtotime('today'))),
				'type' => 'DATE',
				'compare' => 'BETWEEN',
	        ),
	    );
	} else {
		$calender_events_args['meta_query'] = array(
	        array(
	            'key' => 'start_date_',
				'value' => array(date('Ym01',strtotime($event_date)), date('Ymt',strtotime($event_date))),
				'type' => 'DATE',
				'compare' => 'BETWEEN',
	        ),
	    );
	}

    if ($event_location != 'all') {
        $calender_events_args['tax_query'] = array(
            array(
                'taxonomy' => 'location',
                'field' => 'slug',
                'terms' => $event_location,
            ),
        );
    }
    
    $calender_events = new WP_Query($calender_events_args);
    //echo $calender_events->request;
	if($calender_events->have_posts()) {
    while ($calender_events->have_posts()) : $calender_events->the_post();
    	get_template_part('template-parts/calender-events');
    endwhile;
    } else {
	    echo 'No Events Found';
    }
    wp_die();
}

function events_google_map_api( $api )
{	
/*
	if(site_url() == 'https://thriive-staging.noesis.tech') {
		$api['key'] = 'AIzaSyAPbylqDnXbqeDKemCI7BOn3wvljG71SE4';
	} else {
		$api['key'] = 'AIzaSyDth79ayfk2Jo-3nzJh_6uirnb4PwQwmAc';
	}
*/	
	$api['key'] = 'AIzaSyAPbylqDnXbqeDKemCI7BOn3wvljG71SE4';	
	return $api;	
}

function google_map_api_key() 
{	
/*
	if(site_url() == 'https://thriive-staging.noesis.tech') {
		acf_update_setting('google_api_key', 'AIzaSyAPbylqDnXbqeDKemCI7BOn3wvljG71SE4');
	} else {
		acf_update_setting('google_api_key', 'AIzaSyDth79ayfk2Jo-3nzJh_6uirnb4PwQwmAc');
	}
*/
		
	acf_update_setting('google_api_key', 'AIzaSyAPbylqDnXbqeDKemCI7BOn3wvljG71SE4');
}

function getSimilarEvents(){
	$post_id = $_POST['event_post_id'];
	$event_terms = get_the_terms($post_id, 'therapy');
	$event_term = $event_terms[0]->term_id;
	$event_args = array(
		'post_type' => 'event',
		'post__not_in' => array($post_id),
		'tax_query' => array(
			array(
	    		'taxonomy' => 'therapy',
				'field'    => 'term_id',
				'terms'    => $event_term,
			)
		),
	);
	$related_events = new WP_Query( $event_args );

	$finalDetails = array();
	if($related_events->have_posts()):
		
		while ($related_events->have_posts()) : $related_events->the_post();
			$customArr = array();
			
			$start_time = get_field('start_time');
			$end_time = get_field('end_time');
			$event_location = get_the_terms( $post->ID,  'event-location' );
			$customArr['event_title'] = get_the_title();
			$customArr['event_facilitator'] = get_field('facilitator');
			$customArr['start_date'] = date(' dS M | l', strtotime(get_field('start_date_')));
			$customArr['event_date'] = (!empty($end_time) ? $start_time . ' - ' . $end_time : $start_time . ' Onwards' );
			$customArr['event_venue'] = $event_location[0]->name;
			$customArr['post_link'] = get_permalink($related_events->ID);
			$finalDetails[] = $customArr;
		endwhile;
		
	endif;
	
	echo json_encode($finalDetails); 
	wp_die();
}
add_role(
    'therapist',
    __( 'Therapist' ),
    array(
        'read'         				=> true,
        'edit_posts'   				=> true,
        //'delete_posts' 				=> true,
        //'publish_posts'				=> true,
        //'delete_published_posts' 	=> true,
        //'edit_published_posts'		=> true,
    )
);

add_role(
    'pending_delete',
    __( 'Pending Delete' ),
    array(
        'read'         				=> false,
        'edit_posts'   				=> false,
        //'delete_posts' 				=> true,
        //'publish_posts'				=> true,
        //'delete_published_posts' 	=> true,
        //'edit_published_posts'		=> true,
    )
);

function getPostViews($postID){
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if($count==''){
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    }else{
        $count = $count+50;
        update_post_meta($postID, $count_key, $count);
    }
}

function custom_wpseo_breadcrumb_output( $links ){
	if( is_singular('post') ){
		$links[0]['text']='Blog';
		$links[0]['url']=home_url( '/blog/' );
	}
return $links;
}

function get_post_primary_category($post_id, $term='category', $return_all_categories=false){
    $return = array();

    if (class_exists('WPSEO_Primary_Term')){
        // Show Primary category by Yoast if it is enabled & set
        $wpseo_primary_term = new WPSEO_Primary_Term( $term, $post_id );
        $primary_term = get_term($wpseo_primary_term->get_primary_term());

        if (!is_wp_error($primary_term)){
            $return['primary_category'] = $primary_term;
        }
    }

    if (empty($return['primary_category']) || $return_all_categories){
        $categories_list = get_the_terms($post_id, $term);

        if (empty($return['primary_category']) && !empty($categories_list)){
            $return['primary_category'] = $categories_list[0];  //get the first category
        }
        if ($return_all_categories){
            $return['all_categories'] = array();

            if (!empty($categories_list)){
                foreach($categories_list as &$category){
                    $return['all_categories'][] = $category->term_id;
                }
            }
        }
    }

    return $return;
}

function createEvent($input)
{
/*
	if(isset($input['event_title']) && isset($input['facilitator_name']) 
	&& isset($input['start_date']) && isset($input['end_date']) && isset($input['start_time']) && isset($input['end_time'])
	 && isset($input['pac-input']) && isset($input['country']) && isset($input['state']) && isset($input['city']) && isset($input['event_description']))
*/
	if(isset($input['start_date']) && isset($input['start_time']) && isset($input['event_description']) && isset($input['event_title']))
	 {
  		if(is_user_logged_in())
  		{
	  	    $current_user = wp_get_current_user();
		    $user_id = $current_user->ID;
		    $post_id = $current_user->post_id;
		    $username = $current_user->first_name . ' ' . $current_user->last_name;
			$useremail = $current_user->user_email;
		    
	    	$event_banner_img_url = $input['event_banner_img_url'];
	    	$post_title = $input['event_title'];
	    	$facilitator_name = $input['facilitator_name'];
	    	$start_date = $input['start_date'];
			$end_date = $input['end_date'];
			$start_time = $input['start_time'];
			$end_time = $input['end_time'];
			
	    	$venue_address = $input['location_details'];
	    	$clean_address = json_decode(stripslashes($venue_address));
	    	$event_description = $input['event_description'];
	    	
			$price = $input['price'];
			$facebook_url = $input['facebook_url'];
			$instagram_url = $input['instagram_url'];
			$website_url = $input['website_url'];
			$therapy = $input['therapy'];
	    	$book_now_link = $input['book_now_link'];
			$about_the_facilitator = $input['about_the_facilitator'];
			$about_the_organisation = $input['about_the_organisation'];
			$contact_information = $input['contact_information'];
			$thriive_event = $input['thriive-event'];
			$therapy = $input['therapy'];
			$gallery_video = $input['gallery_video'];
	    
		    $url = array(
					array(
						'social' => $facebook_url
					),
					array(
						'social' => $instagram_url
					),
					array(
						'social' => $website_url
					),
			);		    
		    
		    global $event_msg;
		    //If it is thriive event
		    if($thriive_event)
		    {
			    $post_status = 'draft';
			    $event_msg = "Your request for create an event has been sent to admin.";

			    //Sending mail to User
			    $msg="Dear $username,<br><br>
					Hello! It’s always great to hear from our network of lightworkers. We, at Thriive, really believe in you and your amazing contribution to the universe. Your light is the beacon of hope this world needs to keep believing—so, shine away!<br><br>
					The request to upload your event has been received. Your account manager is just reviewing the details, and if it meets all required guidelines, the event will be posted shortly. You will receive an email once your event has been posted.<br><br>
					Love & Light<br>
					Team Thriive<br><br>
					<em style='color: #615c5c;'>
						Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
					<em>";
			    sendEmail($useremail, "Get ready to shine! Your event is being worked on!", $msg);

			    //Sending mail to Account manager
			    $msg="Dear Account Manager,<br><br>
					$username has sent you a request to promote an event. Here are the details:<br>
					Event: $post_title<br>
					Date: $start_date <br><br>
					Please ensure that the $username is within their 15 day time limit. The 15 days is calculated from the day they need the posting to be uploaded and not the day of the event. If the deadline has passed, please reject the event post. Ensure that the content is within the guidelines of word count and image quality. Once you are sure that all protocols have been met, please pass the request onto the Promotions Manager. Please do the needful within 1 working day.";
			    sendEmail("accountmanager1@thriive.in", "$username has requested an event promotion", $msg);

			    //Sending mail to Promotional Team
			    $msg="Dear Promotions Team,<br><br>
					The Account Manager has sent you a request to promote an event of $username for the event happening on $start_date. Please log in to your admin panel and schedule Emailer, Social Media post, SMS and listing on the website.";
			    sendEmail("promotions@thriive.in", "Please promote this event by $username", $msg);
		    }
		    else	//If it is not thriive event
		    {
			    $post_status = 'publish';
			    $event_msg = "Event has been created successfully";
		    }
		    $new_post = array(
			    //'ID' => 1956,
				'post_title'    => $post_title,
				'post_content'  => $event_description,
				'post_status'   => $post_status,          
				'post_type'     => 'event' 
			);
			
			$new_post_id = wp_insert_post($new_post);
			
			includeFiles();
			$event_banner_img = media_handle_upload( 'event_banner_img', $new_post_id );
			$event_featured_img = media_handle_upload( 'event_featured_img', $new_post_id );
			set_post_thumbnail( $new_post_id, $event_featured_img );
			update_field('banner_banner_image',$event_banner_img,$new_post_id);
			update_field('banner_image_url',$event_banner_img_url,$new_post_id);
			update_field('therapist',$post_id,$new_post_id);
			update_field('start_date_',date('Ymd', strtotime($start_date)),$new_post_id);
			update_field('end__date',date('Ymd', strtotime($end_date)),$new_post_id);
			update_field('start_time',$start_time,$new_post_id);
			update_field('end_time',$end_time,$new_post_id);
			update_field('venue',(array) $clean_address,$new_post_id);
			update_field('facilitator',$facilitator_name,$new_post_id);
			update_field('price',$price,$new_post_id);
			update_field('url',$url,$new_post_id);
			update_field('book_now_link',$book_now_link,$new_post_id);
			update_field('about_facilitator',$about_the_facilitator,$new_post_id);
			update_field('about_organisation',$about_the_organisation,$new_post_id);
			update_field('about_the_organisation',$about_the_organisation,$new_post_id);
			update_field('contact_information',$contact_information,$new_post_id);
			if($thriive_event)
		    {
			    update_field('thriive_event',$thriive_event,$new_post_id);
		    }
			update_field('therapy',$therapy,$new_post_id);
			//update_field('gallery_video',$gallery_video,$new_post_id);
			$FAQs_img = media_handle_upload( 'FAQs_img', $new_post_id );
			update_field('faqs',$FAQs_img,$new_post_id);
			$terms_conditions = media_handle_upload( 'terms_conditions', $new_post_id );
			update_field('terms_&_conditions',$terms_conditions,$new_post_id);
			
			$post_id = array($post_id);
			update_field('healer',$post_id,$new_post_id);
			
			saveLocationTaxonomy($input['country'], $input['state'], $input['city'], $new_post_id); // Create Taxonomy for Country, State, City
			
			
			//get multiple file and its uploaded id
			$files = $_FILES['gallery_img'];
			$all_gallery_img = array();
			foreach ($files['name'] as $key => $value) 
			{            
            	if ($files['name'][$key]) 
            	{ 
	                $file = array( 
	                    'name' => $files['name'][$key],
	                    'type' => $files['type'][$key], 
	                    'tmp_name' => $files['tmp_name'][$key], 
	                    'error' => $files['error'][$key],
	                    'size' => $files['size'][$key]
	                );
	                
	                $_FILES = array ("gallery_img" => $file); 
	                foreach ($_FILES as $file => $array) 
	                {
		                $gallery_img = array();       
	                    $gallery_img_id = media_handle_upload($file,$new_post_id); 
	                    $gallery_img['gallery_images'] = $gallery_img_id;
	                    $all_gallery_img[] = $gallery_img;
	                }
            	} 
        	}
        	update_field('event_gallery',$all_gallery_img,$new_post_id);
			
			//Updating video			
			$gallery_videos = array(
					array(
						'gallery_videos' => $gallery_video
					),
			);
			update_field('event_video',$gallery_videos,$new_post_id);

			//storing events id in user's meta
			$my_events = $current_user->my_events;
			if($my_events)
			{
				$my_events = explode(",",str_replace('"', "", $my_events));
				if(!in_array($new_post_id,$my_events))
				{
					array_push($my_events,$new_post_id);
				}
				$my_events = implode(",", $my_events);
			}
			else
			{
				$my_events = $new_post_id;
			}
			update_user_meta($user_id, 'my_events', $my_events);
			
			wp_redirect(get_permalink(1909));
			exit;
		} 
	} 
}

function thriive_get_related_content( $post_id, $related_count,$type = 'post',$taxonomy='category', $args = array() ) {
	$terms = get_the_terms( $post_id, $taxonomy);
	
	if ( empty( $terms ) ) $terms = array();
	
	$term_list = wp_list_pluck( $terms, 'slug' );
	
	$related_args = array(
		'post_type' => $type,
		'posts_per_page' => $related_count,
		'post_status' => 'publish',
		'post__not_in' => array( $post_id ),
		'orderby' => 'date',
		'order' => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => $taxonomy,
				'field' => 'slug',
				'terms' => $term_list
			)
		)
	);

	return new WP_Query( $related_args );
}

function generateBitlyURL($url){
	require_once('bitly.php');
	$client_id = 'c4e1f9e77ec04b1d8ded179e0e975897919d7c3c';
	$client_secret = '73222991269081e99b9e35b47099e5449b7163dc';
	$user_access_token = 'c0c281d705ef60a2480cfcdfd6c5380e874d2337';
	$user_login = 'productmanager@thriive.in';
	$user_api_key = 'a7421798b27ef34f88150c8b1be35f416c3aaa4b';  
	$params = array();
	$params['access_token'] = $user_access_token;
	$params['longUrl'] = $url;
	$params['domain'] = 'bit.ly';
	$results = bitly_get('shorten', $params);
	return $results;
}

function renewPackage()
{
	$current_user = wp_get_current_user();
	$post_id = $current_user->post_id;
	$users_id = $current_user->ID;	
	$username = $current_user->first_name . ' ' . $current_user->last_name;
	$useremail = $current_user->user_email;
	$mobileNo = $current_user->mobile;
	
	
	//Get Package detail
	$get_package = get_field("select_package",$post_id);
    $packageCharges = get_field("package_charges",$get_package[0]->ID);
    $packageName = $get_package[0]->post_title;

	//Generating payment link
    $codeD = $useremail.$users_id . time();  
    $code = sha1( $codeD );
    $url = add_query_arg( array('package' => "renew", 'token' => $code, 'token_id' => $users_id,'token_for' => $useremail ), get_permalink( 274 ));
    $payment_link = generateBitlyURL($url)['data']['url'];
	if(empty($payment_link)){
		$payment_link_email = $url;
	} else {
		$payment_link_email = $payment_link;
	}
	if($packageCharges > 0)
    {
		$subject = "Renew your Thriive package";
	    $msg = "Dear $username,<br><br>
			Please follow the link below to complete the renewal process.<br><br>
			$url <br><br>
			If you have any queries or concerns please contact <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
			As soon as we receive the complete renewal payment and agreement from you, you will be all good to go!<br><br>
			We look forward to you as a shining star in our worldwide web of light!<br><br>
			Love & light,<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>";
		update_user_meta($users_id, 'payment_token',  $code);
		update_user_meta($users_id, 'isRenew',1);
		
		//Sendint Email to Therapist
		sendEmail($useremail,$subject,$msg);	
		
		//Sending Email to Account manager
		$msg = "Dear Account Manager,<br><br>
			$username has just sent a request for package renew .<br><br> 				
			Love & light,<br>
			Team Thriive
			";
		sendEmail('accountmanager1@thriive.in', "Renew Thriive package", $msg);

		echo "Renewal link has been sent to your email id.";
    }
    exit;
}


function upgradePackage()
{
	$UpgragePackageId = $_POST['UpgragePackageId'];
	
	$current_user = wp_get_current_user();
	$post_id = $current_user->post_id;
	$users_id = $current_user->ID;	
	$username = $current_user->first_name . ' ' . $current_user->last_name;
	$useremail = $current_user->user_email;
	$mobileNo = $current_user->mobile;
	
	//Get Package detail
	$get_package = get_field("select_package",$post_id);
    $packageCharges = get_field("package_charges",$UpgragePackageId);
    $packageName = $get_package[0]->post_title;
	update_post_meta($post_id, 'old_package', $packageName);

	//Generating payment link
    $codeD = $useremail.$users_id . time();  
    $code = sha1( $codeD );
    $url = add_query_arg( array('upgrade-package' => $UpgragePackageId, 'token' => $code, 'token_id' => $users_id,'token_for' => $useremail ), get_permalink( 406 ));
    $payment_link = generateBitlyURL($url)['data']['url'];
	if(empty($payment_link)){
		$payment_link_email = $url;
	} else {
		$payment_link_email = $payment_link;
	}
	
	$subject = "Upgrade your Thriive package";
	if($packageCharges > 0)
    {
	    $msg = "Dear $username,<br><br>
			Please follow the link below to complete the upgrade process.<br><br>
			$url <br><br>
			If you have any queries or concerns please contact <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
			As soon as we receive the complete upgrade payment and agreement from you, you will be all good to go!<br><br>
			We look forward to you as a shining star in our worldwide web of light!<br><br>
			Love & light,<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>";
		sendSMS($mobileNo, "Dear $username, you are just a step away from upgrading your Thriive Art & Soul package. Don’t delay. Pay now. The link is $payment_link_email");
		
    }
    else
    {
	    $msg = "Dear $username,<br><br>
			Please follow the link below to complete the upgrade process.<br><br>
			$url <br><br>
			If you have any queries or concerns please contact <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
			We look forward to you as a shining star in our worldwide web of light!<br><br>
			Love & light,<br>
			Team Thriive<br><br>
			<em style='color: #615c5c;'>
				Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
			<em>";
		sendSMS($mobileNo, "Dear $username, accept your agreement now and upgrade your Thriive Art & Soul package. The link is $payment_link_email");
    }
    update_user_meta($post_users_id, 'payment_token',  $code);
    $smsMsg = "Dear $username, package upgrade link is $payment_link_email . If you need any further help, call 7045933385 or email to accountmanager1@thriive.in";
    
    //Sending SMS & Email to Therapist
    //sendSMS($mobileNo, $smsMsg);
	sendEmail($useremail,$subject,$msg);
	
	//Sending Email to Account manager
	$msg = "Dear Account Manager,<br><br>
		$username has just sent a request for upgrade the package.<br><br> 				
		Love & light,<br>
		Team Thriive
		";
	sendEmail('accountmanager1@thriive.in', "Upgrade Thriive package", $msg);
	
	echo "Upgrade link has been sent to your email id.";
    exit;
}

function change_post_published( $new_status, $old_status, $post ) 
{
	//When post type is 'therapist'
    if($post->post_type == 'therapist')
	{
		//echo "Status" . $new_status;
		//Get the user of current post by post_id
		$post_users = get_users(array('meta_key' => 'post_id','meta_value' => $post->ID));
		foreach($post_users as $post_user)
		{
			$post_users_id = $post_user->ID;
			$post_users_email = $post_user->user_email;
		}
		//Get user's detail by its id
		$post_usersdata = get_userdata($post_users_id);		
		$username = $post_usersdata->first_name . ' ' . $post_usersdata->last_name;
		$useremail = $post_usersdata->user_email;
		$mobileNo = $post_usersdata->mobile;
				
	    $get_package = get_field("select_package",$post->ID);
	    $packageCharges = get_field("package_charges",$get_package[0]->ID);
	    $packageName = $get_package[0]->post_title;
	    
		
		//when post status changed from 'pending review' to 'pending payment'.
		if($old_status == 'pending' && $new_status == 'pending-payments') 
    	{		    
		    //Generating payment link
		    $codeD = $post_users_email.$post_users_id . time();  
		    $code = sha1( $codeD );
		    $url = add_query_arg( array('token' => $code, 'token_id' => $post_users_id,'token_for' => $post_users_email ), get_permalink( 274 ));
			$payment_link = generateBitlyURL($url)['data']['url'];
		    if(empty($payment_link)){
				$payment_link_email = $url;
			} else {
				$payment_link_email = $payment_link;
			}
		    if($packageCharges > 0)
		    {
				$subject = "And you’re in! Thriive tribe welcomes you! Don’t delay! Pay now!";
			    $msg = "Dear $username,<br><br>
					You are just steps away from beginning your exciting journey as part of our Thriive Tribe. We can’t wait to get you started. Please follow the link below to complete the payment process.<br><br>
					$url <br><br>
					If you have any queries or concerns please contact <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
					As soon as we receive the complete payment and agreement from you, you will be all good to go!<br><br>
					We look forward to adding you as a shining star in our worldwide web of light!<br><br>
					Love & light,<br>
					Team Thriive<br><br>
					<em style='color: #615c5c;'>
						Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
					<em>";
				$smsMsg = "Dear $username, you are just a step away from completing your Thriive Art & Soul registration process. The payment link is $payment_link_email.";
		    }
		    else
		    {
				$subject = "And you’re in! Thriive tribe welcomes you!";
				$package_page_link = get_permalink(414);
			    $msg = "Dear $username,<br><br>
					Congratulations and welcome to our ever growing network of Wellness Service Providers! Thriive Art & Soul is proud to claim you as part of its tribe!<br><br>
					$url <br><br>
					As soon as you accept the agreement, you will be all good to go!<br><br>
					If you have any queries or concerns, please contact <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
					There are many benefits to upgrading to a higher package...check them <a href='$package_page_link'>here</a>.<br><br>
					We look forward to adding you as a shining star in our worldwide web of light!<br><br>
					Love & light,<br>
					Team Thriive<br><br>
					<em style='color: #615c5c;'>
						Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
					<em>";
				$smsMsg = "Dear $username, accept your agreement now and complete your Thriive Art & Soul registration process: Here's the link: $payment_link_email. If you need help, get in touch with us on 7045933385.";
		    }
/*
		    if($get_package[0]->ID == '129'){
			    $aggrementLink = get_permalink(414);
			    $smsMsg = "Dear $username, accept your agreement now and complete your Thriive Art & Soul registration process: Here's the link: $aggrementLink. If you need help, get in touch with us on 7045933385.";
		    } else {
			    $smsMsg = "Dear $username, you are just a step away from completing your Thriive Art & Soul registration process. The payment link is $payment_link_email.";
		    }
*/
		    
		    update_user_meta($post_users_id, 'stage',  5);
			update_user_meta($post_users_id, 'completed_stages',  array('1','1','1','1')); 
			update_user_meta($post_users_id, 'payment_token',  $code);
		    sendEmail($useremail,$subject,$msg);
		    sendSMS($mobileNo, $smsMsg);
	    }  
	    else if($old_status == 'pending-payments' && $new_status == 'publish') 
    	{
			//when post status changed from 'pending payment' to 'pending publish'.
	    	$dashboard = get_permalink(339);
	    	if($packageCharges > 0)
		    {
				$subject = "Payment Received with Gratitude. You’re now officially ready to shine and Thriive!";
			    $msg = "Dear $username,<br><br>
				    Your payment of Rs. $packageCharges for $packageName package has been received.
					Thriive officially welcomes you to our Tribe! It’s time to give yourself a pat on the back! You are now a part of an elite group of lightworkers who’ve done some amazing work in our Universe. It’s time to show the world 					your light! You are now ready to shine and Thriive!<br><br>
					You can set up your profile page and customize it using this link: <a href='$dashboard'>Dashboard</a><br><br>
					Once your profile page is up and running, doing these 4 things will help spread your reach further:<br>
					<ol type='number'>
						<li>Keep updating your profile page with latest pictures and information.</li>
						<li>Display positive reviews from clients on your page.</li>
						<li>Conduct workshops that relate to your modalities (We can help you with a venue. Call us now to know more).</li>
						<li>Encourage your family and friends to share the link to your Thriive Profile Page with their own networks.</li>
					</ol>
					If you need any further help, call <a href='tel:7045933385'>7045933385</a> / send email to <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
					Love & light,<br>
					Team Thriive<br><br>
					<em style='color: #615c5c;'>
						Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
					<em>";
					
				sendEmailWithInvoice($useremail,$subject,$msg, $post_users_id, 'subscribe');
				//sendEmail($useremail,$subject,$msg);
					
				//Send email to admin
				$current_date = date("d/m/Y");
				$msg = "Dear Account Manager,<br><br>
				    Payment of Rs. $packageCharges has been received from $username on $current_date for $packageName package.</a><br><br>
					Love & light,<br>
					Team Thriive";
				sendEmail("accountmanager1@thriive.in", "Money is here!", $msg);
				
				//Send email to Finance team
				$current_date = date("d/m/Y");
				$msg = "Dear Accounts Team,<br><br>
				    Payment of Rs. $packageCharges has been received from $username on $current_date for $packageName package. Please prepare the invoice and forward it to the $username.</a><br><br>
					Love & light,<br>
					Team Thriive";
				sendEmailWithInvoice("finance@thriive.in", "Prepare invoice for $username", $msg, $post_users_id, 'subscribe');
				//sendEmail("finance@thriive.in", "Prepare invoice for $username", $msg);
		    }
		    else
		    {
				$subject = "You’re now officially ready to shine and Thriive!";				
			    $msg = "Dear $username,<br><br>
					Thriive officially welcomes you to our Tribe! It’s time to give yourself a pat on the back! You are now a part of an elite group of lightworkers who’ve done some amazing work in our Universe. It’s time to show the world 					your light! You are now ready to shine and Thriive!<br><br>
					You can set up your profile page and customize it using this link: <a href='$dashboard'>Dashboard</a><br><br>
					Once your profile page is up and running, doing these 4 things will help you to spread your reach further:<br>
					<ol type='number'>
						<li>Keep updating your profile page with latest pictures and information.</li>
						<li>Display positive reviews from clients on your page.</li>
						<li>Conduct workshops that relate to your modalities (We can help you with a venue. Call us now to know more).</li>
						<li>Encourage your family and friends to share the link to your Thriive Profile Page with their own networks.</li>
					</ol>
					If you need any further help, call <a href='tel:7045933385'>7045933385</a> / send email to <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
					Love & light,<br>
					Team Thriive<br><br>
					<em style='color: #615c5c;'>
						Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
					<em>";
				sendEmail($useremail,$subject,$msg);				
		    }
			
		    //Send therapist msg with payment link after checking package plan
	    }
	    else if($new_status == 'rejected')
	    {
		    $msg = "We regret to inform you that at this point in time your application to be a registered Therapist with Thriive Art & Soul does not comply with our verification requirements . We wish you great luck on your healing journey.  You will be eligible to reapply next year. We hope to see you then!<br><br>
				Love & light,<br>
				Team Thriive<br><br>
				<em style='color: #615c5c;'>
					Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
				<em>";
			sendEmail($useremail,"Sorry!",$msg);
	    }
	}
	else if($post->post_type == 'event')
	{
		//Getting user by event's id
		$getUser = get_users( array(
	        'meta_query' => array(
	            array(
	                'key'     => 'my_events',
	                'value'   => $post->ID,
	                'compare' => 'LIKE',
	            )
	        ),
	    ));
	    $username = $getUser[0]->first_name . ' ' . $getUser[0]->last_name;
	    $useremail = $getUser[0]->user_email;
		
		if($old_status == 'draft' && $new_status == 'publish') 
    	{
	    	$event_link = get_permalink($post->ID);
	    	$msg = "Dear $username,<br><br>
				Your event is successfully published on Thriive website. Here is the link of your event:<br><br>
				$event_link <br><br>
				Thriive hopes you have a super successful event! And don’t forget to get good pictures, and post them on your profile page. We look forward to hearing how it went. Good luck!<br><br>
				If there’s anything more that we can help you with please email us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
				Love & light,<br>
				Team Thriive<br><br>
				<em style='color: #615c5c;'>
					Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
				<em>";
	    	sendEmail($useremail, "Here’s the link for your event!", $msg);
	    }
	}
}

//Aucomplete Search
function ajax_search() 
{
	// //Searching in post
	// $results = new WP_Query( array(
	// 	'post_type'     => array( 'post', 'therapist' ), 	//post name
	// 	'post_status'   => 'publish',
	// 	'posts_per_page'=> 10,
	// 	's'             =>  $_POST['search'],
	//     'orderby' => 'name',
	//     'order' => 'ASC'
	// ));
	// //print_r($results);exit;
	// $items = array();
	// if ( !empty( $results->posts ) ) 
	// {
	// 	foreach ( $results->posts as $result ) 
	// 	{
	// 		$items[] = $result->post_title;
	// 	}
	// }

	// //Searching in taxonomy
	// $args = array(
	//     'taxonomy'      => array( 'ailment', 'therapy','location' ,'language' ), // taxonomy name
	//     'orderby'       => 'name',
	//     'order'         => 'ASC',
	//     'hide_empty'    => false,
	// 	'hierarchical'=>false,
	// 	'childless'=>true,
	//     'name__like'    => stripslashes( $_POST['search'] )
	// ); 
	// $results = get_terms( $args );
	// if( !empty( $results ) )
	// {
	// 	foreach ( $results as $result ) 
	// 	{
	// 		$items[] = $result->name;
	// 	}
	// }
	// $items = array_unique($items);	//Removing duplicate data
	// sort($items);	//Sorting in ascending order
	// $items = array_slice($items, 0, 10, true); 	//take top 10 records
	// //print_r($items);exit;
	// wp_send_json_success( $items );

	global $wpdb;
	$search_text = $_POST['search'];
	$sql_query = "
		SELECT t.name as title FROM wp_terms
		AS t INNER JOIN wp_term_taxonomy
		AS tt ON
		t.term_id = tt.term_id
		WHERE tt.taxonomy IN ('ailment','therapy','language','location') and t.name Like '$search_text%'
		UNION
		SELECT post_title as title FROM `wp_posts` WHERE `post_title` LIKE '$search_text%' and post_type = 'therapist' and post_status = 'publish' 
		order by title
		limit 10
	";
	//print_r($sql_query);exit;
	$results = $wpdb->get_results($sql_query);
	//print_r($results);exit;
	$items = array();
	if( !empty( $results ) )
	{
		foreach ( $results as $result ) 
		{
			$items[] = $result->title;
		}
	}
	wp_send_json_success( $items );exit;
}
function thriive_get_search_query($content_type='post',$entity_type='post',$query,$num_results=2,$page=0){
	$search_query = null;
	switch ($content_type):

		case 'taxonomy':
				$tax_args = array(
				    'taxonomy' => $entity_type,
				    'orderby' => 'name', 
					'order' => 'ASC',
					'number' => $num_results,
					'offset' => ($num_results * $page),
					'name__like'    => $query,
					'description__like'=>$query,
					'hide_empty'=>false,
					'hierarchical'=>false,
					'childless'=>true
					);
				$search_query = new WP_Term_Query( $tax_args );
				break;

		case 'post':
		default:
				$post_args = array(
					's'=>$query,
					'post_type'=>$entity_type,
					'posts_per_page'=>$num_results,
					'paged'=>$page,
				);
				$search_query = new WP_Query($post_args);
				break;
	endswitch;
	return $search_query;
}

function modify_query( $query ) {
//     if ( !is_admin() && $query->is_post_type_archive('therapist') && $query->is_main_query()) {
// 	    $query->set( 'posts_per_page', 4 );
// 		$query->set('meta_key', 'featured_post');
// 		//echo '<pre>';print_r();echo '</pre>';
// /*
// 		$query->set('orderby', 'meta_value');
// 		$query->set('order', 'DESC');
// */	
// 	    $query->set('orderby', array( 'meta_value' => 'DESC', 'post_title' => 'ASC' ));
// 	 //    $query->set( 'meta_query', array(
// 	 //        array(
// 	 //              'key' => 'area',
// 	 //              'value' => $_SESSION['user_area'],
// 	 //              'compare' => '='
// 	 //        )
// 		// ));

// 	    //$getAllNearBy = "SELECT *, (6371 * acos (cos ( radians($user_lat) ) * cos( radians( lat ) ) * cos( radians( lng ) -radians($user_lng) ) + sin ( radians($user_lat) ) * sin( radians( lat ) ) ) ) AS distance FROM `zipcode_area` HAVING distance < 50 ORDER BY distance LIMIT 0 , 50";
// 	} 
// 	else 
		if ( !is_admin() && $query->is_post_type_archive('event') && $query->is_main_query()) {
        $query->set( 'posts_per_page', -1 );
    }
    else if ( $query->is_search )
    {
	    $query->set( 'hide_empty', false );
    }  
  return $query;
}

function thriive_get_terms( $taxonomies, $args=array() ){
    //Parse $args in case its a query string.
    $args = wp_parse_args($args);

    if( !empty($args['post_types']) ){
        $args['post_types'] = (array) $args['post_types'];
        add_filter( 'terms_clauses','thriive_filter_terms_by_cpt',10,3);

        function thriive_filter_terms_by_cpt( $pieces, $tax, $args){
            global $wpdb;

            // Don't use db count
            $pieces['fields'] .=", COUNT(*) " ;

            //Join extra tables to restrict by post type.
            $pieces['join'] .=" INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id 
                                INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id ";

            // Restrict by post type and Group by term_id for COUNTing.
            $post_types_str = implode(',',$args['post_types']);
            $pieces['where'].= $wpdb->prepare(" AND p.post_type IN(%s) GROUP BY t.term_id", $post_types_str);

            remove_filter( current_filter(), __FUNCTION__ );
            return $pieces;
        }
    } // endif post_types set

    return get_terms($taxonomies, $args);           
}

function thriive_get_post_filters($taxonomy,$post_type){
	$args =array(
	    'hide_empty' => 0,
	    'post_types' =>array($post_type),
	);

	return thriive_get_terms($taxonomy,$args);
}

function thriive_get_therapy_ailments() {
	$args = array( 'taxonomy' => 'therapy', 'hide_empty' => 0);  
	$therapyTerms = get_terms( $args );  
	$selectedAilments = array();
	
	foreach($therapyTerms as $term) {
	    $ailment = get_field('ailment',$term);
	    foreach($ailment as $a) {
	    	$selectedAilments[$a->term_id] = $a->name;
	    }
    }
	return array_unique($selectedAilments);
}

function modify_category_title ($title) {

    if ( is_category() ) {

            $title = single_cat_title( '', false );

        } else {
	        $title = __( 'Blog' );
        }

    return $title;

}

function thriive_get_ailments_therapy(){
	$args = array( 'taxonomy' => 'ailment', 'hide_empty' => 0);  
	$ailmentTerms = get_terms( $args );  
	$selectedTherapy = array();
	
	foreach($ailmentTerms as $term) {
	    $therapy = get_field('therapies',$term);
	    foreach($therapy as $t) {
	    	$selectedTherapy[$t->term_id] = $t->name;
	    }
    }
	return array_unique($selectedTherapy);
}

function save_taxonomy_ailment($term_id) {
	$selected_therapy = get_field('therapies', 'ailment_'.$term_id);
	$ailmentIds = array();
	
/*
    foreach($selected_therapy as $st){
	    $existing_ailment = get_field('ailment', 'therapy_'.$st->term_id);
	    
	    if( empty( $existing_ailment ) ) {
		    $ailmentIds[] = $term_id;
		} else {
		    $ailment_arr = unserialize($existing_ailment);
		    if(!in_array($term_id, $ailment_arr)){
			    $ailmentIds[] = $term_id;
		    }
		}
		update_term_meta( $st->term_id, 'ailment', $ailmentIds );
    }
*/
    
    foreach($selected_therapy as $st)
    {
	    $getAilmentIds = array();
	    //echo "<pre>";print_r($sa);echo "</pre>";
	    $existing_ailment = get_field('ailment', 'therapy_'.$st->term_id);
	    
	    if( empty( $existing_ailment ) ) 
	    {
		    $getAilmentIds[] = $term_id;
		} 
		else 
		{
			foreach($existing_ailment as $single_existing_ailment)
		    {
			    $getAilmentIds[] = $single_existing_ailment->term_id;
		    }
		    
		    if(!in_array($term_id, $getAilmentIds))
		    {
			    $getAilmentIds[] = $term_id;
		    }
		}
		$getAilmentIds = array_unique($getAilmentIds);
		//echo "<pre>";print_r($getTherapiesIds);echo"</pre>";
		update_term_meta( $st->term_id, 'ailment', $getAilmentIds );
    }
    //exit;
}

function save_taxonomy_therapy($term_id) {
    $selected_ailment = get_field('ailment', 'therapy_'.$term_id);
	$therapyIds = array();
	
    foreach($selected_ailment as $sa)
    {
	    $getTherapiesIds = array();
	    //echo "<pre>";print_r($sa);echo "</pre>";
	    $existing_therapy = get_field('therapies', 'ailment_'.$sa->term_id);
	    
	    if( empty( $existing_therapy ) ) 
	    {
		    $getTherapiesIds[] = $term_id;
		} 
		else 
		{
			foreach($existing_therapy as $single_existing_therapy)
		    {
			    $getTherapiesIds[] = $single_existing_therapy->term_id;
		    }
		    
		    if(!in_array($term_id, $getTherapiesIds))
		    {
			    $getTherapiesIds[] = $term_id;
		    }
		}
		$getTherapiesIds = array_unique($getTherapiesIds);
		//echo "<pre>";print_r($getTherapiesIds);echo"</pre>";
		update_term_meta( $sa->term_id, 'therapies', $getTherapiesIds );
    }
    //exit;
    
    $is_has_child = get_terms( 'therapy', array(
		'parent'    => $term_id,
		'hide_empty' => false
	) );
	
	if(empty($is_has_child)){
		$term = get_term_by('id',$term_id,'therapy');
		$childrens = get_term_children( $term->parent, 'therapy' );
		$finalArr = array();
		foreach($childrens as $children){
			$child_ailment = get_field('ailment', 'therapy_'.$children);
			foreach($child_ailment as $ca){
				$finalArr[] = $ca->term_id;
			}
		}
		update_term_meta( $term->parent, 'ailment', array_unique($finalArr) );
	}
}

// Changing state dynamically on therapist registration
function CountryStateChange() {
	global $wpdb;
	
	if(!empty($_POST['country_id'])){
	    //Fetch all state data
	    $states = $wpdb->get_results('SELECT * FROM states WHERE country_id = '.$_POST['country_id']); 
	    ?>
	    <option value="">No state selected</option><?php
	    if(count($states) != 0) {
		    foreach($states as $key => $value) { ?>
				<option state_id="<?php print_r( $value->id );?>" value="<?php print_r( $value->name );?>"><?php print_r( $value->name );?></option>
	<?php   } 
	    } 
	    else { ?>
		    <option state_id="not_available" value="not_available" <?php echo ($address->state == 'not_available')?'selected':''?>>State not available</option>
<?php   }
    } else {
	    $current_user = wp_get_current_user();
	    $address = json_decode($current_user->address);
	    $selected_country_name = $address->country;
	    $selected_country_id = $wpdb->get_results("SELECT id FROM countries WHERE name = '".$selected_country_name."'"); 
	    $states = $wpdb->get_results('SELECT * FROM states WHERE country_id = '.$selected_country_id[0]->id); 
	    ?>
	    <option value="">No state selected</option><?php
 
	    if(count($states) != 0) {
		    foreach($states as $key => $value) { ?>
				<option state_id="<?php print_r( $value->id );?>" value="<?php print_r( $value->name );?>" <?php echo ($value->name == $address->state)?'selected':''?>><?php print_r( $value->name );?></option>
	<?php   } 
	    } else { ?>
		    <option state_id="not_available" value="not_available" <?php echo ($address->state == 'not_available')?'selected':''?>>State not available</option>
<?php   }
	}
}

// Changing state dynamically on therapist registration
function StateCityChange() {
	global $wpdb;
	
	if(!empty($_POST['state_id'])) {
	    //Fetch all city data
	    $cities = $wpdb->get_results('SELECT * FROM cities WHERE state_id = '.$_POST['state_id']); 
	    ?>
	    <option value="">No city selected</option><?php
	    if(count($cities) != 0) {
		    foreach($cities as $key => $value) { ?>
				<option city_id="<?php echo $value->id;?>" value="<?php print_r( $value->name );?>"><?php print_r( $value->name );?></option>
	<?php   } 
	    } else { ?>
		    <option city_id="not_available" value="not_available" <?php echo ($address->city == 'not_available')?'selected':''?>>City not available</option>
<?php   }
		exit();
	}
    else {
	    $current_user = wp_get_current_user();
	    $address = json_decode($current_user->address);
	    $selected_state_name = $address->state;
	    $selected_state_id = $wpdb->get_results("SELECT id FROM states WHERE name = '".$selected_state_name."'"); 
	    $cities = $wpdb->get_results('SELECT * FROM cities WHERE state_id = '.$selected_state_id[0]->id); 
	    ?>
	    <option value="">No city selected</option><?php
	    if(count($cities) != 0) {
		    foreach($cities as $key => $value) { ?>
				<option city_id="<?php print_r( $value->id );?>" value="<?php print_r( $value->name );?>" <?php echo ($value->name == $address->city)?'selected':''?>><?php print_r( $value->name );?></option>
	<?php   } 
	    } else { ?>
		    <option city_id="not_available" value="not_available" <?php echo ($address->city == 'not_available')?'selected':''?>>City not available</option>
<?php   }
	}  
}


function get_therapist_language(){
	$therapist_args =  array(
        'taxonomy' => 'language',
        'post_type' => array('therapist'),
        'hide_empty' => true,
    );
	return get_terms($therapist_args);
}

function get_therapist_area(){
	$keyword = strval($_POST['area']);
	$search_param = "{$keyword}%";

	global $wpdb;
	$results = $wpdb->get_results( "SELECT pm.meta_value FROM {$wpdb->prefix}posts AS p LEFT JOIN {$wpdb->prefix}postmeta AS pm ON pm.post_id = p.id WHERE meta_key = 'area' AND meta_value LIKE '$search_param'", OBJECT );

	foreach ($results as $result) {
		if(!empty($result->meta_value)){
			$splitarea = explode(",",$result->meta_value);
			if(!in_array($splitarea[0],$areaResult)){
				$areaResult[] = $splitarea[0];
			}
		}
	}
	echo json_encode($areaResult);
	wp_die();
}
function save_area_session(){
	$areaResult = getLatLng($_POST['area']);
	$_SESSION['user_latitude'] = $areaResult['lat'];
	$_SESSION['user_longitude'] = $areaResult['lng'];
	$_SESSION['user_area'] = $areaResult['area'];
	$_SESSION['user_city'] = $areaResult['city'];
	echo json_encode($areaResult);
	wp_die();
}

function get_therapist_location(){
	$finalArr = array();
	$country_args =  array(
        'taxonomy' => 'location',
        'parent' => 0,
        'hide_empty' => true,
    );
	$countries = get_terms($country_args);
	foreach($countries as $country){
		$state_args =  array(
	        'taxonomy' => 'location',
	        'parent' => $country->term_id,
	        'hide_empty' => true,
	    );
		$states = get_terms($state_args);
		foreach($states as $state){
			$city_args =  array(
		        'taxonomy' => 'location',
		        'parent' => $state->term_id,
		        'hide_empty' => true,
		    );
			$cities = get_terms($city_args);
			foreach($cities as $city){
				array_push($finalArr, $city);
				// $finalArr[] = str_replace(' ', '-', $city->name);
			}
		}
	}
	// Sort Alphabetically by Term Names
	usort($finalArr, 'comparator');
	return $finalArr;
}

// Sort Alphabetically by Term Names
function comparator($object1, $object2) { 
    return strcasecmp($object1->name, $object2->name); 
} 

function getAllTherapistByRole($role)
{
	$args = array(
	    'role__in' => array($role)
	);
	$query = new WP_User_Query($args);
	
	if($query->total_users > 0)
	{
		$results = $query->get_results();
		
		$user_data = array();
		$user_row = array();
		
		foreach($results as $result)
		{	
			$user_row['id'] = $result->ID;
			$user_row['dob'] = $result->dob;
			$user_row['mobile'] = $result->mobile;
			$user_row['email'] = $result->user_email;
			$user_row['name'] = $result->first_name . " " . $result->last_name;
			$user_row['post_id'] = $result->post_id;
			if(!empty($result->post_id))
			{
				$userPost = get_post($result->post_id);
				if(!empty($userPost->select_package[0]))
				{
					$user_row['package'] = get_post($userPost->select_package[0]);					
				}
			}
			if($result->transaction > 0)
			{
				$user_row['transaction'] = get_post($result->transaction);
			}
			
			$user_data[] = $user_row;
			$user_row['transaction'] = "";
			$user_row['package'] = "";
		}
		return $user_data;		
	}
}

function getContactedTherapistSeekers(){
	global $wpdb;
	$users = [];
	$result = $wpdb->get_results("SELECT * from my_operator_call_history WHERE is_seeker = 1");
	if($result){
		foreach($result as $each_user){
			$therapist = get_user_by("id",$each_user->receiver_id);
			$seeker = get_user_by("id",$each_user->caller_id);
			$user_row['id'] = $seeker->ID;
			$user_row['name'] = $seeker->display_name;
			$user_row['uname'] = $seeker->user_login;
			$user_row['email'] = $seeker->user_email;
			$user_row['therapist_name'] = $therapist->display_name;
			$user_row['timestamp'] = $each_user->timestamp;
			$user_row['is_call'] = $each_user->is_call;
			$users[] = $user_row;
		}
	}

	return $users;
}

//  -------- CRON -----------
function cron_therapists_birthday_32e1b781()
{
	$user_data = getAllTherapistByRole('therapist');
	if($user_data)
	{
		$currentDate = date('d/m');
		foreach($user_data as $user)
		{
			$dob = $user['dob'];
			if(!empty($dob))
			{
				$dob = strtotime($dob);
				$dob = date("d/m", $dob);
				if($dob == $currentDate)
				{
					$username = $user['name'];
					$useremail = $user['email'];
					$mobileNo = $user['mobile'];
					$subject = "$username, a very happy birthday from Thriive Art & Soul";
				    $msg = "Hi $username,<br><br>
				    	Happy Birthday!<br><br>
						All of us here at Thriive Art & Soul hope that your special day is as wonderful and extraordinary as you are.<br><br>
						We’d like to take this opportunity to also appreciate the fabulous work you are doing in bringing solace to so many lives through your healing practices. As we continue to create a revolution in the world of 							wellness, it is a great joy to have you as part of the journey.<br><br>
						Stay amazing, always!<br><br>
						Love & light,<br>
						Team Thriive<br><br>
						<em style='color: #615c5c;'>
							Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
						<em>";
				    sendEmail($useremail, $subject, $msg);
				    $msg = "Dear $username, Wishing you a memorable day and a year filled with love, harmony and health. All of us here at Thriive Art & Soul hope that your special day is as wonderful and extraordinary as you are.";
				    sendSMS($mobileNo, $msg);
				}
			}
		}
	}	
}
function cron_packages_renewal_email_one_month_before_expiry_e072d061()
{
    $user_data = getAllTherapistByRole('therapist');
	if($user_data)
	{
		$nextMonthExpiry = date('d/m/Y', strtotime('+1 month'));
		$yesterdayExpired = date('d/m/Y',strtotime("-1 days"));
		
		foreach($user_data as $user)
		{
			$packageCharges = $user['package']->package_charges;
			if($packageCharges > 0)
			{
				if($user['transaction'])
				{
					$expiry_date = strtotime($user['transaction']->end_date);
					$expiry_date = date("d/m/Y", $expiry_date);
					
					$users_id = $user['id'];
					$post_id = $user['post_id'];
					$username = $user['name'];
					$useremail = $user['email'];
					$package_page_link = get_permalink(414);
					
					//One month before package expire
					if($nextMonthExpiry == $expiry_date)
					{
						$subject = "It doesn’t have to be goodbye!";
					    $msg = "Hi $username,<br><br>
					    	Can you believe it? It’s been almost a year since you’ve been a part of India’s largest light network! How has this year been? We’d love to hear your experiences with <a href='www.thriive.in'>www.thriive.in</a>. 						Please email us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a>.<br><br>
							We thought that this would be a great time to reach out and let you know that your registration is about to expire in 30 days. Please do review your profile page and see if you have any benefits you’d like to 							take advantage of...it’s still not too late!<br><br>
							Next year we plan to grow even bigger and brighter, and we hope that you’ll be there to shine with us. There’s lot of exciting upgrades to the packages, check them out: $package_page_link.<br><br>
							If you have any questions or would like to renew, get in touch with your Account Manager ASAP at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
							Let’s keep healing the world together.<br><br>
							Love & light,<br>
							Team Thriive<br><br>
							<em style='color: #615c5c;'>
								Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
							<em>";
					    sendEmail($useremail, $subject, $msg);
					}
					
					//after package expired
					if($yesterdayExpired == $expiry_date)
					{
						$package_page_link = get_permalink(414);
						$subject = "One more chance  to shine with THRIIVE!";
					    $msg = "Hi $username,<br><br>
					    	Your annual package has expired. Can you imagine, it’s already been a year! How did you feel being a part of India’s largest network of light? We’d love to hear your experiences, please email us at <a 									href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a>.<br><br>
							I know we’ve told you this before, but next year promises to be even bigger and brighter! Come, shine with us! Click here to view the exciting new packages we have for you: $package_page_link.<br><br>
							To renew your package or for any questions, please email <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a><br><br>
							Let’s keep healing the world together.<br><br>
							Love & light,<br>
							Team Thriive<br><br>
							<em style='color: #615c5c;'>
								Note:This is an automatically generated email, please do not reply. Any questions, feel free to contact us at <a href='mailto:accountmanager1@thriive.in'>accountmanager1@thriive.in</a> for help.
							<em>";
						update_field('select_package','129',$post_id); 	//129 is id of Earth package.
						sendEmail($useremail, $subject, $msg);
					}
				}
			}
		}
	}
}

function getTherapistTrendingEvents($post_id){
	$events_args = array( 
		'posts_per_page' => 2,
		'post_type' => 'event',
		'post_status' => 'publish',
		'meta_query' => array(
			array(
	            'key' => 'therapist',
	            'value' => '"' . $post_id . '"', 
	            'compare' => 'LIKE'
	        )
	    ),
	);
	return new WP_Query( $events_args );
}

// Convert Indian Rupees Digits to Words
function currencyToWords(float $number) {
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Sighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal) ? "and " . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : 'and Zero Paise';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}

function add_user_meta_box() {
    add_meta_box( 'm_param_therapist', 'User Details', 'display_user_details', 'therapist', 'normal', 'high' );
}

function display_user_details( $post )
{
    $user = get_userdata( $post->post_author );
	$expiry_date = get_post_meta($user->transaction)['end_date'][0];
?>
<table class="form-table">
	<tr valign="top">
		<th scope="row"><label for="user_meta_email">Email</label></th>
		<td><input type="email" disabled name="user_meta_email" value="<?php echo $user->user_email; ?>" style="min-width:275px"></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="user_meta_mobile">Mobile Number</label></th>
		<td><input type="text" disabled name="user_meta_mobile" value="<?php echo $user->mobile; ?>" style="min-width:275px"></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="user_meta_gender">Gender</label></th>
		<td><input type="email" disabled name="user_meta_gender" value="<?php echo $user->gender; ?>" style="min-width:275px"></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="user_meta_dob">Date of Birth</label></th>
		<?php
			if(!empty($user->dob))
			{
			    $time = strtotime($user->dob);
				$dob = date('d/m/Y',$time);
			}
			else
			{
				$dob = "";
			}
	    ?>
		<td><input type="email" disabled name="user_meta_dob" value="<?php echo $dob; ?>" style="min-width:275px"></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="user_meta_nationality">Nationality</label></th>
		<td><input type="email" disabled name="user_meta_nationality" value="<?php echo $user->nationality; ?>" style="min-width:275px"></td>
	</tr>
	<tr valign="top">
		<th scope="row"><label for="user_meta_package_expity">Package Expiry Date</label></th>
		<td><input type="email" disabled name="user_meta_package_expity" value="<?php echo $expiry_date; ?>" style="min-width:275px"></td>
	</tr>
</table>

<?php
}

/*
function no_access_to_therapist_seeker()
{
    $redirect = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : home_url( '/' );
    if ( 
        current_user_can( 'therapist' ) OR current_user_can( 'subscriber' )
    )
        exit( wp_redirect( $redirect ) );
}
*/

function change_excerpt( $text )
{
    $pos = strrpos( $text, '[');
    if ($pos === false)
    {
        return $text;
    }

    return rtrim (substr($text, 0, $pos) );
}
add_filter('get_the_excerpt', 'change_excerpt');




function add_attachment_pdf( $notification, $form, $entry ) {
    //There is no concept of user notifications anymore, so we will need to target notifications based on other criteria,
    //such as name or subject
    if( $notification['name'] == 'User Notification' ) {
        //get upload root for WordPress
        $upload = wp_upload_dir();
        $upload_path = $upload['basedir'];
 
        //add file, use full path , example -- $attachment = "C:\\xampp\\htdocs\\wpdev\\wp-content\\uploads\\test.txt"
        $attachment = get_stylesheet_directory() . '/assets/pdf/thriive-detox-planner.pdf';
 
        GFCommon::log_debug( __METHOD__ . '(): file to be attached: ' . $attachment );
 
        if ( file_exists( $attachment ) ) {
            $notification['attachments']   = rgar( $notification, 'attachments', array() );
            $notification['attachments'][] = $attachment;
            GFCommon::log_debug( __METHOD__ . '(): file added to attachments list: ' . print_r( $notification['attachments'], 1 ) );
        } else {
            GFCommon::log_debug( __METHOD__ . '(): not attaching; file does not exist.' );
        }
    }
    //return altered notification object
    return $notification;
}

function custom_seo_therapist() {
	if (is_singular('therapist')) {
	    $category_name = get_the_terms(get_the_id(), 'therapy');
	    $cat_array = array();
	    foreach ($category_name as $cat_name) {
	        $cat_array[] = $cat_name->name;
	    }
	} 
	return $cat_array;
}

function custom_seo_ailments() {
	if (is_tax('ailment')) {
	    $taxonomy_name = get_queried_object();
	    $selected_therapies = get_field('therapies', $taxonomy_name->taxonomy . '_' . $taxonomy_name->term_id);
	    $therapies_array = array();
	    foreach ($selected_therapies as $selected_therapy) {
	        $therapies_array[] = $selected_therapy->name;
	    }	
    }
    return $therapies_array;
}

function custom_wpseo_title($title) {
    if(is_singular('therapist')) {
        $cat_array = custom_seo_therapist();
	    $title = get_the_title() . '- Therapist -' . implode(", ", $cat_array) . ' | Thriive.in';
    }
    // therapy and area
    if (is_tax('therapy') && !empty($_GET['area']) && empty(is_tax('ailment'))) {
	    $taxonomy_name = get_queried_object();
	    $area = ($_SESSION['user_area']==$_SESSION['user_city']) ? $_SESSION['user_area'] : $_SESSION['user_area'].", ".$_SESSION['user_city'];
	    $title = $taxonomy_name->name." therapist In ".$area.", ".$taxonomy_name->name." In ".$area." Near Me, Best ".$taxonomy_name->name." therapist, List of ".$taxonomy_name->name." therapist in".$_SESSION['user_area'].", Top ".$taxonomy_name->name." therapist in ".$_SESSION['user_city'].", ".$taxonomy_name->name." Clinic, ".$taxonomy_name->name." Treatment  - Book Therapist Appointment Online, Call Therapist, Consult Therapist Online, View Fees, Feedbacks | Thriive.in";
	}
    // ailment and area
    if (is_tax('ailment') && !empty($_GET['area']) && empty(is_tax('therapy'))) {
	    $taxonomy_name = get_queried_object();
	    $therapies_array = implode(", ", custom_seo_ailments());
	    $area = ($_SESSION['user_area']==$_SESSION['user_city']) ? $_SESSION['user_area'] : $_SESSION['user_area'].", ".$_SESSION['user_city'];
	    $title = 'Cure '.$taxonomy_name->name.' In '.$area.', '.$taxonomy_name->name.' In '.$_SESSION['user_area'].', '.$taxonomy_name->name.' Near Me, Cure '.$taxonomy_name->name.' by '.$therapies_array.', Treat '.$taxonomy_name->name.' by '.$therapies_array.' - Book Therapist Appointment Online, Call Therapist Online, Consult Therapist Online, View Fees, Feedbacks | Thriive.in';
	}
	// area
	if (is_archive('therapist') && !empty($_GET['area']) && empty(is_tax('therapy')) && empty(is_tax('ailment'))) {
		$area = ($_SESSION['user_area']==$_SESSION['user_city']) ? $_SESSION['user_area'] : $_SESSION['user_area'].", ".$_SESSION['user_city'];
	    $title = 'Therapist In '.$area.', Therapist Near Me, List of therapist '.$_SESSION['user_city'].', - Book Therapist Appointment Online, Call Therapist Online, Consult Therapist Online, View Fees, Feedbacks | Thriive.in';
	}
	// area, therapy and ailment
	if(!empty(is_tax('therapy')) && !empty($_GET['area']) && !empty($_GET['ailment'])){
		$taxonomy_name = get_queried_object();
		$ailment = str_replace("-", " ", $_GET['ailment']);
		$area = ($_SESSION['user_area']==$_SESSION['user_city']) ? $_SESSION['user_area'] : $_SESSION['user_area'].", ".$_SESSION['user_city'];
		$title = $taxonomy_name->name." therapist In ".$area.", ".$taxonomy_name->name." In ".$_SESSION['user_city'].", ".$taxonomy_name->name." Near Me, Best ".$taxonomy_name->name." therapist, List of ".$taxonomy_name->name." therapist in ".$_SESSION['user_city'].", Cure ".$ailment." by ".$taxonomy_name->name.", Treat ".$ailment." by ".$taxonomy_name->name." - Book Therapist Appointment Online, Call Therapist Online, Consult Therapist Online, View Fees, Feedbacks | Thriive.in";
	}
    
    return $title;
}

function custom_wpseo_meta( $desc ){
    if (is_singular('therapist')) {
        $cat_array = custom_seo_therapist();
	    $desc = get_the_title() . " is a therapist of " . implode(", ", $cat_array) . ", Connect with " . get_the_title() . ", View User Feedbacks for " . get_the_title() . " | Thriive.in";
    } 
	// therapy and area
    if (is_tax('therapy') && !empty($_GET['area']) && empty(is_tax('ailment'))) {
	    $taxonomy_name = get_queried_object();
	    $area = ($_SESSION['user_area']==$_SESSION['user_city']) ? $_SESSION['user_area'] : $_SESSION['user_area'].", ".$_SESSION['user_city'];
	    $desc = $taxonomy_name->name." therapist in ".$area.". Book Therapist's Appointment Online, Call Therapist, View Fees, User feedbacks, Address & Phone Numbers of ".$taxonomy_name->name." in ".$area." | thriive.in";
	}
    // ailment and area
    if (is_tax('ailment') && !empty($_GET['area']) && empty(is_tax('therapy'))) {
	    $taxonomy_name = get_queried_object();
	    $therapies_array = implode(", ", custom_seo_ailments());
	    $desc = "Find a Therapist Curing ".$taxonomy_name->name." in ".$_SESSION['user_city'].", Therapist in ".$_SESSION['user_city'].". Book Therapist's Appointment Online, Call Therapist, View Fees, User feedbacks, Address & Phone Numbers of ".$taxonomy_name->name." in ".$_SESSION['user_city'].", Therapist in ".$_SESSION['user_city']." | thriive.in";
	}
	// area
	if (is_archive('therapist') && !empty($_GET['area']) && empty(is_tax('therapy')) && empty(is_tax('ailment'))) {
		$area = ($_SESSION['user_area']==$_SESSION['user_city']) ? $_SESSION['user_area'] : $_SESSION['user_area'].", ".$_SESSION['user_city'];
	    $desc = "Therapist in ".$area.", Therapist in ".$_SESSION['user_city'].", Therapist Near Me, Book Therapist's Appointment Online, Call Therapist, View Fees, User feedbacks, Address & Phone Numbers of Therapist in ".$area." | thriive.in";
	}
	// area, therapy and ailment
	if(!empty(is_tax('therapy')) && !empty($_GET['area']) && !empty($_GET['ailment'])){
		$taxonomy_name = get_queried_object();
		$ailment = str_replace("-", " ", $_GET['ailment']);
		$area = ($_SESSION['user_area']==$_SESSION['user_city']) ? $_SESSION['user_area'] : $_SESSION['user_area'].", ".$_SESSION['user_city'];
		$desc = $taxonomy_name->name." therapist in ".$area.". Book Therapist's Appointment Online, Call Therapist, View Fees, User feedbacks, Address & Phone Numbers of ".$taxonomy_name->name." in ".$area." | thriive.in";
	}

    return $desc;
}

//Modified Canonical Url
function change_cannonical_url($url){
	if(is_post_type_archive('therapist')) {
		$url = esc_url(home_url('/therapist/'));	
	}
   return $url;
}

function is_in_array($array, $key, $key_value){
      $within_array = 'no';
      foreach( $array as $k=>$v ){
        if( is_array($v) ){
            $within_array = is_in_array($v, $key, $key_value);
            if( $within_array == 'yes' ){
                break;
            }
        } else {
                if( $v == $key_value && $k == $key ){
                        $within_array = 'yes';
                        break;
                }
        }
      }
      return $within_array;
}

//Users GeoLocation
function UsersGeoLocation() {
	//Get Location
	$geolocation = $_POST['latitude'] . ',' . $_POST['longitude'];
	$request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng='.$geolocation.'&key=AIzaSyDBb6WcaBBL5-HYKVPtlbVJWuhubj7MxSg'; 
	$file_contents = file_get_contents($request);
	$json_decode = json_decode($file_contents);
	$area = extractFromAdress($json_decode->results[0]->address_components,'sublocality_level_1');
	$city = extractFromAdress($json_decode->results[0]->address_components,'locality');
	$state = extractFromAdress($json_decode->results[0]->address_components,'administrative_area_level_1');
	$country = extractFromAdress($json_decode->results[0]->address_components,'country');
	$_SESSION['user_latitude'] = $_POST['latitude'];
	$_SESSION['user_longitude'] = $_POST['longitude'];
	$_SESSION['user_area'] = $area;
	$_SESSION['user_city'] = $city;

	global $wpdb;
	if (is_user_logged_in()) {
    	$current_user = wp_get_current_user();
    	$user_id = $current_user->ID;
    	$user_name = $current_user->first_name . ' ' . $current_user->last_name;
    	$user_email = $current_user->user_email;
	} else {
		$user_id = '';
		$user_name = '';
		$user_email = '';
	}
	$user_location = array(
						'date_time' => $_POST['user_date'].' '.$_POST['user_time'],
					 	'latitude' => $_POST['latitude'],
					 	'longitude' => $_POST['longitude'],
					 	'area' => $area,
					 	'city' => $city,
					 	'state' => $state,
					 	'country' => $country
					 );
	//echo serialize($user_location);
	$user_data = array(
					'user_id'		=> $user_id,
					'user_name' 	=> $user_name,
					'user_email'	=> $user_email,
					'user_ip'		=> $_SERVER['REMOTE_ADDR'],
					'user_location' => serialize($user_location)
				);
	
	if(is_user_logged_in()){
		$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}thriive_geolocation WHERE user_id = $user_id", OBJECT );
		if($results){
			$tempArr = array();
			$isDiffArea = false;
			foreach($results as $result){
				$db_ul = unserialize($result->user_location);
				$tempArr = $db_ul;
				array_push($tempArr,$user_location);
				if(is_in_array($db_ul, 'area', $area) == 'no'){
					$wpdb->update('wp_thriive_geolocation', array('user_location' => ""), array('id' => $result->id));
					$user_data['user_location'] = serialize($tempArr);
					$wpdb->update('wp_thriive_geolocation', $user_data, array('id' => $result->id));
				}
			} 
		} else {
			$user_data['user_location'] = serialize(array($user_location));
			$wpdb->insert('wp_thriive_geolocation', $user_data);
		}
	} else {
		$user_data['user_location'] = serialize(array($user_location));
		$wpdb->insert('wp_thriive_geolocation', $user_data);
	}
	echo $area;
	wp_die();
}

function extractFromAdress($components, $type){
    for ($i=0; $i<count($components); $i++){
        for ($j=0; $j<count($components[$i]->types); $j++){
            if ($components[$i]->types[$j]==$type) return $components[$i]->long_name;
        }
    }
    return "";
}

function main_above_banner() {
	register_nav_menus( array(
		'main_above_banner' => 'Menu for above banner',
		'footer_menu1' => 'Footer Menu 1',
		'footer_menu2' => 'Footer Menu 2',
		'footer_menu3' => 'Footer Menu 3',
		'footer_menu4' => 'Footer Menu 4',
	) );
}

// Get Ailment by Therapy Slug
function getAilmentByTherapy() {
	$var = $_POST['therapySlug'];
	$ailments = get_ailment_by_therapy($var);
	if(empty($ailments)) {
		echo 'empty';
	} else {
		echo json_encode($ailments);
	}
	wp_die();
}

// Get Ailments by Therapy Slug
function get_ailment_by_therapy($therapy) {
	if(empty($therapy)) {
		$data = get_all_ailments();
		return $data;
	} else {
		$term = get_term_by('slug', $therapy, 'therapy');
		$ailments = get_field('ailment', $term);
		if(empty($ailments)) {
			return '';
		} else {
			return $ailments;
		}	
	}	
}

function get_all_ailments() {
	$terms = get_terms( 'ailment', array(
		'hide_empty' => true,
	) );
	return $terms;
}

// Get Therapy by Ailment Slug
function getTherapyByAilment() {
	$var = $_POST['ailmentSlug'];
	$therapies = get_therapy_by_ailment($var);
	if(empty($therapies)) {
		echo 'empty';
	} else {
		echo json_encode($therapies);
	}
	wp_die();
}

function get_therapy_by_ailment($ailment) {
	if(empty($ailment)) {
		$data = get_all_therapies();
		return $data;
	} else {
		$term = get_term_by('slug', $ailment, 'ailment');
		$therapies = get_field('therapies', $term);
		if(empty($therapies)) {
			return '';
		} else {
			return $therapies;
		}	
	}	
}

function getAilmentByAjax(){
	$keyword = strval($_POST['issue']);
	$search_param = "{$keyword}%";

	global $wpdb;
	$results = $wpdb->get_results( "SELECT t.name FROM {$wpdb->prefix}terms AS t LEFT JOIN {$wpdb->prefix}term_taxonomy AS tt ON tt.term_id = t.term_id WHERE t.name LIKE '$search_param' AND tt.taxonomy = 'ailment'", OBJECT );
	foreach ($results as $result) {
		if(!empty($result->name)){
			$areaResult[] = $result->name;
		}
	}
	echo json_encode($areaResult);
	wp_die();
}

function get_all_therapies() {
	$terms = get_terms( 'therapy', array(
		'hide_empty' => true,
	) );
	return $terms;
}

function validate_seeker_modal(){
	parse_str($_POST['seeker_form_data'], $input);
	//var_dumpp($input);exit;
	global $seeker_msg;
	if ( username_exists( $input['email'] ) && email_exists($input['email'])) {
		echo generateJSON('error','Email ID already registered, Please login','');exit;
	} else {
		if(isset($input['firstname']) && isset($input['email']) && isset($input['password']))
		{
			$user_id = username_exists( $input['email'] );
			if ( !$user_id and email_exists($input['email']) == false ) 
			{
			   	$seekerDetails = array(
				    'user_login' =>  $input['email'],
				    'user_email'  =>  $input['email'],
				    'user_pass'  =>  $input['password'],
				);
				$user_id = wp_insert_user($seekerDetails);
				$result = update_user_meta($user_id, 'first_name',  $input['firstname']);
				//var_dump($result);
				// $addressObj->country = $input['country'];
				// $addressObj->state = $input['state'];
				// $addressObj->city = $input['city'];
				// $address = json_encode($addressObj);
				// update_user_meta($user_id, 'address',  $address);
			  	
	/*
				update_user_meta($user_id, 'country',  $input['country']);
				update_user_meta($user_id, 'state',  $input['state']);
				update_user_meta($user_id, 'city',  $input['city']);
	*/
				
				auto_login_new_user($user_id);
				if($input['txtEventId'] != "" && $input['txtQuery'] != "")
				{
					$event_id = $input['txtEventId'];
					$question = $input['txtQuery'];
					$current_user = wp_get_current_user();
					$user_email = $current_user->user_email;
					$result = saveFAQQuery($event_id,$question,$user_email);
					wp_redirect(get_permalink($event_id) . "?event_query=saved");
					exit;
				}
				//$login_url = add_query_arg('flg', '1', get_permalink(419));
				//wp_redirect($login_url);exit;
				echo generateJSON('success','You have successfully signed up.Please login',array('user_id'=>$user_id));exit;
			} 
			else 
			{
				update_user_meta($user_id, 'stage',  1);
				auto_login_new_user($user_id);
			    echo generateJSON('error','User already exists','');exit;
			}
		} 
		else 
		{
			 echo generateJSON('error','Enter required fields','');exit;
		}
    }
}

function assign_masked_number_to_user(){
	global $wpdb;
	$therapist_email = $_POST['therapist_email'];
	$seeker_email = $_POST['seeker_email'];
	$therapist = get_user_by("email",$therapist_email);
	$seeker = get_user_by("email",$seeker_email);
	$r_masked_number = $c_masked_number = "";

	
	$check_caller_entry = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE caller_id = ".$seeker->ID." and is_deleted = 0");
	if($check_caller_entry){

		$check_receiver_entry = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE receiver_id = ".$therapist->ID." and caller_id = ".$seeker->ID." and is_deleted = 0");

		if($check_receiver_entry){

			$get_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.caller_id = ".$seeker->ID." and mo.receiver_id = ".$therapist->ID." and mo.is_deleted = 0");
			$c_masked_number = $get_masked_number->masked_number;

			$get_t_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.caller_id = ".$therapist->ID." and mo.receiver_id = ".$seeker->ID." and mo.is_deleted = 0");
			$r_masked_number = $get_t_masked_number->masked_number;

		}else{
			$get_unused_number = $wpdb->get_row("SELECT * from my_operator_call_masking_details where status = 1 LIMIT 1");
			if(!$get_unused_number){
				// If unused masked number is not available
				$first_row = $wpdb->get_row("SELECT * FROM my_operator_call_masking_details WHERE status = 0 ORDER BY id LIMIT 1");

				$wpdb->query("UPDATE my_operator_number_allocation SET is_deleted = 1 WHERE cmd_id = ".$first_row->id." AND caller_id = ".$seeker->ID);
				
				$data = array('caller_id' => $seeker->ID, 'receiver_id' => $therapist->ID, 'cmd_id' => $first_row->id);
				$wpdb->insert('my_operator_number_allocation',$data);

				$c_masked_number = $first_row->masked_number;

				//check for other masked number

				$get_receiver_row = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE cmd_id = ".$first_row->id." AND caller_id = ".$therapist->ID);


				if($get_receiver_row){
					$get_receiver_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number,m.id as id from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.cmd_id != ".$first_row->id." ORDER BY m.id LIMIT 1");


					if(!$get_receiver_masked_number){
						$wpdb->query("UPDATE my_operator_number_allocation SET is_deleted = 1 WHERE cmd_id = ".$first_row->id." AND caller_id = ".$therapist->ID);

						$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $first_row->id);
						$wpdb->insert('my_operator_number_allocation',$data);
						$r_masked_number = $first_row->masked_number;

					}else{
						$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_receiver_masked_number->id);
						$wpdb->insert('my_operator_number_allocation',$data);
						$r_masked_number = $get_receiver_masked_number->masked_number;	
					}
							
				}else{
					$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $first_row->id);
					$wpdb->insert('my_operator_number_allocation',$data);
					$r_masked_number = $first_row->masked_number;
				}

			}else{
				//If unused masked number is available
				$data = array('caller_id' => $seeker->ID, 'receiver_id' => $therapist->ID, 'cmd_id' => $get_unused_number->id);
				$wpdb->insert('my_operator_number_allocation',$data);

				$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_unused_number->id);
				$wpdb->insert('my_operator_number_allocation',$data);

				$wpdb->query("UPDATE my_operator_call_masking_details SET status = 0 WHERE id = ".$get_unused_number->id);
				$r_masked_number = $c_masked_number = $get_unused_number->masked_number;	
			}
		}
	}else{
		//pick any used masked number, make an entry in allocation table
		$get_used_number = $wpdb->get_row("SELECT * from my_operator_call_masking_details where status = 0 ORDER BY RAND() LIMIT 1");
		if(!$get_used_number){
			$get_used_number = $wpdb->get_row("SELECT * from my_operator_call_masking_details where status = 1 ORDER BY id LIMIT 1");

			$wpdb->query("UPDATE my_operator_call_masking_details SET status = 0 WHERE id = ".$get_used_number->id);
		}
		$data = array('caller_id' => $seeker->ID, 'receiver_id' => $therapist->ID, 'cmd_id' => $get_used_number->id);
		$wpdb->insert('my_operator_number_allocation',$data);

		$c_masked_number = $get_used_number->masked_number;

		//check existing connection already exists for the therapist
		$get_receiver_row = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE cmd_id = ".$get_used_number->id." AND caller_id = ".$therapist->ID);

			if($get_receiver_row){
				$get_receiver_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number,m.id as id from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.cmd_id != ".$get_used_number->id." ORDER BY m.id LIMIT 1");


				if(!$get_receiver_masked_number){
					$wpdb->query("UPDATE my_operator_number_allocation SET is_deleted = 1 WHERE cmd_id = ".$get_used_number->id." AND caller_id = ".$therapist->ID);

					$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_used_number->id);
					$wpdb->insert('my_operator_number_allocation',$data);
					$r_masked_number = $get_used_number->masked_number;

				}else{
					$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_receiver_masked_number->id);
					$wpdb->insert('my_operator_number_allocation',$data);
					$r_masked_number = $get_receiver_masked_number->masked_number;	
				}
						
			}else{
				$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_used_number->id);
				$wpdb->insert('my_operator_number_allocation',$data);
				$r_masked_number = $get_used_number->masked_number;
			}
		
	}

	$wpdb->query("UPDATE my_operator_number_allocation SET is_called_now = '0'");
	$wpdb->query("UPDATE my_operator_number_allocation SET is_called_now = '1' WHERE caller_id = ".$seeker->ID." AND receiver_id = ".$therapist->ID." AND is_deleted = 0");

	send_mail_to_therapist($therapist,$seeker,$r_masked_number);
	send_mail_to_seeker($therapist,$seeker,$c_masked_number);

	send_sms_to_therapist($seeker,$therapist,$r_masked_number);
	send_sms_to_seeker($seeker,$therapist,$c_masked_number);

	send_mail_to_product_manager_thriive($therapist,$seeker,$r_masked_number,$c_masked_number);

	$result = array("status"=>"success","masked_number"=>$c_masked_number);
	wp_send_json_success($result);
}
function consult_online_thriive_therapist($therapist_email_val = NULL,$seeker_email_val = NULL){

	global $wpdb;
	$therapist_email = $seeker_email = "";
	$is_ajax = 1;

	if($therapist_email_val == NULL && $seeker_email_val == NULL){
		$therapist_email = $_POST['therapist_email'];
		$seeker_email = $_POST['seeker_email'];
	}else{
		$therapist_email = $therapist_email_val;
		$seeker_email = $seeker_email_val;
		$is_ajax = 0;
	}

	$therapist = get_user_by("email",$therapist_email);
	$seeker = get_user_by("email",$seeker_email);
	$r_masked_number = $c_masked_number = "";
	
	$check_caller_entry = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE caller_id = ".$seeker->ID." and is_deleted = 0");

	if($check_caller_entry){

		$check_receiver_entry = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE receiver_id = ".$therapist->ID." and caller_id = ".$seeker->ID." and is_deleted = 0");

		if($check_receiver_entry){

			$get_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.caller_id = ".$seeker->ID." and mo.receiver_id = ".$therapist->ID." and mo.is_deleted = 0");
			$c_masked_number = $get_masked_number->masked_number;

			$get_t_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.caller_id = ".$therapist->ID." and mo.receiver_id = ".$seeker->ID." and mo.is_deleted = 0");
			$r_masked_number = $get_t_masked_number->masked_number;

		}else{
			$get_unused_number = $wpdb->get_row("SELECT * from my_operator_call_masking_details where status = 1 LIMIT 1");
			if(!$get_unused_number){
				// If unused masked number is not available
				$first_row = $wpdb->get_row("SELECT * FROM my_operator_call_masking_details WHERE status = 0 ORDER BY id LIMIT 1");

				$wpdb->query("UPDATE my_operator_number_allocation SET is_deleted = 1 WHERE cmd_id = ".$first_row->id." AND caller_id = ".$seeker->ID);
				
				$data = array('caller_id' => $seeker->ID, 'receiver_id' => $therapist->ID, 'cmd_id' => $first_row->id);
				$wpdb->insert('my_operator_number_allocation',$data);

				$c_masked_number = $first_row->masked_number;

				//check for other masked number

				$get_receiver_row = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE cmd_id = ".$first_row->id." AND caller_id = ".$therapist->ID);


				if($get_receiver_row){
					$get_receiver_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number,m.id as id from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.cmd_id != ".$first_row->id." ORDER BY m.id LIMIT 1");

					if(!$get_receiver_masked_number){
						$wpdb->query("UPDATE my_operator_number_allocation SET is_deleted = 1 WHERE cmd_id = ".$first_row->id." AND caller_id = ".$therapist->ID);

						$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $first_row->id);
						$wpdb->insert('my_operator_number_allocation',$data);
						$r_masked_number = $first_row->masked_number;

					}else{
						$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_receiver_masked_number->id);
						$wpdb->insert('my_operator_number_allocation',$data);
						$r_masked_number = $get_receiver_masked_number->masked_number;	
					}
							
				}else{
					$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $first_row->id);
					$wpdb->insert('my_operator_number_allocation',$data);
					$r_masked_number = $first_row->masked_number;
				}

			}else{
				//If unused masked number is available
				$data = array('caller_id' => $seeker->ID, 'receiver_id' => $therapist->ID, 'cmd_id' => $get_unused_number->id);
				$wpdb->insert('my_operator_number_allocation',$data);

				$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_unused_number->id);
				$wpdb->insert('my_operator_number_allocation',$data);

				$wpdb->query("UPDATE my_operator_call_masking_details SET status = 0 WHERE id = ".$get_unused_number->id);
				$r_masked_number = $c_masked_number = $get_unused_number->masked_number;	
			}
		}
	}else{
		//pick any used masked number, make an entry in allocation table
		$get_used_number = $wpdb->get_row("SELECT * from my_operator_call_masking_details where status = 0 ORDER BY RAND() LIMIT 1");
		if(!$get_used_number){
			$get_used_number = $wpdb->get_row("SELECT * from my_operator_call_masking_details where status = 1 ORDER BY id LIMIT 1");

			$wpdb->query("UPDATE my_operator_call_masking_details SET status = 0 WHERE id = ".$get_used_number->id);
		}
		$data = array('caller_id' => $seeker->ID, 'receiver_id' => $therapist->ID, 'cmd_id' => $get_used_number->id);
		$wpdb->insert('my_operator_number_allocation',$data);

		$c_masked_number = $get_used_number->masked_number;

		//check existing connection already exists for the therapist
		$get_receiver_row = $wpdb->get_row("SELECT * FROM my_operator_number_allocation WHERE cmd_id = ".$get_used_number->id." AND caller_id = ".$therapist->ID);

			if($get_receiver_row){
				$get_receiver_masked_number = $wpdb->get_row("SELECT m.masked_number as masked_number,m.id as id from my_operator_call_masking_details m JOIN my_operator_number_allocation mo on m.id = mo.cmd_id WHERE mo.cmd_id != ".$get_used_number->id." ORDER BY m.id LIMIT 1");


				if(!$get_receiver_masked_number){
					$wpdb->query("UPDATE my_operator_number_allocation SET is_deleted = 1 WHERE cmd_id = ".$get_used_number->id." AND caller_id = ".$therapist->ID);

					$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_used_number->id);
					$wpdb->insert('my_operator_number_allocation',$data);
					$r_masked_number = $get_used_number->masked_number;

				}else{
					$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_receiver_masked_number->id);
					$wpdb->insert('my_operator_number_allocation',$data);
					$r_masked_number = $get_receiver_masked_number->masked_number;	
				}
						
			}else{
				$data = array('receiver_id' => $seeker->ID, 'caller_id' => $therapist->ID, 'cmd_id' => $get_used_number->id);
				$wpdb->insert('my_operator_number_allocation',$data);
				$r_masked_number = $get_used_number->masked_number;
			}
	}

	$wpdb->query("UPDATE my_operator_number_allocation SET is_called_now = '0'");
	$wpdb->query("UPDATE my_operator_number_allocation SET is_called_now = '1' WHERE caller_id = ".$seeker->ID." AND receiver_id = ".$therapist->ID." AND is_deleted = 0");


	send_mail_to_therapist($therapist,$seeker,$r_masked_number);
	send_mail_to_seeker($therapist,$seeker,$c_masked_number);

	send_sms_to_therapist($seeker,$therapist,$r_masked_number);
	send_sms_to_seeker($seeker,$therapist,$c_masked_number);

	send_mail_to_product_manager_thriive($therapist,$seeker,$r_masked_number,$c_masked_number);

	//save call details in my_operator_call_history table
    $data = array('caller_id' => $seeker->ID,
                  'receiver_id' => $therapist->ID,
                  'is_call'=>0 ,
                  'is_seeker'=>1);
    $format = array('%s','%d','%d','%d','%d');
    $wpdb->insert('my_operator_call_history',$data,$format);


	$result = array("status"=>"success");
	if($is_ajax){
		wp_send_json_success($result);
	}
}

function send_mail_to_therapist($therapist,$seeker,$masked_number){

	$therapist_name = get_user_meta($therapist->ID,"first_name",true)." ".get_user_meta($therapist->ID,"last_name",true);
	$seeker_name = get_user_meta($seeker->ID,"first_name",true)." ".get_user_meta($seeker->ID,"last_name",true);
	$therapist_email = $therapist->user_email;
	
	$subject = "Thriive user is trying to connect to you";
	$msg = "Dear ".$therapist_name.",<br/>
			We are pleased to inform you that ".$seeker_name." wishes to connect with you.<br/><br/>
			Here are the contact details:<br/>
			Name: ".$seeker_name."<br/>
			Number.: ".$masked_number."<br/><br/>
			We have shared your details with them. They might get in touch with you. Hope you have a pleasant experience!<br/><br/>
			Keep Thriiving!<br/>
			Love & light,<br/>
			Team Thriive<br/><br/><br/>
			Note: This is an automatically generated email, please do not reply. For any further questions, please feel free to contact us at accountmanager1@thriive.in for help. ";

	sendEmail($therapist_email, $subject, $msg);

}

function send_mail_to_seeker($therapist,$seeker,$masked_number){

	$therapist_name = get_user_meta($therapist->ID,"first_name",true)." ".get_user_meta($therapist->ID,"last_name",true);
	$seeker_name = get_user_meta($seeker->ID,"first_name",true)." ".get_user_meta($seeker->ID,"last_name",true);
	$seeker_email = $seeker->user_email;

	$subject = "Thriive user is trying to connect to you";
	$msg = "Dear ".$seeker_name.",<br/>
			Thank you for your interest in connecting with our Thriive-verified Therapist ".$therapist_name.". We have sent you an SMS and an email with their details. Please feel free to get in touch with them to get healed :-)<br/><br/>  
				Here are the contact details:<br/>
				Name: ".$therapist_name."<br/>
				Number.: ".$masked_number."<br/><br/>
				We have shared your details with them. They might get in touch with you. Hope you have a pleasant experience!<br/><br/>
				Keep Thriiving!<br/>
				Love & light,<br/>
				Team Thriive<br/><br/><br/>
				Note: This is an automatically generated email, please do not reply. For any further questions, please feel free to contact us at accountmanager1@thriive.in for help.";

	sendEmail($seeker_email, $subject, $msg);
}

function send_mail_to_product_manager_thriive($therapist,$seeker,$r_masked_number,$c_masked_number){
	
	$subject = "Thriive user is trying to connect to a therapist";
	$msg = "Hello,<br/>User has tried to connect to a therapist.Following is the detail for both caller and the receiver<br/><br/>
		Therapist:".get_user_meta($therapist->ID,"first_name",true)." ".get_user_meta($therapist->ID,"last_name",true)."<br/>
		seeker:".get_user_meta($seeker->ID,"first_name",true)." ".get_user_meta($seeker->ID,"last_name",true)."<br/>

		Caller Masked Number:".$c_masked_number."<br/>
		Receiver Masked Number:".$r_masked_number;

	sendEmail("productmanager@thriive.in", $subject, $msg);
}

function send_sms_to_therapist($seeker,$therapist,$masked_number){

	$seeker_name = get_user_meta($seeker->ID,"first_name",true)." ".get_user_meta($seeker->ID,"last_name",true);
	$therapist_mobile = $therapist->mobile;

	$msg = $seeker_name ." + ".$masked_number." was calling you. We have shared your details with them. They might get in touch with you. Hope you have a pleasant experience! Keep Thriiving!";

	sendSMS($therapist_mobile,$msg);
}

function send_sms_to_seeker($seeker,$therapist,$masked_number){

	$therapist_name = get_user_meta($therapist->ID,"first_name",true)." ".get_user_meta($therapist->ID,"last_name",true);
	$seeker_mobile = $seeker->mobile;

	$msg = "Thank you for your interest in connecting with our Thriive-verified Therapist ".$therapist_name.".Here are the contact details:".$therapist_name." + ".$masked_number.".Hope you have a pleasant experience!";

	sendSMS($seeker_mobile,$msg);
}

function cron_delete_my_operator_assigned_users_dfc62ab2() {
	global $wpdb;
    $month_ago = date("Y-m-d",strtotime(date("Y-m-d",strtotime(date("Y-m-d")))."-1 month"));
    $wpdb->query("UPDATE my_operator_number_allocation SET is_deleted = 1 WHERE date(call_timestamp) = '".$month_ago."'");
}

function search_query_ailment() {
	$therapy_arr = [];
	$therapy_list = '';
	$therapies = get_therapy_by_ailment($_GET['ailments']);

	foreach($therapies as $key => $val) {
		array_push($therapy_arr, $val->slug);
		$therapy_list .= $val->slug;

		if($key != count($therapies) - 1) {
			$therapy_list .= ',';
		}
	}

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args = array(
		'post_type' => 'therapist',
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'therapy',
				'terms' => $therapy_arr,
				'field' => 'slug',
				'operator' => 'IN',
				'include_children' => 0
			)
		),
	);

	$custom_query = new WP_Query($args);

	// Pagination fix
	global $wp_query;
	$GLOBALS['temp_query'] = $wp_query;
	$wp_query   = NULL;
	$wp_query   = $custom_query;
}

function search_query_therapy() {
	$therapy = $_GET['therapy'];

	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args = array(
		'post_type' => 'therapist',
		'post_status' => 'publish',
		'posts_per_page' => 4,
		'paged' => $paged,
		'tax_query' => array(
			array(
				'taxonomy' => 'therapy',
				'terms' => $therapy,
				'field' => 'slug',
				'operator' => 'IN',
				'include_children' => 0
			)
		),
	);

	$custom_query = new WP_Query($args);

	// Pagination fix
	global $wp_query;
	$GLOBALS['temp_query'] = $wp_query;
	$wp_query   = NULL;
	$wp_query   = $custom_query;
}

function reset_main_query_object() {
	// Reset main query object
	global $wp_query;
	$wp_query = NULL;
	$wp_query = $GLOBALS['temp_query'];
	wp_reset_query();
}

// Get term by Slug
function get_term_by_slug($slug, $type) {
	$term = get_term_by('slug', $slug, $type);
	return $term->name;
}

function register_geolocation_menu_page() {
    add_menu_page('Geolocation Page', 'Geolocation', 'add_users', 'geolocationpage', '_geolocation_menu_page', null, 6); 
}
add_action('admin_menu', 'register_geolocation_menu_page');

function _geolocation_menu_page(){
   echo "<h1>Insert location area and code</h1><form action='' method='post'><button type='submit' name='insertgeolocation'>Insert</button><br/><br/><button type='submit' name='emptygeolocation'>Empty</button><br/><br/><button type='submit' name='insertavgrating'>Insert Rating</button></form>";  
}

if(isset($_POST['insertavgrating'])){
	$args = array (
	    'post_type' => 'therapist',
	    'post_status' => 'publish',
	    'orderby' => ASC,
	    'posts_per_page' => -1
	);

	// The Query
	$wp_query = new WP_Query( $args );
	if($wp_query->have_posts()) {
		while($wp_query->have_posts()) {
			$wp_query->the_post();
	      	$post_id = get_the_id();
	      	update_field('avg_rating','4',$post_id);
		}
	}
}

if(isset($_POST['insertgeolocation'])){
	$tempPostid = array();
	$args = array (
	    'post_type' => 'therapist',
	    'post_status' => 'publish',
	    'orderby' => ASC,
	    'posts_per_page' => -1
	);

	// The Query
	$wp_query = new WP_Query( $args );
	if($wp_query->have_posts()) {
		while($wp_query->have_posts()) {
			$wp_query->the_post();
	      	$post_id = get_the_id();
	      	update_post_area($post_id);
		}
	}
} 

if(isset($_POST['emptygeolocation'])){
	$tempPostid = array();
	$args = array (
	    'post_type' => 'therapist',
	    'post_status' => 'publish',
	    'orderby' => ASC,
	    'posts_per_page' => -1
	);

	// The Query
	$wp_query = new WP_Query( $args );
	if($wp_query->have_posts()) {
		while($wp_query->have_posts()) {
			$wp_query->the_post();
	      	$post_id = get_the_id();
	      	update_field('area','',$post_id);
		    update_field('latitude','',$post_id);
		    update_field('longitude','',$post_id);
	    }
	}
}

function find_zipcode($filename, $zipcode) {
    $f = fopen($filename, "r");
    $result = array();
    while ($row = fgetcsv($f)) {
        if ($row[1] == $zipcode) {
        	$area_city = $row[0].", ".$row[2];
            array_push($result,$area_city);
        }
    }
    fclose($f);
    return $result;
}

function getLatLng($address){
	$results = array();
	$rp_address = str_replace(' ', '+', $address);

	$ch = curl_init("https://maps.googleapis.com/maps/api/geocode/json?address=".$rp_address."&key=AIzaSyCkzH5PXPkf-Er-f6EEEsRQfYSBzzFD6K4");
	
    // Returns the data/output as a string instead of raw data
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Good practice to let people know who's accessing their servers. See https://en.wikipedia.org/wiki/User_agent
    curl_setopt($ch, CURLOPT_USERAGENT, 'YourScript/0.1 (contact@email)');
    
    //Set your auth headers
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $TOKEN
        ));
    
    // get stringified data/output. See CURLOPT_RETURNTRANSFER
    $data = curl_exec($ch);
    
    // get info about the request
    $info = curl_getinfo($ch);
    
    $decodeData = json_decode($data);

    curl_close($ch);
	$results['area'] = $address;
	$results['city'] = extractFromAdress($decodeData->results[0]->address_components,'locality');
	$results['lat'] = $decodeData->results[0]->geometry->location->lat;
	$results['lng'] = $decodeData->results[0]->geometry->location->lng;
    return $results;
} 

function update_post_area($post_id){
	$address = get_field("address", $post_id);
  	$zipcode = get_field("zipcode", $post_id);
  	$area = get_field("area", $post_id);
  	if($zipcode != "" && empty($area)){
  		$get_area_lists_by_zipcode = find_zipcode(get_template_directory()."/framework/list-of-area-by-zipcodes.csv",$zipcode);
  		$getLatLng = getLatLng($zipcode);
  		if(count($get_area_lists_by_zipcode) > 1){
      		foreach ($get_area_lists_by_zipcode as $csv_area) {
      			if(empty($area)){
	      			$spiltAreaCity = explode(",", $csv_area);
	      			if(strpos( strtolower($address), strtolower($spiltAreaCity[0]) ) !== false) {
	      				update_field('area',$csv_area,$post_id);
					}
					update_field('latitude',$getLatLng['lat'],$post_id);
					update_field('longitude',$getLatLng['lng'],$post_id);
				}
      		}
      	} else {
	    	update_field('area',$get_area_lists_by_zipcode[0],$post_id);
		    update_field('latitude',$getLatLng['lat'],$post_id);
		    update_field('longitude',$getLatLng['lng'],$post_id);
	    }
	    if(empty(get_field("area", $post_id)) && !empty(get_field("latitude", $post_id)) && !empty(get_field("longitude", $post_id))){
	    	update_field('area',$get_area_lists_by_zipcode[0],$post_id);
	    }
  	}
}

function my_acf_save_post($post_id) {
	global $post;
	if($post->post_type == 'therapist'){
		// if (get_post_meta($post_id, 'review_details')) {
		// 	$existingRows = get_post_meta($post_id, 'review_details', true);
		// 	if($existingRows > 0){
		// 		$avgrate = calculateAvgRating($post_id,$existingRows);
		// 		update_field('avg_rating',$avgrate,$post_id);
		// 	}
		// }
		if(empty(get_field("area", $post_id))){
			update_post_area($post_id);
		}
	}
}

function post_published_notification( $ID, $post ) {
	$regdate = current_time('d-m-Y H:i:s');
    update_field('t_registration_date',$regdate, $ID);
}

function custom_posts_table_head( $columns ) {
    $columns['t_registration_date']  = 'Registration Date';
    return $columns;
}

function custom_posts_table_content( $column_name, $post_id ) {
    if( $column_name == 't_registration_date' ) {
        $t_regiration_date = get_post_meta( $post_id, 't_registration_date', true );
        echo $t_regiration_date;
    }
}
?>