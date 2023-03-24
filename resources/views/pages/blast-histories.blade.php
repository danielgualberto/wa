<x-layout-dashboard title="{{__('system.histories')}}">
  
    <div class="app-content">
        <link href="{{asset('plugins/datatables/datatables.min.css')}}" rel="stylesheet">
        <link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">
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
          <h5 class="card-title">{{__('system.histories')}}</h5>

         
             
          </div>
          <div class="card-body">
              <table id="datatable1" class="display" style="width:100%">
                  <thead>
                      <tr>
                          <th>{{__('system.table_recipient')}}</th>
                          <th>{{__('system.table_status')}}</th>
                        <th>{{__('system.table_last_update')}}</th>
                          {{-- <th class="d-flex justify-content-center">__('system.table_action')</th> --}}
                      </tr>
                  </thead>
                  <tbody>
                     @foreach ($histories as $history)
                         
                     <tr>
                        <td>{{$history->receiver}}</td>
                        <td>
                            @php
                                if($history->status == 'pending')
                                {
                                    echo '<span class="badge badge-warning">'.__('system.widget_stats_info_pending').'</span>';
                                }
                                elseif($history->status == 'success')
                                {
                                    echo '<span class="badge badge-success">'.__('system.widget_stats_info_success').'</span>';
                                }
                                elseif($history->status == 'failed')
                                {
                                    echo '<span class="badge badge-danger">'.__('system.widget_stats_info_failed').'</span>';
                                }
                            @endphp
                            </td>
                        <td>{{$history->updated_at}}</td>
                       
                      </tr>
                      @endforeach
                    

                  </tbody>
                  <tfoot></tfoot>
              </table>
          </div>
      </div>
  </div>

</div>



    
            </div>
        </div>
    </div>



    <script src="{{asset('js/pages/datatables.js')}}"></script>
    <script src="{{asset('js/pages/select2.js')}}"></script>
    <script src="{{asset('plugins/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
  <script src="{{asset('js/autoreply.js')}}"></script>
</x-layout-dashboard>





