   /**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * ...and/or other possibilities.
	 *

	 */
	 



jQuery(document).ready(function($) {
   
     $("#submit_btn").click(function(e) {
	    
		e.preventDefault();
	     // an object to store the form data
         var data = {};
		
         data['id'] = {};
         data['publishedAt'] = {};
         data['channelId'] = {};
         data['title'] = {};
         data['description'] = {};
		

		  $( "li.ui-chosen" ).each( function(index){
			 
			   data['id'][index] 			=  $('li.ui-chosen input:hidden[name=id]').eq(index).val() ;
			   data['publishedAt'][index] 	=  $('li.ui-chosen input:hidden[name=publishedAt]').eq(index).val() ;
			   data['channelId'][index] 	=  $('li.ui-chosen input:hidden[name=channelId]').eq(index).val() ;
			   data['title'][index]         =  $('li.ui-chosen input:hidden[name=title]').eq(index).val() ;
			   data['description'][index]   =  $('li.ui-chosen input:hidden[name=description]').eq(index).val() ;
			  
          });
		

		data['action'] = 'esay_import';
		
        $.ajax({
			action: 'esay_import',
            type: 'POST',
            url: easy_video_variables.ajaxurl,
			
            data: data,
			
            success: function(response) {
                //output the response on success
                $("#response").html(response);

            },
            error: function(err) {
                console.log(err);
            }
        });
    
        return false;
   });

    
              
});





jQuery(document).ready(function($) {
	
	  $("#selectable").selectable({
		  
			selected: function(e, ui) {
				$(ui.selected).toggleClass("ui-chosen")
				$(this).find(".ui.chosen").addClass("ui-selected")
				
		  }
	  }); 
	  
	  
	   
});

