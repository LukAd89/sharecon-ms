<?php

/**
 * Name: Sharing Economy
 * Description: Desc will follow
 * Version: 0.1
 * Author: Lukas Adrian
 * Maintainer: none
 */
//set_include_path(get_include_path() . PATH_SEPARATOR . "/var/www/html/"); //dirname(__FILE__)."/../");

//require_once('include/enotify.php');
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
				echo "WRITE";
				$recipient = getShareOwner($_POST['input-message-sharid']);
				write_message($recipient, $_POST['input-message-subject'], $_POST['input-message-body']);
				break;
		}
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
		$result .= replace_macros(get_markup_template('share_min.tpl','addon/sharingecon/'), array(
		'$shareid' => $data[$i]['ID'],
		'$title' => $data[$i]['Title'],
		'$shortdesc' => $data[$i]['ShortDesc']
		));
	}
	return $result;
}

function view_share_details($id){
	
	$share_data = load_share_details($id);
	$content = file_get_contents("http://localhost/addon/sharingecon/share_details.html");
	
	$content = replace_macros(get_markup_template('share_details.tpl', 'addon/sharingecon/'), array(
		'$title'	=> $share_data['Title'],
		'$shortdesc'		=> $share_data['ShortDesc']
		));
	
	return $content;
}
/*
if (isset($_POST['function'])) {
	if($_POST['function'] == "write_message"){
		write_message(null, null, null);
	}
}
*/
function write_message($rec, $subject, $body){
		message::send_message(0, null, "body", "subject");
}


function sharingecon_content(&$a) {
	$siteContent = '<script src="addon/sharingecon/main_js.js" type="text/javascript"></script>';
	
	App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array());
	if(argc() > 1){
		switch(argv(1)){
			case 'myshares':
				$tab1Content = get_shares_list(array('owner' => App::$channel['channel_guid']));
				$tab2Content = get_shares_list(null);
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
					'$tab1' => 'active',
					'$tab2' => '',
					'$tab1content' => $tab1Content,
					'$tab2content' => $tab2Content
				));
				break;
			case 'findshares':
				$tab2Content = get_shares_list(null);
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
					'$tab1' => '',
					'$tab2' => "active",
					'$tab2content' => $tab2Content
				));
				break;
			case 'viewshare':
				$siteContent .= view_share_details(argv(2));
				break;
			default:
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array());
				break;
		}
	}
	else{
		$tab2Content = get_shares_list(null);
		$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
			'$tab1' => 'active',
			'$tab2' => '',
			'$tab2content' => $tab2Content
		));
	}
	
	//require_once('include/enotify.php');
	
	$siteContent .= getcwd();
	return $siteContent;
}


