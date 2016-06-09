<?php
function sharecon_load(){
	Zotlabs\Extend\Hook::register('post_local', 'addon/sharecon/sharecon.php', 'test');
}

function sharecon_unload(){
	Zotlabs\Extend\Hook::unregister('post_local', 'addon/sharecon/sharecon.php', 'test');
}

function test(){
	logger('randplace invoked');

	if(! local_channel())   /* non-zero if this is a logged in user of this system */
		return;

	if(local_channel() != $item['uid'])    /* Does this person own the post? */
		return;

	if(($item['parent']) || (! is_item_normal($item))) {
		/* If the item has a parent, or is not "normal", this is a comment or something else, not a status post. */
		return;
	}

	/* Retrieve our personal config setting */

	$active = get_pconfig(local_channel(), 'randplace', 'enable');

	if(! $active)
		return;
	/**
	 *
	 * OK, we're allowed to do our stuff.
	 * Here's what we are going to do:
	 * load the list of timezone names, and use that to generate a list of world cities.
	 * Then we'll pick one of those at random and put it in the "location" field for the post.
	 *
	 */

	$cities = array();
	$zones = timezone_identifiers_list();
	foreach($zones as $zone) {
		if((strpos($zone,'/')) && (! stristr($zone,'US/')) && (! stristr($zone,'Etc/')))
			$cities[] = str_replace('_', ' ',substr($zone,strpos($zone,'/') + 1));
	}

	if(! count($cities))
		return;
	$city = array_rand($cities,1);
	$item['location'] = $cities[$city];

	return;
}
?>