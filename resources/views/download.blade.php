@extends('layouts.guest')

@section('css')
    <link href="{{URL::asset('plugins/slick/slick.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/slick/slick-theme.css')}}" rel="stylesheet" />
@endsection

@section('content')

    <div class="container mt-9 pt-9" id="download-background">
        
        {!! adsense_download_top_728x90() !!}
        <div class="row">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <div class="col-md-12">
                <div class="card overflow-hidden border-0">
                    <div class="card-body d-flex pt-5 pb-5">
                        <div class="row w-100">
                            <div class="col-md-6 col-sm-12 d-flex">
                                <div class="file-placeholder-container">                                    
                                    <span class="file-placeholder-text text-center">{{ $extension }}</span>
                                    <svg width="30px" height="35px" fill="currentColor" viewBox="0 0 38 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="file-placeholder"><path d="M22.1666667,13.546875 L22.1666667,0 L2.375,0 C1.05885417,0 0,1.06582031 0,2.390625 L0,48.609375 C0,49.9341797 1.05885417,51 2.375,51 L35.625,51 C36.9411458,51 38,49.9341797 38,48.609375 L38,15.9375 L24.5416667,15.9375 C23.2354167,15.9375 22.1666667,14.8617187 22.1666667,13.546875 Z M38,12.1423828 L38,12.75 L25.3333333,12.75 L25.3333333,0 L25.9369792,0 C26.5703125,0 27.1739583,0.249023438 27.6192708,0.697265625 L37.3072917,10.4589844 C37.7526042,10.9072266 38,11.5148437 38,12.1423828 Z"></path></svg>
                                </div>
                                <div>
                                    <p class=" mb-0 fs-12 font-weight-bold">{{ __('File Name') }}: <span class="font-weight-normal">{{ $name }}</span></p>
                                    <p class=" mb-0 fs-12 font-weight-bold">{{ __('File Size') }}: <span class="font-weight-normal">{{ $size }}</span></p>
                                </div>                               
                            </div>
                            <div class="col-md-6 col-sm-12 text-right">
                                @if ($available)
                                    @if ($password)
                                        <div class="input-box mb-0">								
                                            <div class="form-group">		
                                                <div class="input-group" id="download-password-box">					    
                                                    <input type="password" class="form-control @error('password') is-danger @enderror" placeholder="Download is Password Protected" id="password" name="password" autocomplete="off">
                                                    <label class="input-group-btn">
                                                        <button class="btn btn-primary" type="button" name="{{ $transfer_id }}" id="checkPassword">{{ __('Submit') }}</button>
                                                    </label>
                                                </div>
                                                <span id="notification" class="text-danger fs-12 font-weight-bold"></span>
                                                @error('password')
                                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                                @enderror
                                            </div> 
                                        </div> 
                                    @else
                                        <button type="button" class="btn btn-primary special-action-button mt-1 pl-6 pr-6" name="{{ $transfer_id }}" id="getFile">{{ __('Download File') }}</button>
                                        <br><span id="notification" class="text-danger fs-12 font-weight-bold"></span>
                                    @endif                                    
                                @else
                                    <p class="fs-12 font-weight-bold text-danger">{{ __('Download Link has Expired') }}</p>
                                @endif                                	
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="card overflow-hidden border-0">
                    <div class="card-body d-flex pt-5 pb-5">
                        <div class="row w-100">
                            <div class="col-sm-12">
                                <p class=" mb-0 fs-12 font-weight-bold mb-2 text-primary">{{ $name }}</p>
                                <p class=" mb-0 fs-12 font-weight-bold mb-2">{{ __('Uploaded On') }}: <span class="font-weight-normal">{{ $date }}</span></p>                              
                                <p class=" mb-0 fs-12 font-weight-bold mb-2">{{ __('File Exntension') }}: <span class="font-weight-normal">{{ strtoupper($extension) }}</span></p>                              
                                <p class=" mb-0 fs-12 font-weight-bold mb-2">{{ __('File Size') }}: <span class="font-weight-normal">{{ $size }}</span></p>                              
                                <p class=" mb-0 fs-12 font-weight-bold mb-2">{{ __('Total Views') }}: <span class="font-weight-normal">{{ $views }}</span></p>                              
                                <p class=" mb-0 fs-12 font-weight-bold mb-5">{{ __('Total Downloads') }}: <span class="font-weight-normal">{{ $downloads }}</span></p>                              
                                <p class=" mb-0 fs-12 font-weight-bold mb-2">{{ __('Disclaimer') }}</p>                              
                                <p class=" mb-0 fs-12">{{ $information['disclaimer'] }}</p>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                {!! adsense_download_300x250() !!}
            </div>
        </div>
        {!! adsense_download_bottom_728x90() !!}
    </div>

    <!-- SECTION - BLOGS
    ========================================================-->
    @if (config('frontend.blogs_section') == 'on')
        <section id="blog-wrapper" class="download-page">

            <div class="container pt-7 text-center">


                <!-- SECTION TITLE -->
                <div class="row mb-8 mt-7">

                    <div class="title w-100">
                        <h6><span>{{ __('Latest') }}</span> {{ __('Blogs') }}</h6>
                        <p>{{ __('Read our unique blog articles about various data archiving solutions and secrets') }}</p>
                    </div>

                </div> <!-- END SECTION TITLE -->

                @if ($blog_exists)
                    
                    <!-- BLOGS -->
                    <div class="row" id="blogs">
                        @foreach ( $blogs as $blog )
                        <div class="blog" data-aos="zoom-in" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">			
                            <div class="blog-box">
                                <div class="blog-img">
                                    <a href="{{ route('blogs.show', $blog->url) }}"><img src="{{ URL::asset($blog->image) }}" alt="Blog Image"></a>
                                </div>
                                <div class="blog-info">
                                    <h5 class="blog-title text-left">{{ $blog->title }}</h5>
                                    <h6 class="blog-date text-left"><i class="mdi mdi-alarm mr-2"></i>{{ date('F j, Y', strtotime($blog->created_at)) }}</h6>
                                </div>
                            </div>                        
                        </div> 
                        @endforeach
                    </div> 
                    

                    <!-- ROTATORS BUTTONS -->
                    <div class="blogs-nav">
                        <a class="blogs-prev"><i class="fa fa-chevron-left"></i></a>
                        <a class="blogs-next"><i class="fa fa-chevron-right"></i></a>                                
                    </div>

                @else
                    <div class="row text-center">
                        <div class="col-sm-12 mt-6 mb-6">
                            <h6 class="fs-12 font-weight-bold text-center">{{ __('No blog articles were published yet') }}</h6>
                        </div>
                    </div>
                @endif

            </div> <!-- END CONTAINER -->

            {!! adsense_frontend_blogs_728x90() !!}
            
        </section> <!-- END SECTION BLOGS -->
    @endif
