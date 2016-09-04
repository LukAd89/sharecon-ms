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
		
		switch($_POST['action']){
			case 'add-new-share':
				$filename = uploadImage($_FILES['input-image']);
				
				if(!$filename)
					$filename = 'default.jpg';
				
				$data = array(
					'owner' => App::$channel['channel_hash'],
					'title' => strip_tags($_POST['input-title']),
					'shortdesc' => strip_tags($_POST['input-short-desc']),
					'longdesc' => strip_tags($_POST['text-long-desc']),
					'imagename' => $filename,
					'visibility' => strip_tags($_POST['select-visibility']),
					'tags' => strip_tags($_POST['input-tags'])
				);
				add_new_share($data);
				header("Location: " . $_SERVER['REQUEST_URI']);
				exit();
				
			case 'add-new-request':
				$data = array(
					'owner' => App::$channel['channel_hash'],
					'title' => strip_tags($_POST['input-title']),
					'shortdesc' => strip_tags($_POST['input-short-desc']),
					'longdesc' => strip_tags($_POST['text-long-desc']),
					'visibility' => strip_tags($_POST['select-visibility']),
					'tags' => strip_tags($_POST['input-tags'])
				);
				add_new_request($data);
				header("Location: " . $_SERVER['REQUEST_URI']);
				exit();
				break;
				
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
				
			case 'manage-enquiry':
				manage_Enquiry($_POST['id']);
				break;
			
			case 'add-enquiry':
				add_Enquiry($_POST['id'], App::$channel['channel_hash']);
				break;
				
			case 'set-rating':
				set_rating($_POST['rating'], $_POST['rating']);
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
	App::$page['htmlhead'] .= '<script type="text/javascript" src="' . z_root() . '/addon/sharingecon/nlp_compromise.js"></script>'."\r\n";
}

function sharingecon_module() {}

function get_shares_list($args){
	$data = load_shares($args);

	$result = "";
	for($i=0; $i<count($data); $i++){
		
		if($data[$i]['Imagename'] === NULL || $data[$i]['Imagename'] == ''){
			$data[$i]['Imagename'] ='default.jpg';
		}
		
		if($args['ownerview']){
			$status='';
			
			if($data[$i]['Status']==0){
				$status='checked="checked"';
			}
			
			$result .= replace_macros(get_markup_template('share_min_owner.tpl','addon/sharingecon/'), array(
			'$shareid' 		=> $data[$i]['ID'],
			'$title' 		=> $data[$i]['Title'],
			'$shortdesc' 	=> $data[$i]['ShortDesc'],
			'$imagename'	=> $data[$i]['Imagename'],
			'$checked'		=> $status
			));
		}
		else{
			$result .= replace_macros(get_markup_template('share_min.tpl','addon/sharingecon/'), array(
			'$shareid' 		=> $data[$i]['ID'],
			'$title' 		=> $data[$i]['Title'],
			'$shortdesc' 	=> $data[$i]['ShortDesc'],
			'$imagename'	=> $data[$i]['Imagename']					
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
					'ownerview' => true,
					'type' => 2
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
				$pageContent = get_shares_list(array(
					'type' => 0
				));
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
					'$tab2' => 'active',
					'$pagecontent' => $pageContent
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array());
				break;
				
			case 'requests':
				$pageContent = get_shares_list(array(
					'type' => 1
				));
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
						'$tab3' => 'active',
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
					
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
				
			case 'newrequest':
				$siteContent .= replace_macros(get_markup_template('new_request.tpl','addon/sharingecon/'), array(
					
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
						'$filterhidden' => 'hidden'
				));
				break;
			
			case 'editshare':
				$data = load_share_details(argv(2));
				$siteContent .= replace_macros(get_markup_template('edit_share.tpl','addon/sharingecon/'), array(
					'$additional' => '<input type="hidden" name="action" value="'. argv(2) . '">',
					'$titlevalue' => $data['Title'],
					'$shortdescvalue' => $data['ShortDesc'],
					'$longdescvalue' => $data['LongDesc']
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
				
			case 'enquiries':
				$tablebodyenq = "";
				$tablebodypast = "";
				
				$dataenq = load_enquiries();
				$datapast = load_transactions();
				
				foreach($dataenq as $row){
					$tablebodyenq .= '<tr><td>' . getObjectTitle($row["ObjectID"]) . '</td>' . '<td>' . getChannelName($row["CustomerID"]) . '</td>';// . '<td>' . $row["Status"] . '</td>' . '<td>KLICK</td></tr>';
					switch($row["Status"]){
						case 0:
							$tablebodyenq .= '<td>Open</td><td><button class="btn btn-xs btn-primary" onclick="manageEnquiry(' . $row["ID"] . ')">Accept</td></tr>';
							break;
						case 1:
							$tablebodyenq .= '<td>Lend to customer</td><td><button class="btn btn-xs btn-success" onclick="manageEnquiry(' . $row["ID"] . ')">Got Back</td></tr>';
							break;
						case 2:
							$tablebodyenq .= '<td>Lend to other one</td><td><button class="btn btn-xs btn-danger disabled" onclick="manageEnquiry(' . $row["ID"] . ')">Accept</td></tr>';
							break;
					}
				}
				
				foreach($datapast as $row){
					$tablebodypast .= '<tr><td>' . getObjectTitle($row["ObjectID"]) . '</td>' . '<td>' . getChannelName($row["OwnerID"]) . '</td>' . '<td>' . $row["LendingStart"] . '</td>' . '<td>' . $row["LendingEnd"] . '</td>' . '<td>' . $row["Rating"] . '</td>';
					
					$tablebodypast .= '<td><button class="btn btn-primary btn-xs" data-id="1" data-target="#modal-set-rating" data-toggle="modal">Rate</button></td></tr>';
				}
				
				$siteContent .= replace_macros(get_markup_template('transactions.tpl','addon/sharingecon/'), array(
					'$tablebodyenq' => $tablebodyenq,
					'$tablebodypast' => $tablebodypast
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
		$pageContent = get_shares_list(array(
			'owner' => App::$channel['channel_hash'],
			'ownerview' => true,
			'type' => 2
			));
		
		$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
			'$tab1' => 'active',
			'$pagecontent' => $pageContent
		));
		
		App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
			'$filterhidden' => 'hidden'
		));
	}
	
	return $siteContent;
}


