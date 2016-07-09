<?php

/**
 * Name: Sharing Economy
 * Description: Desc will follow
 * Version: 0.1
 * Author: Lukas Adrian
 * Maintainer: none
 */

 
require_once('functions.php');
require_once('include/message.php');

function sharingecon_post(&$a){
	if(isset($_POST['input-function'])){
		switch($_POST['input-function']){
			case "add-new-share":
				$data = array(
					"owner" => App::$channel['channel_hash'],
					"title" => strip_tags($_POST['input-title']),
					"shortdesc" => strip_tags($_POST['input-short-desc'])
				);
				echo add_new_share($data);
				break;
			case "load-shares":
				echo load_shares();
				break;
			
			case "write-message":
				$recipient = getShareOwner($_POST['input-message-shareid']);
				write_message($recipient, $_POST['input-message-subject'], $_POST['input-message-body']);
				break;
		}
		header("Location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
}

function sharingecon_load() {}

function sharingecon_unload() {}

function sharingecon_init(){
	head_add_css('addon/sharingecon/bootstrap_sharecon.css');
}

function sharingecon_module() {}

function get_shares_list($args){
	$data = load_shares($args);

	$result = "";
	for($i=0; $i<count($data); $i++){
		if($args['ownerview']){
			$status='active';
			$statustext='Deactivate';
			
			if($data[$i]['Status']==1){
				$status='inactive';
				$statustext='Activate';
			}
			$result .= replace_macros(get_markup_template('share_min_owner.tpl','addon/sharingecon/'), array(
			'$shareid' 		=> $data[$i]['ID'],
			'$title' 		=> $data[$i]['Title'],
			'$shortdesc' 	=> $data[$i]['ShortDesc'],
			'$btntoggle'	=> $status,
			'$btntoggletext' => $statustext
			));
		}
		else{
			$result .= replace_macros(get_markup_template('share_min.tpl','addon/sharingecon/'), array(
			'$shareid' 		=> $data[$i]['ID'],
			'$title' 		=> $data[$i]['Title'],
			'$shortdesc' 	=> $data[$i]['ShortDesc']
			));
		}
	}
	return $result;
}

function view_share_details($shareid){
	
	$share_data = load_share_details($shareid);
	
	$content = replace_macros(get_markup_template('share_details.tpl', 'addon/sharingecon/'), array(
		'$title'		=> $share_data['Title'],
		'$sharebody'	=> $share_data['LongDesc'],
		'$shareid'		=> $shareid
		));
	
	return $content;
}

function write_message($rec, $subject, $body){
		echo $rec . $subject . $body;
		send_message(null, $rec, $body, $subject);
}


function sharingecon_content(&$a) {
	$siteContent = '<script src="addon/sharingecon/main_js.js" type="text/javascript"></script>';
	
	App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array());
	if(argc() > 1){
		switch(argv(1)){
			case 'myshares':
				$pageContent = get_shares_list(array(
					'owner' => App::$channel['channel_hash'],
					'ownerview' => true
					));
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
					'$tab1' => 'active',
					'$pagecontent' => $pageContent
				));
				break;
				
			case 'findshares':
				$pageContent = get_shares_list(array());
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
					'$tab2' => 'active',
					'$pagecontent' => $pageContent
				));
				break;
				
			case 'viewshare':
				$siteContent .= view_share_details(argv(2));
				break;
				
			case 'newshare':
				$siteContent .= replace_macros(get_markup_template('new_share.tpl','addon/sharingecon/'), array(
					'$title' => 'Add new Share',
					'$function' => 'add-new-share',
					'$submitbutton' => 'Add Share'
				));
				break;
			
			case 'editshare':
				$data = load_share_details(argv(2));
				$siteContent .= replace_macros(get_markup_template('edit_share.tpl','addon/sharingecon/'), array(
					'$title' => 'Edit Share',
					'$function' => 'edit-share',
					'$additional' => '<input type="hidden" name="input-function" value="'. argv(2) . '">',
					'$titlevalue' => $data['Title'],
					'$shortdescvalue' => $data['ShortDesc'],
					'$longdescvalue' => $data['LongDesc'],
					'$submitbutton' => 'Submit changes'
				));
				break;
			default:
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array());
				break;
		}
	}
	else{
		$pageContent = get_shares_list(array('owner' => App::$channel['channel_hash']));
		$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
			'$tab1' => 'active',
			'$pagecontent' => $pageContent
		));
	}
	
	return $siteContent;
}


