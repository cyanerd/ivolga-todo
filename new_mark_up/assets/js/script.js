window.onload = function() {

   document.querySelectorAll('.modal').forEach(modal => {
      modal.classList.add('loaded')
   })

   if ( document.querySelector('.order__aside') ) {
      change_top_position_order_aside();
      window.addEventListener('resize', function(){
         change_top_position_order_aside();
      });
   }
   function change_top_position_order_aside() {
      document.querySelector('.order__aside').style.top = document.querySelector('.topblock').offsetHeight + 'px';
   }

   // Textarea autoheight
   if (document.querySelector('.textarea') ){
      let textareas = document.querySelectorAll('.textarea')
      textareas.forEach(textarea => {
         textarea.style.height = textarea.height + 2 + 'px'
         let lastHeight = textarea.offsetHeight
         textarea.addEventListener('input', function (e) {
            e.preventDefault()
            e.target.style.height = lastHeight + 'px'
            e.target.style.height = e.target.scrollHeight + 2 + "px"
         })
      })
   }

   // Offcanvas
   document.querySelectorAll('[data-offcanvas]').forEach(item => {
      item.addEventListener('click', function(){
         document.querySelector('html').classList.add('locked')
         if ( document.querySelector('.offcanvas.show') ) {
            document.querySelector('.offcanvas.show').classList.remove('show')
         }
         if ( document.querySelector('.modal.show') ) {
            document.querySelector('.modal.show').classList.remove('show')
         }
         document.querySelector('.modal-backdrop').classList.add('show')
         document.querySelector(item.dataset.offcanvas).classList.add('show')
      })
   })
   // Close offcanvas
   document.querySelectorAll('[offcanvas-close]').forEach(item => {
      item.addEventListener('click', function(){
         document.querySelector('html').classList.remove('locked')
         document.querySelector('.offcanvas.show').classList.remove('show')
         if ( document.querySelector('.modal.show') ) {
            document.querySelector('.modal.show').classList.remove('show')
         }
         document.querySelector('.modal-backdrop').classList.remove('show')
      })
   })
   document.querySelector('.modal-backdrop').addEventListener('click', function(){
      document.querySelector('html').classList.remove('locked')
      if ( document.querySelector('.offcanvas.show') ) {
         document.querySelector('.offcanvas.show').classList.remove('show')
      }
      if ( document.querySelector('.modal.show') ) {
         document.querySelector('.modal.show').classList.remove('show')
      }
      document.querySelector('.modal-backdrop').classList.remove('show')
   })

   // Modal
   document.querySelectorAll('[data-modal]').forEach(item => {
      item.addEventListener('click', function(){
         document.querySelector('html').classList.add('locked')
         if ( document.querySelector('.offcanvas.show') ) {
            document.querySelector('.offcanvas.show').classList.remove('show')
         }
         if ( document.querySelector('.modal.show') ) {
            document.querySelector('.modal.show').classList.remove('show')
         }
         document.querySelector('.modal-backdrop').classList.add('show')
         document.querySelector(item.dataset.modal).classList.add('show')
      })
   })
   // Close modal
   document.querySelectorAll('[modal-close]').forEach(item => {
      item.addEventListener('click', function(){
         document.querySelector('html').classList.remove('locked')
         if ( document.querySelector('.offcanvas.show') ) {
            document.querySelector('.offcanvas.show').classList.remove('show')
         }
         document.querySelector('.modal.show').classList.remove('show')
         document.querySelector('.modal-backdrop').classList.remove('show')
      })
   })

   // Spoiler address
   document.querySelectorAll('.spoiler-address').forEach(spoiler => {
      spoiler.querySelector('.spoiler-address__head').addEventListener('click', () => {
         spoiler.classList.toggle('active')
      })
   })

}
