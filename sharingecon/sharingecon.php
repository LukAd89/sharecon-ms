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
				$filename = upload_Image($_FILES['input-image']);
				
				if(!$filename)
					$filename = 'default.jpg';
				
				$data = array(
					'owner' => local_channel(),
					'type' => $_POST['select-type'],
					'title' => strip_tags($_POST['input-title']),
					'description' => strip_tags($_POST['text-description']),
					'imagename' => $filename,
					'visibility' => strip_tags($_POST['select-visibility']),
					'groups'	=> $_POST['select-groups'],
					'location'	=> $_POST['input-location'],
					'tags' => strip_tags($_POST['input-tags'])
				);
				add_NewShare($data);
				header("Location: " . $_SERVER['REQUEST_URI']);
				exit();
				break;
				
			case 'edit-share':
				$filename = upload_Image($_FILES['input-image']);
				
				if(!$filename)
					$filename = '';
				
				$data = array(
					'shareid' => strip_tags($_POST['shareid']),
					'title' => strip_tags($_POST['input-title']),
					'description' => strip_tags($_POST['text-description']),
					'imagename' => $filename,
					'visibility' => strip_tags($_POST['select-visibility']),
					'tags' => strip_tags($_POST['input-tags'])
				);
				edit_Share($data);
				header("Location: " . $_SERVER['REQUEST_URI']);
				exit();
				break;
				
			case 'load-shares':
				echo load_Shares();
				break;
			
			case 'write-message':
				write_Message($_POST['input-message-subject'], $_POST['input-message-body']);
				break;
				
			case 'toggle-share':
				toggle_Share($_POST['id'], $_POST['state']);
				break;
				
			case 'toggle-fav':
				toggle_Favorite($_POST['id'], $_POST['state']);
				break;
				
			case 'delete-share':
				delete_Share($_POST['id']);
				break;
				
			case 'manage-enquiry':
				manage_Enquiry($_POST['id']);
				break;
			
			case 'add-enquiry':
				add_Enquiry($_POST['id'], local_channel());
				break;
				
			case 'set-rating':
				set_Rating($_POST['transid'], $_POST['rating']);
				break;
				
			case 'set-location':
				set_Location(local_channel(), $_POST['adress']);
				break;
				
			case 'get-distance':
				echo get_Distance(local_channel(), $_POST['shareid']);
				break;
		}
		//header("Location: " . $_SERVER['REQUEST_URI']);
		exit();
	}
}

function sharingecon_load() {
	//Zotlabs\Extend\Hook::register('feature_settings', 'addon/sharingecon/sharingecon.php', 'sharingecon_settings');
}

function sharingecon_unload() {
	//Zotlabs\Extend\Hook::unregister('feature_settings', 'addon/sharingecon/sharingecon.php', 'sharingecon_settings');
}

function sharingecon_init(){
	head_add_css('addon/sharingecon/css/bootstrap_sharecon.css');
	App::$page['htmlhead'] .= '<script type="text/javascript" src="' . z_root() . '/addon/sharingecon/js/main_js.js"></script>'."\r\n";
	App::$page['htmlhead'] .= '<script type="text/javascript" src="' . z_root() . '/addon/sharingecon/js/nlp_compromise.js"></script>'."\r\n";
}

function sharingecon_module() {}



/*function view_share_details($shareid){
	
	$share_data = load_ShareDetails($shareid);
	
	$content = replace_macros(get_markup_template('share_details.tpl', 'addon/sharingecon/'), array(
		'$title'		=> $share_data['Title'],
		'$sharebody'	=> $share_data['LongDesc'],
		'$shareid'		=> $shareid
		));
	
	return $content;
}*/

function sharingecon_plugin_admin_post(&$a){
	switch($_POST['action']){
		case 'new-tag-branch':
			new_TagTreeBranch($_POST['input-branch-id'], $_POST['input-title'], $_POST['input-tags']);
			break;
		case 'edit-tag-branch':
			edit_TagTreeBranch($_POST['input-branch-id'], $_POST['input-parent'], $_POST['input-title'], $_POST['input-tags']);
			break;
		case 'delete-tag-branch':
			delete_TagTreeBranch($_POST['input-branch-id']);
			break;
	}
	header("Location: " . $_SERVER['REQUEST_URI']);
	exit();
}

