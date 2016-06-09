<?php

/**
 *
 * Name: SharEcon Plugin
 * Description: to be updated
 * Version: 0.1
 * Author: Lukas Adrian
 *
*/

function sharecon_load(){
}

function sharecon_unload(){
}

function sharecon_module(){}

function qrator_photo_mod_init(&$a,&$b) {}

function sharecon_content(&a){
	$output = <<< SB
	
	<table style='border:1 solid black;'><tr>
		<td>Artikelname</td><td>Hammer</td>
	</tr><tr>
		<td>Beschreibung</td><td>Gr0ßer Zimmermannshammer. Länge: 30cm Gewicht: 850g</td>
	</tr></table>
	
SB;

	return $output;
}
?>