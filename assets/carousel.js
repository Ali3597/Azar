 /**
  * Permet de rajouter la navigation tactile a notre carousel
  */
  class CarouselTouchPlugin{


    /**
     * 
     * @param {Carousel} carousel 
     */
    constructor (carousel){
        carousel.container.addEventListener('dragstart', e=>e.preventDefault())
        carousel.container.addEventListener('mousedown',this.startDrag.bind(this))
        carousel.container.addEventListener('touchstart',this.startDrag.bind(this))
        window.addEventListener('mousemove',this.drag.bind(this))
        window.addEventListener('touchmove',this.drag.bind(this))
        window.addEventListener('mouseup',this.endDrag.bind(this))
        window.addEventListener('touchend',this.endDrag.bind(this))
        window.addEventListener('touchcancel',this.endDrag.bind(this))
        this.carousel = carousel
    }

    /**
     *  Demarre le deplacement au toucher
     * @param {MouseEvent|TouchEvent}e 
     */
    startDrag(e){
        if (e.touches ){
            if (e.touches.length>1){
                return 
            }else{
                e = e.touches[0]
            }
            
        }
        this.origin = {x: e.screenX , y: e.screenY}
        this.width = this.carousel.containerWidth
        this.carousel.disableTransition()
    }


    /**
     *  Deplacement
     * @param {MouseEvent|TouchEvent}e 
     */
     drag(e){
        if (this.origin ){
          let point = e.touches ? e.touches[0] : e
          let translate =  {x: point.screenX - this.origin.x , y : point.screenY - this.origin.y}
          if (e.touches && Math.abs(translate.x) > Math.abs(translate.y)){
              e.preventDefault()
              e.stopPropagation()
          }
          let baseTranslate = this.carousel.currentItem * -100 / this.carousel.items.length
          this.lastTranslate = translate
          this.carousel.translate(baseTranslate + 100* translate.x / this.width)

    }
 }
 
    /**
     *fin du deplacement 
     * @param {MouseEvent|TouchEvent}e 
     */
 endDrag(e){

    if (this.origin && this.lastTranslate){
        this.carousel.enableTransition()
        if((Math.abs(this.lastTranslate.x)  / this.carousel.carouselWidth)> 0.2){
            if (this.lastTranslate.x <0){
                this.carousel.next()
            }else{
                this.carousel.prev()
            }
        }else{
            this.carousel.gotoItem(this.carousel.currentItem)
        }
    
    }
    this.origin = null
 }
}
 
 
 
 
 
 
 
 class Carousel{


    /**
 * This callback type is called `requestCallback` and is displayed as a global symbol.
 *
 * @callback moveCallback
 * @param {number} index
 */

    /**
     * 
     * 
     * @param {HTMLElement} element 
     * @param {Object} options 
     * @param {Object} o{ptions.slidesToScroll= 1} Nombre delement a faire defiler
     * @param {Object} {options.slidesVisible=1} Nombre delement visible dans un slide
     * @param {boolean} {options.loop= false } Doit on boucler en fin de slide
     * @param {boolean} {options.pagination= false } 
     * @param {string} {options.style="promo"}  Permet de definir le differents style de chacun des carousels
     * 
     * 
     */
    constructor(element, options = {} ){
        this.element = element
        this.options= Object.assign({},{
        slidesToScroll: 1,
        slidesVisible: 1,
        loop :false ,
        pagination : false,
        infinite : false ,
        style : "promo",
       
        },options)
        let children =  [].slice.call(element.children)
        this.isMobile = false
        this.currentItem = 0
        this.moveCallbacks = []

        // Modfication du DOM
        this.root = this.createDivWithClass('carousel')
        this.container = this.createDivWithClass('carousel_container')
        this.container.classList.add(`carousel_item_${this.options.style}`)
        this.root.setAttribute('tabindex','0')
        this.root.appendChild(this.container)
        this.element.appendChild(this.root)
        
        this.items = children.map((child) =>{
           let item=  this.createDivWithClass('carousel_item')
           
            item.appendChild(child)
           this.container.appendChild(item)
           return item
        })
        this.setStyle()
        this.createNavigation()
        if (this.options.pagination ){
            this.createPagination()
        }
      
        
        // Evenements
        this.moveCallbacks.forEach(cb => cb(0))
        this.resizeCarousel()
        window.addEventListener('resize', this.resizeCarousel.bind(this))
        this.root.addEventListener('keyup' , e =>{
            if (e.key === "ArrowRight" && e.key === 'Right'){
                this.next()
            }else if (e.key === "ArrowLeft" && e.key === 'Left'){
                this.prev()
            }
        })
        if (this.options.style === "promo"){
        this.root.addEventListener('mouseover',this.makeArrowsVisible.bind(this))
        this.root.addEventListener('mouseout',this.makeArrowsInvisible.bind(this))
        }
        new CarouselTouchPlugin(this)
    }
    
    /**
     * Applique les bonnes dimensions aux element du carousel
     */

    setStyle(){
        let ratio = this.items.length   / this.slidesVisible
        this.container.style.width = (ratio *100) + "%"
        this.items.forEach(item => item.style.width = ((100 / this.slidesVisible)/ ratio) + '%')
    }

    createNavigation(){
        this.nextButton = this.createDivWithClass(`carousel_next_${this.options.style}`)
        this.prevButton = this.createDivWithClass(`carousel_prev_${this.options.style}`)
        this.root.appendChild(this.nextButton)
        this.root.appendChild(this.prevButton)
        this.nextButton.addEventListener('click',this.next.bind(this))
        this.prevButton.addEventListener('click',this.prev.bind(this))
        if (this.options.loop === true ) {
            return
        }
        this.onMove(index=>{
            if (index === 0 ){
                this.prevButton.classList.add(`carousel_prev_hidden`)
            }else{
                this.prevButton.classList.remove(`carousel_prev_hidden`)
            }
            if (this.items[this.currentItem + this.slidesVisible] === undefined){
                this.nextButton.classList.add(`carousel_prev_hidden`)
            }else{
                this.nextButton.classList.remove(`carousel_prev_hidden`)
            }
        })
    }

    createPagination(){
        if (this.options.style == "produit"){
          let laDiv = document.querySelector('.echantillons')
          let echantillons = []
          for (let i = 0; i < this.items.length; i = i + this.options.slidesToScroll){
            let echantillon = this.createDivWithClass(`echantillon`)
            echantillon.appendChild(this.items[i].querySelector('img').cloneNode())

            echantillon.addEventListener('click', ()=> this.gotoItem(i))
            echantillon.addEventListener('click', ()=>{
                echantillons.forEach(element => {
                    element.classList.remove('active')
                    
                })
                echantillon.classList.add("active")
                
            })
           laDiv.appendChild(echantillon)
            echantillons.push(echantillon)
        }
        laDiv.querySelector('.echantillon').classList.add('active')
        }else{
        let pagination = this.createDivWithClass(`carousel_pagination_${this.options.style}`)
        let buttons = []
        this.root.appendChild(pagination)
        for (let i = 0; i < this.items.length; i = i + this.options.slidesToScroll){
            let button = this.createDivWithClass(`carousel_pagination_button_${this.options.style}`)
            button.addEventListener('click', ()=> this.gotoItem(i))
            pagination.appendChild(button)
            buttons.push(button)
        }
        this.onMove(index => {
         let activeButton =  buttons[Math.floor(index / this.options.slidesToScroll)]
         if (activeButton){
             buttons.forEach(button=>button.classList.remove(`carousel_pagination_button_active_${this.options.style}`))
             activeButton.classList.add(`carousel_pagination_button_active_${this.options.style}`)
         }
        })
    }
    }

    translate(percent){
        this.container.style.transform = 'translate3d('+ percent +'%,0,0)'

    }

    next(){
        this.gotoItem(this.currentItem + this.slidesToScroll)
    }

    prev (){
        this.gotoItem(this.currentItem - this.slidesToScroll)
    }


    /**
     * Deplace le carousel vers l'element ciblé
     * @param {number} index 
     */
    gotoItem(index){
        if(index<0){
            if (this.options.loop){
                index = this.items.length - this.slidesVisible
            }else{
                return
            }   
        } else if (index >= this.items.length || this.items[this.currentItem + this.slidesVisible] === undefined && index > this.currentItem){
            if(this.options.loop){
                index = 0
            }else{
                return
            }
            
        }

        let translateX = index * -100 / this.items.length
        this.translate(translateX)
        this.currentItem = index
        this.moveCallbacks.forEach(cb => cb(index))
    }

    /**
     * 
     * @param {moveCallback} cb 
     */

    onMove(cb){
        this.moveCallbacks.push(cb)

    }

    resizeCarousel(){
        let mobile = window.innerWidth < 800
        if (mobile !== this.isMobile){
            this.isMobile = mobile
            this.setStyle()
            this.moveCallbacks.forEach(cb => cb(this.currentItem))
        }
    }
    /**
     * 
     * @param {string} className 
     * @returns {HTMLElement}
     */

    createDivWithClass (className){
        let div = document.createElement('div')
        div.setAttribute('class',className)
        return div
    }

    disableTransition(){
        this.container.style.transition = 'none'
    }

    enableTransition(){
        this.container.style.transition = ''
    }

    makeArrowsVisible(){
        this.nextButton.classList.add('visible')
        this.prevButton.classList.add('visible')
    
    }

    makeArrowsInvisible(){
        this.nextButton.classList.remove('visible')
        this.prevButton.classList.remove('visible')
    }

    /**
     * @returns {number}
     */
    get slidesToScroll (){
            return this.isMobile? 1 : this.options.slidesToScroll
    }

    /**
     * @returns {number}
     */
    get slidesVisible(){
        return this.isMobile? 1 : this.options.slidesVisible
    }

    /**
     * @returns {number}
     */
    get containerWidth(){
       return this.container.offsetWidth
    }

    /**
     * @returns {number}
     */
     get carouselWidth(){
        return this.root.offsetWidth
     }
 }
 
 
 module.exports= {
     Carousel,
     CarouselTouchPlugin
 }