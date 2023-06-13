jQuery(document).ready(function($) {

	/*
	* Ajax like shot
	*/
	
	$(".like").stop().click(function(){

		var rel = $(this).attr("rel");

		var data = {
			data: rel,
			action: 'like_callback'
		}
		$.ajax({
			action: "like_callback",
			type: "GET",
			dataType: "json",
			url: ajaxurl,

			data: data,
			success: function(data){

				console.log(data.likes);
				console.log(data.status);

				if(data.status == true){
					$("#like__count").html(data.likes);
					$(".like[rel="+rel+"]").addClass("liked");
				}else{
					$("#like__count").html(data.likes);
					$(".like[rel="+rel+"]").removeClass("liked");
				}

			}
		});

	});

});