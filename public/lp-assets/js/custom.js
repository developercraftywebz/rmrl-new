$(".orderForm").submit(function (event) {
  var formData = {
    name: $(this).find("#name").val(),
    email: $(this).find("#email").val(),
    message: $(this).find("#message").val(),
    about_project: $(this).find("#about_project").val(),
    // srv_need: $(this).find("#srv_need").val(),
    bjt_project: $(this).find("#bjt_project").val(),
  };
  
  $.ajax({
    type: "POST",
    url: "ajax/order_mail",
    data: formData,
    // dataType: "json",
    // encode: true,
  }).done(function (data) {
    $(".order-status").show();
    $(".order-status").html(data);
    $('.orderform').each(function() {
      this.reset();
    });
    setTimeout(function () {
      $(".order-status").html(data).hide();
    }, 5000);
  });
      
  event.preventDefault();
});

$(".contactForm").submit(function (event) {
  var formData = {
    name: $(this).find("#name").val(),
    email: $(this).find("#email").val(),
  };
  
  $.ajax({
    type: "POST",
    url: "ajax/contact_mail",
    data: formData,
    // dataType: "json",
    // encode: true,
  }).done(function (data) {
    $(".contact-status").show();
    $(".contact-status").html(data);
    $('.contactForm').each(function() {
      this.reset();
    });
    setTimeout(function () {
      $(".contact-status").html(data).hide();
    }, 5000);
  });
      
  event.preventDefault();
});

$(".newsletterForm").submit(function (event) {
  var formData = {
    email: $(this).find("#email").val(),
  };
  
  $.ajax({
    type: "POST",
    url: "ajax/newsletter_mail",
    data: formData,
    // dataType: "json",
    // encode: true,
  }).done(function (data) {
    $(".newsletter-status").show();
    $(".newsletter-status").html(data);
    $('.newsletterForm').each(function() {
      this.reset();
    });
    setTimeout(function () {
      $(".newsletter-status").html(data).hide();
    }, 5000);
  });
      
  event.preventDefault();
});

// counter on scroll
    if($('.counter').length > 0){
        var a = 0;
        function cFuntion(){
            var oTop = $(".overview-sec").offset().top - window.innerHeight;
            if (a == 0 && $(window).scrollTop() > oTop) {
                $(".counter").each(function () {
                    var $this = $(this),
                        countTo = $this.attr("data-number");
                    $({
                        countNum: $this.text()
                    }).animate(
                        {
                            countNum: countTo
                        },
    
                        {
                            duration: 2000,
                            easing: "swing",
                            step: function () {
                                $this.text(
                                    Math.ceil(this.countNum)
                                );
                            },
                            complete: function () {
                                $this.text(
                                    Math.ceil(this.countNum)
                                );
                            }
                        }
                    );
                });
                a = 1;
            }
            
        }
        // window.onload = cFuntion();
        $(window).scroll(function () {
            cFuntion();
        });    
    }
$('.res-menu-icon').on('click',function(){
  $('.menu-ul').addClass('translate-x-zero');
});
  
$('.menu-close').on('click',function(){
  $('.menu-ul').removeClass('translate-x-zero');
  $('.dropdown-menu-a').removeClass('translate-x-zero');
  $('.icon-back').fadeOut();
});
  
$('.dropdown-toggle').on('click',function(){
  $('.dropdown-menu-a').addClass('translate-x-zero');
  $('.icon-back').fadeIn();
});
  
$('.icon-back').on('click',function(){
  $('.dropdown-menu-a').removeClass('translate-x-zero');
  $('.icon-back').fadeOut();
});


$('.tab-ul-a > li > a').on('click',function(){
  $('.tab-ul-a > li > a').removeClass('active');
  $(this).addClass('active');  
  $('.tab-content-a').hide();
  $($(this).data('show')).fadeIn();
});

if($('.testimonial-items').length){
  $('.testimonial-items').slick({
    speed: 250,
    cssEase: 'linear',
    fade: true,
    swipe: true,
    swipeToSlide: true,
    touchThreshold: 10,
    slidesToShow: 1,
    dots: true,
    autoplay: true,
    autoplaySpeed: 2000
    // prevArrow: '<button class="slide-arrow slick-prev-a"><i class="ri-arrow-left-s-line"></i></button>',
    // nextArrow: '<button class="slide-arrow slick-next-a"><i class="ri-arrow-right-s-line"></i></button>'
  });
}

if($('.portfolio-slider-a').length){
  $('.portfolio-slider-a').slick({
    speed: 250,
    cssEase: 'linear',
    swipe: true,
    swipeToSlide: true,
    touchThreshold: 10,
    slidesToShow: 1,
    dots: true,
    autoplay: true,
    autoplaySpeed: 2000,
  });
}

$('.service-slider').slick({
  slidesToShow: 1,
  slidesPerRow: 2,
  rows: 2,
  dots: false,
  cssEase: 'linear',
  infinte: false,
  autoplay: true,
  autoplaySpeed: 3000,
  responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 1,
          slidesPerRow: 1,
          rows: 2,
        }
      },    
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          slidesPerRow: 1,
          rows: 2,
        }
      }    
    ]
});
  $('.service-slider').mouseover(function() {
        $(this).slick('play')
    });

$('.quesiton-1-a .list-a > li').on('click',function(){
  $('.quesiton-1-a .list-a > li').removeClass('active');
  $(this).addClass('active');
  $('#about_project').val($(this).data('inp'));
});
$('.quesiton-2-a .list-a > li').on('click',function(){
  $('.quesiton-2-a .list-a > li').removeClass('active');
  $(this).addClass('active');
  $('#srv_need').val($(this).data('inp'));
});
$('.quesiton-3-a .list-a > li').on('click',function(){
  $('.quesiton-3-a .list-a > li').removeClass('active');
  $(this).addClass('active');
  $('#bjt_project').val($(this).data('inp'));
});

if($(window).width() < 768){
  $('.overview-container').slick({
    speed: 250,
    cssEase: 'linear',
    swipe: true,
    swipeToSlide: true,
    touchThreshold: 10,
    slidesToShow: 2,
    dots: false,
    infinte: true,
    autoplay: true,
    autoplaySpeed: 4000,
    responsive: [
      {
        breakpoint: 481,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }    
    ]            
  });
}

if($(window).width() < 991){
  $('.cliente-logos').slick({
    speed: 250,
    cssEase: 'linear',
    swipe: true,
    swipeToSlide: true,
    slidesToShow: 4,
    dots: false,
    autoplay: true,
    autoplaySpeed: 4000,
    responsive: [
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3
        }
      },
      {
        breakpoint: 481,
        settings: {
          slidesToShow: 2
        }
      }    
    
    ]            
  });
}
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
