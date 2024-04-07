<!-- SIDE MENU BAR -->
<aside class="app-sidebar"> 
    <div class="app-sidebar__logo">
        <a class="header-brand" href="{{url('/')}}">
            <img src="{{URL::asset('img/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Admintro logo">
            <img src="{{URL::asset('img/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Admintro logo">
        </a>
    </div>
    <ul class="side-menu app-sidebar3">
        @role('admin')
            <li class="side-item side-item-category mt-4">{{ __('Admin Dashboard') }}</li>
            <li class="slide">
                <a class="side-menu__item"  href="{{ route('admin.dashboard') }}">
                    <span class="side-menu__icon fa-solid fa-chart-tree-map"></span>
                    <span class="side-menu__label">{{ __('Dashboard') }}</span>
                </a>
            </li>
            <li class="side-item side-item-category">{{ __('Admin Panel') }}</li>
            <li class="slide">
                    <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                        <span class="side-menu__icon fa-solid fa-shuffle"></span>
                        <span class="side-menu__label">{{ __('Transfer Management') }}</span><i class="angle fa fa-angle-right"></i>
                    </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.transfer.dashboard') }}" class="slide-item">{{ __('Transfer Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.transfer.list') }}" class="slide-item">{{ __('User Transfer Files') }}</a></li>
                        <li><a href="{{ route('admin.transfer.list.guest') }}" class="slide-item">{{ __('Guest Transfer Files') }}</a></li>
                        <li><a href="{{ route('admin.transfer.configs') }}" class="slide-item">{{ __('Transfer Settings') }}</a></li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa-solid fa-user-shield"></span>
                    <span class="side-menu__label">{{ __('User Management') }}</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.user.dashboard') }}" class="slide-item">{{ __('User Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.user.list') }}" class="slide-item">{{ __('User List') }}</a></li>
                        <li><a href="{{ route('admin.user.activity') }}" class="slide-item">{{ __('Activity Monitoring') }}</a></li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa-solid fa-sack-dollar"></span>
                    <span class="side-menu__label">{{ __('Finance Management') }}</span>
                    @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count())
                        <span class="badge badge-warning">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count() }}</span>
                    @else
                        <i class="angle fa fa-angle-right"></i>
                    @endif
                </a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.finance.dashboard') }}" class="slide-item">{{ __('Finance Dashboard') }}</a></li>
                        <li><a href="{{ route('admin.finance.transactions') }}" class="slide-item">{{ __('Transactions') }}</a></li>
                        <li><a href="{{ route('admin.finance.plans') }}" class="slide-item">{{ __('Subscription Plans') }}</a></li>
                        <li><a href="{{ route('admin.finance.subscriptions') }}" class="slide-item">{{ __('Subscribers') }}</a></li>
                        <li><a href="{{ route('admin.referral.settings') }}" class="slide-item">{{ __('Referral System') }}</a></li>
                        <li><a href="{{ route('admin.referral.payouts') }}" class="slide-item">{{ __('Referral Payouts') }}
                                @if ((auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count()))
                                    <span class="badge badge-warning ml-5">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\PayoutRequestNotification')->count() }}</span>
                                @endif
                            </a>
                        </li>
                        <li><a href="{{ route('admin.settings.invoice') }}" class="slide-item">{{ __('Invoice Settings') }}</a></li>
                        <li><a href="{{ route('admin.finance.settings') }}" class="slide-item">{{ __('Payment Settings') }}</a></li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item"  href="{{ route('admin.support') }}">
                    <span class="side-menu__icon fa-solid fa-message-question"></span>
                    <span class="side-menu__label">{{ __('Support Requests') }}</span>
                    @if (App\Models\SupportTicket::where('status', 'Open')->count())
                        <span class="badge badge-warning">{{ App\Models\SupportTicket::where('status', 'Open')->count() }}</span>
                    @endif 
                </a>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                    <span class="side-menu__label">{{ __('Notifications') }}</span>
                        @if (auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count())
                            <span class="badge badge-warning" id="total-notifications-a"></span>
                        @else
                            <i class="angle fa fa-angle-right"></i>
                        @endif
                    </a>                     
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.notifications') }}" class="slide-item">{{ __('Mass Notifications') }}</a></li>
                        <li><a href="{{ route('admin.notifications.system') }}" class="slide-item">{{ __('System Notifications') }} 
                                @if ((auth()->user()->unreadNotifications->where('type', '<>', 'App\Notifications\GeneralNotification')->count()))
                                    <span class="badge badge-warning ml-5" id="total-notifications-b"></span>
                                @endif
                            </a>
                        </li>
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa fa-globe"></span>
                    <span class="side-menu__label">{{ __('Frontend Management') }}</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.settings.frontend') }}" class="slide-item">{{ __('Frontend Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.appearance') }}" class="slide-item">{{ __('SEO & Logos') }}</a></li>                        
                        <li><a href="{{ route('admin.settings.blog') }}" class="slide-item">{{ __('Blogs Manager') }}</a></li>
                        <li><a href="{{ route('admin.settings.faq') }}" class="slide-item">{{ __('FAQs Manager') }}</a></li>
                        <li><a href="{{ route('admin.settings.review') }}" class="slide-item">{{ __('Reviews Manager') }}</a></li>
                        <li><a href="{{ route('admin.settings.terms') }}" class="slide-item">{{ __('Pages Manager') }}</a></li>                           
                        <li><a href="{{ route('admin.settings.adsense') }}" class="slide-item">{{ __('Google Adsense') }}</a></li>                           
                    </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="{{ url('#')}}">
                    <span class="side-menu__icon fa fa-sliders"></span>
                    <span class="side-menu__label">{{ __('General Settings') }}</span><i class="angle fa fa-angle-right"></i></a>
                    <ul class="slide-menu">
                        <li><a href="{{ route('admin.settings.global') }}" class="slide-item">{{ __('Global Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.oauth') }}" class="slide-item">{{ __('Auth Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.registration') }}" class="slide-item">{{ __('Registration Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.smtp') }}" class="slide-item">{{ __('SMTP Settings') }}</a></li>
                        <li><a href="{{ route('admin.settings.backup') }}" class="slide-item">{{ __('Database Backup') }}</a></li>
                        <li><a href="{{ route('admin.settings.activation') }}" class="slide-item">{{ __('Activation') }}</a></li>     
                        <li><a href="{{ route('admin.settings.upgrade') }}" class="slide-item">{{ __('Upgrade Software') }}</a></li>                 
                    </ul>
            </li>
        @endrole
        @role('admin')
            <li class="side-item side-item-category">{{ __('User Panel') }}</li>
        @endrole
        @role('user|subscriber')
            <li class="side-item side-item-category mt-4">{{ __('User Panel') }}</li>
        @endrole
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.dashboard') }}">
            <span class="side-menu__icon lead-3 fa-solid fa-chart-tree-map"></span>
            <span class="side-menu__label">{{ __('My Dashboard') }}</span></a>
        </li> 
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.transfer.upload')}}">
            <span class="side-menu__icon fa-solid fa-shuffle"></span>
            <span class="side-menu__label">{{ __('Transfer Files') }}</span></a>
        </li>
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.transfer.list')}}">
            <span class="side-menu__icon fa-solid fa-box-circle-check"></span>
            <span class="side-menu__label">{{ __('My Transfer List') }}</span></a>
        </li>            
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.plans') }}">
            <span class="side-menu__icon lead-3 fa-solid fa-box-circle-check"></span>
            <span class="side-menu__label">{{ __('Pricing Plans') }}</span></a>
        </li>        
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.purchases') }}">
            <span class="side-menu__icon lead-3 fa-solid fa-money-check-pen"></span>
            <span class="side-menu__label">{{ __('Purchase History') }}</span></a>
        </li> 
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.referral') }}">
            <span class="side-menu__icon lead-3 fa-solid fa-badge-dollar"></span>
            <span class="side-menu__label">{{ __('Affiliate Program') }}</span></a>
        </li> 
        <li class="slide">
            <a class="side-menu__item" href="{{ route('user.profile')}}">
            <span class="side-menu__icon fa-solid fa-user-shield"></span>
            <span class="side-menu__label">{{ __('My Profile') }}</span></a>
        </li> 
        @role('user|subscriber')
            @if (config('settings.user_support') == 'enabled')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.support') }}">
                        <span class="side-menu__icon fa-solid fa-messages-question"></span>
                        <span class="side-menu__label">{{ __('Support Requests') }}</span>
                    </a>
                </li>
            @endif        
            @if (config('settings.user_notification') == 'enabled')
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('user.notifications') }}">
                        <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                        <span class="side-menu__label">{{ __('Notifications') }}</span>
                        @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count())
                            <span class="badge badge-warning">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count() }}</span>
                        @endif                
                    </a>
                </li>
            @endif 
        @endrole
        @role('admin')
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.support') }}">
                    <span class="side-menu__icon fa-solid fa-messages-question"></span>
                    <span class="side-menu__label">{{ __('Support Request') }}</span>
                </a>
            </li>    
            <li class="slide">
                <a class="side-menu__item" href="{{ route('user.notifications') }}">
                    <span class="side-menu__icon fa-solid fa-message-exclamation"></span>
                    <span class="side-menu__label">{{ __('Notifications') }}</span>
                    @if (auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count())
                        <span class="badge badge-warning">{{ auth()->user()->unreadNotifications->where('type', 'App\Notifications\GeneralNotification')->count() }}</span>
                    @endif                
                </a>
            </li>
        @endrole
    </ul>
    <div class="aside-progress-position">
        <div class="d-flex">
            <span class="fs-10 text-muted pl-5">{{ __('Storage Used') }}: {{ App\Services\HelperService::getTotalUsedStorageFormatted()}} {{ __('out of') }} {{ App\Services\HelperService::getTotalStorageFormatted()}}</span>
        </div>
    </div>
</aside>
<!-- END SIDE MENU BAR -->