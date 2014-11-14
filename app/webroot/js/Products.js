/**
 * Products Script
 * By: Louis <louis@ne02ptzero.me>
 */

	var		websitesChecked = {};
	var		collectionsChecked = {};
$(document).ready(function() {
	// Check and Unchecked shortDescription
	var		actualHover = 0;
	var		actualHoverBox = 0;
	var		actualText = 0;
	var		boxChecked = {};
	var		selectAll = 0;

	// Fixes on Flat-UI
	$(".websites ul li").on('click', function() {
		var className = $(this).attr('class');
		var id = $(this).attr('name');
		if (className == undefined || className == "") {
			delete websitesChecked[id];
		} else {
			websitesChecked[id] = 1;
		}
	});

	$(".collections ul li").on('click', function() {
		var className = $(this).attr('class');
		var id = $(this).attr('name');
		if (className == undefined || className == "") {
			delete collectionsChecked[id];
		} else {
			collectionsChecked[id] = 1;
		}
	});

	// Ajax for menu
	$(".todo ul li ul li").on('click', function() {
		var link = $(this).find('a');
		var time;
		link = link.attr('href');
		if (link != undefined) {
			$(".result").html('<div class="wait">Un instant...<br /><i class="fa fa-refresh fa-spin"></i></div>');
		   $.ajax({
				url: link,
				success: function (data, status) {
					actualHover = 0;
					actualHoverBox = 0;
					actualText = 0;
					boxChecked = {};
					$(".delete").hide(200);
					$(".addWebsite").hide(200);
					$(".websites").hide(200);
				   $(".result").delay(200).fadeOut(600, function() {
						$(".result").fadeIn(200);
						$(".result").html(data);
						$(".result .col-xs-2").remove()
						$(".result .messageProducts").remove();
						$(".result .delete").remove();
						$(".result .more").remove();
						$(".result .selectAll").remove();
						$(".result .addWebsite").remove();
						$(".result .todo").remove();
						$(".datFade").each(function(i) {
							time = Math.floor(Math.random() * 1000) + 300;
							$(this).delay(time).css({'opacity': 0, 'display': "inline-table"}).animate({'opacity': 1}, 500);
						});
					});
				}
			});
		}
		return false;
	});

	$(document).on('click', ".subMenu ul li a", function() {
		var link = $(this).attr('href');
		var time;
		for (i = 0; $(".result")[i] != undefined; i++)
			obj = $(".result")[i];
		if (link != undefined) {
			$(obj).html('<div class="wait">Un instant...<br /><i class="fa fa-refresh fa-spin"></i></div>');
		   $.ajax({
				url: link,
				success: function (data, status) {
					actualHover = 0;
					actualHoverBox = 0;
					actualText = 0;
					boxChecked = {};
					$(".addWebsite").hide(200);
					$(".websites").hide(200);
				   $(obj).delay(200).fadeOut(600, function() {
						$(obj).fadeIn(200);
						$(obj).html(data);
						$(".result .col-xs-2").remove()
						$(".result .messageProducts").remove();
						$(".result .delete").remove();
						$(".result .more").remove();
						$(".result .selectAll").remove();
						$(".result .addWebsite").remove();
						$(".result .todo").remove();
						$(".datFade").each(function(i) {
							time = Math.floor(Math.random() * 1000) + 300;
							$(this).delay(time).css({'opacity': 0, 'display': "inline-table"}).animate({'opacity': 1}, 500);
						});
					});
				}
			});
		}
		return false;
	});


	// Search ajax
	$(".productSearch").keyup(function() {
		name = $(this).val();
		url = "/ec/Products/search/" + name;
		if (name == "") {
			url = "/ec/Products/";
		}
			$(".result").html('<div class="wait">Un instant...<br /><i class="fa fa-refresh fa-spin"></i></div>');
			$.ajax({
				url: url,
					success: function (data, status) {
					actualHover = 0;
					actualHoverBox = 0;
					actualText = 0;
					boxChecked = {};
					$(".delete").hide(200);
					$(".addWebsite").hide(200);
					$(".websites").hide(200);
					$(".result").hide().html(data);
					//$(".result h1").remove()
					$(".result .col-xs-2").remove()
					$(".result .messageProducts").remove();
					$(".result .delete").remove();
					$(".result .selectAll").remove();
					$(".result .more").remove();
					$(".result .addWebsite").remove();
					$(".result .todo").remove();
					$(".result").fadeIn(200);
					$(".result .datFade").each(function(i) {
						time = Math.floor(Math.random() * 100) + 300;
						$(this).delay(time * i).css({'opacity': 0, 'display': "inline-table"}).animate({'opacity': 1}, 500);
					});
				}
			});
	});

	$(".selectAll").on('click', function() {
		if (selectAll == 0) {
			$(".delete").show(200);
			$(".addWebsite").show(200);
			$(".more").show(200);
			$(".result input").each(function(i) {
				$(this).prop('checked', true);
				boxChecked[$(this).val()] = 1;
				$(this).parent("label").fadeIn(200);
			});
			selectAll = 1;
		} else {
			$(".delete").hide(200);
			$(".addWebsite").hide(200);
			$(".more").hide(200);
			$(".collections").hide(200);
			$(".result input").each(function(i) {
				$(this).prop('checked', false);
				boxChecked[$(this).val()] = 0;
				$(this).parent("label").fadeOut(200);
			});
			boxChecked = {};
			selectAll = 0;
		}
	});

	$('.useShortDescription').change(function() {
		if (!this.checked)
			$(".addProduct .shortDescription").show(300);
		else
			$(".addProduct .shortDescription").hide(300);
	});

	$(document).on('change', '.countCheckBox', function() {
		var i = Object.keys(boxChecked).length;
		if (this.checked)
			boxChecked[$(this).val()] = 1;
		else
			delete boxChecked[$(this).val()];
		var v = Object.keys(boxChecked).length;
		if (i == 0 && v > 0) {
			$(".delete").show(200);
			$(".addWebsite").show(200);
			$(".more").show(200);
		}
		else if (i > 0 && v == 0) {
			$(".delete").hide(200);
			$(".addWebsite").hide(200);
			$(".websites").hide(200);
			$(".more").hide(200);
			$(".collections").hide(200);
		}
	});

	// Hover products
	$(document).on('mouseover', '.product_list ul li', function() {
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

	$(".more").on('click', function() {
		$(".collections").show(200);
	});

	// Add to collection button
	$(document).on('click', '.collections button', function() {
		$(".messageProducts").html("Ajouts des créations... <i class='fa fa-circle-o-notch fa-spin'></i>").show(200);
		for (key2 in boxChecked) {
			for (key in collectionsChecked) {
				$.ajax({
					"url": "/ec/Collections/addProduct/"+key2+"/"+key,
					success: function () {
						$(".collectionId"+key).html(($(".collectionId"+key).html() * 1) + (1 * 1));
					}
				});
			}
		}
		$(".messageProducts").html("Terminé !").show(200);
		$(".more").hide(200);
		$(".collections").hide(200);
	});

	// Add to a website Action
	$(document).on('click', '.websites button', function() {
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

	$(".dropdownMenu li .fui-plus").on('click', function() {
		value = $(this).parent().find("input").val();
		url = "/ec/Collections/add/" + value;
		current = $(this);
		$(this).parent().find("span").attr("class", "").html('<i class="fa fa-refresh fa-spin"></i>');
	   $.ajax({
			url: url,
			success: function (data, status) {
				current.parent().find("span").attr("class", "fui-plus").html("");
				current.parent().find("input").val("");
				current.parent().parent().append("<li><a href='/ec/Products/viewCollection/"+data+"'>"+value+"</a></li>");
			}
		});
	});
});

$(window).load(function() {
	var time;
	$(".datFade").each(function(i) {
		time = Math.floor(Math.random() * 1000) + 300;
		console.log(time);
		$(this).delay(time).css({'opacity': 0, 'display': "inline-table"}).animate({'opacity': 1}, 500);
	});
});
