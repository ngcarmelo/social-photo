var url = 'http://social-photo-laravel.com.devel/';

window.addEventListener("load", function(){
  // alert("the page is already loaded"); 
   //
   $('.btn-like').css('cursor','pointer');
   $('.btn-dislike').css('cursor','pointer');

  //Like botton
   
    function like(){
        
       $('.btn-like').unbind('click').click(function(){
       $(this).addClass('btn-dislike').removeClass('btn-like');
       $(this).attr('src', url+'/img/heart-red.png');
       
       $.ajax({
             //we use data to get property from dom
             url: url+'/like/'+$(this).data('id'),
             type: 'GET',
             success: function(response){
                 if(response.like){
                      console.log('Has dado like a la publicacion');
                 }else {
                     console.log('Error al hacer like');
                 }
                
             }
         });       
       
             
        dislike();
   });
            
    }
    
    
    
    
    
    
   like(); 
   function dislike(){
       
       //Dislike botton
   $('.btn-dislike').unbind('click').click(function(){
       $(this).addClass('btn-like').removeClass('btn-dislike');
       $(this).attr('src', url+'/img/heart-gray.png');
          $.ajax({
             //we use data to get property from dom
             url: url+'/dislike/'+$(this).data('id'),
             type: 'GET',
             success: function(response){
                 if(response.like){
                      console.log('Has dado dislike a la publicacion');
                 }else {
                     console.log('Error al hacer dislike');
                 }
                
             }
         });       
        like();
   });
   }
   
   dislike();
   
   
   //Buscador
   $('#buscador').submit(function(e){
      // e.preventDefault();
       $(this).attr('action',url+'gente/'+$('#buscador #search').val());
      // $(this).submit();
   });
   
   
   
   
   
   
   
   
   
   
});












//Alternative way


// window.addEventListener("load", function(){
//	$('.btn-like').css('cursor','pointer');
//	$('.btn-dislike').css('cursor','pointer');
//	
//     
//     $(document).on("click", ".btn-like", function(e){
//		$(this).addClass('btn-dislike').removeClass('btn-like');
//		$(this).attr('src', url+'/img/heart-red.png');
//                
//         $.ajax({
//             //we use data to get property from dom
//             url: url+'/like/'+$(this).data('id'),
//             type: 'GET',
//             success: function(response){
//                 if(response.like){
//                      console.log('Has dado like a la publicacion');
//                 }else {
//                     console.log('Error al hacer like');
//                 }
//                
//             }
//         });       
//                
//                
//	});
//	$(document).on("click", ".btn-dislike", function(e){
//		$(this).addClass('btn-like').removeClass('btn-dislike');
//		$(this).attr('src', url+'/img/heart-gray.png');
//                
//                 $.ajax({
//             //we use data to get property from dom
//             url: url+'/dislike/'+$(this).data('id'),
//             type: 'GET',
//             success: function(response){
//                 if(response.like){
//                      console.log('Has dado dislike a la publicacion');
//                 }else {
//                     console.log('Error al hacer dislike');
//                 }
//                
//             }
//         });       
//                
//	});
//});