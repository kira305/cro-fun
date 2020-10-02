    
    var list_menu_id = cro_value.rule_action_id_array;
    
      console.log(list_menu_id);

    $(document).ready(function() {
               
        $( ".menu_parent" ).each(function() {
            
             var menu_id = $(this).attr('data-value');
             //console.log(menu_id);
             var menu_id = parseInt(menu_id);
             //console.log(jQuery.inArray( menu_id,list_menu_id ));
             if(jQuery.inArray( menu_id,list_menu_id ) == -1){

                    $(this).remove();
             }
           

        });

        $( ".menu_main" ).each(function() {
            
             var menu_id = $(this).attr('data-value');
             //console.log(menu_id);
             var menu_id = parseInt(menu_id);
             //console.log(jQuery.inArray( menu_id,list_menu_id ));
             if(jQuery.inArray( menu_id,list_menu_id ) == -1){

                    $(this).remove();
             }
           

        });
        

        $( ".menu_child" ).each(function() {
            
             var menu_id = $(this).attr('data-value');
             //console.log(menu_id);
             var menu_id = parseInt(menu_id);
             //console.log(jQuery.inArray( menu_id,list_menu_id ));
             if(jQuery.inArray( menu_id,list_menu_id ) == -1){

                    $(this).remove();
             }
           

        });


    });
