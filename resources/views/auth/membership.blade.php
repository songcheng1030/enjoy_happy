<!doctype html>
<html lang="en">
   <head>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Membership Hapiom</title>
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
                              <div class="iq-card">
                                <div class="iq-card-header d-flex justify-content-between">
                                  <div class="iq-header-title">
                                    <h4 class="card-title">Choose a Plan</h4>
                                  </div>
                                </div>
                                <div class="iq-card-body">
                                  <div class="card-deck">
                                    @foreach($meberships as $mebership)

                                      <div class="col-md-6">
                                        <form method="POST" action="{{ route('user-membershipcart',encrypt($id)) }}">
                                          {{ csrf_field() }}
                                          <input type="hidden" name="membership_id" value="{{$mebership->id}}" />
                                        <div class="card-header text-center"><h5>{{$mebership->name}}</h5></div>
                                        <div class="card-body" >
                                          <h4 class="card-title text-center">${{$mebership->amount}}</h4>
                                          <div class="h-75" style="min-height: 10em;">
                                            @foreach($mebership->descs as $desc)
                                              <div class="card-text mb-2"><i class="fa fa-check" aria-hidden="true"></i>{{ $desc }}</div>
                                            @endforeach
                                          </div>
                                          <div class="text-center">
                                            @if ($mebership->id === 99999)
                                              <button class="btn btn-outline-primary">Choose</button>
                                            @else
                                              <button class="btn btn-primary" type="submit">Choose</button>
                                            @endif
                                          </div>
                                        </div>  </form>
                                      </div>

                                    @endforeach
                                  </div>
                                </div>
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
