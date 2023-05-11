<!DOCTYPE html>
<html>

<head>
    <title>Nos clients</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="./style.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: #d2d2d2;
            padding: 10rem 2rem;
        }

        h2 {
            text-align: center;
            padding: 3rem;
            font-size: 3.5rem;
            margin-bottom: 3rem;

        }

        /* Slider */
        .slick-slide {
            margin: 0px 10px;
        }

        .slick-slide img {
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="w-3">
                <a href="./index.php">
                    <img class="navbar-left" id="brand-image" src="./img/igs.jpg" alt="" style="margin-top: 1px; height:1%; width:5%;">
                </a>
            </div>
            <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">
                    <i class="fa fa-bars"></i>
                </span>
            </button>


            <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavId">
                <ul class="nav">
                    <li class="nav-item">
                        <a class="nav-link " href="./choix_user.php">Mon Compte</a>
                    </li>

                </ul>
            </div>
        </nav>
    </div>
    <div class="container">
        <center>
            <h4>Retrouver les informations sur notre client à tout moment</h4>
        </center>
        <br>

        <section class="customer-logos slider border border-dark rounded" style="background-color: #fff;">
            <div class="slide" style="margin-top: 25px;">    
                <img src="img/1.png">
            </div>
            <div class="slide" style="margin-top: 25px;">
                
                <img src="img/3.png">
            </div>
            <div class="slide" style="margin-top: 15px;">
                <img src="img/4.png">
            </div>
            <div class="slide" style="margin-top: 45px;">
                
                <img src="img/2.png">
            </div>
            <div class="slide" style="margin-top: 15px;">        
                <img src="img/a5.png">
            </div>
        </section>
    </div>


    <script src="https://code.jquery.com/jquery-2.2.0.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $(".customer-logos").slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                arrows: false,
                dots: false,
                pauseOnHover: false,
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 4
                        }
                    },
                    {
                        breakpoint: 520,
                        settings: {
                            slidesToShow: 3
                        }
                    }
                ]
            });
        });
    </script>
</body>

</html>