const nav = document.querySelector("#nav-toggle")
nav.addEventListener('click', ()=>{
  if (nav.innerHTML === '<span><i class="fas fa-times"></i></span>') {
    nav.innerHTML = '<span><i class="fas fa-bars"></i></span>';
  }
  else{
    nav.innerHTML = '<span><i class="fas fa-times"></i></span>';
  }

})