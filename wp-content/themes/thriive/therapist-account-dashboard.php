 
<?php /* Template Name: Therapist account dashboard */ ?>
<?php
	if (!is_user_logged_in()) 
	{ 
		wp_redirect('/login/');
		exit();
	} 
	else 
	{
		$current_user = wp_get_current_user();
		
		if(get_post_status($current_user->post_id)=='pending-payments' || get_post_status($current_user->post_id) != 'publish') 
		{
			wp_redirect(get_permalink(274));
		}		
		$address =json_decode($current_user->address);
		$userPost = get_post($current_user->post_id);
		//if user's role is subscriber then redirect to seeker dashboard 
		if($current_user->roles[0] == 'subscriber')
		{
			wp_redirect('my-account-page/');
			exit();
		}
	}
/*
	
	echo "<pre>";
	print_r($userPost);
	echo "</pre>";
*/
	
?>
<?php get_header(); ?>





<section class="dashboard-head">
	<div class="container therapist-dashboard-container">
		<div class="row">
			<div class="col-lg-4 col-md-4 col-sm-12 col-12 wrapper-listing-post">						
				<div class="healer-circle mt-3">
					<div class="inner-healer-circle">
						<?php  echo wp_get_attachment_image($userPost->profile_picture);?>
					</div>
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/icon-mark.png" class="verify-img" alt="">
				</div>					
			</div>
			<div class="col-lg-7 col-md-8 col-sm-12 col-12 txt-wrap">
				<h3 class=""><?php echo $current_user->first_name.' '.$current_user->last_name;?></h3>
				<p><?php echo get_field("therapist_title",$userPost->ID); ?></p>
				<p class="localtion-wrapper"><?php echo $userPost->about;?></p>

					<div class="my-event-btn">
						<a class="btn secondary-btn btn_box1" href="<?php echo get_permalink(274); ?>?edit-step=1">
							<img src="http://35.232.100.164/wp-content/themes/thriive/assets/images/editprofile_icon.png" class="iconz1" alt="">
							<span class="icon_txt1">EDIT PROFILE</span>
						</a>
						<a class="btn secondary-btn btn_box1" data-toggle="modal" data-target="#delete_user_popup">
							<img src="http://35.232.100.164/wp-content/themes/thriive/assets/images/delete_icon.png" class="iconz1" alt="">
							<span class="icon_txt1">DELETE PROFILE</span>
						</a>
						<a class="btn secondary-btn btn_box1 create_badge" data-toggle="modal" data-target="#show_badge">
							<img src="http://35.232.100.164/wp-content/themes/thriive/assets/images/chat_icon.png" class="iconz1" alt="">
							<span class="icon_txt1">VIEW BADGE</span>
						</a>
						<a class="btn secondary-btn btn_box1" href="<?php echo site_url().'/therapist-chat-history/'?>">
							<img src="http://35.232.100.164/wp-content/themes/thriive/assets/images/newchat_icon.png" class="iconz1" alt="">
							<span class="icon_txt1">VIEW CHAT</span>
						</a>
						<a class="btn secondary-btn btn_box1" href="<?php echo site_url().'/seeker-my-account-edit/?download_report=yes'?>">
							<img src="http://35.232.100.164/wp-content/themes/thriive/assets/images/chat_icon.png" class="iconz1" alt="">
							<span class="icon_txt1">EXPORT CHAT</span>
						</a>
					</div>
				
				<?php if(isset($_GET['download_report']))
					{
						export_csv();
					}
				?>
				
				
			</div>
		</div>
		
		<div class="row section">	
			<div class="col-12 col-sm-7 d-flex mx-auto p-0 therpist-dashboard-btn-wrapper">
				<?php
				$badge_image = get_field('badge_image', $userPost->ID);
				//if ($badge_image) {
				    ?>
					<!--
				    <div class="col text-center">
				        <a href="" download="badge_image.png" class="btn btn-primary btn-dashboard badge-btn" download>BADGE</a>
				    </div>
					-->	
				<?php //} ?>
				<div class="col  text-center">
					<a href="/change-password/" class="btn btn-primary btn-dashboard">CHANGE PASSWORD</a>
				</div>
				
				<div class="col p-0 text-center">
					<?php $therapist_url = get_site_url().'/therapist/'.$userPost->post_name; ?>
					<a href="<?php echo $therapist_url; ?>" class="btn btn-primary btn-dashboard">PREVIEW PROFILE</a>
				</div>
				<div class="col p-0 text-center">
					<button type="button" class="btn btn-primary btn-dashboard mt-0 mb-0"><i class="icon-new-share p-1"></i>SHARE</button>
					<div class="thriive-social-block hide-block mb-3 mt-3"> 				
						<?php //if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { ADDTOANY_SHARE_SAVE_KIT(); } ?>
						<?php echo do_shortcode("[addtoany url='$therapist_url']"); ?>
					</div>
				</div>
			</div>
		</div>
		
		
		
		<div class="m-4 divider"></div>		
		
	
		</div>
		<div class="row section">
			
			<div class="col-12 col-sm-7 d-flex mx-auto count-wrapper">
				<div class="col text-center">
					<?php 
				$current_user = wp_get_current_user();
				?>	
				<input type="hidden" name = "session_user" id="session_user" value="<?php echo $current_user->ID ?>" />
			<?php 
				
		//print_r($therapist_details);
				$result = fetch_user_subscriber();
				$output = '<table class="table table-bordered table-striped desk_tablevw"><tr> <th widht="30%">User Name</th><td widht="20%">Last Conversation (Date&Time)</td><th width="10%">Action</th></tr>';
				
				foreach($result as $row)
				{
				$therapist_details = get_userdata($row->from_user_id);
				$therapist_email = $therapist_details->data->user_email;
			$current_user = wp_get_current_user();
		     $seeker_email = $current_user->user_email;
		 $seeker_name = $current_user->display_name;
					$last_coversation = last_login_chat($row->from_user_id,$row->to_user_id);
		//echo $current_user->role;
		$msg = $seeker_name ." was trying to contact,when you were offline" ;
		 $seeker_id = $current_user->ID;
		if($seeker_id != '')
			$from_status = 1;
		else
		$from_status = 0;	
		$therapist_id = $therapist_details->ID;
 if(is_user_online($therapist_id))
{
   $to_status = 1;
 }
 else
 {
	  $to_status = 0;
 }
		?>
				<input type="hidden" name = "mobile_<?php echo $therapist_id ?>" id="mobile_<?php echo $therapist_id ?>" value="<?php echo $therapist_mobile[0]; ?>" />
		<input type="hidden" name = "countrycode_<?php echo $therapist_id ?>" id="countrycode_<?php echo $therapist_id ?>" value="<?php echo $therapist_countrycde[0]; ?>" />
		<input type="hidden" name = "msg<?php echo $therapist_id ?>" id="msg_<?php echo $therapist_id ?>" value="<?php echo $msg ?>" />	
		
				<?php 
		$therapist_mobile = get_user_meta($therapist_id,'mobile');
			$therapist_countrycde = get_user_meta($therapist_id,'countryCode');	
					 $output .= '<tr><td>'.$therapist_details->data->display_name.'</td><td>'.$last_coversation.'</td><td id="start_chat_button_'.$therapist_id.'"><button type="button" class="btn btn-info btn-xs start_chat" data-fromuserid = "'.$seeker_id.'" data-touserid="'.$therapist_id.'" data-tousername="'.$therapist_details->data->display_name.'" data-from_status = "'.$from_status.'" data-to_status = "'.$to_status.'" data-role ="'.$current_user->role.'" data-mobile="'.$therapist_countrycde[0].$therapist_mobile[0].'" data-msg="'.$msg.'" data-email="'.$therapist_email.'" >Start Chat</button></td>
 </tr>
 ';
					
				}
				$output .= '</table>';
