<x-layout-dashboard title="{{__('system.user_manager')}}">
  
    <div class="app-content">
        <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">

        <link href="{{asset('css/custom.css')}}" rel="stylesheet">
        <div class="content-wrapper">
            <div class="container">
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
               
           
                
    
<div class="row mt-4">
  <div class="col">
      <div class="card">
          <div class="card-header d-flex justify-content-between">
          <h5 class="card-title">{{__('system.users')}}</h5>

         
            <button type="button" class="btn btn-primary" onclick="addUser()" >
                {{__('system.button_add')}} {{__('system.user')}}
            </button>
          </div>
          <div class="card-body">
              <table id="datatable1" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th>{{__('system.table_username')}}</th>
                            <th>{{__('system.table_email')}}</th>
                          <th>{{__('system.table_device_total')}}</th>
                          <th>{{__('system.table_device_limit')}}</th>
                          <th>{{__('system.table_subscription')}}</th>
                          <th>{{__('system.table_subscription_expired')}}</th>
                            <th>{{__('system.table_action')}}</th>
                          {{-- <th class="d-flex justify-content-center">{{__('system.table_action')}}</th> --}}
                      </tr>
                  </thead>
                    <tbody>
                         @foreach ($users as $user)
                             
                         <tr>
                            <td>{{$user->username}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->total_device}}</td>
                            <td>{{$user->limit_device}}</td>
                            <td>
                                @php
                                    if($user->is_expired_subscription){
                                        $badge = 'danger';
                                    } else {
                                        $badge = 'success';
                                    }
                                @endphp
                                <span class="badge badge-{{$badge}}">{{$user->active_subscription}}</span>
                            </td>
                           
                            <td>
                                @php
                                    if($user->is_expired_subscription)
                                    {
                                        echo '<span class="badge badge-danger">-</span>';
                                    }
                                    else
                                    {
                                        if($user->active_subscription == 'active')
                                        {
                                            echo $user->subscription_expired;
                                        } 
                                        else
                                        {
                                            echo '<span class="badge badge-danger">-</span>';
                                        }
                                    }
                                @endphp
                            </td>
                            <td class="d-flex justify-content-center">
                                <button type="button" class="btn btn-primary" onclick="editUser({{$user->id}})">
                                    {{__('system.button_edit')}}
                                </button>
                                <form action="{{route('user.delete',$user->id)}}"  method="POST" onsubmit="return confirm('{{__('validation.alert_delete_user')}}')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <button type="submit" class="btn btn-danger btn-sm">{{__('system.button_delete')}}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                
                  <tfoot></tfoot>
              </table>
          </div>
      </div>
  </div>

</div>


<!-- Modal -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data" id="formUser">
                    @csrf
                    <input type="hidden" id="iduser" name="id" >
                    <label for="username" class="form-label">{{__('system.table_username')}}</label>
                    <input type="text" name="username" id="username" class="form-control" value="" >
                    <label for="email" class="form-label">{{__('system.table_email')}}</label>
                    <input type="email" name="email" id="email" class="form-control" value="" >
                    <label for="password" class="form-label" id="labelpassword">{{__('system.password')}}</label>
                    <input type="password" name="password" id="password" class="form-control" value="" >
                    <label for="limit_device" class="form-label">{{__('system.table_device_limit')}}</label>
                    <input type="number" name="limit_device" id="limit_device" class="form-control" value="">
                    <label for="active_subscription" class="form-label">{{__('system.table_subscription_active')}}</label><br>
                    <select name="active_subscription" id="active_subscription" class="form-control">
                        <option value="active" selected>{{__('system.opt_subscription_active')}}</option>
                        <option value="inactive">{{__('system.opt_subscription_inactive')}}</option>
                        <option value="lifetime">{{__('system.opt_subscription_lifetime')}}</option>
                    </select><br>
                    <label for="subscription_expired" class="form-label">{{__('system.table_subscription_expired')}}</label>
                    <input type="date" name="subscription_expired" id="subscription_expired" class="form-control" value="">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('system.button_close')}}</button>
                <button type="submit" id="modalButton" name="submit" class="btn btn-primary">{{__('system.button_add')}}</button>
                </form>
            </div>
        </div>
    </div>
</div>
    
            </div>
        </div>
    </div>



    <script src="{{asset('js/pages/datatables.js')}}"></script>
  
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>

 
    <script>
       function addUser(){
              $('#modalLabel').html("{{__('system.button_add')}} {{__('system.user')}}");
              $('#modalButton').html("{{__('system.button_add')}}");
                $('#formUser').attr('action', '{{route('user.store')}}');
              $('#modalUser').modal('show');
       }

       function editUser(id){
       
        // return;
            $('#modalLabel').html("{{__('system.button_edit')}} {{__('system.user')}}");
            $('#modalButton').html("{{__('system.button_edit')}}");
            $('#formUser').attr('action', '{{route('user.update')}}');
            $('#modalUser').modal('show');
            $.ajax({
                url: "{{route('user.edit')}}",
                type: "GET",
                data: {id:id},
                dataType: "JSON",
                success: function(data) {
                    $('#labelpassword').html("{{__('validation.password_leave_blank')}}");
                    $('#username').val(data.username);
                    $('#email').val(data.email);
                    $('#password').val(data.password);
                    $('#limit_device').val(data.limit_device);
                    $('#active_subscription').val(data.active_subscription);
                    $('#subscription_expired').val(data.subscription_expired);
                    $('#iduser').val(data.id);
                }
            });
       }
    </script>
</x-layout-dashboard>





