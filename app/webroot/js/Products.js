/**
 * Products Script
 * By: Louis <louis@ne02ptzero.me>
 */

	var		websitesChecked = {};
$(document).ready(function() {
	// Check and Unchecked shortDescription
	var		actualHover = 0;
	var		actualHoverBox = 0;
	var		actualText = 0;
	var		boxChecked = {};

	// Fixes on Flat-UI
	$(".websites ul li").on('click', function() {
		var className = $(this).attr('class');
		var id = $(this).attr('name');
		alert(id);
		if (className == undefined || className == "") {
			delete websitesChecked[id];
		} else {
			websitesChecked[id] = 1;
		}
	});

	$('.useShortDescription').change(function() {
		if (!this.checked)
			$(".addProduct .shortDescription").show(300);
		else
			$(".addProduct .shortDescription").hide(300);
	});

	$('.countCheckBox').change(function() {
		var i = Object.keys(boxChecked).length;
		if (this.checked)
			boxChecked[$(this).val()] = 1;
		else
			delete boxChecked[$(this).val()];
		var v = Object.keys(boxChecked).length;
		if (i == 0 && v > 0) {
			$(".delete").show(200);
			$(".addWebsite").show(200);
		}
		else if (i > 0 && v == 0) {
			$(".delete").hide(200);
			$(".addWebsite").hide(200);
			$(".websites").hide(200);
		}
	});

	// Hover products
	$(".product_list ul li").mouseover(function () {
		if (actualHover != 0 && actualText != $(this).find('h6').html()) {
			actualHover.fadeOut(200);
			if (boxChecked[actualHoverBox.find('input').val()] === undefined ||
				boxChecked[actualHoverBox.find('input').val()] === 0)
				actualHoverBox.fadeOut(200);
		}
		actualHover = $(this).find('button');
		actualHoverBox = $(this).find('label');
		if (actualText != $(this).find('h6').html()) {
			actualHover.css('visibility','visible').hide().fadeIn(200);
			actualHoverBox.fadeIn(200);
			actualText = $(this).find('h6').html();
		}
	});

	// Add to a website button
	$(".addWebsite").on('click', function() {
		$(".websites").show(200);
	});

	// Add to a website Action
	$(".websites button").on('click', function() {
		var i = 0, v = 1;
			for (key2 in boxChecked) {
				i++;
			}
		$(".messageProducts").html("Ajouts des produits <span class='count'>0/"+i+"</span> <i class='fa fa-circle-o-notch fa-spin'></i>").show(200);

		for (key2 in boxChecked) {
			for (key in websitesChecked) {
				$.ajax({
					"url": "/ec/products/addwebsite/"+key2+"/"+key,
					"async": false
				});
				$(".messageProducts .count").html(v + "/" + i);
			}
			v++;
		}
		$(".messageProducts").html("<span class='fui fui-check'></span> Termine !");
		$(".addWebsite").hide(200);
		$(".websites").hide(200);
	});
});

$(window).load(function() {
	var time;
	$(".datFade").each(function(i) {
		time = Math.floor(Math.random() * 100) + 300;
		$(this).delay(time * i).css({'opacity': 0, 'display': "inline-table"}).animate({'opacity': 1}, 500);
	});
});
