$(function(){
    
    'user strict' ;
    
        var username = new RegExp('^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z]([._-]?[a-zA-Z0-9])+(?<![_.])$');
        var fullname = new RegExp("^[a-zA-Z]+(([' -][a-zA-Z ])?[a-zA-Z]+)*$");
        var password = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$");    


    
    $('#username').keyup(function(){
        
       if( username.test( $(this).val().trim()) ){

           $(this).css('border','1px solid #080');
           
           $(this).parent().find('.alert-username').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $(this).parent().find('.alert-username').fadeIn(200);           
           

       }
        
    });
        
    $('#fullname').keyup(function(){
        
       if( fullname.test( $(this).val().trim()) && $(this).val().trim().length >= 3){

           $(this).css('border','1px solid #080');
           
           $(this).parent().find('.alert-fullname').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $(this).parent().find('.alert-fullname').fadeIn(200);           
           

       }        

    
    });
    
    $('#title').keyup(function(){
        
       if( $(this).val().trim().length >= 7 ){

           $(this).css('border','1px solid #080');
           
           $(this).parent().find('.alert-title').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $(this).parent().find('.alert-title').fadeIn(200);           
           

       }        

    
    });
    
    $('#contEmail').keyup(function(){
        
       if( $(this).val().trim().length > 0 ){

           $(this).css('border','1px solid #080');
           
           $('.alert-contEmail').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-contEmail').fadeIn(200);           
           

       }        

    
    });
    
    $('#contMessage').keyup(function(){
        
       if( $(this).val().trim().length >= 20 ){

           $(this).css('border','1px solid #080');
           
           $(this).parent().find('.alert-contMessage').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $(this).parent().find('.alert-contMessage').fadeIn(200);           
           

       }        

    
    });
    
    $('#adname').keyup(function(){
        
       if( $(this).val().trim().length >= 3 ){

           $(this).css('border','1px solid #080');
           
           $('.alert-adname').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-adname').fadeIn(200);           
           

       }
        
    });
        
    $('#price').keyup(function(){
        
       if( $.isNumeric($(this).val()) && $(this).val() > 0){

           $(this).css('border','1px solid #080');
           
           $('.alert-price').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-price').fadeIn(200);           
           

       }        

    
    });
    
    if($('#file-input').val() == ""){
        
    $("#newad").click(function() {
        
      $(".alert-photo").fadeIn(200);
        
    }); 
        
    }
    

       
    });