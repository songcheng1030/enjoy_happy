@extends('dashboard.layouts.master')
@section('title', ' Profile')
@section('page', ' Profile')
@section('page-css-link') @endsection
@section('page-css') @endsection
@section('main-content')
<div class="header-spacer"></div>



<!-- Top Header-Profile -->
@if(!empty($user))
<div class="container">
	<div class="row">
		<div class="col col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
			<div class="ui-block">
				<div class="top-header">
					<div class="top-header-thumb">

					</div>
					<div class="profile-section">
						<div class="row">
							<div class="col col-lg-5 col-md-5 col-sm-12 col-12">
								<ul class="profile-menu">
									<li>
										<a href="02-ProfilePage.html" class="active">Timeline</a>
									</li>
									<li>
										<a href="05-ProfilePage-About.html">About</a>
									</li>
									@if(isset($friendrequest->request_from) && $friendrequest->request_from == Auth::user()->id)
									<li>
										<a href="06-ProfilePage.html">Friends</a>
									</li>
									@else
                                      <li>
										<a href="javascript::void();" toastmsg="test abd basdb" route="{{ route('add-friend',$user->id)}}"  class="addfriend" id="liveToastBtn">Add Friend</a>	
									 </li>
									@endif
								</ul>
							</div>
							<div class="col col-lg-5 ms-auto col-md-5 col-sm-12 col-12">
								<ul class="profile-menu">
									<li>
										<a href="07-ProfilePage-Photos.html">Photos</a>
									</li>
									<li>
										<a href="09-ProfilePage-Videos.html">Videos</a>
									</li>
									<li>
										<div class="more">
											<svg class="olymp-three-dots-icon"><use xlink:href="#olymp-three-dots-icon"></use></svg>
											<ul class="more-dropdown more-with-triangle">
												<!-- <li>
													<a href="#">Add Friend</a>
												</li> -->
												<li>
													<a href="#">Report Profile</a>
												</li>
												<li>
													<a href="#">Block Profile</a>
												</li>
											</ul>
										</div>
									</li>
								</ul>
							</div>
						</div>

						<div class="control-block-button">
							<a href="35-YourAccount-FriendsRequests.html" class="btn btn-control bg-blue">
								<svg class="olymp-happy-face-icon"><use xlink:href="#olymp-happy-face-icon"></use></svg>
							</a>

							<a href="#" class="btn btn-control bg-purple">
								<svg class="olymp-chat---messages-icon"><use xlink:href="#olymp-chat---messages-icon"></use></svg>
							</a>

							<div class="btn btn-control bg-primary more">
								<svg class="olymp-settings-icon"><use xlink:href="#olymp-settings-icon"></use></svg>

								<ul class="more-dropdown more-with-triangle triangle-bottom-right">
									<li>
										<a href="#" data-bs-toggle="modal" data-bs-target="#update-header-photo">Update Profile Photo</a>
									</li>
									<li>
										<a href="#" data-bs-toggle="modal" data-bs-target="#update-header-photo">Update Header Photo</a>
									</li>
									<li>
										<a href="29-YourAccount-AccountSettings.html">Account Settings</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="top-header-author">
						<a href="02-ProfilePage.html" class="author-thumb">
							<img loading="lazy" src="img/author-main1.webp" alt="author" width="124" height="124">
						</a>
						<div class="author-content">
							<a href="02-ProfilePage.html" class="h4 author-name">{{ ucwords($user->name) }}</a>
							<div class="country">San Francisco, CA</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- ... end Top Header-Profile -->

