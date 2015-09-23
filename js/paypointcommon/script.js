/**
 * PayPoint Common extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the PayPoint Common License
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
 * @package     PayPoint_Common
 * @copyright   Copyright (c) 2012 PayPoint Group (http://www.paypoint.com/)
 * @license     http://www.paypoint.net/magento/license
 * @author		Matt Aylward <magento.dev@satellitenine.co.uk>
 */

/* Add Validation cases... */
Validation.addAllThese([
    [
		'validate-minimum',
		'Please enter a number less than the maximum in this field.',
		function(v) {
			var vFloat = parseFloat(v);
			var maximumElements = $$('.validate-maximum');
			for (var i = 0; i < maximumElements.size(); i++) {
				var maximumElement = maximumElements[i];
				if(vFloat >= parseFloat(maximumElement.value)) {
					return false;
				}
			}
			return true;
        }
	],
    [
		'validate-maximum',
		'Please enter a number greater than the minimum in this field.',
		function(v) {
			var vFloat = parseFloat(v);
			var minimumElements = $$('.validate-minimum');
			for (var i = 0; i < minimumElements.size(); i++) {
				var minimumElement = minimumElements[i];
				if(vFloat <= parseFloat(minimumElement.value)) {
					return false;
				}
			}
			return true;
        }
	]
]);

/* Add functions to disable 'required-entry' validation if not enabled... */
function eventToggleRequiredEntry(event) {
	elementToggleRequiredEntry(event.element());
}
function elementToggleRequiredEntry(element) {
	var enabled = 'required-entry';
	var disabled = 'disabled-required-entry';
	var val = element.value;
	var fs = element.up('fieldset');
	var res = fs.select('input[class~="'+(val==1?disabled:enabled)+'"]');
	res.each(function(s) {
		s.removeClassName((val==1?disabled:enabled));
		s.addClassName((val==1?enabled:disabled));
	});
}