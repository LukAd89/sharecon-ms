<?php

/**
 * Name: Sharing Economy
 * Description: Desc will follow
 * Version: 0.2
 * Author: Lukas Adrian
 * Maintainer: none
 */

 
require_once('functions.php');

function sharingecon_post(&$a){
	
	if(isset($_POST['action'])){
		Logger('POST got action');
		switch($_POST['action']){
			case 'add-new-share':
				uploadImage($_FILES['input-image']);
				$data = array(
					'owner' => App::$channel['channel_hash'],
					'title' => strip_tags($_POST['input-title']),
					'shortdesc' => strip_tags($_POST['input-short-desc']),
					'longdesc' => strip_tags($_POST['text-long-desc'])
				);
				add_new_share($data);
				exit();
			case 'load-shares':
				echo load_shares();
				break;
			
			case 'write-message':
				write_message($_POST['input-message-subject'], $_POST['input-message-body']);
				break;
				
			case 'toggle-share':
				toggleShare($_POST['id'], $_POST['state']);
				break;
				
			case 'delete-share':
				deleteShare($_POST['id']);
				break;
		}
		//header("Location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
}

function sharingecon_load() {}

function sharingecon_unload() {}

function sharingecon_init(){
	head_add_css('addon/sharingecon/bootstrap_sharecon.css');
	App::$page['htmlhead'] .= '<script type="text/javascript" src="' . z_root() . '/addon/sharingecon/main_js.js"></script>'."\r\n";
}

function sharingecon_module() {}

function get_shares_list($args){
	$data = load_shares($args);

	$result = "";
	for($i=0; $i<count($data); $i++){
		if($args['ownerview']){
			$status='';
			
			if($data[$i]['Status']==0){
				$status='checked="checked"';
			}
			$result .= replace_macros(get_markup_template('share_min_owner.tpl','addon/sharingecon/'), array(
			'$shareid' 		=> $data[$i]['ID'],
			'$title' 		=> $data[$i]['Title'],
			'$shortdesc' 	=> $data[$i]['ShortDesc'],
			'$checked'		=> $status,
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

function sharingecon_content(&$a) {

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
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
					));
				break;
				
			case 'findshares':
				$pageContent = get_shares_list(array());
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
					'$tab2' => 'active',
					'$pagecontent' => $pageContent
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array());
				break;
				
			case 'viewshare':
				$siteContent .= view_share_details(argv(2));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
				
			case 'newshare':
				$siteContent .= replace_macros(get_markup_template('new_share.tpl','addon/sharingecon/'), array(
					'$title' => 'Add new Share',
					'$action' => 'add-new-share',
					'$submitbutton' => 'Add Share'
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
			
			case 'editshare':
				$data = load_share_details(argv(2));
				$siteContent .= replace_macros(get_markup_template('edit_share.tpl','addon/sharingecon/'), array(
					'$title' => 'Edit Share',
					'$action' => 'edit-share',
					'$additional' => '<input type="hidden" name="action" value="'. argv(2) . '">',
					'$titlevalue' => $data['Title'],
					'$shortdescvalue' => $data['ShortDesc'],
					'$longdescvalue' => $data['LongDesc'],
					'$submitbutton' => 'Submit changes'
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
			default:
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array());
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
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


