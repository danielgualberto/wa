<x-layout-dashboard title="{{__('system.manage_integration')}}">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet">
    <link href="/plugins/select2/css/select2.css" rel="stylesheet">
    <div class="app-content">
        @if (session()->has('alert'))
        <x-alert>
            @slot('type',session('alert')['type'])
            @slot('msg',session('alert')['msg'])
        </x-alert>
        @endif
        <div class="content-wrapper">
            <div class="container">
                <div class="row align-items-center my-5">
                    <div class="col">
                        <h2>{{__('system.manage_integration')}}</h2>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{url("/integration/update/{$integration->id}")}}" method="POST">
                                @csrf
                                @method('PUT')
                                @php $data = json_decode($integration->data, true); @endphp
                                <input type="hidden" name="user_sender" value="{{Session::get('selectedDevice')}}">
                                <input type="hidden" name="token" value="{{$integration->token}}">
                                <input type="hidden" name="qt" id="qt" value="{{count($data["accordion"])-1}}">
                                <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addonname">{{__('system.table_name')}}</span>
                                <input type="text" name="name" class="form-control" placeholder="{{__('system.integration_name')}}" aria-label="{{__('system.integration_name')}}" aria-describedby="basic-addonname" value="{{$data["name"]}}">
                                <button type="submit" class="btn btn-success"><i class="material-icons-outlined">save</i> {{__('system.button_save')}}</button>
                                <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"></button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="{{route('integration_delete', $integration->id)}}" data-bs-toggle="modal" data-bs-target="#delete-{{$integration->id}}">{{__('system.integration_remove')}}</a></li>
                                </ul>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addondesc">{{__('system.table_description')}}</span>
                                <input type="text" name="description" class="form-control" placeholder="{{__('system.integration_description_short')}}" aria-label="{{__('system.table_description')}}" aria-describedby="basic-addondesc" value="{{$data["description"]}}">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addonwebhook">{{__('system.table_webhook')}}</span>
                                <input type="text" class="form-control" id="webhook_url" value="{{url('/')}}/send-message/?integration={{$integration->token}}&api_key={{Auth::user()->api_key}}&sender={{Session::get('selectedDevice')}}" aria-label="{{__('system.table_webhook')}}" aria-describedby="basic-addonwebhook" readonly>
                                <button type="button" name="webhook_url" class="btn btn-primary" onclick="textToClipboard('webhook_url')"><i class="material-icons-outlined">content_copy</i> {{__('system.button_copy')}}</button>
                            </div>
                            <div class="card mb-3">
                                @foreach ($manage_integrations as $key => $manage_integration)
                                @php $manage_integrations_data[] = json_decode($manage_integration->data, true); @endphp
                                @endforeach
                                <input type='hidden' id='manage_integrations_data' value='{{json_encode($manage_integrations_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)}}'>
                                <div class="row g-0 py-3">
                                    <div class="col-3 d-flex position-relative align-items-center justify-content-center">
                                        <img src="https://via.placeholder.com/512x512/FFFFFF/001407/?text=Placeholder" class="img-fluid rounded-start" alt="..." id="manage_integrations_image">
                                        <span class="badge badge-dark rounded btn-close btn-close-white position-absolute bottom-0 mb-3 w-auto disabled" id="manage_integrations_beta">Beta</span>
                                    </div>
                                    <div class="col-9">
                                        <div class="card-body">
                                            <div class="row mb-4">
                                                <label for="integration-select" class="col-2 col-form-label">{{__('system.integration')}}:</label>
                                                <div class="col-10">
                                                    <select class="form-select js-select2-basic-single" name="integration" id="integration-select" onchange="manage_integrations_f(this)">
                                                        <option></option>
                                                        @php $grouped_options = []; @endphp
                                                        @foreach ($manage_integrations as $key => $manage_integration)
                                                        @php $data_mi = json_decode($manage_integration->data, true); @endphp
                                                        @if ($data_mi["status"])
                                                            @php $name = explode("|", $data_mi["name"]); @endphp
                                                            @if (isset($name[1]) && $name[1] != '') {
                                                                @php
                                                                    $grouped_options[$name[1]][] = [
                                                                        'value' => $manage_integration->id,
                                                                        'text' => $data_mi["name"],
                                                                        'selected' => $integration->manage_integration_id == $manage_integration->id
                                                                    ];
                                                                @endphp
                                                            @else
                                                            <option value="{{$manage_integration->id}}" {{$integration->manage_integration_id == $manage_integration->id ? 'selected' : ''}}>{{$data_mi["name"]}}</option>
                                                            @endif
                                                        @endif
                                                        @endforeach
                                                        
                                                        @foreach ($grouped_options as $group_label => $group)
                                                        <optgroup label="{{$group_label}}">
                                                            @foreach ($group as $option)
                                                            <option value="{{$option['value']}}" {{$option['selected'] ? 'selected' : ''}}>{{$option['text']}}</option>
                                                            @endforeach
                                                        </optgroup>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <h5 class="card-title" id="manage_integrations_name"></h5>
                                            <p class="card-text" id="manage_integrations_description"></p>
                                            <p class="card-text overflow-auto" id="manage_integrations_tags" style="max-height:10rem;"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addonnumber">{{__('system.table_recipient_number')}}</span>
                                <input type="text" name="number" class="form-control" id="number" placeholder="{{__('system.table_recipient_number')}}" aria-label="{{__('system.table_recipient_number')}}" aria-describedby="basic-addonnumber" value="{{$data["number"]}}">
                            </div>
                            <div class="input-group mb-3 d-none">
                                <span class="input-group-text">{{__('system.delay_in_seconds_from_to')}}</span>
                                <input type="text" name="range_from" class="form-control" placeholder="5" aria-label="{{__('system.range_from')}}" value="{{$data["range_from"]}}">
                                <span class="input-group-text"><i class="material-icons-outlined">timer</i></span>
                                <input type="text" name="range_to" class="form-control" placeholder="15" aria-label="{{__('system.range_to')}}" value="{{$data["range_to"]}}">
                            </div>
                            <p class="text-danger fst-italic d-none">{{__('system.delay_in_seconds_recommend')}}</p>
                            
                            <div class="card my-3 border shadow">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="messageTypeSelect0">{{__('system.type_message')}}</label>
                                        <select name="message_type0" class="form-select" id="messageTypeSelect0" data-bs-target="0" onchange="messageTypeSelect(this)">
                                            <option>{{__('system.select_')}}</option>
                                            <option value="text" {{ $data["accordion"][0]["message_type0"] == 'text' ? 'selected' : ''}}>{{__('system.text')}}</option>
                                            <option value="media" {{ $data["accordion"][0]["message_type0"] == 'media' ? 'selected' : ''}}>{{__('system.media')}}</option>
                                            <option value="button" {{ $data["accordion"][0]["message_type0"] == 'button' ? 'selected' : ''}}>{{__('system.button')}}</option>
                                            <option value="template" {{ $data["accordion"][0]["message_type0"] == 'template' ? 'selected' : ''}}>{{__('system.template')}}</option>
                                            <option value="list" {{ $data["accordion"][0]["message_type0"] == 'list' ? 'selected' : ''}}>{{__('system.list')}}</option>
                                        </select>
                                    </div>
                                    <div id="messageType0">
                                        @if ($data["accordion"][0]["message_type0"] == 'text')
                                        <label for="message0" class="form-label">{{__('system.message')}}</label>
                                        <textarea class="form-control" id="message0" name="message0" rows="3" required>{{$data["accordion"][0]["message0"]}}</textarea>
                                        @elseif ($data["accordion"][0]["message_type0"] == 'media')
                                        <div class="file-uploader">
                                            <label class="form-label mt-4">{{__('system.message_media_url_select')}}</label><br>
                                            <span class="text-danger text-sm">{{__('system.message_media_url_select_')}}</span>
                                            <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a id="media0" data-input="thumbnail0" data-preview="holder" class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> {{__('system.choose')}}
                                                    </a>
                                                </span>
                                                <input id="thumbnail0" class="form-control" type="text" name="url0" value="{{$data["accordion"][0]["url0"]}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="form-label">{{__('system.type_media')}}</label>
                                            <div class="d-flex ">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline1" name="type0" class="custom-control-input" value="image" {{ $data["accordion"][0]["type0"] == 'image' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline1">{{__('system.image')}} (jpg,jpeg,png,pdf)</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline2" name="type0" class="custom-control-input" value="video" {{ $data["accordion"][0]["type0"] == 'video' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline2">{{__('system.video')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline3" name="type0" class="custom-control-input" value="audio" {{ $data["accordion"][0]["type0"] == 'audio' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline3">{{__('system.audio')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline4" name="type0" class="custom-control-input" value="pdf" {{ $data["accordion"][0]["type0"] == 'pdf' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline4">pdf</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline5" name="type0" class="custom-control-input" value="xls" {{ $data["accordion"][0]["type0"] == 'xls' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline5">xls</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline6" name="type0" class="custom-control-input" value="xlsx" {{ $data["accordion"][0]["type0"] == 'xlsx' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline6">xlsx</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline7" name="type0" class="custom-control-input" value="doc" {{ $data["accordion"][0]["type0"] == 'doc' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline7">doc</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline8" name="type0" class="custom-control-input" value="docx" {{ $data["accordion"][0]["type0"] == 'docx' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline8">docx</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media0RadioInline9" name="type0" class="custom-control-input" value="zip" {{ $data["accordion"][0]["type0"] == 'zip' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media0RadioInline9">zip</label>
                                                </div>
                                            </div>
                                        </div>
                                        <label for="message0" class="form-label mt-4">{{__('system.image_caption')}}</label>
                                        <textarea class="form-control" id="message0" name="message0" rows="3" required>{{$data["accordion"][0]["message0"]}}</textarea>
                                        @elseif ($data["accordion"][0]["message_type0"] == 'button')
                                        <label for="message0" class="form-label">{{__('system.table_message')}}</label>
                                        <textarea class="form-control" id="message0" name="message0" rows="3" required>{{$data["accordion"][0]["message0"]}}</textarea>
                                        <label for="footer0" class="form-label">{{__('system.message_footer')}}</label>
                                        <input type="text" name="footer0" class="form-control" id="footer0" value="{{$data["accordion"][0]["footer0"]}}">
                                        <div class="file-uploader">
                                            <label class="form-label mt-4">{{__('system.image')}} {{__('system.optional')}}</label><br>
                                            <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a id="media0" data-input="thumbnail0" data-preview="holder" class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> {{__('system.choose')}}
                                                    </a>
                                                </span>
                                                <input id="thumbnail0" class="form-control" type="text" name="url0" value="{{$data["accordion"][0]["url0"]}}" required>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary mt-4" type="button" id="addbutton0" data-bs-target="0" onclick="addbutton(this)">+ {{__('system.button')}}</button>
                                        <div id="button-area0">
                                            <div class="form-group">
                                                <label for="button0-1" class="form-label">{{__("system.button")}} #1</label>
                                                <input type="text" name="button0-1" id="button0-1" class="form-control" value="{{$data["accordion"][0]["button0[1]"]}}" required>
                                            </div>
                                            @if (isset($data["accordion"][0]["button0[2]"]))
                                            <div class="form-group">
                                                <label for="button0-2" class="form-label">{{__("system.button")}} #2</label>
                                                <input type="text" name="button0-2" id="button0-2" class="form-control" value="{{$data["accordion"][0]["button0[2]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][0]["button0[3]"]))
                                            <div class="form-group">
                                                <label for="button0-3" class="form-label">{{__("system.button")}} #3</label>
                                                <input type="text" name="button0-3" id="button0-3" class="form-control" value="{{$data["accordion"][0]["button0[3]"]}}">
                                            </div>
                                            @endif
                                        </div>
                                        @elseif ($data["accordion"][0]["message_type0"] == 'template')
                                        <label for="message0" class="form-label">{{__('system.table_message')}}</label>
                                        <textarea class="form-control" id="message0" name="message0" rows="3" required>{{$data["accordion"][0]["message0"]}}</textarea>
                                        <label for="footer0" class="form-label">{{__('system.message_footer')}}</label>
                                        <input type="text" name="footer0" class="form-control" id="footer0" value="{{$data["accordion"][0]["footer0"]}}">
                                        <div class="file-uploader">
                                            <label class="form-label mt-4">{{__('system.image')}} {{__('system.optional')}}</label><br>
                                            <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a id="media0" data-input="thumbnail0" data-preview="holder" class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> {{__('system.choose')}}
                                                    </a>
                                                </span>
                                                <input id="thumbnail0" class="form-control" type="text" name="url0" value="{{$data["accordion"][0]["url0"]}}" required>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary mt-4" type="button" id="addtemplate0" data-bs-target="0" onclick="addtemplate(this)">+ {{__('system.template')}}</button>
                                        <div id="template-area0">
                                            <div class="form-group">
                                                <label for="template0-1" class="form-label">{{__('system.template')}} 1</label>
                                                <input type="text" placeholder="{{__("system.message_template_value")}}" name="template0-1" id="template0-1" class="form-control" value="{{$data["accordion"][0]["template0[1]"]}}" required>
                                            </div>
                                            @if (isset($data["accordion"][0]["template0[2]"]))
                                            <div class="form-group">
                                                <label for="template0-2" class="form-label">{{__('system.template')}} 2</label>
                                                <input type="text" placeholder="{{__("system.message_template_value")}}" name="template0-2" id="template0-2" class="form-control" value="{{$data["accordion"][0]["template0[2]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][0]["template0[3]"]))
                                            <div class="form-group">
                                                <label for="template0-3" class="form-label">{{__('system.template')}} 3</label>
                                                <input type="text" placeholder="{{__("system.message_template_value")}}" name="template0-3" id="template0-3" class="form-control" value="{{$data["accordion"][0]["template0[3]"]}}">
                                            </div>
                                            @endif
                                        </div>
                                        <span class="text-danger">
                                            {{__('system.message_template_helpCall')}} <span class="badge badge-secondary">{{__('system.message_template_helpCall_')}}</span><br>
                                            {{__('system.message_template_helpLink')}} <span class="badge badge-secondary">{{__('system.message_template_helpLink_')}}</span><br>
                                            {{__('system.message_template_help_')}}
                                        </span>
                                        @elseif ($data["accordion"][0]["message_type0"] == 'list')
                                        <label for="message0" class="form-label">{{__('system.table_message')}}</label>
                                        <textarea class="form-control" id="message0" name="message0" rows="3" required>{{$data["accordion"][0]["message0"]}}</textarea>
                                        <label for="footer0" class="form-label">{{__('system.message_footer')}}</label>
                                        <input type="text" name="footer0" class="form-control" id="footer0" value="{{$data["accordion"][0]["footer0"]}}">
                                        <label for="title0" class="form-label">{{__('system.list_title')}}</label>
                                        <input type="text" name="title0" class="form-control" id="title0" value="{{$data["accordion"][0]["title0"]}}" required>
                                        <label for="buttontext0" class="form-label">{{__('system.list_button')}}</label>
                                        <input type="text" name="buttontext0" class="form-control" id="buttontext0" value="{{$data["accordion"][0]["buttontext0"]}}">
                                        <button class="btn btn-sm btn-primary mt-4" type="button" id="addList0" data-bs-target="0" onclick="addlist(this)">+ {{__('system.list')}}</button>
                                        <div id="list-area0">
                                            <div class="form-group">
                                                <label for="list0-1" class="form-label">{{__("system.list")}} #1</label>
                                                <input type="text" name="list0-1" id="list0-1" class="form-control" value="{{$data["accordion"][0]["list0[1]"]}}" required>
                                            </div>
                                            @if (isset($data["accordion"][0]["list0[2]"]))
                                            <div class="form-group">
                                                <label for="list0-2" class="form-label">{{__("system.list")}} #2</label>
                                                <input type="text" name="list0-2" id="list0-2" class="form-control" value="{{$data["accordion"][0]["list0[2]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][0]["list0[3]"]))
                                            <div class="form-group">
                                                <label for="list0-3" class="form-label">{{__("system.list")}} #3</label>
                                                <input type="text" name="list0-3" id="list0-3" class="form-control" value="{{$data["accordion"][0]["list0[3]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][0]["list0[4]"]))
                                            <div class="form-group">
                                                <label for="list0-4" class="form-label">{{__("system.list")}} #4</label>
                                                <input type="text" name="list0-4" id="list0-4" class="form-control" value="{{$data["accordion"][0]["list0[4]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][0]["list0[5]"]))
                                            <div class="form-group">
                                                <label for="list0-5" class="form-label">{{__("system.list")}} #5</label>
                                                <input type="text" name="list0-5" id="list0-5" class="form-control" value="{{$data["accordion"][0]["list0[5]"]}}">
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div id="integration-card-area">
                                @for ($key = 1; $key < count($data["accordion"]); $key++)
                                <div>
                                    <div class="card my-3 border shadow">
                                        <div class="card-body">
                                            <div class="input-group mb-3">
                                                <label class="input-group-text" for="messageTypeSelect{{$key}}">{{__('system.type_message')}}</label>
                                                <select name="message_type{{$key}}" class="form-select" id="messageTypeSelect{{$key}}" data-bs-target="{{$key}}" onchange="messageTypeSelect(this)">
                                                    <option>{{__('system.select_')}}</option>
                                                    <option value="text" {{ $data["accordion"][$key]["message_type$key"] == 'text' ? 'selected' : ''}}>{{__('system.text')}}</option>
                                                    <option value="media" {{ $data["accordion"][$key]["message_type$key"] == 'media' ? 'selected' : ''}}>{{__('system.media')}}</option>
                                                    <option value="button" {{ $data["accordion"][$key]["message_type$key"] == 'button' ? 'selected' : ''}}>{{__('system.button')}}</option>
                                                    <option value="template" {{ $data["accordion"][$key]["message_type$key"] == 'template' ? 'selected' : ''}}>{{__('system.template')}}</option>
                                                    <option value="list" {{ $data["accordion"][$key]["message_type$key"] == 'list' ? 'selected' : ''}}>{{__('system.list')}}</option>
                                                </select>
                                            </div>
                                            <div id="messageType{{$key}}">
                                        @if ($data["accordion"][$key]["message_type$key"] == 'text')
                                        <label for="message{{$key}}" class="form-label">{{__('system.message')}}</label>
                                        <textarea class="form-control" id="message{{$key}}" name="message{{$key}}" rows="3" required>{{$data["accordion"][$key]["message$key"]}}</textarea>
                                        @elseif ($data["accordion"][$key]["message_type$key"] == 'media')
                                        <div class="file-uploader">
                                            <label class="form-label mt-4">{{__('system.message_media_url_select')}}</label><br>
                                            <span class="text-danger text-sm">{{__('system.message_media_url_select_')}}</span>
                                            <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a id="media{{$key}}" data-input="thumbnail{{$key}}" data-preview="holder" class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> {{__('system.choose')}}
                                                    </a>
                                                </span>
                                                <input id="thumbnail{{$key}}" class="form-control" type="text" name="url{{$key}}" value="{{$data["accordion"][$key]["url$key"]}}" required>
                                            </div>
                                        </div>
                                        <div class="form-group mt-4">
                                            <label class="form-label">{{__('system.type_media')}}</label>
                                            <div class="d-flex ">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline1" name="type{{$key}}" class="custom-control-input" value="image" {{ $data["accordion"][$key]["type$key"] == 'image' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline1">{{__('system.image')}} (jpg,jpeg,png,pdf)</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline2" name="type{{$key}}" class="custom-control-input" value="video" {{ $data["accordion"][$key]["type$key"] == 'video' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline2">{{__('system.video')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline3" name="type{{$key}}" class="custom-control-input" value="audio" {{ $data["accordion"][$key]["type$key"] == 'audio' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline3">{{__('system.audio')}}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline4" name="type{{$key}}" class="custom-control-input" value="pdf" {{ $data["accordion"][$key]["type$key"] == 'pdf' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline4">pdf</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline5" name="type{{$key}}" class="custom-control-input" value="xls" {{ $data["accordion"][$key]["type$key"] == 'xls' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline5">xls</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline6" name="type{{$key}}" class="custom-control-input" value="xlsx" {{ $data["accordion"][$key]["type$key"] == 'xlsx' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline6">xlsx</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline7" name="type{{$key}}" class="custom-control-input" value="doc" {{ $data["accordion"][$key]["type$key"] == 'doc' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline7">doc</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline8" name="type{{$key}}" class="custom-control-input" value="docx" {{ $data["accordion"][$key]["type$key"] == 'docx' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline8">docx</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="media{{$key}}RadioInline9" name="type{{$key}}" class="custom-control-input" value="zip" {{ $data["accordion"][$key]["type$key"] == 'zip' ? 'checked' : ''}}>
                                                    <label class="custom-control-label" for="media{{$key}}RadioInline9">zip</label>
                                                </div>
                                            </div>
                                        </div>
                                        <label for="message{{$key}}" class="form-label mt-4">{{__('system.image_caption')}}</label>
                                        <textarea class="form-control" id="message{{$key}}" name="message{{$key}}" rows="3" required>{{$data["accordion"][$key]["message$key"]}}</textarea>
                                        @elseif ($data["accordion"][$key]["message_type$key"] == 'button')
                                        <label for="message{{$key}}" class="form-label">{{__('system.table_message')}}</label>
                                        <textarea class="form-control" id="message{{$key}}" name="message{{$key}}" rows="3" required>{{$data["accordion"][$key]["message$key"]}}</textarea>
                                        <label for="footer{{$key}}" class="form-label">{{__('system.message_footer')}}</label>
                                        <input type="text" name="footer{{$key}}" class="form-control" id="footer{{$key}}" value="{{$data["accordion"][$key]["footer$key"]}}">
                                        <div class="file-uploader">
                                            <label class="form-label mt-4">{{__('system.image')}} {{__('system.optional')}}</label><br>
                                            <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a id="media{{$key}}" data-input="thumbnail{{$key}}" data-preview="holder" class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> {{__('system.choose')}}
                                                    </a>
                                                </span>
                                                <input id="thumbnail{{$key}}" class="form-control" type="text" name="url{{$key}}" value="{{$data["accordion"][$key]["url$key"]}}" required>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary mt-4" type="button" id="addbutton{{$key}}" data-bs-target="{{$key}}" onclick="addbutton(this)">+ {{__('system.button')}}</button>
                                        <div id="button-area{{$key}}">
                                            <div class="form-group">
                                                <label for="button0-1" class="form-label">{{__("system.button")}} #1</label>
                                                <input type="text" name="button{{$key}}-1" id="button{{$key}}-1" class="form-control" value="{{$data["accordion"][$key]["button".$key."[1]"]}}" required>
                                            </div>
                                            @if (isset($data["accordion"][$key]["button".$key."[2]"]))
                                            <div class="form-group">
                                                <label for="button{{$key}}-2" class="form-label">{{__("system.button")}} #2</label>
                                                <input type="text" name="button{{$key}}-2" id="button{{$key}}-2" class="form-control" value="{{$data["accordion"][$key]["button".$key."[2]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][$key]["button".$key."[3]"]))
                                            <div class="form-group">
                                                <label for="button{{$key}}-3" class="form-label">{{__("system.button")}} #3</label>
                                                <input type="text" name="button{{$key}}-3" id="button{{$key}}-3" class="form-control" value="{{$data["accordion"][$key]["button".$key."[3]"]}}">
                                            </div>
                                            @endif
                                        </div>
                                        @elseif ($data["accordion"][$key]["message_type$key"] == 'template')
                                        <label for="message{{$key}}" class="form-label">{{__('system.table_message')}}</label>
                                        <textarea class="form-control" id="message{{$key}}" name="message{{$key}}" rows="3" required>{{$data["accordion"][$key]["message$key"]}}</textarea>
                                        <label for="footer{{$key}}" class="form-label">{{__('system.message_footer')}}</label>
                                        <input type="text" name="footer{{$key}}" class="form-control" id="footer{{$key}}" value="{{$data["accordion"][$key]["footer$key"]}}">
                                        <div class="file-uploader">
                                            <label class="form-label mt-4">{{__('system.image')}} {{__('system.optional')}}</label><br>
                                            <div class="input-group ">
                                                <span class="input-group-btn">
                                                    <a id="media{{$key}}" data-input="thumbnail{{$key}}" data-preview="holder" class="btn btn-primary text-white">
                                                        <i class="fa fa-picture-o"></i> {{__('system.choose')}}
                                                    </a>
                                                </span>
                                                <input id="thumbnail{{$key}}" class="form-control" type="text" name="url{{$key}}" value="{{$data["accordion"][$key]["url$key"]}}" required>
                                            </div>
                                        </div>
                                        <button class="btn btn-sm btn-primary mt-4" type="button" id="addtemplate{{$key}}" data-bs-target="{{$key}}" onclick="addtemplate(this)">+ {{__('system.template')}}</button>
                                        <div id="template-area{{$key}}">
                                            <div class="form-group">
                                                <label for="template{{$key}}-1" class="form-label">{{__('system.template')}} 1</label>
                                                <input type="text" placeholder="{{__("system.message_template_value")}}" name="template{{$key}}-1" id="template{{$key}}-1" class="form-control" value="{{$data["accordion"][$key]["template".$key."[1]"]}}" required>
                                            </div>
                                            @if (isset($data["accordion"][$key]["template".$key."[2]"]))
                                            <div class="form-group">
                                                <label for="template{{$key}}-2" class="form-label">{{__('system.template')}} 2</label>
                                                <input type="text" placeholder="{{__("system.message_template_value")}}" name="template{{$key}}-2" id="template{{$key}}-2" class="form-control" value="{{$data["accordion"][$key]["template".$key."[2]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][$key]["template".$key."[3]"]))
                                            <div class="form-group">
                                                <label for="template{{$key}}-3" class="form-label">{{__('system.template')}} 3</label>
                                                <input type="text" placeholder="{{__("system.message_template_value")}}" name="template{{$key}}-3" id="template{{$key}}-3" class="form-control" value="{{$data["accordion"][$key]["template".$key."[3]"]}}">
                                            </div>
                                            @endif
                                        </div>
                                        <span class="text-danger">
                                            {{__('system.message_template_helpCall')}} <span class="badge badge-secondary">{{__('system.message_template_helpCall_')}}</span><br>
                                            {{__('system.message_template_helpLink')}} <span class="badge badge-secondary">{{__('system.message_template_helpLink_')}}</span><br>
                                            {{__('system.message_template_help_')}}
                                        </span>
                                        @elseif ($data["accordion"][$key]["message_type$key"] == 'list')
                                        <label for="message{{$key}}" class="form-label">{{__('system.table_message')}}</label>
                                        <textarea class="form-control" id="message{{$key}}" name="message{{$key}}" rows="3" required>{{$data["accordion"][$key]["message$key"]}}</textarea>
                                        <label for="footer{{$key}}" class="form-label">{{__('system.message_footer')}}</label>
                                        <input type="text" name="footer{{$key}}" class="form-control" id="footer{{$key}}" value="{{$data["accordion"][$key]["footer$key"]}}">
                                        <label for="title{{$key}}" class="form-label">{{__('system.list_title')}}</label>
                                        <input type="text" name="title{{$key}}" class="form-control" id="title{{$key}}" value="{{$data["accordion"][$key]["title$key"]}}" required>
                                        <label for="buttontext{{$key}}" class="form-label">{{__('system.list_button')}}</label>
                                        <input type="text" name="buttontext{{$key}}" class="form-control" id="buttontext{{$key}}" value="{{$data["accordion"][$key]["buttontext$key"]}}">
                                        <button class="btn btn-sm btn-primary mt-4" type="button" id="addList{{$key}}" data-bs-target="{{$key}}" onclick="addlist(this)">+ {{__('system.list')}}</button>
                                        <div id="list-area{{$key}}">
                                            <div class="form-group">
                                                <label for="list{{$key}}-1" class="form-label">{{__("system.list")}} #1</label>
                                                <input type="text" name="list{{$key}}-1" id="list{{$key}}-1" class="form-control" value="{{$data["accordion"][$key]["list".$key."[1]"]}}" required>
                                            </div>
                                            @if (isset($data["accordion"][$key]["list".$key."[2]"]))
                                            <div class="form-group">
                                                <label for="list{{$key}}-2" class="form-label">{{__("system.list")}} #2</label>
                                                <input type="text" name="list{{$key}}-2" id="list{{$key}}-2" class="form-control" value="{{$data["accordion"][$key]["list".$key."[2]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][$key]["list".$key."[3]"]))
                                            <div class="form-group">
                                                <label for="list{{$key}}-3" class="form-label">{{__("system.list")}} #3</label>
                                                <input type="text" name="list{{$key}}-3" id="list{{$key}}-3" class="form-control" value="{{$data["accordion"][$key]["list".$key."[3]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][$key]["list".$key."[4]"]))
                                            <div class="form-group">
                                                <label for="list{{$key}}-4" class="form-label">{{__("system.list")}} #4</label>
                                                <input type="text" name="list{{$key}}-4" id="list{{$key}}-4" class="form-control" value="{{$data["accordion"][$key]["list".$key."[4]"]}}">
                                            </div>
                                            @endif
                                            @if (isset($data["accordion"][$key]["list".$key."[5]"]))
                                            <div class="form-group">
                                                <label for="list{{$key}}-5" class="form-label">{{__("system.list")}} #5</label>
                                                <input type="text" name="list{{$key}}-5" id="list{{$key}}-5" class="form-control" value="{{$data["accordion"][$key]["list".$key."[5]"]}}">
                                            </div>
                                            @endif
                                        </div>
                                        @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endfor
                            </div>
                            <div class="mt-5">
                                <div class="input-group justify-content-center mb-3" id="cardButtons"></div>
                            </div>
                            
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                    <!-- Modal Delete -->
                    <div class="modal fade" id="delete-{{$integration->id}}" tabindex="-1" aria-labelledby="delete-{{$integration->id}}ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delete-{{$integration->id}}ModalLabel">{{$data["name"]}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('system.modal_confirm_delete')}} <strong><em>{{$data["name"]}}</em></strong>{{__('system.modal_confirm_delete_')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('system.button_cancel')}}</button>
                                    <form action="{{route('integration_delete', $integration->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">{{__('system.button_delete')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</x-layout-dashboard>

<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="/plugins/select2/js/select2.full.min.js"></script>
<script>
$(document).ready(function() {
    "use strict";
    function formatState (state) {
        if (!state.id) {
            return state.text;
        }
        var baseUrl = "/images/integration/flags";
        var $state = $(
            '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" height="20"/> ' + state.text + '</span>'
        );
        return $state;
    };
    $('.js-select2-basic-single').select2({
        placeholder: "{{__('system.select_')}}",
        allowClear: true,
        templateResult: formatState
    });
});
  function messageTypeSelect(e) {
    let target = $(e).data('bs-target');
    let messageTypeSelect = $(e).val();
    if (messageTypeSelect == 'text') {
      $('#messageType' + target).html(
        `
		<label for="message${target}" class="form-label">{{__('system.message')}}</label>
		<textarea class="form-control" id="message${target}" name="message${target}" rows="3" required></textarea>
		`);
    } else if (messageTypeSelect == 'media') {
      $('#messageType' + target).html(
        `
		<div class="file-uploader">
      <label class="form-label mt-4">{{__('system.message_media_url_select')}}</label><br>
      <span class="text-danger text-sm">{{__('system.message_media_url_select_')}}</span>
      <div class="input-group ">
        <span class="input-group-btn">
          <a id="media${target}" data-input="thumbnail${target}" data-preview="holder" class="btn btn-primary text-white">
            <i class="fa fa-picture-o"></i> {{__('system.choose')}}
          </a>
        </span>
        <input id="thumbnail${target}" class="form-control" type="text" name="url${target}" required>
      </div>
    </div>
		
		<div class="form-group mt-4">
      <label class="form-label">{{__('system.type_media')}}</label>
      <div class="d-flex ">
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline1" name="type${target}" class="custom-control-input" value="image" checked>
          <label class="custom-control-label" for="media${target}RadioInline1">{{__('system.image')}} (jpg,jpeg,png,pdf)</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline2" name="type${target}" class="custom-control-input" value="video">
          <label class="custom-control-label" for="media${target}RadioInline2">{{__('system.video')}}</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline3" name="type${target}" class="custom-control-input" value="audio">
          <label class="custom-control-label" for="media${target}RadioInline3">{{__('system.audio')}}</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline4" name="type${target}" class="custom-control-input" value="pdf">
          <label class="custom-control-label" for="media${target}RadioInline4">pdf</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline5" name="type${target}" class="custom-control-input" value="xls">
          <label class="custom-control-label" for="media${target}RadioInline5">xls</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline6" name="type${target}" class="custom-control-input" value="xlsx">
          <label class="custom-control-label" for="media${target}RadioInline6">xlsx</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline7" name="type${target}" class="custom-control-input" value="doc">
          <label class="custom-control-label" for="media${target}RadioInline7">doc</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline8" name="type${target}" class="custom-control-input" value="docx">
          <label class="custom-control-label" for="media${target}RadioInline8">docx</label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
          <input type="radio" id="media${target}RadioInline9" name="type${target}" class="custom-control-input" value="zip">
          <label class="custom-control-label" for="media${target}RadioInline9">zip</label>
        </div>
      </div>
    </div>
		
		<label for="message${target}" class="form-label mt-4">{{__('system.image_caption')}}</label>
		<textarea class="form-control" id="message${target}" name="message${target}" rows="3" required></textarea>
		`);
      $('#media' + target).filemanager('file');
    } else if (messageTypeSelect == 'button') {
      $('#messageType' + target).html(
        `
		<label for="message${target}" class="form-label">{{__('system.table_message')}}</label>
		<textarea class="form-control" id="message${target}" name="message${target}" rows="3" required></textarea>
		<label for="footer${target}" class="form-label">{{__('system.message_footer')}}</label>
		<input type="text" name="footer${target}" class="form-control" id="footer${target}" >
		
		<div class="file-uploader">
      <label class="form-label mt-4">{{__('system.image')}} {{__('system.optional')}}</label><br>
      <div class="input-group ">
        <span class="input-group-btn">
          <a id="media${target}" data-input="thumbnail${target}" data-preview="holder" class="btn btn-primary text-white">
            <i class="fa fa-picture-o"></i> {{__('system.choose')}}
          </a>
        </span>
        <input id="thumbnail${target}" class="form-control" type="text" name="url${target}" required>
      </div>
    </div>
		
		<button class="btn btn-sm btn-primary mt-4" type="button" id="addbutton${target}" data-bs-target="${target}" onclick="addbutton(this)">+ {{__('system.button')}}</button>
		<div id="button-area${target}">
      <div class="form-group">
        <label for="button${target}-1" class="form-label">{{__("system.button")}} #1</label>
        <input type="text" name="button${target}-1" id="button${target}-1" class="form-control" required>
      </div>
    </div>
		`);
      $('#media' + target).filemanager('file');
    } else if (messageTypeSelect == 'template') {
      $('#messageType' + target).html(
        `
		<label for="message${target}" class="form-label">{{__('system.table_message')}}</label>
		<textarea class="form-control" id="message${target}" name="message${target}" rows="3" required></textarea>
		<label for="footer${target}" class="form-label">{{__('system.message_footer')}}</label>
		<input type="text" name="footer${target}" class="form-control" id="footer${target}" >
		
		<div class="file-uploader">
      <label class="form-label mt-4">{{__('system.image')}} {{__('system.optional')}}</label><br>
      <div class="input-group ">
        <span class="input-group-btn">
          <a id="media${target}" data-input="thumbnail${target}" data-preview="holder" class="btn btn-primary text-white">
            <i class="fa fa-picture-o"></i> {{__('system.choose')}}
          </a>
        </span>
        <input id="thumbnail${target}" class="form-control" type="text" name="url${target}" required>
      </div>
    </div>
		
		<button class="btn btn-sm btn-primary mt-4" type="button" id="addtemplate${target}" data-bs-target="${target}" onclick="addtemplate(this)">+ {{__('system.template')}}</button>
		<div id="template-area${target}">
      <div class="form-group">
        <label for="template${target}-1" class="form-label">{{__('system.template')}} 1</label>
        <input type="text" placeholder="{{__("system.message_template_value")}}" name="template${target}-1" id="template${target}-1" class="form-control" required>
      </div>
    </div>
		<span class="text-danger">
      {{__('system.message_template_helpCall')}} <span class="badge badge-secondary">{{__('system.message_template_helpCall_')}}</span><br>
      {{__('system.message_template_helpLink')}} <span class="badge badge-secondary">{{__('system.message_template_helpLink_')}}</span><br>
      {{__('system.message_template_help_')}}
    </span>
		`);
    } else if (messageTypeSelect == 'list') {
      $('#messageType' + target).html(
        `
		<label for="message${target}" class="form-label">{{__('system.table_message')}}</label>
		<textarea class="form-control" id="message${target}" name="message${target}" rows="3" required></textarea>
		<label for="footer${target}" class="form-label">{{__('system.message_footer')}}</label>
		<input type="text" name="footer${target}" class="form-control" id="footer${target}" >
		<label for="title${target}" class="form-label">{{__('system.list_title')}}</label>
		<input type="text" name="title${target}" class="form-control" id="title${target}" required>
		<label for="buttontext${target}" class="form-label">{{__('system.list_button')}}</label>
		<input type="text" name="buttontext${target}" class="form-control" id="buttontext${target}" >
		
		<button class="btn btn-sm btn-primary mt-4" type="button" id="addList${target}" data-bs-target="${target}" onclick="addlist(this)">+ {{__('system.list')}}</button>
		<div id="list-area${target}">
      <div class="form-group">
        <label for="list${target}-1" class="form-label">{{__("system.list")}} #1</label>
        <input type="text" name="list${target}-1" id="list${target}-1" class="form-control" required>
      </div>
    </div>
		`);
    } else {
      $('#messageType' + target).html('');
    }
  }

  function addbutton(e) {
    let target = $(e).data('bs-target');
    var button = $('#button-area' + target).children().length;
    if (button < 3) {
      $('#button-area' + target).append('<div class="form-group"><label for="button'+target+'-' + (button + 1) + '" class="form-label">{{__("system.button")}} #' + (button + 1) + '</label><input type="text" name="button'+target+'-' + (button + 1) + '" id="button'+target+'-' + (button + 1) + '" class="form-control" required></div>');
    }
  }

  function addtemplate(e) {
    let target = $(e).data('bs-target');
    var template = $('#template-area' + target).children().length;
    if (template < 3) {
      $('#template-area' + target).append('<div class="form-group"><label for="template'+target+'-' + (template + 1) + '" class="form-label">{{__("system.template")}} ' + (template + 1) + '</label><input type="text" placeholder="{{__("system.message_template_value")}}"  name="template'+target+'-' + (template + 1) + '" id="template'+target+'-' + (template + 1) + '" class="form-control" required></div>');
    }
  }

  function addlist(e) {
    let target = $(e).data('bs-target');
    var list = $('#list-area' + target).children().length;
    if (list < 5) {
      $('#list-area' + target).append('<div class="form-group"><label for="list'+target+'-' + (list + 1) + '" class="form-label">{{__("system.list")}} #' + (list + 1) + '</label><input type="text"  name="list'+target+'-' + (list + 1) + '" id="list'+target+'-' + (list + 1) + '" class="form-control" required></div>');
    }
  }

  function card_add(e) {
    let target = $('#integration-card-area').children().length +1;
    $('#integration-card-area').append(
      `
		<div>
      <div class="card my-3 border shadow">
        <div class="card-body">
          <div class="input-group mb-3">
            <label class="input-group-text" for="messageTypeSelect${target}">{{__('system.type_message')}}</label>
            <select name="message_type${target}" class="form-select" id="messageTypeSelect${target}" data-bs-target="${target}" onchange="messageTypeSelect(this)">
              <option selected>{{__('system.select_')}}</option>
              <option value="text">{{__('system.text')}}</option>
              <option value="media">{{__('system.media')}}</option>
              <option value="button">{{__('system.button')}}</option>
              <option value="template">{{__('system.template')}}</option>
              <option value="list">{{__('system.list')}}</option>
            </select>
          </div>
          <div id="messageType${target}"></div>
        </div>
      </div>
    </div>
		`);
	card_buttons();
  }

  function card_delete(e) {
    $("#integration-card-area").children().last().remove();
    card_buttons();
  }

  function card_buttons(e) {
    let target = $('#integration-card-area').children();
    $('#qt').val(target.length);
	if (target.length == 0) {
	    $('#cardButtons').html(
	      `
	      <button class="btn btn-outline-dark btn-sm" type="button" onclick="card_add(this)"><b><i class="material-icons-outlined">add</i> {{__('system.button_add')}}</b></button>
	      `);
	} else {
	    $('#cardButtons').html(
	      `
	      <button class="btn btn-outline-dark btn-sm" type="button" onclick="card_add(this)"><b><i class="material-icons-outlined">add</i> {{__('system.button_add')}}</b></button>
	      <button class="btn btn-outline-danger btn-sm" type="button" onclick="card_delete(this)"><i class="material-icons-outlined">delete_forever</i> {{__('system.button_delete')}}</button>
	      `);
	}
  }
  
    function manage_integrations_f(e) {
        var option = $('#integration-select').find(":selected").text();
        var data = JSON.parse($("#manage_integrations_data").val());
        keys = Object.keys(data);
        i = 0;
        while (i < keys.length) {
            if (data[keys[i]].name == option) {
                $("#manage_integrations_name").html(data[keys[i]].name);
                $("#manage_integrations_description").html(data[keys[i]].accordion[0].description0);
                $("#manage_integrations_image").attr("src", data[keys[i]].image);
                if (data[keys[i]].beta) {
                    $('#manage_integrations_beta').show();
                } else {
                    $('#manage_integrations_beta').hide();
                }
                var array = data[keys[i]].tags.split(",");
                $("#manage_integrations_tags").html('');
                $.each(array, function(i) {
                    var string = array[i];
                    string = string.replace(/[^\w\s]/gi, '');
                    $("#manage_integrations_tags").append('<code class="me-2" onclick="textToClipboard(\'' + string + '\')" id="' + string + '" style="word-wrap:normal;">{' + array[i] + '}</code>');
                });
            }
            i++;
        }
    };
    
    //card_buttons();
    manage_integrations_f();

</script>
