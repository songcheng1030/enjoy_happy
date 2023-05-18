@extends('dashboard.layouts.master')
@section('title', ' Newsfeed')
@section('page', ' Newsfeed')
@section('page-css-link') @endsection
@section('page-css')
<style>
	.line-height-17 {
		line-height: 17px;
	}
</style>
@endsection
@section('main-content')

<div id="content-page" class="content-page">
	<div class="container">
		<div class="row">
			@include('dashboard.includes.alert')

			<div class="col-lg-8 m-0 p-0">
				<div class="col-sm-12">
					<div id="post-modal-data" class="iq-card iq-card-block iq-card-stretch iq-card-height">
						<div class="iq-card-header d-flex justify-content-between">
							<div class="iq-header-title">
								<h4 class="card-title">Create Post</h4>
							</div>
						</div>
						<div class="iq-card-body">
							<div class=" ">

								<form method="post" action="{{ route('newsfeed-create') }}" enctype="multipart/form-data" id="post_upload_Form"  >
									@csrf
									<div>
										<div class="d-flex align-items-center">
											<div class="user-img">
												@if(isset($userinfo->profile_image) && file_exists('images/profile/'. $userinfo->profile_image))
												<img src="{{ url('images/profile',$userinfo->profile_image ) }}" alt="userimg" class="avatar-60 rounded-circle">
												@else
												<img src="{{url('assets/dashboard/img/default-avatar.png')}}" alt="userimg" class="avatar-60 rounded-circle">
												@endif
											</div>
											<div class="caption ml-2">
												<h5 class="mb-0 line-height">{{ ucwords(Auth::user()->name) }}</h5>
											</div>
										</div>
										<input onkeyup="enableDisablePost()" id="mainpost" type="text" class="form-control mt-3" name="textpost" placeholder="What's on your mind?" style="border-radius:20px;">

										<input type="hidden" name="group_id" value="{{ @$group_id }}">
										<hr>
										<ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
											<li class="col-md-6 mb-3 d-flex">
												<div class="iq-bg-primary rounded p-2 pointer mr-3 image_upload1"><img src="{{ url('assets/dashboard/images/small/07.png') }}" alt="icon" class="img-fluid "> Photo/Video</div>
												<input class="d-none" id="my_file1" type="file" name="image[]" multiple>
												<div id="preview_embed"></div>
											</li>
										</ul>
										<hr>
										<div class="other-option">
											<div class="d-flex align-items-center justify-content-between">


											</div>
										</div>
										<button id="post_submit" type="submit" class="btn btn-primary d-block w-100 mt-3" disabled>Post</button>
									</div>
								</form>
							</div>

						</div>
					<!--	<div class="modal fade" id="post-modal" tabindex="-1" role="dialog" aria-labelledby="post-modalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title" id="post-modalLabel">Create Post</h5>
										<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="ri-close-fill m-0"></i></button>
									</div>
									<form method="post" action="{{ route('newsfeed-create') }}" enctype="multipart/form-data" id="post_upload_Form">
										@csrf
										<div class="modal-body">
											<div class="d-flex align-items-center">
												<div class="user-img">
													@if(isset($userinfo->profile_image) && file_exists('images/profile'. $userinfo->profile_image))
													<img src="{{ url('images/profile',$userinfo->profile_image ) }}" alt="userimg" class="avatar-60 rounded-circle">
													@else
													<img src="{{url('assets/dashboard/img/default-avatar.png')}}" alt="userimg" class="avatar-60 rounded-circle">
													@endif
												</div>
												<div class="caption ml-2">
													<h5 class="mb-0 line-height">{{ ucwords(Auth::user()->name) }}</h5>
												</div>
											</div>
											<input type="text" class="form-control mt-3" name="textpost" placeholder="What's on your mind?" style="border-radius:20px;">

											<input type="hidden" name="group_id" value="{{ @$group_id }}">
											<hr>
											<ul class="d-flex flex-wrap align-items-center list-inline m-0 p-0">
												<li class="col-md-6 mb-3 d-flex">
													<div class="iq-bg-primary rounded p-2 pointer mr-3 image_upload1"><img src="{{ url('assets/dashboard/images/small/07.png') }}" alt="icon" class="img-fluid "> Photo/Video</div>
													<input class="d-none" id="my_file1" type="file" name="image[]" multiple>
													<div id="preview_embed"></div>
												</li>
											</ul>
											<hr>
											<div class="other-option">
												<div class="d-flex align-items-center justify-content-between">


												</div>
											</div>
											<button type="submit" class="btn btn-primary d-block w-100 mt-3">Post</button>
										</div>
									</form>
								</div>
							</div>
						</div>-->
					</div>
				</div>
				<div id="newsfeedposts">
                @php /* We put everything Ajax will use in a layout to avoid redundant code */ @endphp
				@include('dashboard.layouts.posts')

			</div></div>
			<div class="col-lg-4">
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Friend Suggestions</h4>
						</div>
					</div>
					<div class="iq-card-body">
						<ul class="media-story m-0 p-0">
							@foreach($friends as $value)
							<li class="d-flex mb-4 align-items-center active add-friend-{{ $value->id }}">
								@if (isset($value->profile_image) && file_exists('images/profile/'. $value->profile_image))
								<a href="{{ route('user-profile',encrypt($value->id)) }}">
									<img src="{{url('images/profile/', $value->profile_image)}}" class="rounded-circle img-fluid" alt="user">
								</a>
								@else
								<a href="{{ route('user-profile',encrypt($value->id)) }}">
									<img src="{{url('assets/dashboard/img/default-avatar.png')}}" class="rounded-circle img-fluid" alt="user">
								</a>
								@endif
								<div class="stories-data ml-3">
									<h5><a href="{{ route('user-profile',encrypt($value->id)) }}">{{ $value->name }}</a></h5>
									<p class="mb-0"><a href="javascript:void(0)" route="{{ route('add-friend',$value->id)}}" user_id="{{$value->id}}" class="add-friend" id="liveToastBtn">Add friend</a></p>
								</div>
							</li>
							@endforeach
						</ul>
						<a href="{{ route('friendlist') }}" class="btn btn-primary d-block mt-3">See All</a>
					</div>
				</div>
				<!-- <div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Events</h4>
						</div>
						<div class="iq-card-header-toolbar d-flex align-items-center">
							<div class="dropdown">
								<span class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false" role="button">
									<i class="ri-more-fill"></i>
								</span>
								<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton" style="">
									<a class="dropdown-item" href="#"><i class="ri-eye-fill mr-2"></i>View</a>
									<a class="dropdown-item" href="#"><i class="ri-delete-bin-6-fill mr-2"></i>Delete</a>
									<a class="dropdown-item" href="#"><i class="ri-pencil-fill mr-2"></i>Edit</a>
									<a class="dropdown-item" href="#"><i class="ri-printer-fill mr-2"></i>Print</a>
									<a class="dropdown-item" href="#"><i class="ri-file-download-fill mr-2"></i>Download</a>
								</div>
							</div>
						</div>
					</div>
					<div class="iq-card-body">
						<ul class="media-story m-0 p-0">
							<li class="d-flex mb-4 align-items-center ">
								<img src="{{ url('assets/dashboard/images/page-img/s4.jpg') }}" alt="story-img" class="rounded-circle img-fluid">
								<div class="stories-data ml-3">
									<h5>Web Workshop</h5>
									<p class="mb-0">1 hour ago</p>
								</div>
							</li>
							<li class="d-flex align-items-center">
								<img src="{{ url('assets/dashboard/images/page-img/s5.jpg') }}" alt="story-img" class="rounded-circle img-fluid">
								<div class="stories-data ml-3">
									<h5>Fun Events and Festivals</h5>
									<p class="mb-0">1 hour ago</p>
								</div>
							</li>
						</ul>
					</div>
				</div> -->
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Upcoming Birthday</h4>
						</div>
					</div>
					<div class="iq-card-body">
						@if(isset($acceptedFriends) && $acceptedFriends && count($acceptedFriends) > 0)
						 @php
						 $cnt = 0;
						 @endphp
						<ul class="media-story m-0 p-0">
							@foreach($acceptedFriends as $value)
								@php
								if ($value->userInfo) {
								$birthMonth = Carbon\Carbon::parse($value->userInfo->dob)->format('m');
								$birthDate = Carbon\Carbon::parse($value->userInfo->dob)->format('d');
								$currentMonth = Carbon\Carbon::now()->format('m');
								$currentDate = Carbon\Carbon::now()->format('d');
								$birthDay = Carbon\Carbon::parse($value->userInfo->dob);
								}
								@endphp
								@if ($value->userInfo)
									@if(($birthMonth == $currentMonth) && ($birthDate > $currentDate) )
										$cnt ++
										<li class="d-flex mb-4 align-items-center active">
											@if(isset($value->userInfo->profile_image) && file_exists('images/profile/' . $value->userInfo->profile_image))
											<a href="{{ route('user-profile',encrypt($value->id)) }}">
												<img src="{{ url('images/profile/',$value->userInfo->profile_image) }}" alt="profile-img" class="rounded-circle img-fluid" />
											</a>
											@else
											<a href="{{ route('user-profile',encrypt($value->id)) }}">
												<img src="{{ url('assets/dashboard/img/default-avatar.png') }}" alt="profile-img" class="rounded-circle img-fluid" />
											</a>
											@endif
											<div class="stories-data ml-3">
												<h5><a href="{{ route('user-profile',encrypt($value->id)) }}">{{ $value->name }}</a></h5>
												<p class="mb-0">{{ $birthDay->format('Y-m-d') }}</p>
											</div>
										</li>
									@endif
								@else
									<h5 class="text-center">He needs to add his profile.</h5>
									<li class="d-flex mb-4 align-items-center active">
										<a href="{{ route('user-profile',encrypt($value->id)) }}">
											<img src="{{ url('assets/dashboard/img/default-avatar.png') }}" alt="profile-img" class="rounded-circle img-fluid" />
										</a>
										<div class="stories-data ml-3">
											<h5><a href="{{ route('user-profile',encrypt($value->id)) }}">{{ $value->name }}</a></h5>
											<p class="mb-0">No birthday</p>
										</div>
									</li>
								@endif
							@endforeach	
						</ul>
						@else
						<h5 class="text-center">No friends accepted.</h5>
						@endif
						@if (!isset($cnt) || $cnt == 0)
						<h5 class="text-center">No upcoming birthday.</h5>
						@endif
					</div>
				</div>
				<div class="iq-card">
					<div class="iq-card-header d-flex justify-content-between">
						<div class="iq-header-title">
							<h4 class="card-title">Suggested Pages</h4>
						</div>
					</div>
					<div class="iq-card-body">
						<ul class="suggested-page-story m-0 p-0 list-inline">
							@foreach($randomResults as $result)
							<li class="mb-3">
								<div class="d-flex align-items-center mb-3">
									@if(isset($result->userImageByPost->profile_image) && file_exists('images/profile' .$result->userImageByPost->profile_image))
									<a href="{{ route('user-profile',encrypt($result->NewsfeedUser->id)) }}">
										<img alt="story-img" class="rounded-circle img-fluid avatar-50" src="{{ url('images/profile',$result->userImageByPost->profile_image) }}">
									</a>
									@else
									<a href="{{ route('user-profile',encrypt($result->NewsfeedUser->id)) }}">
										<img alt="story-img" class="rounded-circle img-fluid avatar-50" src="{{url('assets/dashboard/img/default-avatar.png')}}">
									</a>
									@endif
									<div class="stories-data ml-3">
										<h5><a href="{{ route('user-profile',encrypt($result->NewsfeedUser->id)) }}">{{ ucwords($result->NewsfeedUser->name) }}</a></h5>
										@php
										$truncated = (strlen($result->text) > 15) ? substr($result->text, 0, 15) . '...' : $result->text;
										@endphp
										<p class="mb-0">{{ $truncated }}</p>
									</div>
								</div>
								@if($result->NewsfeedGallaries->count() == 1)
								@foreach($result->NewsfeedGallaries as $imageValue)
								@if(isset($imageValue->image) && file_exists('images/newsfeed/'.$imageValue->image))
								<a href="{{ route('newsfeed-show', $result->id) }}"><img src="{{ url('images/newsfeed/'.$imageValue->image) }}" class="img-fluid rounded w-100 suggested-page_img" alt="Responsive image"></a>
								@endif
								@endforeach
								@else
								@foreach($result->NewsfeedGallaries as $imageValue)
								@if(isset($imageValue->image) && file_exists('images/newsfeed/'.$imageValue->image))
								<a href="{{ route('newsfeed-show', $result->id) }}"><img src="{{ url('images/newsfeed/'.$imageValue->image) }}" class="img-fluid rounded w-100 suggested-page_img" alt="Responsive image"></a>
								@endif
								@endforeach
								@endif
								<div class="mt-3">
									@php
									$like = null;
									foreach($result->NewsfeedLike as $newLike) {
									if($newLike->NewsfeedUser->id == Auth::user()->id) {
									$like = true;
									break;
									}
									}
									@endphp
									<a href="javascript:void(0)" class="btn d-block likePost like1Color_{{ $result->id }}" newsfeed_id="{{ $result->id }}" route="{{ route('newsfeed-like')}}" user_id="{{ $result->user_id }}" likes_id="{{ Auth::user()->id }}">
										@if($like)
										<span style="color: #ff5e3a;"><i class="ri-thumb-down-line mr-2"></i> Unlike Page</span>
										@else
										<i class="ri-thumb-up-line mr-2"></i> Like Page
										@endif
									</a>
								</div>
							</li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="col-sm-12 text-center">
				<img id="page_load_loader" src="{{ url('assets/dashboard/images/page-img/page-load-loader.gif') }}" alt="loader" style="height: 100px; display: none;">
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="newsfeedModal" tabindex="-1" role="dialog" aria-labelledby="newsfeedModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="newsfeedModalLabel">Edit Post</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="newsfeed_form">
					<div class="form-group">
						<label for="newsfeed_description" class="col-form-label">Description:</label>
						<textarea type="text" class="form-control" id="newsfeed_description"></textarea>
						<input type="hidden" class="form-control" id="newsfeed-id">
					</div>
					<div class="form-group">
						<div class="row">
							<div class="iq-bg-primary col-md-4 rounded p-2 pointer mr-3 image_upload2"><img src="{{ url('assets/dashboard/images/small/07.png') }}" alt="icon" class="img-fluid "> Photo/Video</div>
							<input class="d-none" id="my_file2" type="file" name="image[]" multiple>
							<div class="col-md-8" id="edit-img-show">
								<img src="#" alt="icon" class="img-fluid ">
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary newsfeed_update_btn">Submit</button>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="commentModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="commentModalLabel">Edit Comment</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="comment_form">
					<div class="form-group">
						<label for="comment_desc" class="col-form-label">Comment:</label>
						<textarea type="text" class="form-control" id="comment_desc"></textarea>
						<input type="hidden" class="form-control" id="edit-comment-id">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary comment_update_btn">Submit</button>
			</div>
		</div>
	</div>
