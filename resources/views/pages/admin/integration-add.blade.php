<x-layout-dashboard title="Integração">
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
                    <div class="col d-flex align-items-center justify-content-between">
                        <h2 class="">Integração</h2>
                        <form action="{{url('/admin/manage-integration/save')}}" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}">
                        <input type="hidden" name="user_level" value="{{Auth::user()->level}}">
                        <input type="hidden" name="qt" id="qt" value="1">
                        <div class="d-flex align-items-center">
                            <div class="form-check form-switch me-3">
                                <input name="status" class="form-check-input" type="checkbox" id="flexSwitchCheckStatus">
                                <label class="form-check-label" for="flexSwitchCheckStatus">Publicar</label>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="material-icons-outlined">save</i> Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="card">
                        <div class="card-header">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="integration" id="integrationApp" value="app">
                                <label class="form-check-label" for="integrationApp">App</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="integration" id="integrationWebhook" value="webhook" checked>
                                <label class="form-check-label" for="integrationWebhook">Webhook</label>
                            </div>
                            <div class="form-check form-switch float-end">
                                <input name="beta" class="form-check-input" type="checkbox" id="flexSwitchCheckBeta">
                                <label class="form-check-label" for="flexSwitchCheckBeta">Beta</label>
                            </div>
                            <div class="input-group my-3">
                                <span class="input-group-text" id="basic-addonname">Nome</span>
                                <input type="text" name="name" class="form-control" placeholder="Nome da Integração" aria-label="Nome da Integração" aria-describedby="basic-addonname">
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addontags">Valores</span>
                                <input type="text" name="tags" class="form-control" placeholder="Valores separados por vírgula" aria-label="Valores" aria-describedby="basic-addontags">
                            </div>
                            <div class="file-uploader">
                                <label class="form-label">{{__('system.message_media_url_select')}}</label>
                                <div class="input-group mb-3">
                                    <a id="media" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                        <i class="material-icons-outlined">image</i> {{__('system.choose')}}
                                    </a>
                                    <input id="thumbnail" class="form-control" type="text" name="image" required>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="accordion mb-3" id="accordion0">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading0">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse0" aria-expanded="true" aria-controls="collapse0"><i class="material-icons-two-tone">translate</i> #1</button>
                                    </h2>
                                    <div id="collapse0" class="accordion-collapse collapse show" aria-labelledby="heading0" data-bs-parent="#accordion0">
                                        <div class="accordion-body">
                                            <div class="row">
                                                <div class="col-10">
                                                    <div class="input-group mb-3">
                                                        <span class="input-group-text"><i class="material-icons-two-tone">translate</i></span>
                                                        <input type="text" name="lang0" class="form-control" placeholder="Idioma" aria-label="Idioma">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-check form-switch float-end">
                                                        <input name="published0" class="form-check-input" type="checkbox" id="flexSwitchCheckPublished0">
                                                        <label class="form-check-label" for="flexSwitchCheckPublished0">Publicado</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Descrição</span>
                                                <textarea name="description0" class="form-control" aria-label="Descrição"></textarea>
                                            </div>
                                        </div>
                                    </div>
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
<script>
$(document).ready(function () {
    $('#media').filemanager('file');
});

  function card_add(e) {
    let target = $('#integration-card-area').children().length +1;
    let target_view = target + 1;
    $('#integration-card-area').append(
      `
		<div class="accordion mb-3" id="accordion${target}">
		    <div class="accordion-item">
		        <h2 class="accordion-header" id="heading${target}">
		            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse${target}" aria-expanded="true" aria-controls="collapse${target}"><i class="material-icons-two-tone">translate</i> #${target_view}</button>
		        </h2>
		        <div id="collapse${target}" class="accordion-collapse collapse show" aria-labelledby="heading${target}" data-bs-parent="#accordion${target}">
		            <div class="accordion-body">
		                <div class="row">
		                    <div class="col-10">
		                        <div class="input-group mb-3">
		                            <span class="input-group-text"><i class="material-icons-two-tone">translate</i></span>
		                            <input type="text" name="lang${target}" class="form-control" placeholder="Idioma" aria-label="Idioma">
		                        </div>
		                    </div>
		                    <div class="col-2">
		                        <div class="form-check form-switch float-end">
		                            <input name="published${target}" class="form-check-input" type="checkbox" id="flexSwitchCheckPublished${target}">
		                            <label class="form-check-label" for="flexSwitchCheckPublished${target}">Publicado</label>
		                        </div>
		                    </div>
		                </div>
		                <div class="input-group mb-3">
		                    <span class="input-group-text">Descrição</span>
		                    <textarea name="description${target}" class="form-control" aria-label="Descrição"></textarea>
		                </div>
		            </div>
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
	} else if (target.length == 1) {
	    $('#cardButtons').html(
	      `
	      <button class="btn btn-outline-dark btn-sm" type="button" onclick="card_add(this)"><b><i class="material-icons-outlined">add</i> {{__('system.button_add')}}</b></button>
	      <button class="btn btn-outline-danger btn-sm" type="button" onclick="card_delete(this)"><i class="material-icons-outlined">delete_forever</i> {{__('system.button_delete')}}</button>
	      `);
	}
  }
  
  card_buttons();

</script>
