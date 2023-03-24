<x-layout-dashboard title="{{__('system.setting_server')}}">
    <div class="app-content">
        <div class="content-wrapper">
            
            <div class="container-fluid">
                <div class="row">
                    @if (session()->has('alert'))
                    <x-alert>
                        @slot('type',session('alert')['type'])
                        @slot('msg',session('alert')['msg'])
                    </x-alert>
                 @endif
                 @if ($errors->any())
                 <div class="alert alert-danger">
                     <ul>
                         @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
             @endif
                    <div class="col">
                        <div class="page-description page-description-tabbed">
                           

                            <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#server" type="button" role="tab" aria-controls="hoaccountme" aria-selected="true">{{__('system.setting_server')}}</button>
                                </li>
                                
                              
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="server" role="tabpanel" aria-labelledby="account-tab">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                           

                                       
                                        <div class="row m-t-lg">
                                            <form action="{{route('setServer')}}" method="POST">
                                           @csrf
                                            <div class="col-md-6">
                                                <label for="typeServer" class="form-label">{{__('system.type_server')}}</label>
                                                <select name="typeServer" class="form-control" id="server" required>

                                                @if (env('TYPE_SERVER') === 'localhost')
                                                    <option value="localhost" selected>{{__('system.localhost')}}</option>
                                                    <option value="hosting">{{__('system.hosting_shared')}}</option>
                                                    <option value="other">{{__('system.other')}}</option>
                                                @elseif(env('TYPE_SERVER') === 'hosting')
                                                    <option value="localhost">{{__('system.localhost')}}</option>
                                                    <option value="hosting" selected>{{__('system.hosting_shared')}}</option>
                                                    <option value="other">{{__('system.other')}}</option>
                                                @else
                                                <option value="other" required>{{__('system.other')}}</option>
                                                <option value="localhost">{{__('system.localhost')}}</option>
                                                <option value="hosting">{{__('system.hosting_shared')}}</option>
                                                @endif
                                            </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="Port" class="form-label">{{__('system.port_node_js')}}</label>
                                                <input type="number" name="portnode" class="form-control" id="Port" value="{{env('PORT_NODE')}}" required>
                                            </div>
                                        </div>
                                        <div class="row m-t-lg {{env('TYPE_SERVER') === 'other' ? 'd-block' : 'd-none'}} formUrlNode">
                                            <div class="col-md-6">
                                                <label for="settingsInputUserName " class="form-label">{{__('system.url_node')}}</label>
                                                <div class="input-group">
                                                    <span class="input-group-text"  id="settingsInputUserName-add">{{__('system.url')}}</span>
                                                    <input type="text" class="form-control" value="{{env('WA_URL_SERVER')}}" name="urlnode" id="settingsInputUserName" aria-describedby="settingsInputUserName-add">
                                                </div>
                                            </div>
                                        
                                        </div>
                                       
                                        <div class="row m-t-lg">
                                            <div class="col">
                                               
                                                <button type="submit" class="btn btn-primary m-t-sm">{{__('system.button_update')}}</button>
                                            </div>
                                        </div>
                                    </form>
                                    </div>
                                </div>
                            </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#server').on('change',function(){
           let type = $('#server :selected').val();
            console.log(type);
            if(type === 'other'){
                    $('.formUrlNode').removeClass('d-none')
                } else {
                $('.formUrlNode').addClass('d-none')

            }
        })
    </script>
</x-layout-dashboard>