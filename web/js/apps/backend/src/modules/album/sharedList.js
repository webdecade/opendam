(function($) {
	"use strict";

	$(document).ready(function() {
		var notification = window.services.notification;
		
		var $root = $("#album-shared-list-page");
		
		var $albumThumbmails = $root.find("#album-thumbnails");
		var $orderBySelect = $root.find(".order-by-select");
		var $perPageSelect = $root.find("select[name=perPage]");
		var $showModeBtn = $root.find("#show-more-container").find("> button");

		// initialize
		$albumThumbmails.masonry({
			gutter: 10,
			gutterWidth: 10,
			isAnimated: true,
			itemSelector: '.thumbnail'
		});
		
		$albumThumbmails.css("visibility", "visible");
		
		// change perPage or orderBy
		function reloadThumbnail(event) {
			notification.loading();

			$.ajax(Routing.generate("album_shared_list_thumbnail"), {
				data: {"page": 1, "perPage": $perPageSelect.val(), "orderBy[]": $orderBySelect.val()}
			})
			.done(function(jxhr) {
				var $html = $(jxhr.html);

				$albumThumbmails.html($html);
				$albumThumbmails.masonry('reload');

				$showModeBtn.button("reset");
				notification.close();
			})
			.fail(function() {
				$showModeBtn.button("reset");
				notification.error();
			});
		}
		
		$orderBySelect.on("change", reloadThumbnail);
		$perPageSelect.on("change", reloadThumbnail);
		
		// show more
		var pageLoaded = 1;
		
		$showModeBtn.on("click", function() {
			notification.loading();
			$showModeBtn.button("loading");
			
			$.ajax(Routing.generate("album_shared_list_thumbnail"), {
				data: {"page": ++pageLoaded, "perPage": $perPageSelect.val(), "sort": $orderBySelect.val()}
			})
			.done(function(jxhr) {
				var $html = $(jxhr.html);
				$albumThumbmails.append($html).masonry('appended', $html, true);
				
				if (pageLoaded >= jxhr.lastPage) {
					$showModeBtn.hide();
					$showModeBtn.off();
				}
				
				$showModeBtn.button("reset");
				notification.close();
			})
			.fail(function() {
				$showModeBtn.button("reset");
				notification.error();
			});
		});
	});
})(jQuery);