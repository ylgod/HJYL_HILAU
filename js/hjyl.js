$(document).ready(function(){ //Begin jQuery

$(".carousel-inner a:first-child").addClass("active");
$(".carousel-inner img").removeClass("img-fluid");


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
    if(!$self.has('img').length){
            $self.append(' <i class="fas fa-external-link-alt"></i>');
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