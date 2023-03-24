
<div class="app align-content-stretch d-flex flex-wrap">
    <div class="app-sidebar">
        <div class="logo">
            <a href="{{route('home')}}" class="logo-icon"><span class="logo-text">{{__('system.brand')}}</span></a>
            <div class="sidebar-user-switcher user-activity-online">
                <a href="/">
                    <img src="https://secure.gravatar.com/avatar/{{md5(strtolower(trim(Auth::user()->email)))}}?s=40&d=mm&r=g">
                    <span class="activity-indicator"></span>
                    <span class="user-info-text">{{ Auth::user()->username}}<br></span>
                </a>
            </div>
        </div>
        <div class="app-menu">
            <ul class="accordion-menu pb-5">
                <x-select-device></x-select-device>
                <li class="sidebar-title">
                    Apps @if(__('system.beta_apps')=='1')<span class="badge badge-dark rounded">Beta</span>@endif
                    <small class="text-lowercase float-end">{{__('system.version')}}</small>
                </li>
                <li class="{{request()->is('home') ? 'active-page' : ''}}">
                    <a href="{{route('home')}}" class=""><i class="material-icons-two-tone">dashboard</i>{{__('system.home')}}</a>
                </li>
                 <li class="{{request()->is('file-manager') ? 'active-page' : ''}}">
                    <a href="{{route('file-manager')}}" class=""><i class="material-icons-two-tone">folder</i>{{__('system.file_manager')}}</a>
                </li>
                @if(Session::has('selectedDevice'))
                <li class="{{request()->is('autoreply') ? 'active-page' : ''}}">
                    <a href="{{route('autoreply')}}" class=""><i class="material-icons-two-tone">message</i>{{__('system.autoreply')}}</a>
                </li>
                <li class="{{request()->is('tags') ? 'active-page' : ''}}">
                    <a href="{{route('tag')}}"><i class="material-icons-two-tone">contacts</i>{{__('system.taglist')}}</a>
                </li>
                <li class="{{request()->is('campaign/create') ? 'active-page' : ''}}">
                    <a href="{{route('campaign.create')}}" class=""><i class="material-icons-two-tone">email</i>{{__('system.campaign_create')}}</a>
                </li>
                <li class="{{request()->is('campaigns') ? 'active-page' : ''}}">
                    <a href="{{route('campaign.lists')}}" class=""><i class="material-icons-two-tone">history</i>{{__('system.campaign_lists')}}</a>
                </li>
                <li class="{{request()->is('message/test') ? 'active-page' : ''}}">
                    <a href="{{route('messagetest')}}" class=""><i class="material-icons-two-tone">note</i>{{__('system.test')}}</a>
                </li>
                <li class="{{request()->is('integration') ? 'active-page' : ''}}">
                    <a href="{{route('integration')}}"><i class="material-icons-two-tone">power</i>{{__('system.integration')}}</a>
                </li>
                @endif
                <li class="{{request()->is('rest-api') ? 'active-page' : ''}}">
                    <a href="{{route('rest-api')}}"><i class="material-icons-two-tone">api</i>{{__('system.restapi')}}</a>
                </li>
                 <li class="{{request()->is('user/change-password') ? 'active-page' : ''}}">
                    <a href="{{route('changePassword')}}"><i class="material-icons-two-tone">settings</i>{{__('system.setting')}}</a>
                </li>
                 <li class="{{request()->is('perks') ? 'active-page' : ''}}">
                    <a href="{{route('perks')}}"><i class="material-icons-two-tone">redeem</i>{{__('system.perks')}} <span class="badge badge-{{request()->is('perks') ? 'light' : 'primary'}} rounded">{{__('system.new_')}}</span></a>
                </li>
              
                {{-- <li class="{{request()->is('schedule') ? 'active-page' : ''}}">
                    <a href="{{route('scheduleMessage')}}" class=""><i class="material-icons-two-tone">schedule</i>{{__('system.schedule_message')}}</a>
                </li> --}}
                {{-- only level admin --}}
                @if(Auth::user()->level == 'admin')
                <li class="sidebar-title">
                    Admin Menu
                </li>
                <li class="{{request()->is('admin/manage-integration') ? 'active-page' : ''}}">
                    <a href="{{route('admin.manage_integration')}}"><i class="material-icons-two-tone">electrical_services</i>{{__('system.manage_integrations')}}</a>
                </li>
                <li class="{{request()->is('admin/manage-user') ? 'active-page' : ''}}">
                    <a href="{{route('admin.manageUser')}}"><i class="material-icons-two-tone">people</i>{{__('system.user_manager')}}</a>
                </li>
                <li class="{{request()->is('settings') ? 'active-page' : ''}}">
                    <a href="{{route('settings')}}"><i class="material-icons-two-tone">dns</i>{{__('system.setting_server')}}</a>
                </li>
                @endif
               

            </ul>
            <div class="text-center">
                <small class="text-muted">©{{__('system.version_year')}} {{__('system.brand')}}</small>
            </div>
        </div>
        <div class="container position-absolute bottom-0 px-4 pb-4">
            <div class="btn-group d-grid" role="group" aria-label="Button group language">
                <div class="btn-group dropup" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons-two-tone">translate</i> {{__('system.language')}}</button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                        <li><a class="dropdown-item d-flex align-middle align-items-center" href="javascript:;" onclick="setCookie_lang('en')">English</a></li>
                        <li><a class="dropdown-item d-flex align-middle align-items-center" href="javascript:;" onclick="setCookie_lang('es')">Español</a></li>
                        <li><a class="dropdown-item d-flex align-middle align-items-center" href="javascript:;" onclick="setCookie_lang('pt_BR')">Português</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="app-container">
        <div class="search">
            <form>
                <input class="form-control" type="text" placeholder="Type here..." aria-label="Search">
            </form>
            <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
        </div>
        <div class="app-header">
            <nav class="navbar navbar-light navbar-expand-lg">
                <div class="container-fluid">
                    <div class="navbar-nav" id="navbarNav">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                            </li>
                           
                        </ul>

                    </div>
                    <div class="d-flex">
                       
                        <ul class="navbar-nav">
                            
                            <li class="nav-item hidden-on-mobile">
                                <a class="nav-link bg-transparent" id="loopedin" href="javascript:;" style="border-radius:10px;"><i class="material-icons-outlined">notifications</i></a>
                            </li>
                            <li class="nav-item hidden-on-mobile">
                                <a class="nav-link nav-notifications-toggle" id="notificationsDropDown" href="#" data-bs-toggle="dropdown" style="border-radius:10px;"><i class="material-icons-outlined">logout</i></a>
                                <div class="dropdown-menu dropdown-menu-end notifications-dropdown" aria-labelledby="notificationsDropDown">
                                    <a href={{route('user.changePassword')}} class="dropdown-header h6" style="border: 0; background-color :white;">{{__('system.setting')}}</a>
                                    <form action="{{route('logout')}}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-header h6 " style="border: 0; background-color :white;">{{__('system.logout')}}</button>
                                    </form>
                                </div> 
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>