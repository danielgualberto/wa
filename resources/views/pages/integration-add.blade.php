<x-layout-dashboard title="{{__('system.add_integration')}}">
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
                        <h2>{{__('system.add_integration')}}</h2>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{url('/integration/save')}}" method="POST">
                                @csrf
                                <input type="hidden" name="user_sender" value="{{Session::get('selectedDevice')}}">
                                <input type="hidden" name="token" value="{{md5(uniqid(mt_rand(),true))}}">
                                <input type="hidden" name="qt" id="qt" value="0">
                                <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addonname">{{__('system.table_name')}}</span>
                                <input type="text" name="name" class="form-control" placeholder="{{__('system.integration_name')}}" aria-label="{{__('system.integration_name')}}" aria-describedby="basic-addonname">
                                <button type="submit" class="btn btn-success"><i class="material-icons-outlined">save</i> {{__('system.button_save')}}</button>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addondesc">{{__('system.table_description')}}</span>
                                <input type="text" name="description" class="form-control" placeholder="{{__('system.integration_description_short')}}" aria-label="{{__('system.table_description')}}" aria-describedby="basic-addondesc">
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
                                                                        'text' => $data_mi["name"]
                                                                    ];
                                                                @endphp
                                                            @else
                                                            <option value="{{$manage_integration->id}}">{{$data_mi["name"]}}</option>
                                                            @endif
                                                        @endif
                                                        @endforeach
                                                        
                                                        @foreach ($grouped_options as $group_label => $group)
                                                        <optgroup label="{{$group_label}}">
                                                            @foreach ($group as $option)
                                                            <option value="{{$option['value']}}">{{$option['text']}}</option>
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
                                <input type="text" name="number" class="form-control" id="number" placeholder="{{__('system.table_recipient_number')}}" aria-label="{{__('system.table_recipient_number')}}" aria-describedby="basic-addonnumber">
                            </div>
                            <div class="input-group mb-3 d-none">
                                <span class="input-group-text">{{__('system.delay_in_seconds_from_to')}}</span>
                                <input type="text" name="range_from" class="form-control" placeholder="5" aria-label="{{__('system.range_from')}}" value="5">
                                <span class="input-group-text"><i class="material-icons-outlined">timer</i></span>
                                <input type="text" name="range_to" class="form-control" placeholder="15" aria-label="{{__('system.range_to')}}" value="15">
                            </div>
                            <p class="text-danger fst-italic d-none">{{__('system.delay_in_seconds_recommend')}}</p>
                            
                            <div class="card my-3 border shadow">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <label class="input-group-text" for="messageTypeSelect0">{{__('system.type_message')}}</label>
                                        <select name="message_type0" class="form-select" id="messageTypeSelect0" data-bs-target="0" onchange="messageTypeSelect(this)">
                                            <option selected>{{__('system.select_')}}</option>
                                            <option value="text">{{__('system.text')}}</option>
                                            <option value="media">{{__('system.media')}}</option>
                                            <option value="button">{{__('system.button')}}</option>
                                            <option value="template">{{__('system.template')}}</option>
                                            <option value="list">{{__('system.list')}}</option>
                                        </select>
                                    </div>
                                    <div id="messageType0"></div>
                                </div>
                            </div>
                            <div id="integration-card-area"></div>
                            <div class="mt-5">
                                <div class="input-group justify-content-center mb-3" id="cardButtons"></div>
                            </div>
                            
                            </form>
                        </div>
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
		<input type="text" name="title${target}" class="form-control" id="title${target} required>
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

</script>
