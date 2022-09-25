@extends('layout.website')
@section('home_content')
<main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                    </ol>
                </div><!-- End .container -->
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h2 class="light-title"><strong> Contact Us</strong></h2>
                         @include('includes.message')
                        <form action="{{ route('post-contact') }}" method="POST">
                            @csrf
                            <div class="form-group required-field">
                                <label for="contact-name">Name</label>
                                <input type="text" class="form-control" id="contact-name" name="name" required>
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label for="contact-email">Email</label>
                                <input type="email" class="form-control" id="contact-email" name="email" required>
                            </div><!-- End .form-group -->

                            <div class="form-group">
                                <label for="contact-phone">Phone Number</label>
                                <input type="tel" class="form-control" id="contact-phone" name="phone_number">
                            </div><!-- End .form-group -->

                            <div class="form-group required-field">
                                <label for="contact-message">What’s on your mind?</label>
                                <textarea cols="30" rows="1" id="contact-message" class="form-control" name="message" required></textarea>
                            </div><!-- End .form-group -->

                            <div class="form-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div><!-- End .form-footer -->
                        </form>
                    </div><!-- End .col-md-8 -->

                    @php
                        $footer = \App\GeneralSetting::first();
                  //  dd($footer);
                    @endphp

                    <div class="col-md-4">
                        <h2 class="light-title">Contact <strong>Details</strong></h2>

                        <div class="contact-info">
                            <div>
                                <i class="icon-phone"></i>
                                <p><a href="tel:">{{$footer->address}}</a></p>
                                <!-- <p><a href="tel:">0201 203 2032</a></p> -->
                            </div>
                            <div>
                                <i class="icon-mobile"></i>
                                <p><a href="tel:">{{$footer->phone}}</a></p>
                                <!-- <p><a href="tel:">302-123-3928</a></p> -->
                            </div>
                            <div>
                                <i class="icon-mail-alt"></i>
                                <p><a href="mailto:#">{{$footer->email}}</a></p>
                                <!-- <p><a href="mailto:#">porto@portotemplate.com</a></p> -->
                            </div>
                            
                        </div><!-- End .contact-info -->
                    </div><!-- End .col-md-4 -->
                </div><!-- End .row -->


              @php
                 $warehouses =  \App\Warehouse::get();
              @endphp
                 <div class="row">

                     @foreach($warehouses as $warehouse)

                         @php
                       //  dd($warehouse->name);

                         @endphp
                       <div class="card branch col-md-4" style="margin-left:10px;max-width:350px;">
                         {{--<img class="card-img-top" src="https://www.populardiagnostic.com/public/branch/1-20190325125709.jpg">--}}
                         <div class="card-body">
                             <h4 class="font-weight-bold  text-4" > <strong style="color: black">{{ $warehouse->name }}</strong></h4>
                             <p class="card-text">{{  $warehouse->address  }}</p>

                             <ul class=" list-icons list-icons-style-3">
                                 <li><i class="fas fa-phone"></i>
                                     <a style="color: black" href="tel:09666 787801">{{ $warehouse->phone }}</a>,
                                     <a  style="color: black" href="tel:09613 787801">{{ $warehouse->phone }}</a>
                                 </li>
                                  {{--<li><i class="far fa-envelope" style="color: black"></i> <a style="color: black" href="mailto:{{ $warehouse->email }}"> <div>{{ $warehouse->email }}</div></a></li>--}}
                             </ul>

                             <a href="https://www.google.com/maps/place/{{ $warehouse->address }}" target="_blank" class="btn btn-primary" style="text-decoration:none;" >View Location Map <i class="fas fa-angle-right position-relative top-1 ml-1"></i></a>
                         </div>
                     </div>
                         @endforeach

                 </div><!-- End #map -->




            </div><!-- End .container -->


            <div class="mb-8"></div><!-- margin -->

        </main><!-- End .main -->

        

@endsection