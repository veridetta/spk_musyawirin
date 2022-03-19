jQuery.imageMagnify={
	dsettings: {
		magnifyby: 2,
		duration: 500,
		imgopacity: 0.2
 	},
	cursorcss: '-moz-zoom-in', 
	zIndexcounter: 100,

	refreshoffsets:function($window, $target, warpshell){
		var $offsets=$target.offset()
		var winattrs={x:$window.scrollLeft(), y:$window.scrollTop(), w:$window.width(), h:$window.height()}
		warpshell.attrs.x=$offsets.left 
		warpshell.attrs.y=$offsets.top
		warpshell.newattrs.x=winattrs.x+winattrs.w/2-warpshell.newattrs.w/2
		warpshell.newattrs.y=winattrs.y+winattrs.h/2-warpshell.newattrs.h/2
		if (warpshell.newattrs.x<winattrs.x+5){ 
			warpshell.newattrs.x=winattrs.x+5	
		}
		else if (warpshell.newattrs.x+warpshell.newattrs.w > winattrs.x+winattrs.w){
			warpshell.newattrs.x=winattrs.x+5
		}
		if (warpshell.newattrs.y<winattrs.y+5){ 
			warpshell.newattrs.y=winattrs.y+5
		}
	},

	magnify:function($, $target, options){
		var setting={} 
		var setting=jQuery.extend(setting, this.dsettings, options)
		var attrs=(options.thumbdimensions)? {w:options.thumbdimensions[0], h:options.thumbdimensions[1]} : {w:$target.outerWidth(), h:$target.outerHeight()}
		var newattrs={}
		newattrs.w=(setting.magnifyto)? setting.magnifyto : Math.round(attrs.w*setting.magnifyby)
		newattrs.h=(setting.magnifyto)? Math.round(attrs.h*newattrs.w/attrs.w) : Math.round(attrs.h*setting.magnifyby)
		$target.css('cursor', jQuery.imageMagnify.cursorcss)
		if ($target.data('imgshell')){
			$target.data('imgshell').$clone.remove()
			$target.css({opacity:1}).unbind('click.magnify')
		}	
		var $clone=$target.clone().css({position:'absolute', left:0, top:0, visibility:'hidden', border:'1px solid gray', cursor:'pointer'}).appendTo(document.body)
		$clone.data('$relatedtarget', $target)
		$target.data('imgshell', {$clone:$clone, attrs:attrs, newattrs:newattrs})
		$target.bind('click.magnify', function(e){ 
			var $this=$(this).css({opacity:setting.imgopacity})
			var imageinfo=$this.data('imgshell')
			jQuery.imageMagnify.refreshoffsets($(window), $this, imageinfo)
			var $clone=imageinfo.$clone
			$clone.stop().css({zIndex:++jQuery.imageMagnify.zIndexcounter, left:imageinfo.attrs.x, top:imageinfo.attrs.y, width:imageinfo.attrs.w, height:imageinfo.attrs.h, opacity:0, visibility:'visible', display:'block'})
			.animate({opacity:1, left:imageinfo.newattrs.x, top:imageinfo.newattrs.y, width:imageinfo.newattrs.w, height:imageinfo.newattrs.h}, setting.duration,
			function(){
			}) 
		}) 
		$clone.click(function(e){ 
			var $this=$(this)
			var imageinfo=$this.data('$relatedtarget').data('imgshell')
			jQuery.imageMagnify.refreshoffsets($(window), $this.data('$relatedtarget'), imageinfo)
			$this.stop().animate({opacity:0, left:imageinfo.attrs.x, top:imageinfo.attrs.y, width:imageinfo.attrs.w, height:imageinfo.attrs.h},  setting.duration,
			function(){
				$this.hide()
				$this.data('$relatedtarget').css({opacity:1})
			})
		}) 
	}
};

jQuery.fn.imageMagnify=function(options){
	var $=jQuery
	return this.each(function(){ 
		var $imgref=$(this)
		if (this.tagName!="IMG")
			return true 
		if (parseInt($imgref.css('width'))>0 && parseInt($imgref.css('height'))>0 || options.thumbdimensions){ 
			jQuery.imageMagnify.magnify($, $imgref, options)
		}
		else if (this.complete){ 
			jQuery.imageMagnify.magnify($, $imgref, options)
		}
		else{
			$(this).bind('load', function(){
				jQuery.imageMagnify.magnify($, $imgref, options)
			})
		}
	})
};

jQuery.fn.applyMagnifier=function(options){ 
	var $=jQuery
	return this.each(function(){ 
		var $imgref=$(this)
		if (this.tagName!="IMG")
			return true 
		
	})	

};

jQuery(document).ready(function($){
	var $targets=$('.magnify')
	$targets.each(function(i){
		var $target=$(this)
		var options={}
		if ($target.attr('data-magnifyto'))
			options.magnifyto=parseFloat($target.attr('data-magnifyto'))
		if ($target.attr('data-magnifyby'))
			options.magnifyby=parseFloat($target.attr('data-magnifyby'))
		if ($target.attr('data-magnifyduration'))
			options.duration=parseInt($target.attr('data-magnifyduration'))
		$target.imageMagnify(options)
	})
	var $triggers=$('a[rel^="magnify["]')
	$triggers.each(function(i){
		var $trigger=$(this)
		var targetid=$trigger.attr('rel').match(/\[.+\]/)[0].replace(/[\[\]']/g, '')
		$trigger.data('magnifyimageid', targetid)
		$trigger.click(function(e){
			$('#'+$(this).data('magnifyimageid')).trigger('click.magnify')
			e.preventDefault()
		})
	})
})

