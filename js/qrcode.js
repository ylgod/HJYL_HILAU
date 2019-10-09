	jQuery(function(){
		$(".qrcode").qrcode({
			render: "canvas",
			text: document.location.href,
			width : "180",               //二维码的宽度
			height : "180",              //二维码的高度
			background : "#ffffff",       //二维码的后景色
			foreground : "#000000",        //二维码的前景色
			//src: 'img/logo.png'             //二维码中间的图片
		});
	});
	
    $('#primary a:has(img)').each(function(){
		var dataTitle = $(this).find('img').attr('alt');
		$(this).attr({'data-lightbox' : 'hilau.com', 'data-title' : dataTitle});
		
	}); 