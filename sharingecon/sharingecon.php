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

function sharingecon_mod_content(&$a, &$b){
	App::$layout['region_aside'] = file_get_contents("http://localhost/addon/sharingecon/main_aside_left.html");
}


function sharingecon_module() {}



function sharingecon_content(&$a) {
	return file_get_contents("http://localhost/addon/sharingecon/main_page.html");
}