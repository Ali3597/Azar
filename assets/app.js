
import './styles/app.css';


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