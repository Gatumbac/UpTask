!function(){const e=document.querySelector("#menu"),n=document.querySelector("#close-menu"),s=document.querySelector(".sidebar");!function(e,n){if(!e||!n)return;e.addEventListener("click",(function(){s.classList.add("show-nav"),s.classList.remove("close-nav")})),n.addEventListener("click",(function(){s.classList.add("close-nav"),setTimeout((()=>{s.classList.remove("show-nav")}),500)}))}(e,n),window.addEventListener("resize",(function(){document.body.clientWidth>=768&&(s.classList.remove("show-nav"),s.classList.remove("close-nav"))}))}();//# sourceMappingURL=app.js.map