</div>

@endsection
@section('page-js-link') @endsection
@section('page-js')


<script type="text/javascript">
	function sharePost() {
		let newsfeed_id = $('.share-post-btn').attr('newsfeed-id');
		let username = $('.share-post-btn').attr('username');
		let subject = `${encodeURIComponent('See this post by @' + username)}`;
		let body = subject + `${encodeURIComponent('{{url()->current()}}')}`;
		let mailtoURL = 'mailto:?subject=' + subject + '&body=' + body;
		$('.share-post-btn').attr('href', mailtoURL);
	}

	function enableDisablePost() {
		var preview_embed = jQuery('#preview_embed').html();
		var inputText = jQuery('#mainpost').val();
		if (preview_embed.trim() != '' || inputText.trim() != '') {
        	jQuery('#post_submit').prop("disabled", false);
	    }
		else {
			jQuery('#post_submit').prop("disabled", true);
		}
	}

	function likePost($this) {
		newsfeed_id = $($this).attr('newsfeed_id');
			user_id = $($this).attr('user_id');
			likes_id = $($this).attr('likes_id');
			route = $($this).attr('route');
			face_icon = $($this).find('input').val();
            //alert(route);
			//return;
			$.ajax({
				url: route,
				method: "GET",
				data: {
					"_token": "{{ csrf_token() }}",
					"newsfeed_id": newsfeed_id,
					"user_id": user_id,
					"likes_id": likes_id,
					"face_icon": face_icon,
				},
				beforeSend: function() {},
				success: function(data) {
					console.log('data', data);
					if (null !== (data['newsfeedLike'])) {
						$('.likePost').find('input').val(data['newsfeedLike']['face_icon']);
				    }
					if (data['is_like'] === true) {
						html = `<i class="ri-thumb-down-line mr-2"></i>Unlike Page`;
						$('.like1Color_' + newsfeed_id).html(html);
						$('.like1Color_' + newsfeed_id).css("color", "#ff5e3a");
						//$('.like2Color_' + newsfeed_id).css("background-color", "#ff5e3a");
					} else {
						html = `<i class="ri-thumb-up-line mr-2"></i>Like Page`;
						$('.like1Color_' + newsfeed_id).html(html);
						$('.like1Color_' + newsfeed_id).css("color", "#212529");
						//$('.like2Color_' + newsfeed_id).css("background-color", "#9a9fbf");
					}
					$('.total_count_' + newsfeed_id).html(data['count']);
				}
			})
	}

	function postFollow($this) {
		newsfeed_id = $($this).attr('newsfeed_id');
		user_id = $($this).attr('user_id');
		following_id = $($this).attr('following_id');
		route = $($this).attr('route');

		$.ajax({
			url: route,
			method: "POST",
			data: {
				"_token": "{{ csrf_token() }}",
				"newsfeed_id": newsfeed_id,
				"user_id": user_id,
				"following_id": following_id,
			},
			beforeSend: function() {},
			success: function(response) {
				if (response.data.is_follow === true) {
					$('#post-follow-' + newsfeed_id).html('');
					html = '<i class="ri-user-unfollow-line line-height-17"></i>Unfollow';
					$('#post-follow-' + newsfeed_id).html(html);
					$('#post-follow-' + newsfeed_id).css('color', 'black');
					$('#post-follow-' + newsfeed_id).css('font-weight', 'bold');
				} else {
					$('#post-follow-' + newsfeed_id).html('');
					html = '<i class="ri-user-follow-line line-height-17"></i>Follow';
					$('#post-follow-' + newsfeed_id).html(html);
					$('#post-follow-' + newsfeed_id).css('color', '#50b5ff');
					$('#post-follow-' + newsfeed_id).css('font-weight', 'normal');
				}
				//$('.total_count_' + newsfeed_id).html(data['count']);
			}
		})
	}

	function likeCommentPost($this) {
		newsfeed_id = $($this).attr('newsfeed_id');
		users_id = $($this).attr('users_id');
		comment_id = $($this).attr('comment_id');
		route = $($this).attr('route');
		face_icon = $($this).find('input').val();
		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"newsfeed_id": newsfeed_id,
				"comment_id": comment_id,
				"users_id": users_id,
				"face_icon": face_icon,
			},
			beforeSend: function() {},
			success: function(data) {
				if (data['is_like'] === true) {
					$('.commentlikeColor_' + comment_id).css("background-color", "#ff5e3a");
				} else {
					$('.commentlikeColor_' + comment_id).css("background-color", "#fafbfd");
				}

				$('.total_comment_like_count_' + comment_id).html(data['count']);

			}
		})
	}

	function likeReplyCommentPost($this) {
		newsfeed_id = $($this).attr('newsfeed_id');
		users_id = $($this).attr('users_id');
		comment_id = $($this).attr('comment_id');
		reply_comment_id = $($this).attr('reply_comment_id');
		route = $($this).attr('route');
		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"newsfeed_id": newsfeed_id,
				"comment_id": comment_id,
				"users_id": users_id,
				"reply_comment_id": reply_comment_id
			},
			beforeSend: function() {},
			success: function(data) {
				if (data['is_like'] === true) {
					$('.replycommentlikeColor_' + reply_comment_id).css("background-color", "#ff5e3a");
				} else {
					$('.replycommentlikeColor_' + reply_comment_id).css("background-color", "#fafbfd");
				}
				$('.total_reply_comment_like_count_' + reply_comment_id).html(data['count']);
			}
		})
	}

	function blocknewsfeed($this) {
		toastr.options = {
			"closeButton": true,
			"newestOnTop": true,
			"positionClass": "toast-top-right"
		};
		newsfeed_id = $($this).attr('newsfeed_id');
		var route = "{{url('/block-newsfeed/')}}" + '/' + newsfeed_id;
		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
			},
			beforeSend: function() {},
			success: function(data) {
				toastr.success(data.text);
				if (data.status) {
					$('.block-hide-show-' + newsfeed_id).hide();
					var _html = '<a href="javascript:void(0)" class="unblock-newsfeed unblock-hide-show-' + newsfeed_id + '" newsfeed_id="' + newsfeed_id + '" id="liveToastBtn">Unblock Post</a>'
					$(".block-unbolock-" + newsfeed_id).append(_html);
				}
			}
		})
	}

	function unblockNewsfeed($this) {
		toastr.options = {
			"closeButton": true,
			"newestOnTop": true,
			"positionClass": "toast-top-right"
		};

		newsfeed_id = $($this).attr('newsfeed_id');
		var route = "{{url('/unblock-newsfeed/')}}" + '/' + newsfeed_id;

		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
			},
			beforeSend: function() {},
			success: function(data) {
				toastr.success(data.text);
				if (data.status) {
					$('.unblock-hide-show-' + newsfeed_id).hide();
					var _html = '<a href="javascript:void(0)" class="block-newsfeed block-hide-show-' + newsfeed_id + '" newsfeed_id="' + newsfeed_id + '" id="liveToastBtn">Block Post</a>'
					$(".block-unbolock-" + newsfeed_id).append(_html);
				}
			}
		})
	}

	function deleteNewsfeed($this) {
		newsfeed_id = $($this).attr('newsfeed_id');
		toastr.options = {
			"closeButton": true,
			"newestOnTop": true,
			"positionClass": "toast-top-right"
		};
		route = $($this).attr('route');
		if (confirm("Are You Sure to delete this newsfeed post ?") == true) {
			$.ajax({
				url: route,
				method: "GET",
				data: {
					"_token": "{{ csrf_token() }}",
				},
				beforeSend: function() {},
				success: function(data) {
					toastr.success(data.text);
					if (data.status) {
						document.getElementById("del-newsfeed_" + newsfeed_id).remove();
					}
				}
			})
		}
	}

	function replyComment(newsfeed_id, comment_id)
	{
		let comment = jQuery('#comment-reply-text-' + comment_id).val();
        var fd = new FormData();
		var files = jQuery('#comment_file_' + comment_id)[0].files;
		fd.append('comment_file',files[0]);
		fd.append('newsfeed_id', newsfeed_id);
        fd.append('comment_id', comment_id);
		fd.append('comment', comment);
        doCommentAjax(fd, newsfeed_id, comment_id);
	}

	// Post Comment
	function doComment(event, newsfeed_id) {
		if (event.keyCode == 13) {
			event.preventDefault();
			let comment = $('.comment-text-' + newsfeed_id).val();
			//alert(comment);
		    var fd = new FormData();
		    var files = jQuery('#comment_file_' + newsfeed_id)[0].files;
			fd.append('comment_file',files[0]);
			fd.append('newsfeed_id', newsfeed_id);
			fd.append('comment', comment);
			doCommentAjax(fd, newsfeed_id, false);
		}
    }

    function doCommentAjax(fd, newsfeed_id, comment_id)
	{
		jQuery.ajax({
				url: '{{ route('comment_add')}}',
				type: 'post',
				headers: {'X-CSRF-TOKEN': '{{csrf_token()}}' },
				data: fd,
				contentType: false,
				processData: false,
				success: function(response){
					if (comment_id) {
						jQuery('#comment-reply-box-' + comment_id).prepend(response.comment);
					}
					else {
						jQuery('.hide-newsfeed_' + newsfeed_id).prepend(response.comment);
					}
					jQuery('.comment_add_' + newsfeed_id).html('<input type="text" class="form-control rounded comment-text-'+newsfeed_id+'" onkeydown="doComment(event, '+newsfeed_id+')" /> \
									<input class="d-none" id="comment_file_'+newsfeed_id+'" type="file" name="image" /> \
                                                        <div class="comment-attagement d-flex"> \
                                                            <!-- <a href="javascript:void();"><i class="ri-link mr-3"></i></a> \
                                                            <a href="javascript:void();"><i class="ri-user-smile-line mr-3"></i></a> --> \
                                                            <a href="javascript:void();" onClick="commentPicture('+newsfeed_id+')"><i class="ri-camera-line mr-3"></i></a> \
                                                        </div>');

														//_html = data;
					//$('.view-more-comment-btn-' + newsfeed_id).hide();
					$(".comments_list_" + newsfeed_id).hide();

					$('.comment-reply-form').hide();
		            $(".comment_reply_btn").unbind('click');


					$(".comment_reply_btn").click(function() {
						var id = $(this).attr('id');
					    $(".cr_" + id).toggle();
					});

					$(".comment_reply_btn").click(function() {
						var id = $(this).attr('id');
					    $(".comment_reply_add_" + id).toggle();
					});



					$(".comment_reply_child_btn").click(function() {
						var id = $(this).attr('id');
						$(".crc_" + id).toggle();
					});

					$('.comment-reply-form').on('submit', function(e) {
						//console.log(4444444444444444444);
						e.preventDefault();
						CommentReplyForm(this);
					});
					$('.comment-reply-child-form').on('submit', function(e) {
						e.preventDefault();
						CommentReplyChildForm(this);
				    });
					 $('.facemocion').faceMocion({
		emociones: [{
				"emocion": "amo",
				"TextoEmocion": "I love"
			},
			{
				"emocion": "divierte",
				"TextoEmocion": "I enjoy"
			},
			{
				"emocion": "gusta",
				"TextoEmocion": "I like"
			},
			{
				"emocion": "asombro",
				"TextoEmocion": "It amazes me"
			},
			{
				"emocion": "alegre",
				"TextoEmocion": "I am glad"
			}
		]
	});

				}
			});
	}

	function commentPicture(newsfeed_id) {
		jQuery('#comment_file_' + newsfeed_id).click();
    }

	function editNewsFeed($this) {
		newsfeed_id = $($this).attr('newsfeed_id');
		route = $($this).attr('route');

		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"newsfeed_id": newsfeed_id,
			},
			beforeSend: function() {},
			success: function(data) {
				$('#newsfeedModal').modal('show');
				$('#newsfeed_description').val('');
				$('#newsfeed_description').val(data.data.newfeed.text);
				document.getElementById("newsfeed-id").value = data.data.newfeed.id;
				var images = data.data.newfeed_galary;
				var arrayImagesElement = document.getElementById("edit-img-show");

				function createImageNode(images) {
					var img = document.createElement('img');
					img.src = "images/newsfeed/" + images.image;
					img.id = "edit-image-show";
					img.class = "edit-image-show";
					img.width = "435";
					img.height = "194"
					img.style.margin = "15px";
					return img;
				}
				$('div#edit-img-show  img').remove();
				images.forEach(img => {
					arrayImagesElement.appendChild(createImageNode(img));
				});

			}
		})
	}
    function addFriend($this) {
		toastr.options = {
				"closeButton": true,
				"newestOnTop": true,
				"positionClass": "toast-top-right"
			};

		route = $($this).attr('route');
		user_id = $($this).attr('user_id');
		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"user_id": user_id,
			},
			beforeSend: function() {},
			success: function(data) {
				toastr.success(data.text.message);
				if (data.status) {
					$('.add-friend-' + user_id).remove();
				}
			}
		})
	}

	function editComment($this) {
		comment_id = $($this).attr('comment_id');
		route = $($this).attr('route');

		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"comment_id": comment_id,
			},
			beforeSend: function() {},
			success: function(data) {
				//$('#commentModal').modal('show');
				$('#comment_desc').val('');
				$('#comment_desc').val(data.comment);
				$('#edit-comment-id').val(data.id);
			}
		})
	}

	function deleteComment($this) {
		comment_id = $($this).attr('comment_id');
		toastr.options = {
			"closeButton": true,
			"newestOnTop": true,
			"positionClass": "toast-top-right"
		};
		route = $($this).attr('route');
		if (confirm("Are you Sure to delete this comment ?") == true) {
			$.ajax({
				url: route,
				method: "GET",
				data: {
					"_token": "{{ csrf_token() }}",
				},
				beforeSend: function() {},
				success: function(data) {
					toastr.success(data.text);
					if (data.status) {
						$('#comment-el-' + comment_id).remove();
						$('.reply_comment_add_' + comment_id).remove();
					}
				}
			})
		}
	}
	function commentForm($this)
	{
		let user_id = $($this).attr('user_id')
		let newsfeed_id = $($this).attr('newsfeed_id')
		let comment = $(".comment-text-" + newsfeed_id).text();
		route = $($this).attr('route');
		$.ajax({
			url: route,
			method: "POST",
			data: {
				"_token": "{{ csrf_token() }}",
				comment: comment,
				user_id: user_id,
				newsfeed_id: newsfeed_id,
			},
			success: function(response) {
				location.reload();
			},
			error: function(response) {
				$('.comment-error-' + newsfeed_id).text(response.responseJSON.errors.comment);
			}
		});
	}

	function CommentForm_2()
	{
        var formData = new FormData();
		let comment_desc = $('#comment_desc').val();
		let comment_id = $('#edit-comment-id').val();
		let _token = $('meta[name="csrf-token"]').attr('content');
		_token = document.getElementsByName("_token")[0].value
		formData.append('_token', _token);
		formData.append('textpost', comment_desc);
		formData.append('comment_id', comment_id);
		$.ajax({
			url: "{{ url('/comment-update')}}",
			type: "POST",
			contentType: 'multipart/form-data',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function() {

			},
			success: (response) => {
				toastr.success(response.text);
				if (response.status === "success") {
					$("#commentModal").modal('hide');
					$('.comment-text-' + comment_id).text(comment_desc);
				}
			},
			error: function(data) {
				console.log(data);
			}
		});
	}

	function CommentReplyForm($this) {
		let user_id = $($this).attr('user_id')
		let newsfeed_id = $($this).attr('newsfeed_id')
		let comment_id = $($this).attr('comment_id')
		let comment = $(".comment-reply-text-" + comment_id).val();

		route = $($this).attr('route');
		if (comment === "") {
			$('.comment-reply-error-' + comment_id).text("This field is required.");
		} else {
			$.ajax({
				url: route,
				method: "POST",
				data: {
					"_token": "{{ csrf_token() }}",
					comment: comment,
					user_id: user_id,
					newsfeed_id: newsfeed_id,
					comment_id: comment_id
				},
				success: function(response) {
					console.log(response.data);
					$('.comment_reply_add_' + comment_id).hide();
					$(".reply_comment_add_" + comment_id).html(response.data);
					$('.comment-reply-child-form').hide();
					$('.comment-reply-text-' + comment_id).val('');
					$(".comment_reply_child_btn").click(function() {
						var id = $(this).attr('id');
						$(".crc_" + response.insertData.id).toggle();
					});
				},
				error: function(response) {
					alert('errrorrrrrrrr');
					$('.comment-reply-error-' + comment_id).text(response.responseJSON.errors.comment);
				}
			});
		}
	}


	function CommentReplyForm_2() {

		var formData = new FormData();
		let reply_comment_description = $('#reply_comment_description').val();
		let comment_id = $('#edit-comments-id').val();
		let reply_comment_id = $('#edit-reply-comment-id').val();
		let _token = $('meta[name="csrf-token"]').attr('content');
		_token = document.getElementsByName("_token")[0].value
		formData.append('_token', _token);
		formData.append('textpost', reply_comment_description);
		formData.append('comment_id', comment_id);
		formData.append('reply_comment_id', reply_comment_id);

		$.ajax({
			url: "{{ url('/reply-comment-update')}}",
			type: "POST",
			contentType: 'multipart/form-data',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function() {

			},
			success: (response) => {
				toastr.success(response.text);
				if (response.status === "success") {
					$("#replyCommentModal").modal('hide');
					$('.comment-reply-txt-' + reply_comment_id).text(reply_comment_description);
				}
			},
			error: function(data) {
				console.log(data);
			}
		});
	}


	function CommentReplyChildForm($this) {
		let user_id = $($this).attr('user_id')
		let newsfeed_id = $($this).attr('newsfeed_id')
		let comment_id = $($this).attr('comment_id')
		let reply_comment_id = $($this).attr('reply_comment_id')
		let comment = $(".comment-reply-child-text-" + reply_comment_id).val();
		route = $($this).attr('route');
		if (comment === "") {
			$('.comment-reply-child-error-' + reply_comment_id).text("This field is required.");
		} else {
			$.ajax({
				url: route,
				method: "POST",
				data: {
					"_token": "{{ csrf_token() }}",
					comment: comment,
					user_id: user_id,
					newsfeed_id: newsfeed_id,
					comment_id: comment_id
				},
				success: function(response) {
					// location.reload();
					$('.comment_reply_child_add_' + reply_comment_id).hide();
					$(".reply_comment_add_" + comment_id).html(response.data);
					$('.comment-reply-child-form').hide();
					$('.comment-reply-child-text-' + reply_comment_id).val('');
					$(".comment_reply_child_btn").click(function() {
						var id = $(this).attr('id');
						$(".crc_" + response.insertData.id).toggle();
					});


				},
				error: function(response) {
					$('.comment-reply-child-error-' + reply_comment_id).text("This field is required.");
				}
			});
		}
	}

	function editReplyComment($this) {
		comment_id = $($this).attr('comment_id');
		reply_comment_id = $($this).attr('reply_comment_id');
		route = $($this).attr('route');

		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"comment_id": comment_id,
				"reply_comment_id": reply_comment_id
			},
			beforeSend: function() {},
			success: function(data) {
				$('#replyCommentModal').modal('show');
				$('#reply_comment_description').val('');
				$('#reply_comment_description').val(data.reply_comment);
				document.getElementById("edit-comments-id").value = data.comment_id;
				document.getElementById("edit-reply-comment-id").value = data.id;
			}
		})
	}

	function moreComments($this)
	{
		newsfeed_id = $($this).attr('newsfeed_id');
		route = $($this).attr('route');
		$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"newsfeed_id": newsfeed_id,
			},
			beforeSend: function() {
				$('.view-more-comment-btn-' + newsfeed_id).html('Loading...');
			},
			success: function(data) {
				if (data.length > 0) {
					//_html = data;
					$('.view-more-comment-btn-' + newsfeed_id).hide();
					$(".comments_list_" + newsfeed_id).hide();
					$(".hide-newsfeed_" + newsfeed_id).html(data);
					// $('.comment-form').hide();
					// $('.comment-reply-form').hide();
					// $('.comment-reply-child-form').hide();

					$('.comment-reply-form').hide();
					$(".comment_reply_btn").unbind('click');

					$(".comment_reply_btn").click(function() {
						var id = $(this).attr('id');
						$(".cr_" + id).toggle();
					});

				    $(".comment_reply_btn").click(function() {
						var id = $(this).attr('id');
						$(".comment_reply_add_" + id).toggle();
					});



					$(".comment_reply_child_btn").click(function() {
						var id = $(this).attr('id');
						$(".crc_" + id).toggle();
					});

					$('.comment-reply-form').on('submit', function(e) {
						console.log(4444444444444444444);
						e.preventDefault();
						CommentReplyForm(this);
					});
					$('.comment-reply-child-form').on('submit', function(e) {
						e.preventDefault();
						CommentReplyChildForm(this);
				    });
					 $('.facemocion').faceMocion({
		emociones: [{
				"emocion": "amo",
				"TextoEmocion": "I love"
			},
			{
				"emocion": "divierte",
				"TextoEmocion": "I enjoy"
			},
			{
				"emocion": "gusta",
				"TextoEmocion": "I like"
			},
			{
				"emocion": "asombro",
				"TextoEmocion": "It amazes me"
			},
			{
				"emocion": "alegre",
				"TextoEmocion": "I am glad"
			}
		]
	});




				} else {
					$('.view-more-comment-btn-' + newsfeed_id).html('No Comment Found.');
				}
			}
		})
	}

	function NewsfeedForm() {
		var formData = new FormData();
		let newsfeed_description = $('#newsfeed_description').val();
		let my_file2 = $('#my_file2').prop('files');
		let newsfeed_id = $('#newsfeed-id').val();
		let TotalFiles = $('#my_file2')[0].files.length; //Total files
		let files = $('#my_file2')[0];

		for (let i = 0; i < TotalFiles; i++) {
			formData.append('image' + i, files.files[i]);
		}

		let _token = $('meta[name="csrf-token"]').attr('content');
		_token = document.getElementsByName("_token")[0].value
		formData.append('_token', _token);
		formData.append('textpost', newsfeed_description);
		formData.append('totalFile', TotalFiles);
		formData.append('newsfeed_id', newsfeed_id);

		$.ajax({
			url: "{{ url('/newsfeed/update')}}",
			type: "POST",
			contentType: 'multipart/form-data',
			cache: false,
			contentType: false,
			processData: false,
			data: formData,
			beforeSend: function() {

			},
			success: (response) => {
				toastr.success(response.text);
				$("#newsfeedModal").modal('hide');

				$('.newsfeed-text-' + newsfeed_id).text(newsfeed_description);
				$('.newsfeed-update-img-' + newsfeed_id).hide();
				let _html = ''
				response.data.forEach(function(element) {
					let imagePath = "{{ url('images/newsfeed/') }}";
					_html += '<img loading="lazy" src="' + imagePath + '/' + element.image + '" alt="photo" width="488" height="194" ><br>'
				});
				$('div.newsfeed-update-img-show-' + newsfeed_id + ' > img, br').remove();
				$(".newsfeed-update-img-show-" + newsfeed_id).append(_html);
			},
			error: function(data) {
				console.log(data);
			}
		});
	}

	function deleteReplyComment($this) {
		comment_id = $($this).attr('comment_id');
		reply_comment_id = $($this).attr('reply_comment_id');
		toastr.options = {
			"closeButton": true,
			"newestOnTop": true,
			"positionClass": "toast-top-right"
		};
		route = $($this).attr('route');
		if (confirm("Are You Sure to delete this comment reply ?") == true) {
			$.ajax({
				url: route,
				method: "GET",
				data: {
					"_token": "{{ csrf_token() }}",
				},
				beforeSend: function() {},
				success: function(data) {
					toastr.success(data.text);
					if (data.status) {
						document.getElementById("del-reply-comment_" + reply_comment_id).remove();
					}
				}
			})
		}
	}

	function filePreview(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#post_upload_Form + embed').remove();
				 $('#post_upload_Form #preview_embed').html('<embed src="' + e.target.result + '" width="80" height="50">');
				 enableDisablePost();
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	@if(Session::has('message'))
	toastr.options = {
		"closeButton": true,
		"progressBar": true
	}
	toastr.success("{{ session('message') }}");
	@endif

function clickFunctionality() {
	$('.comment-form').on('submit', function(e) {
			e.preventDefault();
			commentForm(this);
		});

		$(".image_upload1").unbind('click');
		$(".image_upload1").click(function() {
			$("input[id='my_file1']").click();
		});

		$(".image_upload2").unbind('click');
		$(".image_upload2").click(function() {
			$("input[id='my_file2']").click();
		});

		$(".image_upload3").unbind('click');
		$(".image_upload3").click(function() {
			$("input[id='my_file3']").click();
		});

		$('.comment-form').hide();

		$(".comment_btn").unbind('click');
		$(".comment_btn").click(function() {
			var id = $(this).attr('id');
			$(".comment_add_" + id).toggle();
		});

		$('.comment-reply-form').hide();
		$(".comment_reply_btn").unbind('click');
		$(".comment_reply_btn").click(function() {
			var id = $(this).attr('id');

			$(".comment_reply_add_" + id).toggle();
		});

		$('.comment-reply-child-form').hide();
		$(".comment_reply_child_btn").unbind('click');
		$(".comment_reply_child_btn").click(function() {
			var id = $(this).attr('id');
			$(".comment_reply_child_add_" + id).toggle();
		});

		$(".postFollow").unbind('click');
		$('.postFollow').on('click', function() {
			postFollow(this);
		});

		$(document).off('click', '.likeCommentPost');
		$(document).on('click', '.likeCommentPost', function() {
			likeCommentPost(this);
		});

		$(document).off('click', '.likeReplyCommentPost');
		$(document).on('click', '.likeReplyCommentPost', function() {
			likeReplyCommentPost(this);
		});
}
function reAddClickFunctions()
{
	$('.share-post-btn').on('click', function() { sharePost() });

	$(document).off('click', '.likePost');
	$(document).on('click', '.likePost', function() { likePost(this); });

	// Block Newsfeed Post
	$(document).off('click', '.block-newsfeed');
	$(document).on('click', '.block-newsfeed', function() {
		blocknewsfeed(this);
	});
	// Block Newsfeed Post
	$(document).off('click', '.unblock-newsfeed');
	$(document).on('click', '.unblock-newsfeed', function() {
		unblockNewsfeed(this);
	});
	// Delete Newsfeed Post
	$(document).off('click', '.delete-newsfeed');
	$(document).on('click', '.delete-newsfeed', function() {
		deleteNewsfeed(this);
	});

	// Newsfeed Model-popup
	$(document).off('click', '.edit-newsfeed');
	$(document).on('click', '.edit-newsfeed', function() {
		editNewsFeed(this);

	})

	 // Update Comment
	$('.comment_form').on('submit', function(e) {
		e.preventDefault();
		CommentForm_2();
	});

	// Add Friend
	$(document).off('click', '.add-friend');
	$(document).on('click', '.add-friend', function() {
		addFriend(this);

	});
	// Comment Model-popup
	$(document).off('click', '.edit-comment');
	$(document).on('click', '.edit-comment', function() {
		editComment(this);

	})
	// Delete comment Post
	$(document).off('click', '.delete-comment');
	$(document).on('click', '.delete-comment', function() {
		deleteComment(this);
	});

	// Post Reply Comment

	$(".comment-reply-form").unbind('click');
	$('.comment-reply-form').on('submit', function(e) {
		e.preventDefault();
		CommentReplyForm(this);
	});

	$('.comment-reply-child-form').on('submit', function(e) {
		e.preventDefault();
		CommentReplyChildForm(this);
	});

	// Reply Comment Model-popup
	$(document).off('click', '.edit-reply-comment');
	$(document).on('click', '.edit-reply-comment', function() {
		editReplyComment(this);
	})

	// Delete comment Post
	$(document).off('click', '.delete-reply-comment');
	$(document).on('click', '.delete-reply-comment', function() {
		deleteReplyComment(this);
	});
	// View More Comments+
	$(document).off('click', '.more-comments');
	$(document).on('click', '.more-comments', function() {
		moreComments(this);
	});

	// Model Close
	$(".close-newsfeed-model").unbind('click');
	$(".close-newsfeed-model").click(function() {
		$("#newsfeedModal").modal('hide');
	});

	$(".close-comment-model").unbind('click');
	$(".close-comment-model").click(function() {
		$("#commentModal").modal('hide');
	});

	$(".close-reply-comment-model").unbind('click');
	$(".close-reply-comment-model").click(function() {
		$("#replyCommentModal").modal('hide');
	});

	$(".newsfeed_update_btn").unbind('click');
	$('.newsfeed_update_btn').click(function() {
		$('.newsfeed_form').submit();
	});
	// Update Newsfeed
	$('.newsfeed_form').on('submit', function(e) {
		e.preventDefault();
		NewsfeedForm();
	});

	$(".comment_update_btn").unbind('click');
	$('.comment_update_btn').on('click', function() {
		$('.comment_form').submit();
	});


	// // Update Comment Reply
	$('.comment_reply_form').on('submit', function(e) {
		e.preventDefault();
        CommentReplyForm_2();
	});

	$('#my_file1').change(function() {
		filePreview(this);
	});



	$('.facemocion').faceMocion({
		emociones: [{
				"emocion": "amo",
				"TextoEmocion": "I love"
			},
			{
				"emocion": "divierte",
				"TextoEmocion": "I enjoy"
			},
			{
				"emocion": "gusta",
				"TextoEmocion": "I like"
			},
			{
				"emocion": "asombro",
				"TextoEmocion": "It amazes me"
			},
			{
				"emocion": "alegre",
				"TextoEmocion": "I am glad"
			}
		]
	});

}


$(document).ready(function() { clickFunctionality(); });
reAddClickFunctions();

var page = 2;
$(window).scroll(function() {
   if($(window).scrollTop() + $(window).height() == $(document).height()) {
	   if (page !== false) {
	   jQuery('#page_load_loader').fadeIn();
       $.get( "{{ url('/load-more-newsfeed') }}?page=" + page, function( data ) {
	   		page++;
			jQuery('#newsfeedposts').append(data);
		    reAddClickFunctions();
			clickFunctionality();
			if (data == '') { page = false; jQuery('#page_load_loader').fadeOut(); }
		});
	}
   }
});

function viewReplies(newsfeed_id, comment_id, route)
{
	/*alert(route);
	alert(newsfeed_id);
	alert(comment_id);*/
	$.ajax({
			url: route,
			method: "GET",
			data: {
				"_token": "{{ csrf_token() }}",
				"comment_id": comment_id,
				"newsfeed_id": newsfeed_id
			},
			beforeSend: function() {
				//$('.view-more-comment-btn-' + newsfeed_id).html('Loading...');
			},
			success: function(data) {
				if (data.length > 0) {
					//_html = data;
					//$('.view-more-comment-btn-' + newsfeed_id).hide();
					//$(".comments_list_" + newsfeed_id).hide();
					$("#view_replies_button_" + comment_id).hide();
					$("#comment-reply-box-" + comment_id).html(data);
					// $('.comment-form').hide();
					// $('.comment-reply-form').hide();
					// $('.comment-reply-child-form').hide();

					$('.comment-reply-form').hide();
					$(".comment_reply_btn").unbind('click');

					$(".comment_reply_btn").click(function() {
						var id = $(this).attr('id');
						$(".cr_" + id).toggle();
					});

				    $(".comment_reply_btn").click(function() {
						var id = $(this).attr('id');
						$(".comment_reply_add_" + id).toggle();
					});



					$(".comment_reply_child_btn").click(function() {
						var id = $(this).attr('id');
						$(".crc_" + id).toggle();
					});

					$('.comment-reply-form').on('submit', function(e) {
						console.log(4444444444444444444);
						e.preventDefault();
						CommentReplyForm(this);
					});
					$('.comment-reply-child-form').on('submit', function(e) {
						e.preventDefault();
						CommentReplyChildForm(this);
				    });
					 $('.facemocion').faceMocion({
		emociones: [{
				"emocion": "amo",
				"TextoEmocion": "I love"
			},
			{
				"emocion": "divierte",
				"TextoEmocion": "I enjoy"
			},
			{
				"emocion": "gusta",
				"TextoEmocion": "I like"
			},
			{
				"emocion": "asombro",
				"TextoEmocion": "It amazes me"
			},
			{
				"emocion": "alegre",
				"TextoEmocion": "I am glad"
			}
		]
	});




				} else {
					$("#comment-reply-box-" + comment_id).html('No Comment Found.');
					$("#view_replies_button_" + comment_id).hide();
				}
			}
		})
}

</script>

@endsection
