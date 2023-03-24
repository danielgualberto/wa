<x-layout-dashboard title="{{__('system.manage_integrations')}}">
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
                        <h2 class="">{{__('system.manage_integrations')}} ({{$manage_integrations->count()}})</h2>
                    </div>
                    <div class="col">
                        <a href="{{url('/admin/manage-integration/add')}}" class="btn btn-primary d-flex align-content-center float-end"><i class="material-icons-outlined">add</i> {{__('system.button_add')}}</a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach ($manage_integrations as $key => $manage_integration)
                    @php $data = json_decode($manage_integration->data, true); @endphp
                    <div class="col-6 d-flex">
                        <div class="card mb-3">
                            <div class="row g-0 py-3 h-100">
                                <div class="col-3 d-flex position-relative align-items-center justify-content-center border-end">
                                    <img src="{{$data["image"]}}" class="img-fluid rounded-start" alt="">
                                    @if ($data["beta"])
                                    <span class="badge badge-dark rounded btn-close btn-close-white position-absolute bottom-0 mb-3 w-auto disabled">Beta</span>
                                    @endif
                                </div>
                                <div class="col-9">
                                    <div class="card-body">
                                        <div class="card-title d-flex align-items-center justify-content-between">
                                            <h5 class="mb-0">{{$data["name"]}}</h5>
                                            <div class="dropdown">
                                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">{{__('system.table_action')}}</button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a class="dropdown-item" href="{{route('admin.manage_integration_details', $manage_integration->id)}}">{{__('system.button_edit')}}</a></li>
                                                    <li><a class="dropdown-item" href="{{route('admin.manage_integration_delete', $manage_integration->id)}}" data-bs-toggle="modal" data-bs-target="#delete-{{$manage_integration->id}}">{{__('system.button_delete')}}</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <p class="card-text text-truncate">{!!$data["accordion"][0]["description0"]!!}</p>
                                        <p class="card-text text-truncate">
                                            @if ($data["tags"] != "")
                                            @foreach(explode(',', $data["tags"]) as $tag)
                                                <code onclick="textToClipboard('{{$tag}}')" id="{{$tag}}">{{'{'.$tag.'}'}}</code>
                                            @endforeach
                                            @endif
                                        </p>
                                        <span class="badge bg-{{ $data["status"] ? 'success' : 'danger'}} text-capitalize fst-italic position-absolute bottom-0 end-0 mb-3 me-4">
                                            {{$data["integration"]}}
                                            <span class="visually-hidden">{{ $data["status"] ? 'Publicado' : 'Não Publicado'}}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal Delete -->
                    <div class="modal fade" id="delete-{{$manage_integration->id}}" tabindex="-1" aria-labelledby="delete-{{$manage_integration->id}}ModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="delete-{{$manage_integration->id}}ModalLabel">{{$data["name"]}}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>{{__('system.modal_confirm_delete')}} <strong><em>{{$data["name"]}}</em></strong>{{__('system.modal_confirm_delete_')}}</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('system.button_cancel')}}</button>
                                    <form action="{{route('admin.manage_integration_delete', $manage_integration->id)}}" method="POST">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger">{{__('system.button_delete')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="col-12 d-flex justify-content-center py-5">
                    {{$manage_integrations->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout-dashboard>
