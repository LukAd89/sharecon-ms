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

function sharingecon_content(&$a) {
	if(! is_site_admin())
		return;

	$title = t('Send email to all hub members.');

	return $title;

}
