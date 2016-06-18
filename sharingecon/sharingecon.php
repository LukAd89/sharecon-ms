<?php

/**
 * Name: Sharing Economy
 * Description: Desc will follow
 * Version: 0.1
 * Author: Lukas Adrian
 * Maintainer: none
 */


function sharingecon_load() {
}
function sharingecon_unload() {
}


function sharingecon_module() {}



function sharingecon_content(&$a) {


return file_get_contents("main_page.html");
//return "TEST";

}