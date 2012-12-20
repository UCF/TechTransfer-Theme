/**
 * Get max height for resources and set
 * that height to all resource objects.
 */

$(document).ready(function() {
	boxes = $('.resource');
	maxHeight = Math.max.apply(
		Math, boxes.map(function() {
			return $(this).outerHeight();
		}).get());
	$('.resource-row .resource-box').height(maxHeight);
});

$(window).resize(function() {
	boxes = $('.resource');
	maxHeight = Math.max.apply(
		Math, boxes.map(function() {
			return $(this).outerHeight();
		}).get());
	$('.resource-row .resource-box').height(maxHeight);
});