function sharingecon_plugin_admin(&$a, &$o){
	App::$page['htmlhead'] .= '<script type="text/javascript" src="' . z_root() . '/addon/sharingecon/js/admin_js.js"></script>'."\r\n";
	$tagTree = get_TagTree();
	
	foreach($tagTree as $row){
		$tagTreeString .= '<tr id="tr_' . $row['ID'] . '"><td>' . $row['ID'] . '</td><td class="td_parent">' . $row['Parent'] . '</td><td class="td_title">' . $row['Title'] . '</td><td class="td_tags">' . $row['Tags'] . '</td>';
		
		$tagTreeString .= '<td><button type="button" title="Add Branch" class="btn btn-default btn-xs" data-toggle="modal" data-target="#new-branch-modal" data-branchid="' . $row['ID'] . '"><span class="glyphicon glyphicon-plus"></span></button>
				<button type="button" title="Edit Tags" class="btn btn-default btn-xs" data-toggle="modal" data-target="#edit-branch-modal" data-branchid="' . $row['ID'] . '"><span class="glyphicon glyphicon-pencil"</span></button>
				<button type="button" title="Delete Branch" class="btn btn-default btn-xs" data-toggle="modal" data-target="#delete-branch-modal" data-branchid="' . $row['ID'] . '"><span class="glyphicon glyphicon-trash"</span></button></td></tr>';
	}
	$o .= replace_macros(get_markup_template('admin_settings.tpl','addon/sharingecon/'), array(
		'$tablebody' => $tagTreeString
	));
}