<div class="container">
	<div class="row">
		<div class="col col-xl-8 order-xl-2 col-lg-8 order-lg-2 col-md-12 order-md-1 col-sm-12 col-12">
			<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">Hobbies and Interests</h6>
					<a href="#" class="more"><svg class="olymp-three-dots-icon"><use xlink:href="#olymp-three-dots-icon"></use></svg></a>
				</div>
				<div class="ui-block-content">
					<div class="row">
						<div class="col col-lg-6 col-md-6 col-sm-12 col-12 mb-3 mb-md-0">

							
							<!-- W-Personal-Info -->
							
							<ul class="widget w-personal-info item-block">
								<li>
									<span class="title">Hobbies:</span>
									<span class="text">I like to ride the bike to work, swimming, and working out. I also like
															reading design magazines, go to museums, and binge watching a good tv show while it’s raining outside.
														</span>
								</li>
								<li>
									<span class="title">Favourite TV Shows:</span>
									<span class="text">Breaking Good, RedDevil, People of Interest, The Running Dead, Found,  American Guy.</span>
								</li>
								<li>
									<span class="title">Favourite Movies:</span>
									<span class="text">Idiocratic, The Scarred Wizard and the Fire Crown,  Crime Squad, Ferrum Man. </span>
								</li>
								<li>
									<span class="title">Favourite Games:</span>
									<span class="text">The First of Us, Assassin’s Squad, Dark Assylum, NMAK16, Last Cause 4, Grand Snatch Auto. </span>
								</li>
							</ul>
							
							<!-- ... end W-Personal-Info -->
						</div>
						<div class="col col-lg-6 col-md-6 col-sm-12 col-12">

							
							<!-- W-Personal-Info -->
							
							<ul class="widget w-personal-info item-block">
								<li>
									<span class="title">Favourite Music Bands / Artists:</span>
									<span class="text">Iron Maid, DC/AC, Megablow, The Ill, Kung Fighters, System of a Revenge.</span>
								</li>
								<li>
									<span class="title">Favourite Books:</span>
									<span class="text">The Crime of the Century, Egiptian Mythology 101, The Scarred Wizard, Lord of the Wings, Amongst Gods, The Oracle, A Tale of Air and Water.</span>
								</li>
								<li>
									<span class="title">Favourite Writers:</span>
									<span class="text">Martin T. Georgeston, Jhonathan R. Token, Ivana Rowle, Alexandria Platt, Marcus Roth. </span>
								</li>
								<li>
									<span class="title">Other Interests:</span>
									<span class="text">Swimming, Surfing, Scuba Diving, Anime, Photography, Tattoos, Street Art.</span>
								</li>
							</ul>
							
							<!-- ... end W-Personal-Info -->
						</div>
					</div>
				</div>
			</div>
			<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">Education and Employement</h6>
					<a href="#" class="more"><svg class="olymp-three-dots-icon"><use xlink:href="#olymp-three-dots-icon"></use></svg></a>
				</div>
				<div class="ui-block-content">
					<div class="row">
						<div class="col col-lg-6 col-md-6 col-sm-12 col-12">

							
							<!-- W-Personal-Info -->
							
							<ul class="widget w-personal-info item-block">
								<li>
									<span class="title">The New College of Design</span>
									<span class="date">2001 - 2006</span>
									<span class="text">Breaking Good, RedDevil, People of Interest, The Running Dead, Found,  American Guy.</span>
								</li>
								<li>
									<span class="title">Rembrandt Institute</span>
									<span class="date">2008</span>
									<span class="text">Five months Digital Illustration course. Professor: Leonardo Stagg.</span>
								</li>
								<li>
									<span class="title">The Digital College </span>
									<span class="date">2010</span>
									<span class="text">6 months intensive Motion Graphics course. After Effects and Premire. Professor: Donatello Urtle. </span>
								</li>
							</ul>
							
							<!-- ... end W-Personal-Info -->

						</div>
						<div class="col col-lg-6 col-md-6 col-sm-12 col-12">

							
							<!-- W-Personal-Info -->
							
							<ul class="widget w-personal-info item-block">
								<li>
									<span class="title">Digital Design Intern</span>
									<span class="date">2006-2008</span>
									<span class="text">Digital Design Intern for the “Multimedz” agency. Was in charge of the communication with the clients.</span>
								</li>
								<li>
									<span class="title">UI/UX Designer</span>
									<span class="date">2008-2013</span>
									<span class="text">UI/UX Designer for the “Daydreams” agency. </span>
								</li>
								<li>
									<span class="title">Senior UI/UX Designer</span>
									<span class="date">2013-Now</span>
									<span class="text">Senior UI/UX Designer for the “Daydreams” agency. I’m in charge of a ten person group, overseeing all the proyects and talking to potential clients.</span>
								</li>
							</ul>
							
							<!-- ... end W-Personal-Info -->
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col col-xl-4 order-xl-1 col-lg-4 order-lg-1 col-md-12 order-md-2 col-sm-12 col-12">
			<div class="ui-block">
				<div class="ui-block-title">
					<h6 class="title">Personal Info</h6>
					<a href="#" class="more"><svg class="olymp-three-dots-icon"><use xlink:href="#olymp-three-dots-icon"></use></svg></a>
				</div>
				<div class="ui-block-content">

					
					<!-- W-Personal-Info -->
					
					<ul class="widget w-personal-info">
						<li>
							<span class="title">About Me:</span>
							<span class="text">Hi, I’m James, I’m 36 and I work as a Digital Designer for the
													“Daydreams” Agency in Pier 56
												</span>
						</li>
						<li>
							<span class="title">Birthday:</span>
							<span class="text">December 14th, 1980</span>
						</li>
						<li>
							<span class="title">Birthplace:</span>
							<span class="text">Austin, Texas, USA</span>
						</li>
						<li>
							<span class="title">Lives in:</span>
							<span class="text">San Francisco, California, USA</span>
						</li>
						<li>
							<span class="title">Occupation:</span>
							<span class="text">UI/UX Designer</span>
						</li>
						<li>
							<span class="title">Joined:</span>
							<span class="text">April 31st, 2014</span>
						</li>
						<li>
							<span class="title">Gender:</span>
							<span class="text">Male</span>
						</li>
						<li>
							<span class="title">Status:</span>
							<span class="text">Married</span>
						</li>
						<li>
							<span class="title">Email:</span>
							<a href="#" class="text">jspiegel@yourmail.com</a>
						</li>
						<li>
							<span class="title">Website:</span>
							<a href="#" class="text">daydreamsagency.com</a>
						</li>
						<li>
							<span class="title">Phone Number:</span>
							<span class="text">(044) 555 - 4369 - 8957</span>
						</li>
						<li>
							<span class="title">Religious Belifs:</span>
							<span class="text">-</span>
						</li>
						<li>
							<span class="title">Political Incline:</span>
							<span class="text">Democrat</span>
						</li>
					</ul>
					
					<!-- ... end W-Personal-Info -->
					<!-- W-Socials -->
					
					<div class="widget w-socials">
						<h6 class="title">Other Social Networks:</h6>
						<a href="#" class="social-item bg-facebook">
							<svg width="16" height="16"><use xlink:href="#olymp-facebook-icon"></use></svg>
							Facebook
						</a>
						<a href="#" class="social-item bg-twitter">
							<svg width="16" height="16"><use xlink:href="#olymp-twitter-icon"></use></svg>
							Twitter
						</a>
						<a href="#" class="social-item bg-dribbble">
							<svg width="16" height="16"><use xlink:href="#olymp-dribble-icon"></use></svg>
							Dribbble
						</a>
					</div>
					
					
					<!-- ... end W-Socials -->
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@endsection
@section('page-js-link') @endsection
@section('page-js')
<script type="text/javascript">
$(document).on('click', '.addfriend', function() {
    route = $(this).attr('route');
    $.ajax({
        url: route,
        method: "GET",
        data: {
            "_token": "{{ csrf_token() }}",
        },
        beforeSend: function() {
        },
        success: function(data) {
        	$('.addfriend').addClass('d-none');
            if (data.status) {
               location.reload();
            }
        }
    })
});
</script>
@endsection