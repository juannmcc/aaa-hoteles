(function ($) {
	$( document ).ready(function() {

		/* Active CSS Page onClick */
		$(".nav li a").on("click", function(e) {
			$(".nav li").removeClass("active");

			var $parent = $(this).parent();
			if (!$parent.hasClass('active')) {
			    $parent.addClass('active');
			}
			e.preventDefault();
		});
		
		var url = window.location.href;

		$('#header-hotelList > li a').click(function(e){
			var className = $(this).attr('class');
			var valueName = $(this).attr('value');
			var cities = ["alcorcon", "chamberi", "cordoba", "malaga", "valencia", "zaragoza"];
			for (var i = 0; i < cities.length; i++) {
			    if (url.indexOf(cities[i]) !== -1) { 
			    	url = url.replace(cities[i], className);
			    	console.log("Update with: "+url);
			    	window.location.href = url;
					$.ajax({
					    type: 'POST',
					    data: { 
					        'valueName': valueName, 
					    },
					    success: function(msg){
			    			$("#actual-hotel").text("Hotel actual: "+valueName);
					    }
					});
			    }
			}
			e.preventDefault();
		});

		$(".form-upd-rooms #appbundle_habitaciones_idhotel").prop('disabled', true);
		
		/* Return Room Item onClick /{hotelSlug}/habitaciones */
		/*$('a.roomLink').on('click', function(){
			var idHabitacionPosted = $(this).find('span').text();
			//var path = "{{ path('roompage', {'slugHotel': 'alcorcon'})) }}";
			
			$.ajax({
	            type: "POST",
	            data: {
	                idHabitacionPosted: idHabitacionPosted
	            }, 
	            success: function(data){
	                $('div.room-details h3').text('Habitación nº'+idHabitacionPosted);
	                $('.no-room-selected').css({'display': 'none', 'opacity': '0'});
	                $('.room-selected').css({'display': 'block'});
	            }
	        });
		});
*/
	});
})(window.jQuery);