echo $output;

// mobile view starts here
$output2 = '<section class="mobi_tableview">
<div class="container">
	<div class="row">
		<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12"><table class="table">';
				
				foreach($result as $row)
				{
				$therapist_details = get_userdata($row->from_user_id);
				$therapist_email = $therapist_details->data->user_email;
			$current_user = wp_get_current_user();
		     $seeker_email = $current_user->user_email;
		 $seeker_name = $current_user->display_name;
					$last_coversation = last_login_chat($row->from_user_id,$row->to_user_id);
		//echo $current_user->role;
		$msg = $seeker_name ." was trying to contact,when you were offline" ;
		 $seeker_id = $current_user->ID;
		if($seeker_id != '')
			$from_status = 1;
		else
		$from_status = 0;	
		$therapist_id = $therapist_details->ID;
 if(is_user_online($therapist_id))
{
   $to_status = 1;
 }
 else
 {
	  $to_status = 0;
 }
		?>
				<input type="hidden" name = "mobile_<?php echo $therapist_id ?>" id="mobile_<?php echo $therapist_id ?>" value="<?php echo $therapist_mobile[0]; ?>" />
		<input type="hidden" name = "countrycode_<?php echo $therapist_id ?>" id="countrycode_<?php echo $therapist_id ?>" value="<?php echo $therapist_countrycde[0]; ?>" />
		<input type="hidden" name = "msg<?php echo $therapist_id ?>" id="msg_<?php echo $therapist_id ?>" value="<?php echo $msg ?>" />	
		
				<?php 
		$therapist_mobile = get_user_meta($therapist_id,'mobile');
			$therapist_countrycde = get_user_meta($therapist_id,'countryCode');	
					 $output2 .= '<tbody><tr><th widht="30%">User Name</th><td>'.$therapist_details->data->display_name.'</td></tr> <tr><th widht="20%">Last Conversation (Date&Time)</th><td>'.$last_coversation.'</td></tr> <tr><th width="10%">Action</th><td id="start_chat_button_'.$therapist_id.'"><button type="button" class="btn btn-info btn-xs start_chat" data-fromuserid = "'.$seeker_id.'" data-touserid="'.$therapist_id.'" data-tousername="'.$therapist_details->data->display_name.'" data-from_status = "'.$from_status.'" data-to_status = "'.$to_status.'" data-role ="'.$current_user->role.'" data-mobile="'.$therapist_countrycde[0].$therapist_mobile[0].'" data-msg="'.$msg.'" data-email="'.$therapist_email.'" >Start Chat</button></td></tr></tbody>';
					
				}
				$output2 .= '</table></div></div></div></section>';

				echo $output2;
