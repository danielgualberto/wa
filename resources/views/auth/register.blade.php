<x-layout-auth>
    @slot('title',__('auth.register'))
        
    <div class="app app-auth-sign-up align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">

        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="/">{{__('system.brand')}}</a>
            </div>
            @if (session()->has('alert'))
            <x-alert>
                @slot('type',session('alert')['type'])
                @slot('msg',session('alert')['msg'])
            </x-alert>
         @endif
            <p class="auth-description">{{__('auth.auth_description_register')}}<br>{{__('auth.auth_description_register_')}} <a href="{{route('login')}}">{{__('auth.sign_in')}}</a></p>

            <div class="auth-credentials m-b-xxl">
                <form action="" class="" method="post">
                    @csrf
                    
                   
<div class="mb-2">

    <label for="username" class="form-label">{{__('auth.auth_username')}}</label>
    <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}"  id="email" aria-describedby="email" placeholder="{{__('auth.auth_username_')}}">
    @error('username')
    <div class="form-text text-danger">{{$message}}</div>
    @enderror   
</div>

                      
                  
<div class="mb-2">

    <label for="email" class="form-label">{{__('auth.auth_email')}}</label>
    <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}"  id="email" aria-describedby="email" placeholder="{{__('auth.auth_email_')}}">
    @error('email')
    <div class="form-text text-danger">{{$message}}</div>
    @enderror   
</div>

    
                    <label for="password" class="form-label">{{__('auth.auth_password')}}</label>
                    <input type="password" name="password" class="form-control" id="password" aria-describedby="signUpPassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;&#9679;">
                    @error('password')
                    <div id="emailHelp" class="form-text text-danger">{{$message}}</div>
               @enderror
              
            </div>

            <div class="auth-submit">
                <button type="submit" class="btn btn-success">{{__('auth.register')}}</button>
            </div>
        </form>
            <div class="divider"></div>
            <div class="auth-alts">
                @if (__('system.auth_facebook')!='')
                <a href="{{__('system.auth_facebook')}}" target="_blank" class="auth-alts-facebook"></a>
                @endif
                @if (__('system.auth_google')!='')
                <a href="{{__('system.auth_google')}}" target="_blank" class="auth-alts-google"></a>
                @endif
                @if (__('system.auth_instagram')!='')
                <a href="{{__('system.auth_instagram')}}" target="_blank" class="auth-alts-instagram"></a>
                @endif
                @if (__('system.auth_twitter')!='')
                <a href="{{__('system.auth_twitter')}}" target="_blank" class="auth-alts-twitter"></a>
                @endif
                @if (__('system.auth_groove')!='')
                <a href="{{__('system.auth_groove')}}" target="_blank" class="auth-alts-groove"></a>
                @endif
                @if (__('system.auth_site')!='')
                <a href="{{__('system.auth_site')}}" target="_blank" class="auth-alts-site"></a>
                @endif
                <div class="btn-group float-end" role="group">
                    <button id="btnGroupDrop1" type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons-two-tone">translate</i> {{__('system.language')}}</button>
                    <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1" style="height: fit-content;">
                        <li><a class="dropdown-item d-flex align-middle align-items-center" href="javascript:;" onclick="setCookie_lang('en')">English</a></li>
                        <li><a class="dropdown-item d-flex align-middle align-items-center" href="javascript:;" onclick="setCookie_lang('es')">Español</a></li>
                        <li><a class="dropdown-item d-flex align-middle align-items-center" href="javascript:;" onclick="setCookie_lang('pt_BR')">Português</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layout-auth>