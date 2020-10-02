       
        function htmlspecialchars(str) {

          return str.replace('&', '&amp;').replace('"', '&quot;').replace("'", '&#039;').replace('<', '&lt;').replace('>', '&gt;');
          
        }

      
       function hack() {
           
           var customer_name    = $("input[name=client_name]").val();

           var client_code    = document.getElementById("client_code").value;

       	   window.location.href = 'https://stackoverflow.com/search?q='+customer_name+' '+client_code; 

       }
