<?php

/**
 * Name: Sharing Economy
 * Description: Desc will follow
 * Version: 0.1
 * Author: Lukas Adrian
 * Maintainer: none
 */


function sharingecon_load() {
	head_add_css('/addon/sharingecon/bootstrap_sharecon.css');
}
function sharingecon_unload() {
}


function sharingecon_module() {}



function sharingecon_content(&$a) {


return file_get_contents("http://localhost/addon/sharingecon/main_page.html");
//return "TEST";

}