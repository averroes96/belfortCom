$(function(){
    
    'use strict';
    
      function isEmpty( el ){
      return !$.trim(el.html());
        }    
    
    // Login / Signup choice
    
    $(".forms h1 span").click(function(){
        
        $(this).addClass("active").siblings().removeClass("active");
        $(".forms form").hide(300);
        $("." + $(this).data("class")).show(300);
        
    });
     
    
    $(".filter-link").click(function(){

        $(this).addClass("w3-teal").removeClass("w3-light-grey").siblings().addClass("w3-light-grey").removeClass("w3-teal");
        
    });
    
    $(".pagination ul li").click(function(){

        $(this).addClass("w3-teal").siblings().removeClass("w3-teal");
        
    });     
    
    // placeholder
    
    $('[placeholder]').focus(function(){
        
        $(this).attr('data-text',$(this).attr('placeholder'));
        
        $(this).attr('placeholder','');
        
    }).blur(function(){
        
        $(this).attr('placeholder',$(this).attr('data-text'));
        
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
        $(this).find(".fa").toggleClass("fa-angle-right").toggleClass("fa-angle-down");
        
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
    
    
    $(".live-name").keyup(function(){
        
        $(".live-preview .caption h3").text($(this).val());
        
        
    });
    
    $(".live-price").keyup(function(){
        
        $(".live-preview .caption .price-tag").text($(this).val() + " DA");
        
        
    });
    
    $(".live-wilaya").change(function(){
        
        $(".live-preview .caption .wilaya").text($(this).val() );
        
        
    });
    
    $(".live-status").change(function(){
        
        $(".live-preview .caption .status").text($(this).val() + "/5" );
        
        
    });
    
    
var $messages = $('.li-messages');
$('#search_input').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $messages.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});

var $rows = $('.cat');
$('#forum_search').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();

});
    
$(".tablink").click(function(){
    
    
    $(".tablink").removeAttr("id","defaultOpen");
    $(this).attr("id","defaultOpen");
    
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
        
        itemsToPaginate : ".all"
        
    });

    
    $(".remove1").click(function(){
        $(".file-info1").text("");
        $(this).hide();
     });
    
    $(".remove2").click(function(){
        $(".file-info2").text("");
        $(this).hide();        
     });
    
    $(".remove3").click(function(){
        $(".file-info3").text("");
        $(this).hide();        
     });    
    
    $("#edit_form").click(function() {
      $("#hidden_input1").val($(".file-info1").text());
      $("#hidden_input2").val($(".file-info2").text());
      $("#hidden_input3").val($(".file-info3").text());        
    }); 
    
    $("#file-input1").change(function(){
        
        if(!isEmpty($(".file-info1"))){
       
            $(".remove1").show();
       }        
        
    });
    
    $("#file-input2").change(function(){
        
        if(!isEmpty($(".file-info2"))){
       
            $(".remove2").show();
       }        
        
    });
    
    $("#file-input3").change(function(){
        
        if(!isEmpty($(".file-info3"))){
       
            $(".remove3").show();
       }        
        
    });    

    

    if (isEmpty($('#Items'))) {
      $("#Items").html("<p class='alert alert-danger w3-center w3-padding' style='margin-top:50px'>Aucune annonce n'a été trouvée</p>");
    }
    
    if (isEmpty($('#Users'))) {
      $("#Users").html("<p class='alert alert-danger w3-center w3-padding' style='margin-top:50px'>Aucun membre n'a été trouvé</p>");
    }
    
    if (isEmpty($('#Subjects'))) {
      $("#Subjects").html("<p class='alert alert-danger w3-center w3-padding' style='margin-top:50px'>Aucune sujet trouvée</p>");
    }    

});


    $(".info-panel").hover(function(){
        
        $(this).find(".edit-btn").show();
        
    },function(){
        
        $(this).find(".edit-btn").hide();   
 
    });

    function openSideNav() {
  document.getElementById("mySidenav").style.width = "250px";
}

    function closeNav() {
  document.getElementById("mySidenav").style.width = "0";
}

    function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.profile-pic').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

    $("#file-input").change(function(){
    readURL(this);
    });

    function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.item-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

    $("#file-input").change(function(){
    readURL2(this);
    });


    // function to display item images 

    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById('myImg');
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function(){
      modal.style.display = "block";
      modalImg.src = this.src;
      captionText.innerHTML = this.alt;
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() { 
      modal.style.display = "none";
    }
    
    
    // Accordion
    function myFunction(id) {
      var x = document.getElementById(id);
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
        x.previousElementSibling.className += " w3-theme-d1";
      } else { 
        x.className = x.className.replace("w3-show", "");
        x.previousElementSibling.className = 
        x.previousElementSibling.className.replace(" w3-theme-d1", "");
      }
    }

    // Used to toggle the menu on smaller screens when clicking on the menu button
    function openNav() {
      var x = document.getElementById("navDemo");
      if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
      } else { 
        x.className = x.className.replace(" w3-show", "");
      }
    }

    // Modal Image Gallery
    function onClick(element) {
      document.getElementById("img01").src = element.src;
      document.getElementById("modal01").style.display = "block";
      var captionText = document.getElementById("caption");
      captionText.innerHTML = element.alt;
    }

function prepareDiv() {
    document.getElementById("hidden_input1").value = document.getElementById("file-input1").innerHTML;
}