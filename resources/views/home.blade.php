@extends('layouts.frontend')

@section('css')
    <link href="{{URL::asset('plugins/slick/slick.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/slick/slick-theme.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/aos/aos.css')}}" rel="stylesheet" />
    <!-- FilePond CSS -->
    <link href="{{URL::asset('plugins/filepond/filepond-plugin-image-preview.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/filepond/filepond.css')}}" rel="stylesheet" />
	<link href="{{URL::asset('plugins/awselect/awselect.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('plugins/datetimepicker/jquery.datetimepicker.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

        <section id="main-wrapper">
            
            <div class="h-100vh justify-center min-h-screen" id="main-background">

                <div class="container-fluid" >

                    <div class="central-banner">
                        <form id="multipartupload" action="" method="post" enctype="multipart/form-data">		
                            @csrf
                            <div class="row">
                                <div class="col-lg-5 col-md-6 col-sm-12 ml-8 upload-responsive" data-aos="fade-right" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">                             
                                    
                                    <div class="card border-0 special-card">
                                        <div class="card-body">			
                                            <!-- ADDITIONAL SETTINGS BUTTON-->
                                            @if ((config('settings.password_protection_feature_frontend') == 'enable') || (config('settings.link_expiration_feature_frontend') == 'enable'))
                                                <a id="settings" data-tippy-content="Additional Transfer Settings"><i class="fas fa-sliders-h"></i></a>
                                            @endif

                                            <!-- DRAG & DROP FILES -->
                                            <div class="select-file">
                                                <input type="file" name="filepond" id="filepond" class="filepond" multiple data-allow-reorder="true" required  />	
                                            </div>						
                                        </div>
                                    </div>
                    
                                    <div class="card border-0 special-card">
                                        <div class="card-body p-5 pb-0">
                    
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">	
                                                        <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Transfer Type') }}</h6>								
                                                        <select id="type" name="type" data-placeholder="{{ __('Select file share option') }}" data-callback="typeChanged">		
                                                            <option value="link" @if (config('settings.default_share_method') == 'link') selected @endif>{{ __('Link') }}</option>
                                                            <option value="email" @if (config('settings.default_share_method') == 'email') selected @endif>{{ __('Email') }}</option>									
                                                        </select>
                                                        @error('type')
                                                            <p class="text-danger">{{ $errors->first('type') }}</p>
                                                        @enderror	
                                                    </div>
                                                </div>
                    
                                                <div class="col-sm-12">								
                                                    <div class="input-box email-box">								
                                                        <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Send To') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
                                                        <div class="form-group">							    
                                                            <input type="text" class="form-control @error('email-to') is-danger @enderror" id="email-to" name="email_to" autocomplete="off">
                                                            @error('email-to')
                                                                <p class="text-danger">{{ $errors->first('email-to') }}</p>
                                                            @enderror
                                                        </div> 
                                                    </div> 
                                                </div>
                    
                                                <div class="col-sm-12">								
                                                    <div class="input-box email-box">								
                                                        <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Send From') }}  <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
                                                        <div class="form-group">							    
                                                            <input type="text" class="form-control @error('email-from') is-danger @enderror" id="email-from" name="email_from" autocomplete="off">
                                                            @error('email-from')
                                                                <p class="text-danger">{{ $errors->first('email-from') }}</p>
                                                            @enderror
                                                        </div> 
                                                    </div> 
                                                </div>
                    
                                                <div class="col-sm-12">								
                                                    <div class="input-box email-box">								
                                                        <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Message') }}</h6>
                                                        <div class="form-group">							    
                                                            <textarea class="form-control" id="message" rows="6" name="message" placeholder="Include your email message (Optional)"></textarea>
                                                        </div> 
                                                    </div> 
                                                </div>
                                            </div>						
                    
                                            <div class="card-footer border-0 text-center p-0">
                                                <div class="w-100">
                                                    <div class="text-center">
                                                        <span id="processing" class="processing-image"><img src="{{ URL::asset('/img/svgs/upgrade.svg') }}" alt=""></span>
                                                        <button type="submit" name="submit" class="btn btn-primary pl-6 pr-6 frontend-button" id="transfer">{{ __('Transfer') }}</button>
                                                    </div>
                                                </div>							
                                            </div>							
                                    
                                        </div>
                                    </div>                 
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 pt-7 pl-8 upload-responsive">
                                    <div class="text-container text-center">
                                        <h1 class="mb-4 text-white" data-aos="fade-left" data-aos-delay="400" data-aos-once="true" data-aos-duration="700">{{ __('Cloud File Transfer') }}</span></h1>
                                        <h1 class="mb-4 text-yellow" data-aos="fade-left" data-aos-delay="500" data-aos-once="true" data-aos-duration="900">{{ __('Transfer big files around the world') }}</h1>
                                        <p class="fs-20 text-white" data-aos="fade-left" data-aos-delay="600" data-aos-once="true" data-aos-duration="1100">{{ __('Secure, durable cloud solution for file transfering') }} <br> {{ __('Unmatched durability and scalability') }}</p>

                                        <a href="{{ route('register') }}" class="btn btn-primary special-action-button frontend-button" data-aos="fade-left" data-aos-delay="800" data-aos-once="true" data-aos-duration="1100">{{ __('Try Now') }}</a>

                                    </div>
                                </div>                                
                            </div>

                            <!-- SET MODAL -->
                            <div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true" data-bs-keyboard="false">
                                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                    <div class="modal-content special-card">
                                        <div class="modal-header mb-1">
                                            <h4 class="modal-title" id="myModalLabel"><i class="fas fa-sliders-h text-primary"></i> {{ __('Additional Transfer Settings') }}</h4>
                                            <button type="button" class="btn-close fs-12" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>                                 
                                        <div class="modal-body pb-0 pl-6 pr-6">        
                                            <div class="input-box no-gutters">	
                                                
                                                @if (config('settings.link_expiration_feature_frontend') == 'enable')
                                                    <div class="col-sm-12">
                                                        <div id="form-group">
                                                            <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Link Expiration') }} <i class="ml-1 text-dark fs-12 fa-solid fa-circle-info" data-tippy-content="{{ __('Set a custom date to expire the download link') }}"></i></h6>
                                                            <select id="link-expiration" name="link-expiration" data-placeholder="{{ __('Enable/Disable Link Expiration') }}" data-callback="signedLinkChanged">
                                                                <option value=1 @if (config('settings.link_expiration_default_state') == 'enable') selected @endif>{{ __('Enable') }}</option>
                                                                <option value=0 @if (config('settings.link_expiration_default_state') == 'disable') selected @endif> {{ __('Disable') }}</option>																															
                                                            </select>
                                                        </div>
                                                    </div>
                    
                                                    <div class="col-sm-12">
                                                        <div id="form-group" class="expiration-time-box">
                                                            <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Set Expiration Date') }} <span class="text-required"><i class="fa-solid fa-asterisk"></i></span></h6>
                                                            <input type="text" id="datetime" name="link-duration">
                                                        </div>
                                                    </div>
                                                @endif
                                                
                                                @if (config('settings.password_protection_feature_frontend') == 'enable')
                                                    <div class="col-sm-12">
                                                        <div id="form-group">
                                                            <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Password Protection') }}</h6>
                                                            <select id="password-protection" name="password-protection" data-placeholder="{{ __('Enable/Disable Password Protection') }}" data-callback="passwordChanged">
                                                                <option value=1>{{ __('Enable') }}</option>
                                                                <option value=0 selected> {{ __('Disable') }}</option>																															
                                                            </select>
                                                        </div>
                                                    </div>
                        
                                                    <div class="col-sm-12">								
                                                        <div class="input-box password-box">								
                                                            <h6 class="fs-11 mb-2 font-weight-bold">{{ __('Password') }} </h6>
                                                            <div class="form-group">							    
                                                                <input type="text" class="form-control @error('password') is-danger @enderror" id="password-input" name="password" autocomplete="off">
                                                                @error('password')
                                                                    <p class="text-danger">{{ $errors->first('password') }}</p>
                                                                @enderror
                                                            </div> 
                                                        </div> 
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="modal-footer pr-6 pb-3 modal-footer-awselect">
                                            <button type="button" class="btn btn-cancel mb-4" data-bs-dismiss="modal">{{ __('Return') }}</button>
                                        </div>                                                    
                                    </div>
                                </div>
                            </div>
                            <!-- END SET MODAL -->
                        </form> 
                    </div>
                
                </div>

            </div> 
            
            <!-- DOWNLOAD LINK MODAL -->
            <div class="modal fade" id="linkResultModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content special-card">                                
                        <div class="modal-body pb-0 pl-6 pr-6 pt-6">        
                            <div class="input-box no-gutters">	    
                                <div class="col-sm-12 text-center">			
                                    <span><i class='fa-solid fa-cloud-check fs-40 mb-4 text-primary'></i></span>
                                    <h4 class="font-weight-bold fs-22"> {{ __('Download Links Created') }}</h4>
                                    <p class="mb-4">{{ __('File are successfully uploaded and download links are listed below') }}</p>					
                                    <div id="files-data">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button type="button" class="btn btn-cancel mb-4" data-bs-dismiss="modal" onclick="resetData()">{{ __('Transfer New File') }}</button>
                        </div>                                                    
                    </div>
                </div>
            </div>
            <!-- END DOWNLOAD LINK MODAL -->

            <!-- EMAIL DOWNLOAD LINK MODAL -->
            <div class="modal fade" id="emailResultModal" tabindex="-1" role="dialog" aria-labelledby="projectModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                    <div class="modal-content">                                
                        <div class="modal-body pb-0 pl-6 pr-6 pt-6">        
                            <div class="input-box no-gutters">	    
                                <div class="col-sm-12 text-center">			
                                    <span><i class='fa-solid fa-envelope-circle-check fs-40 mb-4 text-primary'></i></span>
                                    <h4 class="font-weight-bold fs-22"> {{ __('Email Sent Successfully') }}</h4>
                                    <p class="mb-4">{{ __('File are successfully uploaded and email has been sent with download links listed below') }}</p>					
                                    <div id="email-files-data">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center pb-3">
                            <button type="button" class="btn btn-cancel mb-4" data-bs-dismiss="modal" onclick="resetData()">{{ __('Transfer New File') }}</button>
                        </div>                                                    
                    </div>
                </div>
            </div>
            <!-- END EMAIL DOWNLOAD LINK MODAL -->
        </section>



        <!-- SECTION - FEATURES
        ========================================================-->
        @if (config('frontend.features_section') == 'on')
            <section id="features-wrapper">

                {!! adsense_frontend_features_728x90() !!}
                

                <div class="container">

                    <div class="row text-center mt-8 mb-8">
                        <div class="col-md-12 title">
                            <h6><span>{{ config('app.name') }}</span> {{ __('Benefits') }}</h6>
                            <p>{{ __('Enjoy the full flexibility of the platform with ton of features') }}</p>
                        </div>
                    </div>
        
                        
                    <!-- LIST OF SOLUTIONS -->
                    <div class="row d-flex" id="solutions-list">
                        
                        <div class="col-md-4 col-sm-12">
                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1000" data-aos-once="true" data-aos-duration="1000">                                                                          
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/01.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('Glacier & Deep Archive Tiers') }}</h5>
                                        
                                        <p>Lorem ipsum dolor sit amet est consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                    </div>                         

                                </div>

                            </div> <!-- END SOLUTION -->
                            
                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/09.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('Lowest Cost for Storage') }}</h5>
                                        
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->

                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/06.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('Most Comprehensive Security') }}</h5>
                                        
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->
                        </div>

                        <div class="col-md-4 col-sm-12 mt-7">
                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1000" data-aos-once="true" data-aos-duration="1000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/05.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('Instant Retrieval with Glacier Tier') }}</h5>
                                        
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->


                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="1500" data-aos-once="true" data-aos-duration="1500">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/03.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('Long-term Backup Retention') }}</h5>
                                        
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                    </div>                                

                                </div>

                            </div> <!-- END SOLUTION -->


                            <!-- SOLUTION -->
                            <div class="col-sm-12 mb-6">
                                    
                                <div class="solution" data-aos="zoom-in" data-aos-delay="2000" data-aos-once="true" data-aos-duration="2000">
                                    
                                    <div class="solution-content">
                                        
                                        <div class="solution-logo mb-3">
                                            <img src="{{ URL::asset('img/files/04.png') }}" alt="">
                                        </div>
                                    
                                        <h5>{{ __('High Availability with Data Replication') }}</h5>
                                        
                                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati unde.</p>

                                    </div>

                                </div>

                            </div> <!-- END SOLUTION -->
                        </div>

                        <div class="col-md-4 col-sm-12 d-flex">

                            <div class="feature-text">
                                <div>
                                    <h4><span class="text-primary">{{ config('app.name') }}</span> {{ __('Provides the most durable solution in the world') }}</h4>
                                </div>
                                
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi, quibusdam? Illum ad eius, molestiae placeat dicta quae, ab nihil omnis obcaecati reiciendis recusandae, voluptatem eos molestias aliquam saepe tenetur optio? Consectetur adipisicing elit. Ut aspernatur mollitia aliquid consectetur illo sapiente nemo obcaecati.</p>
                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Unde ea et, error quisquam corporis, architecto minus doloremque aut facere itaque culpa eos molestias nulla reiciendis animi dolores, quod sunt illum.</p>
                            </div>
                            
                        </div>
                        
                    </div> <!-- END LIST OF SOLUTIONS -->
         

                </div>

            </section>
        @endif


        <!-- SECTION - CUSTOMER FEEDBACKS
        ========================================================-->
        @if (config('frontend.reviews_section') == 'on')
            <section id="feedbacks-wrapper">

                <div class="container pt-4 text-center">


                    <!-- SECTION TITLE -->
                    <div class="row mb-8">

                        <div class="title">
                            <h6>{{ __('Customer') }} <span>{{ __('Reviews') }}</span></h6>
                            <p>{{ __('We guarantee that you will be one of our happy customers as well') }}</p>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    @if ($review_exists)

                        <div class="row" id="feedbacks">
                            
                            @foreach ($reviews as $review)
                                <div class="feedback" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                                    <!-- MAIN COMMENT -->
                                    <p class="comment"><sup><span class="fa fa-quote-left"></span></sup> {{ $review->text }} <sub><span class="fa fa-quote-right"></span></sub></p>

                                    <!-- COMMENTER -->
                                    <div class="feedback-image d-flex">
                                        <div>
                                            <img src="{{ URL::asset($review->image_url) }}" alt="Feedback" class="rounded-circle"><span class="small-quote fa fa-quote-left"></span>
                                        </div>

                                        <div class="pt-3">
                                            <p class="feedback-reviewer">{{ $review->name }}</p>
                                            <p class="fs-12">{{ $review->position }}</p>
                                        </div>
                                    </div>	
                                </div> 
                            @endforeach                                                       
                        </div>

                        <!-- ROTATORS BUTTONS -->
                        <div class="offers-nav">
                            <a class="offers-prev"><i class="fa fa-chevron-left"></i></a>
                            <a class="offers-next"><i class="fa fa-chevron-right"></i></a>                                
                        </div>

                    @else
                        <div class="row text-center">
                            <div class="col-sm-12 mt-6 mb-6">
                                <h6 class="fs-12 font-weight-bold text-center">{{ __('No customer reviews were published yet') }}</h6>
                            </div>
                        </div>
                    @endif

                    
                    
                </div> <!-- END CONTAINER -->
                
            </section> <!-- END SECTION CUSTOMER FEEDBACK -->
        @endif
        
        
         <!-- SECTION - BANNER
        ========================================================-->
        <section id="banner-wrapper">

            <div class="container">

                <!-- SECTION TITLE -->
                <div class="row mb-7 text-center">

                    <div class="title">
                        <h6>{{ __('Our') }} <span>{{ __('Partners') }}</span></h6>
                        <p class="mb-0">{{ __('Be among the many that trust us') }}</p>
                    </div>

                </div> <!-- END SECTION TITLE -->

                <div class="row" id="partners">
                            
                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/c1.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div>    
                    
                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/c2.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/c7.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/c5.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/c6.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/c7.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 

                    <div class="partner" data-aos="flip-down" data-aos-delay="500" data-aos-once="true" data-aos-duration="1000">					
                        <div class="partner-image d-flex">
                            <div>
                                <img src="{{ URL::asset('img/files/c2.png') }}" alt="partner">
                            </div>
                        </div>	
                    </div> 
                </div>
            </div>

        </section> <!-- END SECTION BANNER -->


        <!-- SECTION - BLOGS
        ========================================================-->
        @if (config('frontend.blogs_section') == 'on')
            <section id="blog-wrapper">

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


        <!-- SECTION - FAQ
        ========================================================-->
        @if (config('frontend.faq_section') == 'on')
            <section id="faq-wrapper">    
                <div class="container pt-7">

                    <div class="row text-center mb-8 mt-7">
                        <div class="col-md-12 title">
                            <h6>{{ __('Frequently Asked') }} <span>{{ __('Questions') }}</span></h6>
                            <p>{{ __('Got questions? We have you covered.') }}</p>
                        </div>
                    </div>

                    <div class="row justify-content-md-center">
        
                        @if ($faq_exists)

                            <div class="col-md-10">
        
                                @foreach ( $faqs as $faq )

                                    <div id="accordion" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                                        <div class="card">
                                            <div class="card-header" id="heading{{ $faq->id }}">
                                                <h5 class="mb-0">
                                                <span class="btn btn-link" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $faq->id }}" aria-expanded="false" aria-controls="collapse-{{ $faq->id }}">
                                                    {{ $faq->question }}
                                                </span>
                                                </h5>
                                            </div>
                                        
                                            <div id="collapse-{{ $faq->id }}" class="collapse" aria-labelledby="heading{{ $faq->id }}" data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    {!! $faq->answer !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

                            </div>
                    
        
                        @else
                            <div class="row text-center">
                                <div class="col-sm-12 mt-6 mb-6">
                                    <h6 class="fs-12 font-weight-bold text-center">{{ __('No FAQ answers were published yet') }}</h6>
                                </div>
                            </div>
                        @endif
            
                    </div>        
                </div>
        
            </section> <!-- END SECTION FAQ -->
        @endif

        
        <!-- SECTION - CONTACT US
        ========================================================-->
        @if (config('frontend.contact_section') == 'on')
            <section id="contact-wrapper">

                <div class="container pt-9">       
                    
                    <!-- SECTION TITLE -->
                    <div class="row mb-8 text-center">

                        <div class="title w-100">
                            <h6><span>{{ __('Contact') }}</span> {{ __('With Us') }}</h6>
                            <p>{{ __('Reach out to us for additional information') }}</p>
                        </div>

                    </div> <!-- END SECTION TITLE -->

                    
                    <div class="row">                
                        
                        <div class="col-md-6 col-sm-12" data-aos="fade-left" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <img class="w-70" src="{{ URL::asset('img/files/about.svg') }}" alt="">
                        </div>

                        <div class="col-md-6 col-sm-12" data-aos="fade-right" data-aos-delay="300" data-aos-once="true" data-aos-duration="700">
                            <form id="" action="{{ route('contact') }}" method="POST" enctype="multipart/form-data">
                                @csrf
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="off" placeholder="First Name" required>
                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" autocomplete="off" placeholder="Last Name" required>
                                            @error('lastname')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off"  placeholder="Email Address" required>
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-12">
                                        <div class="input-box mb-4">                             
                                            <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" autocomplete="off"  placeholder="Phone Number" required>
                                            @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror                            
                                        </div>
                                    </div>
                                </div>
        
                                <div class="row justify-content-md-center">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="input-box">							
                                            <textarea class="form-control @error('message') is-invalid @enderror" name="message" rows="10" required placeholder="Message"></textarea>
                                            @error('message')
                                                <p class="text-danger">{{ $errors->first('message') }}</p>
                                            @enderror	
                                        </div>
                                    </div>
                                </div>
        
                                <input type="hidden" name="recaptcha" id="recaptcha">
                                
                                <div class="row justify-content-md-center text-center">
                                    <!-- ACTION BUTTON -->
                                    <div class="mt-2">
                                        <button type="submit" class="btn btn-primary special-action-button">{{ __('Send Message') }}</button>							
                                    </div>
                                </div>
                            
                            </form>
        
                        </div>                   
                        
                    </div>
                
                </div>
        
            </section>
        @endif

@endsection

@section('js')
    <script src="{{URL::asset('plugins/slick/slick.min.js')}}"></script>  
    <script src="{{URL::asset('plugins/aos/aos.js')}}"></script> 
    <script src="{{URL::asset('js/frontend.js')}}"></script>  
    <script src="{{URL::asset('plugins/datetimepicker/jquery.datetimepicker.full.min.js')}}"></script>
    <!-- FilePond JS --> 
    <script src={{ URL::asset('plugins/filepond/filepond.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-size.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-file-validate-type.min.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-image-preview.js') }}></script>
    <script src={{ URL::asset('plugins/filepond/filepond-plugin-image-exif-orientation.js') }}></script>
    <script src="{{URL::asset('js/upload.js')}}"></script>
    <!-- Awselect JS -->
    <script src="{{URL::asset('plugins/awselect/awselect-custom.js')}}"></script>
    <script src="{{URL::asset('js/awselect.js')}}"></script>
    <script type="text/javascript">
		$(function () {

            AOS.init();

            $('#settings').on('click', function() {
				$('#settingsModal').modal('show');
			});

            
            $('#datetime').datetimepicker({
			format:'d M Y H:i:s',
		});



		FilePond.registerPlugin(
			FilePondPluginImagePreview,
			FilePondPluginImageExifOrientation,
			FilePondPluginFileValidateSize,
   			FilePondPluginFileValidateType
		);


		$.ajax({
			headers: {
				'X-CSRF-TOKEN': '{{ csrf_token() }}',
			},
			type: "GET",
			url: 'settings',

		}).done(function(data) {

			$('#files-data').html('');
			$('#email-files-data').html('');
			$('.file-data').html('');

			// SET DEFATUL FILEPOND OPTIONS
			FilePond.setOptions({
				maxFileSize: data['max_file_size'] + 'MB',
				maxFiles: data['max_file_quantity'],
				labelIdle: "{{ __('Drag & Drop files to transfer or') }} <span class=\"filepond--label-action\">{{ __('Browse') }}</span><br><span class='restrictions'><span class='restrictions-highlight'>{{ __('Max Size') }}: " + data['max_file_size'] + "MB, {{ __('Max Files') }}: " + data['max_file_quantity'] + "</span></span>",
				required: true,
				server: {
					process: "tmp-upload",
					revert: "tmp-delete",
					headers: {
						'X-CSRF-TOKEN': '{{ csrf_token() }}',
					},
				},
				labelFileProcessingError: (error) => {
				console.log(error);
			}
			});
		});


		// CREATE FILEPOND INSTANCE
		let pond = FilePond.create(document.querySelector('.filepond'));


		// SUBMIT FORM
		$('#multipartupload').on('submit', function(e) {

			e.preventDefault();

			let form = $(this);

			$.ajax({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
				method: 'POST',
				url: 'upload',
				data: form.serialize(),
				beforeSend: function() {
					$('#transfer').html('');
					$('#transfer').prop('disabled', true);
					$('#processing').show().clone().appendTo('#transfer'); 
					$('#processing').hide();          
				},
				complete: function() {
					$('#transfer').prop('disabled', false);
					$('#processing', '#transfer').empty().remove();
					$('#processing').hide();
					$('#transfer').html('Transfer');            
				},
				success: function (data) {
					
					if (data['status'] == 'success') {
						
						pond.removeFiles({ revert: true });

						processLinks(data['links'], data['type']);

						if (data['type'] == 'link') {
                        	setTimeout(() => {  $('#linkResultModal').modal('show'); }, 1000);
						} else {
							setTimeout(() => {  $('#emailResultModal').modal('show'); }, 1000);
						}

					} else {
						Swal.fire('{{ __('File Transfer Error') }}', data['message'], 'error');
					}
				},
				error: function(data) {
					$('#transfer').prop('disabled', false);
            		$('#transfer').html('Transfer'); 
					console.log(data)
				}
			});
		});
	});

	function processLinks(links, type) {

		let inputLink;

		Object.keys(links).forEach(key => {

  			if (type == 'link') {
				$("<div class='fs-12' />").html("<div class='file-name text-left'><span class='font-weight-bold'>{{ __('File Name') }}</span>: " + key + "</div>").appendTo("#files-data");

				inputLink = '<div class="input-group download-links"> \
									<input type="text" class="form-control link" value="{{ config('app.url') }}/download/' + links[key] + '" readonly> \
									<label class="input-group-btn mb-0"> \
										<button class="btn btn-primary copy-link" type="button" onclick="copy(this)"><i class="fas fa-copy fs-15"></i></button> \
									</label> \
								</div>';

				$("<div class='file-data mb-4' />").html(inputLink).appendTo("#files-data");
			
			} else {
				$("<div class='fs-12' />").html("<div class='file-name text-left'><span class='font-weight-bold'>{{ __('File Name') }}</span>: " + key + "</div>").appendTo("#email-files-data");

				inputLink = '<div class="input-group download-links"> \
									<input type="text" class="form-control link" value="{{ config('app.url') }}/download/' + links[key] + '" readonly> \
									<label class="input-group-btn mb-0"> \
										<button class="btn btn-primary copy-link" type="button" onclick="copy(this)"><i class="fas fa-copy fs-15"></i></button> \
									</label> \
								</div>';

				$("<div class='file-data mb-4' />").html(inputLink).appendTo("#email-files-data");
			}
		});
	}

	function resetData() {

		$('#files-data').html('');
		$('#email-files-data').html('');
		$('.file-data').html('');

		document.getElementById('email-to').value = '';
		document.getElementById('email-from').value = '';
		document.getElementById('message').value = '';
		document.getElementById('password-input').value = '';
	}
    </script>

    @if (config('services.google.recaptcha.enable') == 'on')
         <!-- Google reCaptcha JS -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.site_key') }}"></script>
        <script>
            grecaptcha.ready(function() {
                grecaptcha.execute('{{ config('services.google.recaptcha.site_key') }}', {action: 'contact'}).then(function(token) {
                    if (token) {
                    document.getElementById('recaptcha').value = token;
                    }
                });
            });
        </script>
    @endif
@endsection
        
        
       
        
       
    

