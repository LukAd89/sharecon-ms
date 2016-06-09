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

$header = t('QR Generator');
$prompt = t('Enter some text');

$o .= <<< EOT
<h2>$header</h2>

<div>$prompt</div>
<input type="text" id="qr-input" onkeyup="makeqr();" />
<div id="qr-output"></div>


EOT;
return $o;

}