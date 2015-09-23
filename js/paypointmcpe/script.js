/**
 * PayPoint Mcpe extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the PayPoint Mcpe License
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.paypoint.net/magento/license
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to MagentoLicense@PayPoint.net so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to be able to upgrade this extension to newer
 * versions in the future. If you wish to customise the module, then please extend it within a seperate module.
 * Please refer to http://www.paypoint.net/magento/ for more information.
 *
 * @category    PayPoint
 * @package     PayPoint_Mcpe
 * @copyright   Copyright (c) 2012 PayPoint Group (http://www.paypoint.com/)
 * @license     http://www.paypoint.net/magento/license
 * @author		Matt Aylward <magento.dev@satellitenine.co.uk>
 */

Event.observe(window, 'load', function() {
	
	/* Disable 'required-entry' validation if not enabled (see paypointcommon script for functions)... */
	var enableSelects = [
		'payment_paypointmcpe_fasttrackhosted_active',
		'payment_paypointmcpe_bankenterprisefreedom_active'
	];
	for(var i in enableSelects) {
		var el = $(enableSelects[i]);
		if(el != undefined) {
			elementToggleRequiredEntry(el.observe('change',eventToggleRequiredEntry));
		}
	}
});