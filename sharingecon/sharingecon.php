<?php

/**
 * Name: Sharing Economy
 * Description: Desc will follow
 * Version: 0.1
 * Author: Lukas Adrian
 * Maintainer: none
 */




function sharingecon_load() {
	register_hook('sharingecon_mod_content', 'addon/sharingecon/sharingecon.php', 'sharingecon_mod_content');
}
function sharingecon_unload() {
	unregister_hook('sharingecon_mod_content', 'addon/sharingecon/sharingecon.php', 'sharingecon_mod_content');
}

function sharingecon_init(){
	head_add_css('addon/sharingecon/bootstrap_sharecon.css');
	//head_add_js('addon/sharingecon/main_js.js');
}

function sharingecon_module() {}

function sharingecon_content(&$a) {
	$siteContent = '<script src="addon/sharingecon/main_js.js" type="text/javascript"></script>';
	
	if(argc() > 1){
		switch(argv(1)){
			case 'main':
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array()); //file_get_contents("http://localhost/addon/sharingecon/main_page.html");
				break;
			case 'viewshare':
				$siteContent .= view_share_details(argv(2));
				break;
			default:
				$siteContent .= replace_macros(get_markup_template('main_page.tpl','addon/sharingecon/'), array());
				break;
		}
	}
	return $siteContent; //file_get_contents("http://localhost/addon/sharingecon/main_page.html");*/
}

function sharingecon_mod_content(&$a, &$b){
	App::$layout['region_aside'] = replace_macros(get_markup_template('main_aside.tpl', 'addon/sharingecon/'), array()); //file_get_contents("http://localhost/addon/sharingecon/main_aside_left.html");
}

function view_share_details($id){
	require_once('addon/sharingecon/db_functions.php');
	
	$share_data = load_share_details($id);
	$content = file_get_contents("http://localhost/addon/sharingecon/share_details.html");
	
	/*$values = array(
		'{$title}'	=> $share_data['Title'],
		'{$shortdesc}'		=> $share_data['ShortDesc']
	);
	return strtr($content, $values);*/
	
	$content = replace_macros(get_markup_template('share_details.tpl', 'addon/sharingecon/'), array(
		'$title'	=> $share_data['Title'],
		'$shortdesc'		=> $share_data['ShortDesc']
		));
	
	return $content;
}