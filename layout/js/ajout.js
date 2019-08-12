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




const uploadButton1 = document.querySelector('.browse-btn1');
const fileInfo1 = document.querySelector('.file-info1');
const realInput1 = document.getElementById('file-input1');

uploadButton1.addEventListener('click', (e) => {
  realInput1.click();
});

realInput1.addEventListener('change', () => {
  const name1 = realInput1.value.split(/\\|\//).pop();
  const truncated1 = name1.length > 20 
    ? name1.substr(name1.length - 20) 
    : name1;
  
  fileInfo1.innerHTML = truncated1;
});


const uploadButton2 = document.querySelector('.browse-btn2');
const fileInfo2 = document.querySelector('.file-info2');
const realInput2 = document.getElementById('file-input2');

uploadButton2.addEventListener('click', (e) => {
  realInput2.click();
});

realInput2.addEventListener('change', () => {
  const name2 = realInput2.value.split(/\\|\//).pop();
  const truncated2 = name2.length > 20 
    ? name2.substr(name2.length - 20) 
    : name2;
  
  fileInfo2.innerHTML = truncated2;
});



const uploadButton3 = document.querySelector('.browse-btn3');
const fileInfo3 = document.querySelector('.file-info3');
const realInput3 = document.getElementById('file-input3');

uploadButton3.addEventListener('click', (e) => {
  realInput3.click();
});

realInput3.addEventListener('change', () => {
  const name3 = realInput3.value.split(/\\|\//).pop();
  const truncated3 = name3.length > 20 
    ? name3.substr(name3.length - 20) 
    : name3;
  
  fileInfo3.innerHTML = truncated3;
});




// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close-btn")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}