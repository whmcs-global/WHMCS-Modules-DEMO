<?php

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *  Manage Secondary Sidebar Hook By whmcsglobalservices.com
 *
 *  Date: 05 Feb, 2020
 *  WHMCS Version: v8.x
 *
 *  By WHMCSGLOBALSERVICES    https://whmcsglobalservices.com
 *
 * 	This hook will remove/change URL for domain related sidebar menus
 *
 *  @owner <whmcsglobalservices.com>
 *  @author <whmcsglobalservices.com>
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

use WHMCS\View\Menu\Item as MenuItem;

add_hook('ClientAreaSecondarySidebar', 1, function (MenuItem $secondarySidebar) {
	if (!is_null($secondarySidebar->getChild('Actions'))) {
		if (!is_null($secondarySidebar->getChild('Actions')->getChild('Domain Renewals')))
			$secondarySidebar->getChild('Actions')->getChild('Domain Renewals')->setUri('https://url');
		if (!is_null($secondarySidebar->getChild('Actions')->getChild('Domain Registration')))
			$secondarySidebar->getChild('Actions')->getChild('Domain Registration')->setUri('https://url');
		if (!is_null($secondarySidebar->getChild('Actions')->getChild('Domain Transfer')))
			$secondarySidebar->getChild('Actions')->removeChild('Domain Transfer');
		if (!is_null($secondarySidebar->getChild('Actions')->getChild('View Cart')))
			$secondarySidebar->getChild('Actions')->getChild('View Cart')->setUri('https://url');
	}
});
