$(function(){
  var lightbox = new SimpleLightbox('.work-box a', { bindToItems: true });
  // $('.work-box a').simpleLightbox();
    $(".globalForm").submit(function (event) {
      var formData = {
        name: $(this).find("#name").val(),
        email: $(this).find("#email").val(),
        phone: $(this).find("#phone").val(),
        message: $(this).find("#message").val(),
      };
      $(".globalForm").removeClass('active-from');
      $(this).addClass('active-from');

      $.ajax({
        type: "POST",
        url: "ajax/header_mail.php",
        data: formData,
        // dataType: "json",
        // encode: true,
      }).done(function (data) {
          $(".active-from .header-status").show();
          $(".active-from .header-status").html(data);
          $('.active-from .globalform').each(function() {
            this.reset();
          });
          setTimeout(function () {
              $(".header-status").html(data).hide();
          }, 5000);
      });

      event.preventDefault();
    });
      
      if($('.testimonials-boxes').length){
        $('.testimonials-boxes').slick({
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3,
            dots: false,
            autoplay: true,
            autoplaySpeed: 3000,
            prevArrow: '<button class="slide-arrow slick-prev-a" aria-label="Previous"><i class="ri-arrow-left-line"></i></button>',
            nextArrow: '<button class="slide-arrow slick-next-a"  aria-label="Next"><i class="ri-arrow-right-line"></i></button>',
            responsive: [
              {
                breakpoint: 1025,
                settings: {
                  slidesToShow: 2
                }
              },
              {
                breakpoint: 769,
                settings: {
                  slidesToShow: 1
                }
              }            
            ]
          });
      }
      if($(window).width() < 992){
        if($('.expert-boxes').length){
          $('.expert-boxes').slick({
              infinite: true,
              slidesToShow: 1,
              slidesToScroll: 1,
              dots: false,
              autoplay: true,
              autoplaySpeed: 3000,
              arrows:false
            });
        }

        if($('.work-boxes').length){
          $('.work-boxes').slick({
              infinite: true,
              slidesToShow: 2,
              slidesToScroll: 1,
              autoplay: true,
              autoplaySpeed: 3000,
              dots: false,
              arrows:false,
              responsive: [
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 1
                  }
                }            
              ]
            });
        }
        if($('.icon-boxes').length){
          $('.icon-boxes').slick({
              infinite: true,
              slidesToShow: 2,
              slidesToScroll: 1,
              autoplay: true,
              autoplaySpeed: 3000,
              dots: false,
              arrows:false,
              responsive: [
                {
                  breakpoint: 600,
                  settings: {
                    slidesToShow: 1
                  }
                }            
              ]
            });
        }
      }
      if($(window).width() < 768){
        if($('.logo-images').length){
          $('.logo-images').slick({
              infinite: true,
              slidesToShow: 3,
              slidesToScroll: 1,
              dots: true,
              arrows:false,
              responsive: [
                {
                  breakpoint: 481,
                  settings: {
                    slidesToShow: 2
                  }
                }            
              ]
            });
        }
      }
  
      $('.res-menu-icon').on('click',function(){
          $('.nav-area').addClass('translate-x-zero');
      });

      $('.has-children').on('click',function(){
        $('.sub-menu').addClass('translate-x-zero');
        $('.icon-back').fadeIn();
      });
  
      $('.menu-close').on('click',function(){
          $('.nav-area').removeClass('translate-x-zero');
          $('.sub-menu').removeClass('translate-x-zero');
          $('.icon-back').fadeOut();
      });
  
      $('.icon-back').on('click',function(){
          $('.sub-menu').removeClass('translate-x-zero');
          $('.icon-back').fadeOut();
      });
      
      $('.ftr-col .p').on('click',function(){
        $('.ftr-col .p').removeClass('rotate-arrow-a');
        $(this).addClass('rotate-arrow-a');
        $('.ftr-col .p').next('.list-a').slideUp();
        $(this).next('.list-a').slideToggle();
      });

      var $document = $(document),
      $element = $('.will-stick'),
      className = 'fixed-top shadow';
    
      $document.scroll(function() {
        if ($document.scrollTop() >= 50) {
          $element.addClass(className);
        } else {
          $element.removeClass(className);
        }
      });

      $('.select-cetagory').select2({
        placeholder: 'Select Cetagory'
      });

  });
  
  window.onload = function(){
      customAnimation();
  }
  $(window).on('scroll',function(){
      customAnimation();
  });
  
  function customAnimation(){
      $('.ani-a').each(function(){
          var top_of_element = $(this).offset().top;
          var bottom_of_element = $(this).offset().top + $(this).outerHeight();
          var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
          var top_of_screen = $(window).scrollTop();
  
          if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)){
              $(this).addClass('animated');
          } 
        //   else {
        //       $(this).removeClass('animated');
        //   }
      });
  }

$('.image-gallery-2').slick({
  dots: true,
  arrows: true
});
