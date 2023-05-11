<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <link rel="icon" type="img/x-icon" href="https://i.ibb.co/svhKncv/igs.jpg">


  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
  <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Cookie&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="./style.css" />
  <style>
    footer {
      position: fixed;
      bottom: 0;
    }

    @media (max-height:800px) {
      footer {
        position: static;
      }

      header {
        padding-top: 40px;
      }
    }

    .footer-distributed {
      background-color: #2d2a30;
      box-sizing: border-box;
      width: 100%;
      text-align: left;
      font: bold 16px sans-serif;
      padding: 50px 50px 60px 50px;
      margin-top: 80px;
    }

    .footer-distributed .footer-left,
    .footer-distributed .footer-center,
    .footer-distributed .footer-right {
      display: inline-block;
      vertical-align: top;
    }

    /* Footer left */

    .footer-distributed .footer-left {
      width: 30%;
    }

    .footer-distributed h3 {
      color: #ffffff;
      margin: 0;
    }


    .footer-distributed h3 span {
      color: #32be8f;
    }

    /* Footer links */

    .footer-distributed .footer-links {
      color: #ffffff;
      margin: 20px 0 12px;
    }

    .footer-distributed .footer-links a {
      display: inline-block;
      line-height: 1.8;
      text-decoration: none;
      color: inherit;
    }

    .footer-distributed .footer-company-name {
      color: #8f9296;
      font-size: 14px;
      font-weight: normal;
      margin: 0;
    }

    /* Footer Center */

    .footer-distributed .footer-center {
      width: 35%;
    }

    .footer-distributed .footer-center i {
      background-color: #33383b;
      color: #ffffff;
      font-size: 25px;
      width: 38px;
      height: 38px;
      border-radius: 50%;
      text-align: center;
      line-height: 42px;
      margin: 10px 15px;
      vertical-align: middle;
    }

    .footer-distributed .footer-center i.fa-envelope {
      font-size: 17px;
      line-height: 38px;
    }

    .footer-distributed .footer-center p {
      display: inline-block;
      color: #ffffff;
      vertical-align: middle;
      margin: 0;
    }

    .footer-distributed .footer-center p span {
      display: block;
      font-weight: normal;
      font-size: 14px;
      line-height: 2;
    }

    .footer-distributed .footer-center p a {
      color: #32be8f;
      text-decoration: none;
      ;
    }

    /* Footer Right */

    .footer-distributed .footer-right {
      width: 30%;
    }

    .footer-distributed .footer-company-about {
      line-height: 20px;
      color: #92999f;
      font-size: 13px;
      font-weight: normal;
      margin: 0;
    }

    .footer-distributed .footer-company-about span {
      display: block;
      color: #ffffff;
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .footer-distributed .footer-icons {
      margin-top: 25px;
    }

    .footer-distributed .footer-icons a {
      display: inline-block;
      width: 35px;
      height: 35px;
      cursor: pointer;
      background-color: #33383b;
      border-radius: 2px;
      font-size: 20px;
      color: #ffffff;
      text-align: center;
      line-height: 35px;
      margin-right: 3px;
      margin-bottom: 5px;
    }

    .footer-distributed .footer-icons a:hover {
      background-color: #32be8f;
    }

    .footer-links a:hover {
      color: #32be8f;
    }

    @media (max-width: 880px) {

      .footer-distributed .footer-left,
      .footer-distributed .footer-center,
      .footer-distributed .footer-right {
        display: block;
        width: 100%;
        margin-bottom: 40px;
        text-align: center;
      }

      .footer-distributed .footer-center i {
        margin-left: 0;
      }
    }</style>
  <title>IGS</title>
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
  <section class="home container mb-5">
    <div class="row mt-5">
      <div class="col-lg-6 mt-5 py-5 pl-5">
        <img class="animated zoomIn img-fluid" src="./img/undraw_working_re_ddwy.svg" alt="" />
      </div>
      <div class="col-lg-6 my-auto">
        <div class="row">
          <div class="home-content offset-lg-1 col-lg-10">
            <h1 class=" delay-1s pb-3 ">
              IGS Management
            </h1>
            <p class="pb-3">
              Nous vous accompagnons par le biais d’un programme élaboré sous l’appellation I.G.S (Info, gestion, solution) </p>
            <a href="./partner.php" target="_blank"><button class="btn btn-lg btn-outline-secondary">Nos Clients
              </button></a>

          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="call-to-action py-2" >
    <div class="container text-center w-20">


      <div class="text-center py-5">
        <h2 class="py-2 " >Services</h2>
        <div class="mx-auto heading-line"></div>
      </div>
      <div class="container">
        <div class="row">
          <div class="col-md-4 text-center">
            <i class="fa fa-bullhorn fa-2x" ></i>
            <h4 class="py-3  ml-10" >Information</h4>
            <p class="pb-5 " >
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, vero.
            </p>
          </div>
          <div class="col-md-4 text-center">
            <i class="fa fa-search fa-2x" ></i>
            <h4 class="py-3" >Gestion
            </h4>
            <p class="pb-5" >
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempore, id.
            </p>
          </div>
          <div class="col-md-4 text-center">
            <i class="fa fa-user fa-2x" aria-hidden="true" ></i>
            <h4 class="py-3 ">Solution De Management</h4>
            <p class="pb-5 " >
              Lorem ipsum dolor sit amet consectetur adipisicing elit. Et, iusto.
            </p>
          </div>
        </div>
      </div>


    </div>
  </section>
  <section class="contact" style="">
    <div class="container">


      <div class="row row-cols-2">
        <div class="col-lg-6">
          <div class="py-5">
            <h2>Adresse</h2>
            <div class="heading-line"></div>
          </div>
          <div class="embed-responsive embed-responsive-16by9">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2626.34280329205!2d2.2875831764063776!3d48.832599571328565!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e66feba9b3e5cf%3A0x26a7ba95152fa72b!2sWebitech%2C%20la%20Grande%20%C3%89cole%20de%20l&#39;Informatique%20%C3%A0%20Paris!5e0!3m2!1sfr!2sfr!4v1683555029426!5m2!1sfr!2sfr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
        </div>

        <div class="col">
          <div class="col-sm py-5">
            <h2 class="">Contact</h2>
            <div class="heading-line "></div>
          </div>

          <form action="#" method="POST" class="col">

            <div class="form-group">
              <label for="email">E-mail</label>
              <input class="form-control" type="email" id="email" aria-describedby="emailHint" placeholder="Email" name="email" />

            </div>
            <div class="form-group">
              <label for="name">Nom & Prénom</label>
              <input class="form-control" type="text" id="name" name="name" aria-describedby="" placeholder="Nom" />
            </div>
            <div class="form-group">
              <label for="message">Message</label>
              <textarea class="form-control" id="message" name="message" rows="5" placeholder="Message" style="resize: none;"></textarea>
            </div>
            <button type="submit" class="btn btn-lg btn-outline-secondary">
              envoyer
            </button>
          </form>
        </div>
      </div>
    </div>
    <br>
  </section>
  <footer class="footer-distributed">

    <div class="footer-left">
      <h3>IGS<span> MANAGEMENT</span></h3>

      <p class="footer-links">
        <a href="#">Accueil</a>
        |
        <a href="#">About</a>
        |
        <a href="#">Contact</a>
        |
        <a href="#">Blog</a>
      </p>

      <p class="footer-company-name">Copyright © 2022 <strong>IGS Management</strong> Tous les droits sont réservés</p>
    </div>

    <div class="footer-center">
      <div>
        <i class="fa fa-map-marker"></i>
        <p><span>Ville</span>
          Paris</p>
      </div>

      <div>
        <i class="fa fa-phone-square"></i>
        <p><span>Fixe</span>
          +33 3 00 00 00 00 </p>
      </div>
      <div>
        <i class="fa fa-phone"></i>
        <p><span>Tél</span>
          +33 6 00 00 00 00
        </p>

      </div>
      <div>
        <i class="fa fa-envelope"></i>
        <p><a href="mailto:ayoub.elbouad@gmail.com">admin@igs.com</a></p>
      </div>
    </div>
    <div class="footer-right">
      <p class="footer-company-about">
        <span>Réeau sociaux</span>

      </p>
      <div class="footer-icons">
        <a href="#"><i class="fa fa-facebook"></i></a>
        <a href="#"><i class="fa fa-instagram"></i></a>
        <a href="#"><i class="fa fa-linkedin"></i></a>
        <a href="#"><i class="fa fa-twitter"></i></a>
        <a href="#"><i class="fa fa-youtube"></i></a>
      </div>
    </div>
  </footer>





  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>