@endsection

@section('js')
    <script src="{{URL::asset('js/minimize.js')}}"></script> 
    <script src="{{URL::asset('plugins/slick/slick.min.js')}}"></script>  
    <script>
        $(document).ready(function()  {

            $('#blogs').slick({
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: true,
                arrows: true,
                nextArrow: $('.blogs-next'),
                prevArrow: $('.blogs-prev'),
                autoplay: false,
                autoplaySpeed: 2000, 
                speed: 1000,
                infinite: true,
                responsive: [
                    {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,         
                    }
                    },
                    {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                    }
                    },
                    {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                    }
                    },
                ]
            });
      
        }); 
        
        $("#getFile").on('click', function() {

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'POST',
                url: '/getfile',
                data: {id: this.name},
                success: function (data) {
                    if (data['status'] == 200) {
                        downloadURI(data['url']);
                    } else if (data['status'] == 405) {
                        document.getElementById("notification").innerHTML = 'Download limit has been reached for current month';
                    } else {
                        document.getElementById("notification").innerHTML = 'Password is not correct';
                    } 
                },
                error: function(data) {
                    console.log('There was an error getting the file') 
                }
            })
        });

        $("#checkPassword").on('click', function() {

            var password = document.getElementById('password').value;

            if (password == '') {
                document.getElementById("notification").innerHTML = 'Password cannot be empty';
            } else {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'POST',
                    url: '/checkpassword',
                    data: {id: this.name, pass: password},
                    success: function (data) {
                        if (data['status'] == 200) {
                            downloadURI(data['url']);
                        } else if (data['status'] == 405) {
                            document.getElementById("notification").innerHTML = 'Download limit has been reached for current month';
                        } else {
                            document.getElementById("notification").innerHTML = 'Password is not correct';
                        }                            
                    },
                    error: function(data) {
                        document.getElementById("notification").innerHTML = 'There was an error getting the file';
                    }
                })
            }
        });

        function downloadURI(uri) {
            var link = document.createElement("a");
            link.href = uri;
            link.setAttribute("download", "download");
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            delete link;
        }

    </script> 
@endsection
