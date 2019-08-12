
$(function(){
    
    'use strict';
    
        var username = new RegExp('^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z]([._-]?[a-zA-Z0-9])+(?<![_.])$');
        var password = new RegExp('^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[?_#$^+=!*()@%&]).{8,}$');
        var fullname = new RegExp("^[a-zA-Z]+(([' -][a-zA-Z ])?[a-zA-Z]+)*$")
    
    // placeholder
    
    $('[placeholder]').focus(function(){
        
        $(this).attr('data-text',$(this).attr('placeholder'));
        
        $(this).attr('placeholder','');
        
    }).blur(function(){
        
        $(this).attr('placeholder',$(this).attr('data-text'));
        
    });
    
    $(".filter-link").click(function(){

        $(this).addClass("w3-teal").removeClass("w3-light-grey").siblings().addClass("w3-light-grey").removeClass("w3-teal");
        
    });      
    
    // Asterix
    
    $('input').each(function(){
        
        
        if($(this).attr('required') === 'required') {
            
            $(this).after("<span class='asterisk'>*</span>");
        }
        
    });
    
    //  Convert password to text
    
    var passfield =$('.password');
    
    $('.show-pass').hover(function(){
        
        passfield.attr('type','text');
    },
            
        function(){
            
            passfield.attr('type','password');
            
        });
        
    
    // delete confirmation
    
    $(".confirm").click(function(){
        
       return confirm("Vous etes sure ?") ;
        
        
    });
    
    $(".cat h3").click(function(){
        
       $(this).next(".full-view").fadeToggle(200);
        
        
    });
    
    $(".toggle-info").click(function(){
        
        $(this).toggleClass("selected").parent().next(".panel-body").fadeToggle(200);
        
        if($(this).hasClass("selected")){
            
            $(this).html('<i class="fa fa-plus"></i>');
        }
        else
        {
           $(this).html('<i class="fa fa-minus"></i>');     
                
        }
        
    });
    
    
    $(".edit-link").hover(function(){
        
        $(this).find(".show-delete").fadeIn(300);
    }, function(){
        
        $(this).find(".show-delete").fadeOut(300);
        
    });
    
    
    $(".see-all").click(function(){
        
        $(".top-6").fadeToggle(0);
        $(".all-wilayas").fadeToggle(0);
        
    });
    
var $rows = $('#result .filtered');
$('#myInput').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
    
    
    $.fn.myPagination = function(options)
    {
        var pagination = this ;
        var itemsToPaginate;
        var dflt = {
        
        itemsPerPage : 12
        
    };
        var settings = {};
        
        $.extend(settings, dflt, options);

        itemsToPaginate = $(settings.itemsToPaginate);
        var nbrItems = Math.ceil(itemsToPaginate.length/settings.itemsPerPage);
        
        $("<ul></ul>").prependTo(pagination);
        for(var index = 0 ; index < nbrItems ; index++){
            
            pagination.find("ul").append("<li>" + (index+1) + "</li>")
        }
        
        itemsToPaginate.filter(":gt(" + (settings.itemsPerPage-1) + ")").hide();        
        
        pagination.find("ul li").on("click", function(){
            
            var linkNbr = $(this).text();            
            var itemsToHide = itemsToPaginate.filter(":lt(" + ((linkNbr-1) * settings.itemsPerPage) + ")");
            $.merge(itemsToHide, itemsToPaginate.filter(":gt(" + ((linkNbr * settings.itemsPerPage)-1) + ")"));
            itemsToHide.hide();
            var itemsToShow = itemsToPaginate.not(itemsToHide);
            itemsToShow.show();
            
            
        });
        
    }    

        
    $(".pagination").myPagination({
        
        itemsToPaginate : ".main-table tr"
        
    });      
    
    
// cache collection of elements so only one dom search needed
var $mediaElements = $('.all');    
$('.filter-link').click(function(e){
    e.preventDefault();
    // get the category from the attribute
    var filterVal = $(this).data('filter');

    if(filterVal === 'all'){
      $mediaElements.show();
    }else{
       // hide all then filter the ones to show
       $mediaElements.hide().filter('.' + filterVal).show();
    }
});
    
    $('#brand').blur(function(){
        
       if( $(this).val().trim().length >= 2 ){

           $(this).css('border','1px solid #080');
           
           $('.alert-brand').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-brand').fadeIn(200);           
           

       }        

    
    });
    
    if($('#file-input').val() == ""){
        
    $("#newbrand").click(function() {
        
      $(".alert-photo").fadeIn(200);
        
    }); 
        
    }
    
    $('#username').blur(function(){
        
       if( username.test( $(this).val().trim()) ){

           $(this).css('border','1px solid #080');
           
           $('.alert-username').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-username').fadeIn(200);           
           

       }
        
    });
    
    $('#password').blur(function(){
        
       if( password.test($(this).val().trim())){

           $(this).css('border','1px solid #080');
           
           $('.alert-password').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-password').fadeIn(200);           
           

       }
        
    });
    
    $('#email').blur(function(){
        
       if( $(this).val().trim().length > 0){

           $(this).css('border','1px solid #080');
           
           $('.alert-email').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-email').fadeIn(200);           
           

       }
        
    });     
    
    $('#fullname').blur(function(){
        
       if( fullname.test($(this).val().trim())){

           $(this).css('border','1px solid #080');
           
           $('.alert-fullname').fadeOut(200);
           
           
       }  
       else{
           
           $(this).css('border','1px solid #F00');
           
           $('.alert-fullname').fadeIn(200);           
           

       }
        
    });    
    
});

const uploadButton = document.querySelector('.browse-btn');
const fileInfo = document.querySelector('.file-info');
const realInput = document.getElementById('file-input');

uploadButton.addEventListener('click', (e) => {
  realInput.click();
});

realInput.addEventListener('change', () => {
  const name = realInput.value.split(/\\|\//).pop();
  const truncated = name.length > 20 
    ? name.substr(name.length - 20) 
    : name;
  
  fileInfo.innerHTML = truncated;
});




