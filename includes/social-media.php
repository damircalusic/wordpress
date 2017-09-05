<?php 
if ( !defined('ABSPATH')){ exit; }

/*
* Get the latest Facebook post from a user/page
* Get the $page_id from http://findmyfbid.com/
*/
function wktheme_get_facebook_post(){
	$page_id = ($page_id_faceb == '') ? '******' : $page_id_faceb;
	$access_token = '1695809097367668|05b97bfdcc780ee5fe1af0a5d745889e';
	$api_url = 'https://graph.facebook.com/v2.5/'.$page_id.'/posts';
	$limit = 1;
	$sanitized_blogname = sanitize_title(get_bloginfo('name'));
	$key = $sanitized_blogname.'_facebook_'.md5($sanitized_blogname.'_facebook_key',$limit);
	
	if(false === ($fb_feed = get_transient($key))){
		$response = wp_remote_get( 
						add_query_arg( 
							array(
								'access_token' => esc_html($access_token),
								'limit' => absint($limit),
								'fields' => esc_html('id,caption,description,link,message,object_id,full_picture,type'),
							), 
							$api_url 
						) 
					);
		
		// Is the API up?
		if(!200 == wp_remote_retrieve_response_code($response)){
			return false;
		}
		
		// Parse the API data and place into an array
		$fb_feed = json_decode( wp_remote_retrieve_body( $response ), true );

		// Are the results in an array?
		if(!is_array($fb_feed)){
			return false;
		}
		
		$fb_feed = maybe_unserialize($fb_feed);
		
		// Store Facebook in a transient, and expire every hour
		set_transient($key, $fb_feed, apply_filters($sanitized_blogname.'_facebook_cache_lifetime', 1 * HOUR_IN_SECONDS));
	}
	
	// Check so we get something from facebook!
	if(!empty($fb_feed)){ 
		// Check so DATA exists!
		if(!empty($fb_feed["data"])){
			$data_counter = 0;
			
			foreach($fb_feed["data"] as $data){
				// What type of post is it?
				if($fb_feed["data"][$data_counter]["type"] == 'message' || $fb_feed["data"][$data_counter]["type"] == 'video'){
					$message = (!empty($fb_feed["data"][$data_counter]["message"]) ? '<p>'.mb_substr($fb_feed["data"][0]["message"],0,220,'UTF-8').'<a href="'.$data["link"].'" target="_blank">...</a></p>' : '');
					
					echo '<div id="fb-post" class="fb-post-'.$data_counter.'">'.$message.'</div>';
				}
				elseif($fb_feed["data"][$data_counter]["type"] == 'photo'){
					$message = (!empty($fb_feed["data"][$data_counter]["message"]) ? '<p>'.mb_substr($fb_feed["data"][$data_counter]["message"],0,220,'UTF-8').'<a href="'.$data["link"].'" target="_blank">...</a></p>' : '');
					
					//<img src="'.$fb_feed["data"][0]["full_picture"].'" width="580" height="400" alt="" />
					echo '<div id="fb-post" class="fb-post-'.$data_counter.'"><img src="'.$fb_feed["data"][0]["full_picture"].'" width="580" height="400" alt="" /></div>';
				}
				elseif($fb_feed["data"][$data_counter]["type"] == 'link'){
					$message = (!empty($fb_feed["data"][$data_counter]["message"]) ? '<p>'.mb_substr($fb_feed["data"][$data_counter]["message"],0,220,'UTF-8').'<a href="'.$data["link"].'" target="_blank">...</a></p>' : '');
					$img = (!empty($fb_feed["data"][$data_counter]["full_picture"])) ? '<img src="'.$fb_feed["data"][$data_counter]["full_picture"].'" width="580" height="400" alt="" />' : '';
					
					echo '<div id="fb-post" class="fb-post-'.$data_counter.'">'.$img.$message.'</div>';
				}
				
				$data_counter++;
			}
			
			//echo '<div id="fb-post" class="fb-post-0"><a class="yellowbtn" href="" target="_blank">'.__('Läs mer på Facebook','lvm').'</a></div>';
			
		}
	}
}

/*
* Get the latest Instagram post from a user
* https://smashballoon.com/instagram-feed/find-instagram-user-id/
* http://jelled.com/instagram/lookup-user-id
*/
function wktheme_get_instagram_feed(){
	$user_id = '***';
	$client_id = '3a81a9fa2a064751b8c31385b91cc25c';
	$access_token = '1808017486.3a81a9f.bfd5c0d3fe8c4da2a4dad5c47308da5b';
	$api_url = 'https://api.instagram.com/v1/users/'.$user_id.'/media/recent/';
	$limit = 4;
	$sanitized_blogname = sanitize_title(get_bloginfo('name'));
	$key = $sanitized_blogname.'_instagram_'.md5($sanitized_blogname.'_instagram_key', $limit);
	
	// If no client id, bail
	if(empty($client_id)){
		return false;
	}

	// Check for transient
	if(false === ($instagrams = get_transient($key))){
		$response = wp_remote_get(
						add_query_arg(
							array(
								'client_id' => $client_id,
								'access_token' => esc_html($access_token),
								'count' => absint($limit)
							), 
							$api_url
						)
					);
					
		// Is the API up?
		if(!200 == wp_remote_retrieve_response_code($response)){
			return false;
		}
		
		// Parse the API data and place into an array
		$instagrams = json_decode(wp_remote_retrieve_body($response), true);
		
		// Are the results in an array?
		if(!is_array($instagrams)){
			return false;
		}
		
		$instagrams = maybe_unserialize($instagrams);
		
		// Store Instagrams in a transient, and expire every hour
		set_transient( $key, $instagrams, apply_filters( $sanitized_blogname . '_instagram_cache_lifetime', 1 * HOUR_IN_SECONDS ) );
	}
	
	// Check so we get something from Instagram!
	if(!empty($instagrams)){
		
		// Check so DATA exists!
		if(!empty($instagrams['data'])){
			echo '<ul id="instagram-feed">';
			foreach($instagrams['data'] as $insta){
				$img_url = explode("?",$insta['images']['low_resolution']['url']);
				echo '<li class="instagram-picture"><a href="'.$link[0].'" rel="nofollow" target="_blank"><img src="'.$img_url[0].'" width="'.$insta['images']['low_resolution']['width'].'" height="'.$insta['images']['low_resolution']['height'].'" alt="'.$insta['user']['full_name'].'" /></a></li>';
			}
			echo "</ul>";
		}
	}
}
