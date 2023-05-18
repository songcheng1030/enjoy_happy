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
		 
	.hide {
		display: none;
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

                      <div class="modal-dialog" role="document">
                         <div class="modal-content">
                            <div class="modal-header">
                               <h5 class="modal-title" id="gridModalLabel">Plan Payment</h5>
                               <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                            </div>
                            <div class="modal-body">
                    					<form action="{{ route('firstplan.post') }}"  method="post" data-cc-on-file="false"  data-stripe-publishable-key="{{ env('STRIPE_KEY') }}" autocomplete="off" class="require-validation" id="payment-form">
                    						{{ csrf_field() }}
                    						<input type="hidden" id="membershipId" name="membershipId" value="{{ $mebership_id }}" />
											<input type="hidden" id="user_id" name="user_id" value="{{ $user_id }}" />
                    						<div class="form-group">
                    							<label for="card_name">Full name (on the card)</label>
                    							<input class="form-control card-name" type="text" id="card_name" >
                    						</div> 
                    						<div class="form-group">
                    							<label for="card_number">Card number</label>
                    							<div class="input-group">
                    								<input type="text" class="form-control card-number" id="card_number" aria-describedby="basic-addon2">
                    								<div class="input-group-append">
                    									<span class="input-group-text" id="basic-addon2">
                    										<i class="fab fa-cc-visa" aria-hidden="true" style="font-size: 24px"></i>
                    										<i class="fab fa-cc-amex" aria-hidden="true" style="font-size: 24px; margin-left:5px"></i>
                    										<i class="fab fa-cc-mastercard" aria-hidden="true" style="font-size: 24px; margin-left:5px"></i>
                    									</span>
                    								</div>
                    							</div>
                    						</div>
                    						<div class="row">
                    							<div class="col col-xl-8 col-lg-8 col-md-12 col-sm-12 col-12">
                    								<div class="form-group expiration">
                    									<label>Expiration</label>
                    									<div class="d-flex"> 
                    										<select class="form-control" id="expiration_month">
                    											<option value="" hidden>MM</option>
                    											<option value="01">01</option>
                    											<option value="02">02</option>
                    											<option value="03">03</option>
                    											<option value="04">04</option>
                    											<option value="05">05</option>
                    											<option value="06">06</option>
                    											<option value="07">07</option>
                    											<option value="08">08</option>
                    											<option value="09">09</option>
                    											<option value="10">10</option>
                    											<option value="11">11</option>
                    											<option value="12">12</option>
                    										</select> 
                    										<select class="form-control" id="expiration_year">
                                          <option value="" hidden>YY</option>
                                          @php
                                          $b = (int)date('Y', time());
                                          for ($a = $b; $a < ($b + 11); $a++) {
                                                echo '<option value="'.$a.'">'.$a.'</option>';
                                          }

                                          @endphp

                    										</select>
                    									</div>
                    								</div>
                    							</div>
                    							<div class="col col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                    								<div class="form-group cvc">
                    									<label for="cvc"></label>
                    									<input autocomplete='off' class='form-control card-cvc' placeholder='CVC' size='4' type='text' id="card_cvc">
                    								</div>
                    							</div>
                    						</div>
                    						 
                    						 <!-- ... end Order Totals List -->
						<div class='form-row row'>
							<div class='col-md-12 error form-group hide'>
								<div class='alert-danger alert'>Please correct the errors and try again.
								</div>
							</div>
						</div>

						<div class="form-group">
                    							<label for="card_number" style="font-weight: bold;">Enter Special Code:</label>
												<div style="margin-top: -0.5em;">By entering a special code, you can bypass payment.</div>
                    							<div class="input-group">
												
												<input type="text" route="{{route('membershipspecialcode')}}" class="form-control card-number" id="special_payment_code" aria-describedby="basic-addon2">
                    								
												</div>
                    						</div>

                    			    	<button class="btn btn-primary mt-2" type="submit">
                    							Pay now
                    							<!--<span class="spinner-border spinner-border-sm ml-2 hide" role="status" aria-hidden="true" id="payment_loader"></span>-->
                    						</button>
                    					</form>
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

      <!-- Magnific Popup JavaScript -->
      <script src="{{ url('assets/dashboard/js/jquery.magnific-popup.min.js') }}"></script>
      <!-- Smooth Scrollbar JavaScript -->
      <script src="{{ url('assets/dashboard/js/smooth-scrollbar.js') }}"></script>
      <!-- Chart Custom JavaScript -->
      <script src="{{ url('assets/dashboard/js/chart-custom.js') }}"></script>
      <!-- Custom JavaScript -->
      <script src="{{ url('assets/dashboard/js/custom.js') }}"></script>

      <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
      <script type="text/javascript">
   $(function() {
        var $form = $(".require-validation");
        $('form.require-validation').bind('submit', function(e) {

			var special_pc = jQuery('#special_payment_code').val();
			var membershipId = jQuery('#membershipId').val();
			var user_id = jQuery('#user_id').val();
			if (special_pc.trim() != '') {
				e.preventDefault();
			    route = jQuery('#special_payment_code').attr('route');
				$.ajax({
					url: route,
					method: "POST",
					data: {
						"_token": "{{ csrf_token() }}",
						"special_pc": special_pc,
						"membershipId": membershipId,
						"user_id": user_id
                    },
					beforeSend: function() {},
					success: function(data) {
						if (data.error == 1) {
							var $form = $(".require-validation");
							$errorMessage = $form.find('div.error');
							$errorMessage.removeClass('hide');
							$errorMessage.children('div').html(data.text);
						} else { 
							window.location.href = '{{route('firstplan.paysucc')}}';
						}
					}
				})
				return;
			} else {
				var $form = $(".require-validation");
				e.preventDefault();
				let cardname = jQuery('#card_name').val(); 
				let card_number = jQuery('#card_number').val();  
				let expiration_month = jQuery('#expiration_month').val();  
				let expiration_year = jQuery('#expiration_year').val();  
				let card_cvc = jQuery('#card_cvc').val();
				if (cardname.trim() == '' || card_number.trim() == '' || expiration_month.trim() == '' 
				|| expiration_year.trim() == '' || card_cvc.trim() == '') {
					$errorMessage = $form.find('div.error');
					$errorMessage.removeClass('hide');
					$errorMessage.children('div').html('Please fill the required fields');
					return;
				} 
			}
			
            var $form = $(".require-validation"),
                inputSelector = ['input[type=email]', 'input[type=password]',
                    'input[type=text]', 'input[type=file]',
                    'textarea'
                ].join(', '),
                $inputs = $form.find('.required').find(inputSelector),
                $errorMessage = $form.find('div.error'),
                valid = true;
            $errorMessage.addClass('hide');
			if (!$form.data('cc-on-file')) { 
							e.preventDefault();
							const stripePublishableKey = $form.data('stripe-publishable-key');
							if (!stripePublishableKey) {
								$errorMessage.removeClass('hide');
								$errorMessage.children('div').html('Please correct your payment settings');
								return
							}
							$("#payment_loader").removeClass('hide');
							Stripe.setPublishableKey($form.data('stripe-publishable-key'));
							Stripe.createToken({
									number: $('#card_number').val(),
									cvc: $('#card_cvc').val(),
									exp_month: $('#expiration_month').val(),
									exp_year: $('#expiration_year').val()
							}, stripeResponseHandler);
            }
        });
        function stripeResponseHandler(status, response) {
            if (response.error) {
							$('.error').removeClass('hide').find('.alert').text(response.error.message);
			} else {
							var token = response['id'];
							$form.find('input[type=text]').empty();
							$form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
							$form.append("<input type='hidden' name='tokendetail' value='" + response + "'/>");
							$form.get(0).submit();
            }
        }
    });

		function showPaymentTierModal(membershipId) {
			$("#membershipId").val(membershipId);
			$('#stripePaymentModal').modal('show');
		}
</script>

<script type="text/javascript">
	$(document).ready(function() {

		$( "#level" ).change(function() {
		    id =  $('#level').val();
		    $('#create-friend-group-1 #meberships_id').val(id);

			$.ajax({
				url: "<?php echo route('plan-amount') ?>",
				method: "GET",
				data: {
					"_token": "{{ csrf_token() }}", "id" : id,
				},
				beforeSend: function() {
				},
				success: function(data) {
					$('#amount').val(data['amount']);
					$('#create-friend-group-1 #amount').val(data['amount']);

				}
			})
		});

	});

</script>
   </body>
</html>
