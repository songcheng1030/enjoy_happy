<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Hapiom</title>
      <!-- Favicon -->
      <link rel="shortcut icon" href="{{ url('assets/dashboard/images/favicon.ico') }}" />
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{ url('assets/dashboard/css/bootstrap.min.css') }}">
      <!-- Typography CSS -->
      <link rel="stylesheet" href="{{ url('assets/dashboard/css/typography.css') }}">
      <!-- Style CSS -->
      <link rel="stylesheet" href="{{ url('assets/dashboard/css/style.css') }}">
      <!-- Responsive CSS -->
      <link rel="stylesheet" href="{{ url('assets/dashboard/css/responsive.css') }}">

    <style>
        kbd {
            background-color: #3193d4;
        }
    </style>
   </head>
   <body>
      <!-- loader Start -->
      <div id="loading">
         <div id="loading-center">
         </div>
      </div>
      <!-- loader END -->
        <!-- Sign in Start -->
        <section class="sign-in-page" style="overflow: visible; height: 120vh;">
          <div id="container-inside">
              <div id="circle-small"></div>
              <div id="circle-medium"></div>
              <div id="circle-large"></div>
              <div id="circle-xlarge"></div>
              <div id="circle-xxlarge"></div>
          </div>
            <div class="container p-0">
                <div class="row no-gutters">

                    <div class="col-md-12 bg-white pt-5 mb-2">
                        <div class="sign-in-from">
                            <img src="{{ url('assets/dashboard/images/logo-ha.png') }}" class="img-fluid" alt="logo">

<br /><br />
                            <div class="tab-pane  " id="upgrade-plan" role="tabpanel">
                              <div class="iq-card" style="text-align: center">
                                <br /><h1 style="margin: auto">Payment Sucessful</h1>
<br />
                                <div style="text-align: left; padding: 1em">Your payment has been successful. You are now a Hapiom member.</div>
                                <div style="text-align: left; padding: 1em">You will be re-directed in <span id="fiveseconds">5</span> seconds.</div>
                              </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Sign in END -->
      <!-- Optional JavaScript -->
      <!-- jQuery first, then Popper.js, then Bootstrap JS -->
      <script src="{{ url('assets/dashboard/js/jquery.min.js') }}"></script>
      <script src="{{ url('assets/dashboard/js/popper.min.js') }}"></script>
      <script src="{{ url('assets/dashboard/js/bootstrap.min.js') }}"></script>
      <!-- Appear JavaScript -->
      <script src="{{ url('assets/dashboard/js/jquery.appear.js') }}"></script>
      <!-- Countdown JavaScript -->
      <script src="{{ url('assets/dashboard/js/countdown.min.js') }}"></script>
      <!-- Counterup JavaScript -->
      <script src="{{ url('assets/dashboard/js/waypoints.min.js') }}"></script>
      <script src="{{ url('assets/dashboard/js/jquery.counterup.min.js') }}"></script>
      <!-- Wow JavaScript -->
      <script src="{{ url('assets/dashboard/js/wow.min.js') }}"></script>
      <!-- Apexcharts JavaScript -->
      <script src="{{ url('assets/dashboard/js/apexcharts.js') }}"></script>
      <!-- lottie JavaScript -->
      <script src="{{ url('assets/dashboard/js/lottie.js') }}"></script>
      <!-- Slick JavaScript -->
      <script src="{{ url('assets/dashboard/js/slick.min.js') }}"></script>
      <!-- Select2 JavaScript -->
      <script src="{{ url('assets/dashboard/js/select2.min.js') }}"></script>
      <!-- Owl Carousel JavaScript -->
      <script src="{{ url('assets/dashboard/js/owl.carousel.min.js') }}"></script>
      <!-- Magnific Popup JavaScript -->
      <script src="{{ url('assets/dashboard/js/jquery.magnific-popup.min.js') }}"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="{{ url('assets/dashboard/js/smooth-scrollbar.js') }}"></script>
      <!-- Chart Custom JavaScript -->
      <script src="{{ url('assets/dashboard/js/chart-custom.js') }}"></script>
      <!-- Custom JavaScript -->
      <script src="{{ url('assets/dashboard/js/custom.js') }}"></script>

      <script>
      var time2redir = 5;
      window.addEventListener('DOMContentLoaded', (event) => { timeRedir(); });
        function timeRedir() {
           setInterval(function() {
                time2redir--;
                var a = document.getElementById("fiveseconds");
                if (time2redir > 0) { a.innerHTML = time2redir; }
                if (time2redir <=0) { redirect(); }
             }, 1000);
        }
        function redirect () {
           document.location.href = "{{ url('/user-login') }}";
        }

        function onSignupClicked() {
            $("#user-signup-agreement").modal("show");
        }

        function onProceedClicked() {
            $("#signup-form").submit();
        }

        function changeBtnStatus() {
            let firstName = $("#first_name").val();
            let lastName = $("#last_name").val();
            let email = $("#email").val();
            let password = $("#password").val();
            let acceptTerms = $("#customCheck1").prop('checked');
            if (firstName && lastName && email && password && acceptTerms) {
                $("#signupBtn").removeAttr('disabled');
            } else {
                $("#signupBtn").attr('disabled', 'true');
            }
        }

        $(document).ready(function() {
            $("input").keydown(function(){
                changeBtnStatus();
            });
            $("#customCheck1").on('change', function() {
                changeBtnStatus();
            })
        })
      </script>
   </body>
</html>
