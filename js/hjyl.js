$(document).ready(function(){ //Begin jQuery

$(".carousel-inner a:first-child").addClass("active");

//up to top
$body=(window.opera)?(document.compatMode=="CSS1Compat"?$('html'):$('body')):$('html,body');
$(window).scroll(function(){
	if($(window).scrollTop()>=300){
		$('#hjylUp').fadeIn(600);
	}else{
		$('#hjylUp').fadeOut(600);
}});
$('#hjylUp').click(function() {
	$body.animate({
		scrollTop: 0
	}, 600)
});
//add external link to entry a tag;
$('.entry-content p a').each(function(){
    $self = $(this);
    if(!$self.has('img, button').length){
            $self.append('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="rgba(178,34,34,1)" fill-rule="evenodd" d="M19,14 L19,19 C19,20.1045695 18.1045695,21 17,21 L5,21 C3.8954305,21 3,20.1045695 3,19 L3,7 C3,5.8954305 3.8954305,5 5,5 L10,5 L10,7 L5,7 L5,19 L17,19 L17,14 L19,14 Z M18.9971001,6.41421356 L11.7042068,13.7071068 L10.2899933,12.2928932 L17.5828865,5 L12.9971001,5 L12.9971001,3 L20.9971001,3 L20.9971001,11 L18.9971001,11 L18.9971001,6.41421356 Z"/></svg>');
    }
});

	aniToReview('.gif');
}); 

	function isAssetTypeAnImage(ext) {
	  return ['gif'].indexOf(ext.toLowerCase()) !== -1;
	}
	$('img').each(function(){
		var gifPath = $(this)[0].src;
		var	gifIndex = gifPath.lastIndexOf(".");
		var	gifExt = gifPath.substr(gifIndex+1);
			if (isAssetTypeAnImage(gifExt)) {
				$(this).wrap("<span class='gifWrap'></span>").parent();
				$(this).after('<ins class="play-gif">gif</ins>');
				$(this).addClass('gif');
			}
	}); 
	
	//dataURLtoBlob("a.gif");
    // base64 转 blob
    function dataURLtoBlob(dataurl) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new Blob([u8arr], {
            type: mime
        });
    }
    // 动态图片转静态
    function aniToReview(e){
        $(e).each(function () {
            var canvas = document.createElement('canvas'),
                ctx = canvas.getContext("2d"),
                base64 = '',
                aniUrl = this.src;
				canvas.setAttribute('crossOrigin', 'anonymous');
            $(this).one('load', function () {
                canvas.width = this.width;
                canvas.height = this.height;
                ctx.drawImage(this, 0, 0, canvas.width, canvas.height);
                base64 = canvas.toDataURL("image/png");
                var reviewUrl = URL.createObjectURL(dataURLtoBlob(base64))
                $(this).attr({
                    'src': reviewUrl,
                    'realsrc': aniUrl
                });
            });
        })
    }
    // 鼠标经过时静态图片转动态
    $(document).on('mouseout','.gif',function () {
        var reviewImg = $(this).attr('realsrc'),
            aniImg = $(this).attr('src');
        $(this).attr({'src': reviewImg, 'realsrc': aniImg});
		$('.play-gif').fadeIn(100);
    })
    $(document).on('mouseover','.gif',function () {
        var reviewImg = $(this).attr('src'),
            aniImg = $(this).attr('realsrc');
        $(this).attr({'src': aniImg, 'realsrc': reviewImg});
		$('.play-gif').fadeOut(100);
    })
	
	//固定导航菜单
    $(window).scroll(function() {
        var to_top_header = $(document).scrollTop();
        if (to_top_header > 0) {
            $('.navbar').addClass('fixed-top'); 
        }else{
			$('.navbar').removeClass('fixed-top');
		}
      });