function sharingecon_content(&$a) {
	if(argc() > 1){
		switch(argv(1)){
			case 'myshares':
				$pageContent = get_SharesList(array(
					//'ownerid' => App::$channel['channel_hash'],
					'ownerid' => local_channel(),
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
				$pageContent = get_SharesList(array(
					'type' => 0,
					'channel' => local_channel(),
					'ownerview' => false,
					'orderby' => $_GET['orderby'],
					'filterfavs' => $_GET['filterfavs'],
					'filterfriends' => $_GET['filterfriends']
				));
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
					'$tab2' => 'active',
					'$pagecontent' => $pageContent
				));
				$channellocation = get_Location(local_channel());
				if($channellocation == -1){
					$channellocation = '';
				}
				
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$curlocation'	=> $channellocation,
					'$cursearch'	=> $_GET['search'],
					'$curorderby'	=> $_GET['orderby'],
					'$filterfavschecked' => ($_GET['filterfavs']==1) ? 'checked="checked"' : '',
					'$filterfriendschecked' => ($_GET['filterfriends']==1) ? 'checked="checked"' : '',
				));
				break;
				
			case 'requests':
				$pageContent = get_SharesList(array(
					'type' => 1
				));
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array(
						'$tab3' => 'active',
						'$pagecontent' => $pageContent
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array());
				break;
			case 'viewshare':
				$share_data = load_ShareDetails(argv(2));
				$ratingavg = get_AvgRating(argv(2));
				$ratinglatest = get_LatestRatings(argv(2));
				
				$ratinglatesttable = '<table class="table"><thead><tr><th>Lend On</th><th>Brought Back On</th><th>Days of Lending</th><th>Rating</th></tr></thead><tbody>';
				foreach($ratinglatest as $entry){
					$ratinglatesttable .= '<tr><td>' . $entry["LendingStart"] . '</td><td>' . $entry["LendingEnd"] . '</td><td>' . $entry["Timespan"] . '</td><td>' . $entry["Rating"] . '</td></tr>';
				}
				$ratinglatesttable .= '</tbody></table>';
				
				$siteContent = replace_macros(get_markup_template('share_details.tpl', 'addon/sharingecon/'), array(
						'$title'		=> $share_data['Title'],
						'$sharebody'	=> $share_data['Description'],
						'$shareid'		=> argv(2),
						'$imagename'	=> $share_data['Imagename'],
						'$ratingavg'	=> 'Overall Average Rating: ' . $ratingavg . ' / 5',
						'$ratinglatest'	=> 'Latest Ratings:<br>' . $ratinglatesttable
				));
				
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
				
			case 'newshare':
				$channelgroups = get_ChannelGroups(local_channel(), true);
				
				foreach($channelgroups as $item){
					$groupselector .= '<option value="'. $item['id'] .'">' . $item['gname'] . '</option>';
				}
				$siteContent .= replace_macros(get_markup_template('new_share.tpl','addon/sharingecon/'), array(
					'$groups'	=> $groupselector
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
			
			case 'editshare':
				$data = load_ShareDetails(argv(2));
				$siteContent .= replace_macros(get_markup_template('edit_share.tpl','addon/sharingecon/'), array(
					'$additional' => '<input type="hidden" name="shareid" value="'. argv(2) . '">',
					'$titlevalue' => $data['Title'],
					'$descvalue' => $data['Description']
				));
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
					'$filterhidden' => 'hidden'
				));
				break;
				
			case 'enquiries':
				$tablebodyenq = "";
				$tablebodypast = "";
				
				$dataenq = load_Enquiries(local_channel());
				$datapast = load_Transactions(local_channel());
				
				foreach($dataenq as $row){
					$tablebodyenq .= '<tr><td>' . $row['Title'] . '</td>' . '<td>' . $row['channel_name'] . '</td>';// . '<td>' . $row["Status"] . '</td>' . '<td>KLICK</td></tr>';
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
					$tablebodypast .= '<tr><td>' . $row['Title'] . '</td>' . '<td>' . $row['channel_name'] . '</td>' . '<td>' . $row['LendingStart'] . '</td>' . '<td>' . $row['LendingEnd'] . '</td>' . '<td>' . $row['Rating'] . '</td>';
					if($row['Rating'] > 0)
						$tablebodypast .= '<td><button class="btn btn-xs disabled">Rate</button></td></tr>';
					else
						$tablebodypast .= '<td><button class="btn btn-primary btn-xs" data-id="' . $row['ID'] . '" data-target="#modal-set-rating" data-toggle="modal">Rate</button></td></tr>';
				}
				
				$siteContent .= replace_macros(get_markup_template('transactions.tpl','addon/sharingecon/'), array(
					'$tablebodyenq' => $tablebodyenq,
					'$tablebodypast' => $tablebodypast
				));
				
				App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
						'$filterhidden' => 'hidden'
				));
				break;
			
			case 'matches':
				if(argc()==2){
					$data = load_Shares(array(
						'ownerview' => true,
						'ownerid'	=> local_channel(),
						'type'		=> 2
					));
					if(count($data) == 0){
						$siteContent .= 'You do not have any Shares';
						App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
								'$filterhidden' => 'hidden'
						));
						break;
					}
					
					foreach($data as $row){
						$tablebodystring .= '<tr><td>' . $row['Title'] . '</td><td>' . (($row['Type']==0) ? 'Offer' : 'Request') . '</td><td><a href="sharingecon/matches/' . $row['ID'] . '"><button type="button" class="btn btn-default btn-xs">Select</button></a></td></tr>';
					}
						
					$siteContent .= replace_macros(get_markup_template('matches.tpl','addon/sharingecon/'), array(
							'$tablebody' => $tablebodystring
					));
				}
				else if(argc()==3){
					if(get_ShareOwner(argv(2)) != local_channel()){
						$siteContent .= 'You are not the Owner of this Share';
						App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array(
								'$filterhidden' => 'hidden'
						));
						break;
					}
					$data = get_MatchesForShare(argv(2));
					
					foreach($data as $row){
						$tablebodystring .= '<tr><td>' . $row['Title'] . '</td><td>0</td><td><a href="sharingecon/viewshare/' . $row['ID'] . '"><button type="button" class="btn btn-default btn-xs">View Details</button></a></td></tr>';
					}
					
					$siteContent .= replace_macros(get_markup_template('matches_detail.tpl','addon/sharingecon/'), array(
							'$tablebody' => $tablebodystring
					));
				}
				
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
		$pageContent = get_SharesList(array(
			'ownerid' => local_channel(),
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
