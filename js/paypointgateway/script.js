/**
 * PayPoint Gateway extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the PayPoint Gateway License
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
 * @package     PayPoint_Gateway
 * @copyright   Copyright (c) 2012 PayPoint Group (http://www.paypoint.com/)
 * @license     http://www.paypoint.net/magento/license
 * @author		Matt Aylward <magento.dev@satellitenine.co.uk>
 */

Event.observe(window, 'load', function() {
	
	/* show/hide template field depending on service package */
	function eventTogglePayPointTemplateUrl(event) {
		elementTogglePayPointTemplateUrl(event.element());
	}
	function elementTogglePayPointTemplateUrl(element){
		if(element.getValue()=='gateway_freedom_package') {
			$('row_payment_paypointgateway_hosted_template_url').show();
		} else {
			$('row_payment_paypointgateway_hosted_template_url').hide();
		}
	}
	var el = $('payment_paypointgateway_common_service_package');
	if(el != undefined) {
		elementTogglePayPointTemplateUrl(el.observe('change',eventTogglePayPointTemplateUrl));
	}
	
	/* Disable 'required-entry' validation if not enabled (see paypointcommon script for functions)... */
	var enableSelects = [
		'payment_paypointgateway_direct_active',
		'payment_paypointgateway_hosted_active',
		'payment_paypointgateway_paypal_active'
	];
	for(var i in enableSelects) {
		var el = $(enableSelects[i]);
		if(el != undefined) {
			elementToggleRequiredEntry(el.observe('change',eventToggleRequiredEntry));
		}
	}
});