
$(function(){
    
   "use strict"; 
    
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
        
        pagination.find("ul li").on("click", function(){
            
            var linkNbr = $(this).text();            
            var itemsToHide = itemsToPaginate.filter(":lt(" + (linkNbr * settings.itemsPerPage-1) + ")");

            var itemsToShow = $(".all").not(itemsToHide).show();
            
            
        });
        
    }
    
    
    
    
    
    
});