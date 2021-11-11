
import './styles/app.css';

///header sticky

var scrollY = function() {
  var supportPageOffset = window.pageXOffset !== undefined;
  var isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");

  return supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
  
}

var elements = document.querySelectorAll("[data-sticky]")

for(var i = 0 ;i < elements.length ;i++){
   (function(element){

      
      var rect = element.getBoundingClientRect()
      var offset = parseInt(element.getAttribute("data-offset") || 0,10)
      var theTop = rect.top + scrollY()
      var fake= document.createElement('div')
         fake.style.width=rect.width + "px"
         fake.style.height= rect.height + "px"
     
     //functions
     var onScroll = function(){
         var hasScrollClass= element.classList.contains("fixed")
     
         if (scrollY()> theTop - offset && !hasScrollClass){
             element.classList.add("fixed")
             element.style.top = offset + 'px'
             element.style.width = rect.width + 'px'
             element.parentNode.insertBefore(fake,element)
              
         }else if(scrollY() < theTop - offset && hasScrollClass){
             element.classList.remove("fixed")
             element.parentNode.removeChild(fake)
         }
         
     }
     
     var onResize = function(){
     if (!element.getAttribute("data-offset")){
         element.style.width="auto"
         element.classList.remove("fixed")
         fake.style.display = "none"
         rect = element.getBoundingClientRect()
         theTop = rect.top + scrollY()
         fake.style.width=rect.width + "px"
         fake.style.height= rect.height + "px"
         fake.style.display = "block"
         onScroll()
     }else {
      element.style.width="15%"
      element.classList.remove("fixed")
         fake.style.display = "none"
         rect = element.getBoundingClientRect()
         theTop = rect.top + scrollY()
         fake.style.width=rect.width + "px"
         fake.style.height= rect.height + "px"
         fake.style.display = "block"
         onScroll()
     }
     }
     //Listener
     window.addEventListener("scroll",onScroll)
     window.addEventListener('resize', onResize)
            

   })(elements[i])
}
//// depliant catgories
let printSubCategory = function(div){
  console.log(div)
  let categoryName = div.querySelector("p").innerHTML
  
  return categoryName
  
}


let replier = function() {
  menudepliant.style.display = 'none'
}

window.addEventListener('click',replier)

let menudepliant = document.querySelector('.menudepliant')
let arrow_up = document.querySelector('.arrow-up')

let deplier = function(){
  if (menudepliant.style.display =='flex'){
      menudepliant.style.display ='none'
      arrow_up.style.display ='none'
  }else{
  menudepliant.style.display = 'flex'
  arrow_up.style.display = 'block'
  }
  
}

menudepliant.addEventListener('click',(e)=>{
  e.stopPropagation()
})
let activeHighCategory = function(){
  let hightCategories = document.querySelectorAll(".categorieHaut-depliant div")
  
  hightCategories.forEach(element => {
      element.classList.remove('active')
  });
  this.classList.add("active")
  let selectCategory = printSubCategory(this)
  let randomSubCategories = Math.floor(Math.random() * 10);
  let  subCategoriesPrinted= ''
  for(let i=1; i<randomSubCategories+1;i++){
      subCategoriesPrinted+=  `<div class="flex ">
       la sous categorie ${i} de ${selectCategory}
      </div>`
  }
  tabSubCategories.innerHTML= subCategoriesPrinted

}
let tabSubCategories = document.querySelector('.categorieBas-depliant')
let hightCategories = document.querySelectorAll(".categorieHaut-depliant div")

for (let i = 0; i <hightCategories.length; i++){
  hightCategories[i].addEventListener('mouseover',activeHighCategory )
}

let depliant = document.querySelector('.depliant')
depliant.addEventListener('click',deplier)
depliant.addEventListener('click',(e)=>{
  e.stopPropagation()
})
////modal inscription connexion
let modal = document.querySelector('.modal')
let openModal = document.querySelector('.clickmodal')
let modal_wrapper = document.querySelector('.modal-wrapper')
if (openModal != null){
openModal.addEventListener('click',(e)=>{
    e.stopPropagation()
    modal.classList.add('active')
})
}
modal_wrapper.addEventListener('click',(e)=>{
    e.stopPropagation()
})

window.addEventListener("click",()=> {
    if (modal.classList.contains("active")){
      modal.classList.remove("active")
     
    }
  })

  let switchC = document.querySelector('.switchConnexion ')
  let switchI = document.querySelector('.switchInscription ')
  switchC.addEventListener('click', ()=>{
    if(modal_wrapper.classList.contains('connexion')){

    }else{
      modal_wrapper.style.transform = "rotateY(90deg)"
     setTimeout(function(){
         modal_wrapper.style.transform = ''
     },500)
     setTimeout(function(){
         modal_wrapper.classList.add('connexion')
       modal_wrapper.classList.remove('inscription')
    
    },500)
  }
})


switchI.addEventListener('click', ()=>{
    if(modal_wrapper.classList.contains('inscription')){

    }else{
      modal_wrapper.style.transform = "rotateY(90deg)"
     setTimeout(function(){
         modal_wrapper.style.transform = ''
     },500)
     setTimeout(function(){
         modal_wrapper.classList.remove('connexion')
       modal_wrapper.classList.add('inscription')
    
    },500)
  }
})

//compte 
let compte_header = document.querySelector(".compte_header")
let depliant_compte_header = document.querySelector('.depliant_compte_header')

if (compte_header != null){
    compte_header.addEventListener('mouseover',()=>{
        if(!depliant_compte_header.classList.contains('active')){
        depliant_compte_header.classList.add('active')
        }
    })
    depliant_compte_header.addEventListener('mouseout',()=>{
        depliant_compte_header.classList.remove('active')
    })
}