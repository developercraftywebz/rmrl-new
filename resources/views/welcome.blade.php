<!DOCTYPE html>
@php
use App\Models\CMS; // Assuming CMS is in the App namespace
$cms = CMS::where('page_name', 'homepage')->first();

@endphp
<html lang="en">

<head>
    <title>Real Men Real Life</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link id="favicon" rel="shortcut icon" href="" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="{{asset('lp-assets/css/remixicon.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('lp-assets/css/slick.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('lp-assets/css/slick-theme.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('lp-assets/css/custom.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('lp-assets/js/jquery.min.js')}}"></script>
</head>

<body>
    <header class="header">
        <div class="header-inner will-stick">
            <div class="container header-container">
                <div class="logo-area">
                    <a href="/">
                        <img src="{{asset('lp-assets/images/rml-logo.png')}}" class="logo-a" alt="" loading="lazy">
                    </a>
                </div>
                <div class="nav-area">
                    <i class="ri-menu-fill res-menu-icon"></i>
                    <ul class="menu-ul">
                        <div class="mob-res-icon">
                            <i class="ri-menu-unfold-line menu-close"></i>
                            <i class="ri-arrow-right-line icon-back"></i>
                        </div>
                        <li class=""><a href="/" class="menu-items">Home</a></li>
                        <li><a href="#" class="menu-items">Galleries</a></li>
                        <li><a href="{{route('login')}}" class="menu-items">Login</a></li>
                        <li><a href="https://rmrl.goliveapps.com/register" class="menu-items">Registration</a></li>
                        <li><i class="ri-search-line"></i></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    <section class="home-banner">
        <div class="row-a">
            <div class="col-left">
                @if($cms->banner_heading)
                <h1>{{ $cms->banner_heading }}</h1>

                @else
                <h1><strong>Captivate.</strong><br>Connect.<br>Create.</h1>
                @endif


                @if($cms->banner_description)
                <p>{{$cms->banner_description}}</p>

                @else
                <p>Embracing authentic masculinity through photography. Explore everyday men’s captivating stories, artfully captured. Join us, celebrate male beauty, and embrace the allure of the ordinary.</p>
                @endif

            </div>
            <div class="col-right">
                @if($cms->banner_picture)
                <img src="{{ asset('images/cms/' . $cms->banner_picture) }}" class="img-fluid">
                @else
                <img src="{{ asset('lp-assets/images/1.jpg') }}" class="img-fluid">
                @endif
            </div>

        </div>
    </section>

    <section class="about-sec">
        <div class="container">
            <div class="row-a">
                <div class="col-left">
                    @if($cms->about_picture)
                    <img src="{{ asset('images/cms/' . $cms->about_picture) }}" class="img-fluid">
                    @else
                    <img src="{{asset('lp-assets/images/about-us.jpg')}}" class="img-fluid">

                    @endif
                </div>
                <div class="col-right">

                    @if($cms->about_heading)
                    <h2>{{ $cms->about_heading }}</h2>

                    @else
                    <h2>About</h2>
                    @endif

                    <img src="{{asset('lp-assets/images/rml-logo.png')}}" class="img-fluid">

                    @if($cms->about_description)
                    <p>{{ $cms->about_description }}</p>

                    @else
                    <p>Welcome to RealMenRealLife, where we embrace the raw and authentic beauty of everyday men through the lens of our male photographer. Our mission is to celebrate the unique and captivating essence of masculinity in its purest form.</p>
                    <p>With a focus on male photography, we offer exclusive memberships, granting you access to a world of intimate, artistic, and empowering imagery. Explore the depths of erotic energy as we unveil the hidden allure of ordinary men and women, each with its own compelling story to tell.</p>
                    <p>As we grow, we’re excited to expand our offerings to include physical products like books and t-shirts, allowing you to carry a piece of our artistry with you. Join us on this journey of self-discovery, appreciation, and the celebration of real men in real life.</p>
                    @endif

                </div>
            </div>
        </div>
    </section>

    <section class="gallery-sec">
        <div class="container">
            <div class="text-center">

                @if($cms->gallery_heading)
                <h2>{{ $cms->gallery_heading }}</h2>

                @else
                <h2>Our Gallery</h2>

                @endif

                @if($cms->gallery_description)
                <p>{{ $cms->gallery_description }}</p>

                @else
                <p>Explore our captivating gallery at RealMenRealLife. Witness the unfiltered allure of <br>everyday men, artfully captured to celebrate their unique erotic energy. Join us <br>to experience authenticity through our lens.</p>

                @endif

            </div>
            <div class="gallery-items">
                <div class="gallery-item">
                    <img src="{{asset('lp-assets/images/g-1.jpg')}}" class="img-fluid">
                </div>
                <div class="gallery-item">
                    <img src="{{asset('lp-assets/images/g-2.jpg')}}" class="img-fluid">
                </div>
                <div class="gallery-item">
                    <img src="{{asset('lp-assets/images/g-3.jpg')}}" class="img-fluid">
                </div>
                <div class="gallery-item">
                    <img src="{{asset('lp-assets/images/g-4.jpg')}}" class="img-fluid">
                </div>
                <div class="gallery-item">
                    <img src="{{asset('lp-assets/images/g-5.jpg')}}" class="img-fluid">
                </div>
                <div class="gallery-item">
                    <img src="{{asset('lp-assets/images/g-6.jpg')}}" class="img-fluid">
                </div>
            </div>
            <button class="btn-white">View All</button>
        </div>
    </section>

    <section class="contact-form">
        <div class="container">
            <h2 class="text-center">Be A Part OF Us</h2>
            <form>
                <div class="row-a">
                    <div class="form-field">
                        <input type="text" placeholder="First Name">
                    </div>
                    <div class="form-field">
                        <input type="text" placeholder="Last Name">
                    </div>
                </div>
                <div class="row-a">
                    <div class="form-field">
                        <input type="tel" placeholder="Phone">
                    </div>
                    <div class="form-field">
                        <input type="email" placeholder="Email">
                    </div>
                </div>
                <div class="form-field">
                    <textarea placeholder="Comments"></textarea>
                </div>
                <div class="form-field">
                    <input type="submit" name="submit">
                </div>
            </form>
        </div>
    </section>

    <footer>
        <div class="container">
            <div class="row-a">
                <div>
                    <h4>Quicks Links</h4>
                    <ul class="footer-menu">
                        <li><a href="#">Home</a></li>
                        <li><a href="#">Galleries</a></li>
                        <li><a href="{{route('login')}}">Login</a></li>
                        <li><a href="{{route('register')}}">Registration</a></li>
                    </ul>
                </div>
                <div>
                    <img src="{{asset('lp-assets/images/rml-logo.png')}}" class="img-fluid">
                </div>
                <div>
                    <h4>Follow us on social</h4>
                    <ul class="social-links">
                        <li><a href="#"><i class="ri-facebook-fill"></i></a></li>
                        <li><a href="#"><i class="ri-instagram-fill"></i></a></li>
                        <li><a href="#"><i class="ri-twitter-fill"></i></a></li>
                        <li><a href="#"><i class="ri-youtube-fill"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div class="copyright">
        <p>Copyright @ <?php echo date("Y"); ?> Real Men Real Life . All right reserved. - Designed and Developed by: Crafty webz</p>
    </div>


    <script src="{{asset('lp-assets/js/slick.min.js')}}"></script>
    <script src="{{asset('lp-assets/js/custom.js')}}"></script>
</body>

</html>