// mobile view ends here
			
		?>
				</div>
						</div>
			
			<div class="col-12 col-sm-7 d-flex mx-auto count-wrapper">
				<div class="col text-center">
					<p class="count-highlight count_txtHighliter">
						<?php 
							$totalContactedSeeker = explode(",",$current_user->contacted_seeker_id);
							if($totalContactedSeeker)
							{ 
								echo count(array_filter($totalContactedSeeker));
							}
							else
							{ 
								echo "0"; 
								
							} 
						?>
					</p>
					<h3 class="seek_txt">Seekers Who Contacted</h3>
				</div>
				
				<div class="col text-center">
					<p class="count-highlight count_txtHighliter">
						<?php
							$currentPost = get_post_meta($current_user->post_id);
							$current_count = $currentPost['page_visit'][0];
							if($current_count)
							{ 
								echo $current_count;
							}
							else
							{  	
								echo "0";						
							} 
						?>
					</p>
					<h3 class="seek_txt">Seekers Who Showed Interest</h3>
				</div>
			</div>
		</div>
		<div class="m-4 divider"></div>
	</div>
</section>

<section class="dashboard-content">
	<div class="container">
		<!--<div class="row section review-seeker">
			<h4 class="col-12 col-sm-7 mx-auto">Seeker Reviews</h4>
		
			<?php  for ($x = 1; $x < 4; $x++) {
				$keyValue = 'ref_'.$x;
				if($x==1){
				  	$refName = $userPost->first_reference_name;
				} else if($x==2){
					$refName = $userPost->second_reference_name;
				} else if($x==3){
					$refName = $userPost->third_reference_name;
				}
			?>
		
			<div class="col-12 col-sm-7 mx-auto mt-2">
				<p><?php echo $current_user->$keyValue;?></p>
				<div class="text-highlight"><?php echo $refName;?></div>
			</div>
			
			
			<?php  } ?>
		</div>
		<div class="m-4 divider"></div>-->
		<?php $package = get_post($userPost->select_package[0]); 
			$transaction = get_post($current_user->transaction);
			$valid_till = get_field("end_date",$current_user->transaction);
		?>
		<div class="row dashboard-package">
			<div class="col-lg-4 col-md-4 col-sm-3 col-12">
				<div class="package-wrapper">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images//package3.png" class="img-fluid mobi_picDashbrd" alt="">
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-sm-9 col-12">
				<h6 class="mobi_headtxt"><?php echo $package->post_title;?> package </h6>
				<div class="package-price mobi-pckgCont">
						<span class="package-price">INR <?php echo $package->package_charges;?>/-</span>
						<p class="mt-1">
							<?php
								if($valid_till)
								{
									echo "Valid Till : " . $valid_till;
								}
							?>
						</p>
					</div>
			</div>
			<div class="col-12 p-0 col-sm-7 mt-4 d-flex mx-auto ">
				<?php if($package->post_title != 'Fire'){ ?>
				<div class="col-6">
					 <button type="button" class="btn btn-primary btnMobi" onclick="location.href='<?php echo get_permalink(406) . "/?action=upgrade-package"; ?>';">UPGRADE</button>
				</div>
				<?php } ?>
				
				<div class="col-6">
					<a href="<?php echo site_url(); ?>/package-details/" class="btn btn-primary btnMobi" target="_blank">KNOW MORE</a>
				</div>
				
				<div class="col">
					<?php
						if($package->package_charges > 0)
						{
							$codeD = $current_user->user_email.$current_user->ID . time();  
							$code = sha1( $codeD );
							$renewal_url = get_permalink(274) . "/?package=renew&token=" . $code . "&token_id=" . $current_user->ID . "&token_for=" . $current_user->user_email;
							?> <a href="<?php echo get_permalink(406) . "/?action=renew-package"; ?>"><button type="button" class="btn btn-primary btnMobi">RENEW</button></a> <?php
						}
					?>
				</div>
				
			</div>
		</div>
		<div class="m-4 divider"></div>
		<div class="row section dashboard-therapies-details">
			<div class="col-12 col-sm-7 d-flex mx-auto mt-3 p-0">
				<div class="col-4 col-sm-4">
					<h6>Therapies</h6>
				</div>
				<div class="col-6 col-sm-6">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo calculateProgress((($userPost->therapy) ? $userPost->therapy :0),$package->number_of_therapies);?>" aria-valuemin="0" aria-valuemax="100" <?php if($package->post_title != 'Fire'){ ?> style="width:<?php echo calculateProgress($userPost->therapy,$package->number_of_therapies);?>%" <?php } ?>></div>
					</div>
					<div class="text-center text-highlight"><?php echo ($userPost->therapy) ? $userPost->therapy :0; ?> / <?php if($package->post_title == 'Fire'){ echo "&infin;"; }else { echo $package->number_of_therapies; } ?></div>
					<div class="sub-text">To add more therapies contact us at accountmanager1@thriive.in</div>
				</div>
				
				<div class="col-2">
					<a href="edit-therapies" class="text-highlight link-dashboard-details">></a>
				</div>
				
			</div>
			<div class="col-12 col-sm-7 d-flex mx-auto mt-3 p-0">
				<div class="col-4 col-sm-4">
					<h6>Gallery Images</h6>
				</div>
				<div class="col-6 col-sm-6">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo calculateProgress($userPost->gallery,$package->number_of_images);?>"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo calculateProgress($userPost->gallery,$package->number_of_images);?>%"></div>
					</div>
					<div class="text-center text-highlight"><?php echo (($userPost->gallery ) ? $userPost->gallery :0);?> / <?php echo $package->number_of_images;?></div>
					<div class="sub-text">Add images to enhance your profile page</div>
				</div>
				
				<div class="col-2">
					<a href="my-gallery" class="text-highlight link-dashboard-details">></a>
				</div>
				
			</div>
			<div class="col-12 col-sm-7 d-flex mx-auto mt-3 p-0">
				<div class="col-4 col-sm-4">
					<h6>Gallery Videos</h6>
				</div>
				<div class="col-6 col-sm-6">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo calculateProgress($userPost->videos,$package->number_of_videos);?>"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo calculateProgress($userPost->videos,$package->number_of_videos);?>%"></div>
					</div>
					<div class="text-center text-highlight"><?php echo (($userPost->videos ) ? $userPost->videos :0);?> / <?php echo $package->number_of_videos;?></div>
					<div class="sub-text">Add videos to enhance your profile page</div>
				</div>
				
				<div class="col-2">
					<a href="/my-gallery" class="text-highlight link-dashboard-details">></a>
				</div>
				
			</div>
			<div class="col-12 col-sm-7 d-flex mx-auto mt-3 p-0">
				<div class="col-4 col-sm-4">
					<h6>Event/ Workshops</h6>
				</div>
				<div class="col-6 col-sm-6">
					<?php
						$createdThriiveEvent = explode(",",get_user_meta($current_user->ID,'my_events',true));
						$createdThriiveEvent = count(array_filter($createdThriiveEvent));
					?>
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo calculateProgress($createdThriiveEvent,$package->number_of_events);?>"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo calculateProgress($createdThriiveEvent,$package->number_of_events);?>%"></div>
					</div>
					<div class="text-center text-highlight"><?php echo $createdThriiveEvent; ?> / <?php echo $package->number_of_events;?></div>
					<div class="sub-text">You can upload an event on your profile page but promotion and listing of the event on our website is only available for Water/Fire package.</div>
				</div>
				
				<div class="col-2">
					<a href="<?php echo get_permalink(1909); ?>" class="text-highlight link-dashboard-details">></a>
				</div>
				
			</div>
			<div class="col-12 col-sm-7 d-flex mx-auto mt-3 p-0">
				<div class="col-4 col-sm-4">
					<h6>My Blog</h6>
					<?php
						//echo get_post_meta($current_user->post_id, 'my_blogs');
						//print_r(count(get_post_meta($current_user->post_id, 'my_blogs')[0]));
					?>
				</div>
				<div class="col-6 col-sm-6">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow=""aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
					</div>
					<div class="text-center text-highlight"><?php echo count(array_filter(get_field('my_blogs', $current_user->post_id))); ?> / &infin;</div>
					<div class="sub-text">Articles added here will be displayed on your profile page</div>
				</div>
				
				<div class="col-2">
					<a href="<?php echo get_permalink(1873); ?>" class="text-highlight link-dashboard-details">></a>
				</div>
				
			</div>
			<div class="col-12 col-sm-7 d-flex mx-auto mt-3 p-0">
				<div class="col-4 col-sm-4">
					<h6>Request For Blog</h6>
				</div>
				<div class="col-6 col-sm-6">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo calculateProgress((($userPost->request_for_blog) ? $userPost->request_for_blog :0),$package->request_for_blog);?>"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo calculateProgress((($userPost->request_for_blog) ? $userPost->request_for_blog :0),$package->request_for_blog);?>%"></div>
					</div>
					<div class="text-center text-highlight"><?php echo (($userPost->request_for_blog) ? $userPost->request_for_blog :0);?> / <?php echo $package->request_for_blog;?></div>
					<div class="sub-text">Get featured in our blogs.This feature is available only for Fire package.</div>
				</div>
				
				<div class="col-2">
					<?php 
					$blogRequestCount =  (($userPost->request_for_blog) ? $userPost->request_for_blog :0);
					if(($blogRequestCount)<($package->request_for_blog)){
					?>
						<a href="#" data-toggle="modal" data-target="#request_for_blog"  class="text-highlight link-dashboard-details">></a>
					<?php 	
					}
					?>
					
				</div>
				
			</div>
			<div class="col-12 col-sm-7 d-flex mx-auto mt-3 p-0">
				<div class="col-4 col-sm-4">
					<h6>Request For Newsletters</h6>
				</div>
				<div class="col-6 col-sm-6">
					<div class="progress">
						<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo calculateProgress((($userPost->request_for_news_letter) ? $userPost->request_for_news_letter :0),$package->request_for_news_letter);?>"aria-valuemin="0" aria-valuemax="100" style="width:<?php echo calculateProgress((($userPost->request_for_news_letter) ? $userPost->request_for_news_letter :0),$package->request_for_news_letter);?>%"></div>
					</div>
					<div class="text-center text-highlight"><?php echo (($userPost->request_for_news_letter) ? $userPost->request_for_news_letter :0);?> / <?php echo $package->request_for_news_letter;?></div>
					<div class="sub-text">Get featured in our newsletter.This feature is available only for Fire package</div>
				</div>
				
				
				<div class="col-2">
					<?php 
					$newslRequestCount =  (($userPost->request_for_news_letter) ? $userPost->request_for_news_letter :0);
					if(($newslRequestCount)<($package->request_for_news_letter)){
					?>
						<a href="#" data-toggle="modal" data-target="#request_for_news" class="text-highlight link-dashboard-details">></a>
					<?php 	
					}
					?>
					
				</div>
				
			</div>
			
		</div>
		<div class="m-4 divider"></div>
		
		<div class="row section pb-5">
			<div class="col-12 col-sm-7 mx-auto text-center">
				<p>For any additional requirements contact your account manager</p>
				 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#request_popup">CONTACT ACCOUNT MANAGER</button>
			</div>
		</div>
		
		
	</div>
</section>
<!--
<div class="badge_wrapper">
	<p><?php echo $current_user->first_name.' '.$current_user->last_name;?></p>
</div>
<div class="badge_wrapper_download"></div>
-->


 <div class="modal fade" id="show_badge" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
      
        <!-- Modal body -->
        <div class="modal-body">
        	 <button type="button" class="close" data-dismiss="modal">&times;</button>
        	<div class="badge_view_wrapper">
				<p><?php echo $current_user->first_name.' '.$current_user->last_name;?></p>
			</div>
			<div class="text-center">
				<a href="" download="badge_image.png" class="badge-btn" download> <i class="fa fa-download" aria-hidden="true"></i> DOWNLOAD BADGE</a>
			</div>
        	               
        </div>
      </div>
    </div>
 </div>

<?php get_footer(); ?>

  
   
  

