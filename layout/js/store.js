function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}

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

// Add active class to the current control button (highlight it)
var btnContainer = document.getElementById("myBtnContainer");
var btns = btnContainer.getElementsByClassName("w3-button");
for (var i = 0; i < btns.length; i++) {
  btns[i].addEventListener("click", function() {
    var current = document.getElementsByClassName("w3-black");
    current[0].className = current[0].className.replace(" w3-black", "");
    this.className += " w3-black";
  });
}