@extends('dashboard.layouts.master')
@section('title', ' Users')
@section('page', ' Users')
@section('page-css-link') @endsection
@section('page-css')

@endsection
@section('main-content')
<!-- Top Header-Profile -->

<div id="content-page" class="content-page">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="col-sm-12">
                    <div class="iq-card">


                        <div class="iq-card-body">
                        <form method="POST" action="{{ route('user.storecode') }}" enctype="multipart/form-data" class="needs-validation" novalidate id="ads_form">
                                @csrf
                                @method('POST')
                                <div class="row">
                                    @foreach ($meberships as $mebership)
                                    <div class="form-group col-md-12">
                                        <label for="email" style="font-weight: bold; font-size: 1.3em;">{{$mebership->name}} Code:</label>
                                        @php
                                        $value = isset($mem_code_array[$mebership->id]) ? $mem_code_array[$mebership->id] : '';
                                        @endphp
                                        <input name="membership_{{$mebership->id}}" class="form-control" type="text" placeholder="Enter code"  value="{{$value}}" required="">
                                        <label style="font-size: 1.2em;">{{$mebership->name}} Code Valid: </label>
                                        <br />No <input type="radio" value="1" name="used_{{$mebership->id}}" @if ($mem_used_array[$mebership->id] == 1) checked @endif /> | Yes <input type="radio" value="0" name="used_{{$mebership->id}}" @if ($mem_used_array[$mebership->id] == 0) checked @endif />
                                    </div>
                                    @endforeach

                                </div>
                                <button type="submit" class="btn btn-primary" id="submit_btn">Submit</button>
                                <a href="{{ route('user.index') }}" class="btn iq-bg-danger">Cancel</a>
                             
                         </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
</div>



@endsection
