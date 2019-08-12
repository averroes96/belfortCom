    const searchBar=document.forms['search'].querySelector('input');

    searchBar.addEventListener('onClick',function (e) {
    const term=e.target.value.toLowerCase();
    const users=list.getElementById("ul_messages");
    Array.from(users).forEach(function (user) {
        const name= user.firstElementChild.textContent;
        })
    });


        $(".messages").animate({ scrollTop: $(document).height() }, "fast");

        $(document).ready(function () {
                $(".contact").click(function () {
                    var username = $(this).attr('name');

                    $(function () {
                        $.ajax({
                           type:"POST",
                           url:'selected_user.php',
                           data: ({other_user_name:username}),
                           success : function(data){
                           window.location='messages.php?target=wahibRD';
                           }
                        });
                        
                    });
                });
            
        });

          let input,filter,ul,li,p,i,txtvalue;
          input= document.getElementById('search_input');
          filter= input.value.toUpperCase();
          ul=document.getElementById('ul_message');
          li=ul.getElementsByTagName('li');

          for(i=0;i<ul.length;i++){
              p = li[i].getElementsByClassName("wrap").getElementsByClassName("meta").getElementsByClassName("name");
              txtvalue = p.innerText ;
              if (txtvalue.toUpperCase().indexOf(filter) <= -1) {
                  li[i].style.disable = "";
              }else{
                  li[i].style.disable = "none" ;
              }
          }