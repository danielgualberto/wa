<x-layout-auth>
    @slot('title',__('auth.auth_login'))
        
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
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
            <p class="auth-description">{{__('auth.auth_description')}}<a href="register">{{__('auth.create_an_account')}}</a></p>
            <form action="{{route('login')}}" method="POST">
                @csrf
                <div class="auth-credentials m-b-xxl">
                    <label for="username" class="form-label">{{__('auth.auth_username')}}</label>
                    <input type="text" name="username" class="form-control m-b-md" id="username" aria-describedby="username">
    
                    <label for="password" class="form-label">{{__('auth.auth_password')}}</label>
                    <input type="password" name="password" class="form-control" id="password" aria-describedby="password" >
                </div>
    
                <div class="auth-submit">
                    <button type="submit" name="login" class="btn btn-success">{{__('auth.auth_login')}}</button>
                    {{-- <a href="#" class="auth-forgot-password float-end">{{__('auth.auth_forgot_password')}}</a> --}}
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