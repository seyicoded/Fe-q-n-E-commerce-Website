<?php
  session_start();
  include("../include/connectdba.php");
  $p = new dba();
  $con = $p->con();
  $php = $p->php();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official FemQuen Pay Page</title>
    
    <?php
        include('include/head.php');
    ?>
    <link rel="stylesheet" type="text/css" href="src/css/index.css">
    <script type="text/javascript" src="src/js/index.js"></script>
</head>
<body>

    <?php
        include("include/unsignedheader.php");
    ?>

    <!-- carousel start -->
    <div>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      .carousel-item{
          height:590px;
          background-color: rgba(30,255,130,0.3);
      }

      #myCarousel img{
          width: 100%;
          height: 100%;
      }

      .right-arrow{
        padding-right: 3px;
        color:rgba(0,255,255,0.3);
      }

      @media (max-width: 600px) {
        .carousel-item{
            height:487px;
        }
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
        #myCarousel img{
            position:relative;
            bottom:40%;
        }
      }
    </style>
    <div id="myCarousel" class="carousel slide" data-bs-ride="carousel">
    <ol class="carousel-indicators">
      <li data-bs-target="#myCarousel" data-bs-slide-to="0" class="active"></li>
      <li data-bs-target="#myCarousel" data-bs-slide-to="1"></li>
      <li data-bs-target="#myCarousel" data-bs-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="container">
          <div class="carousel-caption text-start">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                  <img class="w3-padding wow fadeInDown" data-wow-duration="4000ms" data-wow-delay="1200ms" src="media/svg/undraw_transfer_money_rywa.svg"/> 
                </div>
                <div class="col-md-6 col-sm-12">
                    <p>
                      <h3 class="w3-text-blue">Referral Earning</h3> <br> 
                      <span class="w3-text-white">
                          The commission awarded for successfully registering others into our
                          affiliate platform. Your earned commission is equivalent to a specified percentage of the
                          registeration fee from the referred member.
                      </span>
                    </p>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <div class="container">
          <div class="carousel-caption">
          <div class="row">
                <div class="col-md-6 col-sm-12 order-md-2"> <img class="w3-padding" src="media/svg/machine.svg"/> </div>
                <div class="col-md-6 col-sm-12 order-md-1">
                    <p>
                    <h3 class="w3-text-blue">Product/Machine Earning</h3> <br> 
                    <span class="w3-text-white">
                    The commission awarded for purchasing or referring people to purchase our products/machines.
                    The commission we allocate for product is… % and …% for machine from the sales price.
                    </span>
                    </p>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="carousel-item">
        <!-- <svg class="bd-placeholder-img" width="100%" height="100%" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#777"/></svg> -->

        <div class="container">
          <div class="carousel-caption text-end">
          <div class="row">
                <div class="col-md-6 col-sm-12"> <img class="w3-padding" src="media/svg/activity.svg"/> </div>
                <div class="col-md-6 col-sm-12">
                    <p>
                    <h3 class="w3-text-blue">Activity Earning</h3> <br> 
                    <span class="w3-text-white">
                    The activities carried out by our affiliate is majorly the sharing of sponsored contents,
                    others may include; creation of articles, graphic works such as fliers, posters, banners etc…
                    for the promotion of our company’s products, machines, and other services that we offer.
                    </span>
                    </p>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </a>
  </div>
    </div>
    <!-- carousel end -->

    <!-- registration info start -->
    <div class="align-items-center w3-margin-16 px-4 py-4 w3-card-2">
      <h3 class="w3-center w3-text-blue" style="font-weight:bolder; text-transform: uppercase;">Registration Guideline</h3>
      <br>
      <div>
        <ul class="w3-ul" style="font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">
          <li class=""><i class="fa fa-chevron-right right-arrow"></i> on Register Now! at the top of this site</li>
          <li class=""><i class="fa fa-chevron-right right-arrow"></i>Fill in the bio-data form with your valid information. The Registration form consists of your Full name, Phone No., E-mail address, Password and accepts our terms and conditions. </li>
          <li class=""><i class="fa fa-chevron-right right-arrow"></i>Select the payment option that’s best for you in between: Online payment and Coupon code utilization.</li>
          <li class=""><i class="fa fa-chevron-right right-arrow"></i>Make payment for your desired registration package.</li>
          <li class=""><i class="fa fa-chevron-right right-arrow"></i>Take a screenshot of the transaction receipt</li>
          <li class="">
            <i class="fa fa-chevron-right right-arrow"></i>
            Online Payment: Enter your Debit card details and wait until you’re successfully debited. Afterwards, take a screenshot of the transaction receipt. 
Coupon Code Utilization:<br>
-	Contact our verified Vendors to purchase your coupon code<br>
-	Enter the coupon code on the registration form, accept our T&C and submit.<br>
•	After a successful registration, members are required to verify their phone No. and E-mail address where an OTP will be sent to your phone no. and a verification message will be mailed to you which contains the verification link.<br>
•	After a successful verification, members will be awarded with divers Welcome bonuses depending on their package.<br>

          </li>
        </ul>
      </div>
      <br>
    </div>
    <!-- registration info stop -->

    <?php
        include('include/foot.php');
        include('../include/footer.php');
    ?>
</body>
</html>