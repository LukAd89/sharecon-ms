<?php

/**
 *
 * Name: sharingecon
 * Description: Send admin email message to all account holders. <b>-><a href=/sharingecon TARGET = "_blank">send now!</a><-</b>
 * Version: 1.0
 * Author: Mike Macgirvin
 * Maintainer: none
 */




require_once('include/enotify.php');

function sharingecon_module() {}

function sharingecon_plugin_admin(&$a, &$o) {

	$o = '<div></div>&nbsp;&nbsp;&nbsp;&nbsp;<a href="' . z_root() . '/hubwall">' . t('Send email to all members') . '</a></br/>';

}

function sharingecon_post(&$a) {
}

function sharingecon_content(&$a) {

	return 'hello';

}
