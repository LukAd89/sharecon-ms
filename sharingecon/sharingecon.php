<?php

/**
 * Name: Sharing Economy
 * Description: Desc will follow
 * Version: 0.1
 * Author: Lukas Adrian
 * Maintainer: none
 */

include('db_functions.php');

function sharingecon_post(){
if(isset($_POST['function'])){
	switch($_POST['function']){
		case "add_new_share":
			$data = array(
				"owner" => App::$channel['channer_guid'],
				"title" => strip_tags($_POST['input-title']),
				"shortdesc" => strip_tags($_POST['input-short-desc'])
			);
			echo add_new_share($data);
			break;
		case "load_shares":
			echo load_shares();
			break;
	}
}}

function sharingecon_load() {}

function sharingecon_unload() {}

function sharingecon_init(){
	head_add_css('addon/sharingecon/bootstrap_sharecon.css');
}

function sharingecon_module() {}

function sharingecon_content(&$a) {
	$siteContent = '<script src="addon/sharingecon/main_js.js" type="text/javascript"></script>';
	
	App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside_left.tpl', 'addon/sharingecon/'), array());
	if(argc() > 1){
		switch(argv(1)){
			case 'main':
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array());
				break;
			case 'viewshare':
				$siteContent .= view_share_details(argv(2));
				break;
			default:
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array());
				break;
		}
	}
	return $siteContent;
}

function view_share_details($id){
	require_once('addon/sharingecon/db_functions.php');
	
	$share_data = load_share_details($id);
	$content = file_get_contents("http://localhost/addon/sharingecon/share_details.html");
	
	$content = replace_macros(get_markup_template('share_details.tpl', 'addon/sharingecon/'), array(
		'$title'	=> $share_data['Title'],
		'$shortdesc'		=> $share_data['ShortDesc']
		));
	
	return $content;
}