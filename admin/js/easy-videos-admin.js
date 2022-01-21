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
        var serialized = $( '#import_easy_videos' ).serialize();
	     // an object to store the form data
         data = {};
         data['id'] = {};
         data['publishedAt'] = {};
         data['channelId'] = {};
         data['title'] = {};
         data['description'] = {};
		

        // for each array element of the serializeArray
        // runs the function to create a new attribute on data
        // with the correct value
     //  $( ".ui-chosen :input" ).serializeArray().forEach( function(element){
      //      data[element.name] = element.value;
     //   });
		
		  $( "li.ui-chosen" ).each( function(index){
            // console.log( index + ": " + $('li.ui-chosen input:hidden[name=id]').eq(index).val() );
		    // data[element.name] = element.value;  
			   data['id'][index] 			=  $('li.ui-chosen input:hidden[name=id]').eq(index).val() ;
			   data['publishedAt'][index] 	=  $('li.ui-chosen input:hidden[name=publishedAt]').eq(index).val() ;
			   data['channelId'][index] 	=  $('li.ui-chosen input:hidden[name=channelId]').eq(index).val() ;
			   data['title'][index]         =  $('li.ui-chosen input:hidden[name=title]').eq(index).val() ;
			   data['description'][index]   =  $('li.ui-chosen input:hidden[name=description]').eq(index).val() ;
			   
          });
	    data['action'] = 'esay_import';
	    console.log( JSON.stringify(data) );
		
	    console.log( (data) );
		
	   // $('#import_easy_videos').serialize()
	   // listItems = $("#selectable").find("li.ui-chosen type[hidden]").each(function(){
		//   var product = $(this);
		 //  console.log(product);
		 
		   // rest of code.
		// });
	   var mydata = JSON.stringify(data);
	     console.log( (mydata) );
	    var data1 = {
             action: 'esay_import',
             security: easy_video_variables.nonce,
             name: $("#name").val(),
             email: $("#email").val()
        }
		

        $.ajax({
			
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

