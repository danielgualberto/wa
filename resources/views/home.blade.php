<x-layout-dashboard title="Home">
  
    <div class="app-content">
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
                <div class="row">
                    {{-- text danger subscription --}}
                    <div class="col-xl-12 mt-1 mb-4">
                        <h5 class="shadow rounded-pill bg-white py-2 px-4 d-inline hide-sidebar-toggle-button">
                            {{__('system.subscription')}}
                            <span class="badge rounded-pill bg-{{Auth::user()->is_expired_subscription ? 'danger' : 'primary'}} ms-3">
                                {{Auth::user()->expired_subscription}}
                            </span>
                        </h5>
                    </div>
                               
                 
               
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">contacts</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">{{__('system.widget_stats_title_contacts')}}</span>
                                        <span class="widget-stats-amount">{{ Auth::user()->contacts()->count()}}</span>
    
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-warning">
                                        <i class="material-icons-outlined">message</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">{{__('system.widget_stats_title_blast_message')}}</span>
    
                                        <span class="widget-stats-info">{{Auth::user()->blasts()->where(['status' => 'success'])->count()}} {{__('system.widget_stats_info_success')}}</span>
                                        <span class="widget-stats-info">{{Auth::user()->blasts()->where(['status' => 'failed'])->count()}} {{__('system.widget_stats_info_failed')}}</span>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div>
                       </div>
                    </div>
                   
                    {{-- <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">schedule</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">{{__('system.widget_stats_title_schedule')}}</span>
    
                                        <span class="widget-stats-info">0 {{__('system.widget_stats_info_success')}}</span>
                                        <span class="widget-stats-info">0 {{__('system.widget_stats_info_failed')}}</span>
                                        <span class="widget-stats-info">0 {{__('system.widget_stats_info_pending')}}</span>
                                    </div>
    
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body" style="position: relative; height:350px;">
                                <canvas id="myChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between gap-4">
                                    <h5 class="">{{__('system.widget_wa_accounts')}}
                                        <small class="text-warning ms-2">{{__('system.widget_have_limit_device')}} {{$limit_device}} {{__('system.widget_have_limit_device_')}}</small>
                                    </h5>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDevice"><i class="material-icons">add</i>{{__('system.button_add')}}</button>
                                </div>
                                <table class="table table-striped">
                                    <thead>
                                        <th>{{__('system.table_number')}}</th>
                                        {{--<th>{{__('system.table_webhook_url')}}</th>--}}
                                        <th>{{__('system.table_messages')}}</th>
                                        <th>{{__('system.table_status')}}</th>
                                        <th>{{__('system.table_action')}}</th>
                                    </thead>
                                    <tbody>
                                       @foreach ($numbers as $number)
                                       <tr>
    
                                        <td>{{$number['body']}}</td>
                                        {{--<td>
                                            <form action="" method="post">
                                                @csrf
                                                <input type="text" id="webhook" class="form-control form-control-solid-bordered" data-id="{{$number['body']}}" name="" value="{{$number['webhook']}}" id="">
                                            </form>
                                        </td>--}}
                                        <td>{{$number['messages_sent']}}</td>
                                        <td><span class="badge badge-{{ $number['status'] == 'Connected' ? 'success' : 'danger'}}">{{ $number['status'] == 'Connected' ? __('system.widget_title_wa_info_status_connected') : __('system.widget_title_wa_info_status_disconnected')}}</span></td>
                                        <td>
                                            <div class="d-flex justify-content-center">

                                                <a href="{{route('scan',$number->body)}}" class="btn btn-warning "  style="font-size: 10px;"><i class="material-icons">qr_code</i></a>
                                                <form action="{{route('deleteDevice')}}" method="POST">
                                                    @method('delete')
                                                    @csrf
                                                    <input name="deviceId" type="hidden" value="{{$number['id']}}">
                                                    <button type="submit" name="delete" class="btn btn-danger "><i class="material-icons">delete_outline</i></button>
                                                </form>
                                            </div>

                                        </td>
                                    </tr>
                                       @endforeach
                                           
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="addDevice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{__('system.modal_addDevice')}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('addDevice')}}" method="POST">
                        @csrf
                        <label for="sender" class="form-label">{{__('system.modal_addDevice_number')}}</label>
                        <input type="number" name="sender" class="form-control" id="nomor"  required>
                        <p class="text-small text-danger">{{__('system.modal_addDevice_number_')}}</p>
                        {{--<label for="urlwebhook" class="form-label">{{__('system.modal_addDevice_webhook')}}</label>
                        <input type="text" name="urlwebhook" class="form-control" id="urlwebhook">
                        <p class="text-small text-danger">{{__('system.modal_addDevice_webhook_')}}</p>--}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__('system.button_cancel')}}</button>
                    <button type="submit"  name="submit" class="btn btn-primary">{{__('system.button_save')}}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        var typingTimer;                //timer identifier
var doneTypingInterval = 1000;
        $('#webhook').keydown(function(){
            clearTimeout(typingTimer);

            typingTimer = setTimeout(function(){
                $.ajax({
           method : 'POST',
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           url : '{{route('setHook')}}',
           data : {
               number : $('#webhook').data('id'),
               webhook : $('#webhook').val()
           },
           dataType : 'json',
           success : (result) => {
           
           },
           error : (err) => {
                console.log(err);
           }
       })
            }, doneTypingInterval);
        })
    </script>

</x-layout-dashboard>

<script src="{{asset('plugins/chartjs/chart.umd.js')}}"></script>
<script>
    const chart_labels = [];
    const chart_data_blast_success = [];
    const chart_data_blast_pending = [];
    @for ($i = 6; $i >= 0; $i--)
        chart_labels.push('{{date("d/m", strtotime("-$i days"))}}');
        chart_data_blast_success.push('{{Auth::user()->blasts()->where(["status" => "success"])->whereDate("created_at", now()->subDays($i))->count()}}');
        chart_data_blast_pending.push('{{Auth::user()->blasts()->where(["status" => "pending"])->whereDate("created_at", now()->subDays($i))->count()}}');
    @endfor
    Chart.defaults.borderColor = 'transparent';
    Chart.defaults.color = '#000';
    const ctx = document.getElementById('myChart');
    ctx.width = parent.offsetWidth;
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chart_labels,
            datasets: [{
                label: "{{__('system.widget_stats_title_blast_message')}}",
                data: chart_data_blast_success,
                backgroundColor: '#FFF3E3',
                borderColor: '#FF9500'
            }, {
                label: "{{__('system.blast_pending')}}",
                data: chart_data_blast_pending,
                backgroundColor: '#E3FFED',
                borderColor: '#075E54'
        }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: "{{__('system.analytics')}}",
                    align: 'start',
                    font: {
                        size: 13,
                        family: 'Poppins,sans-serif',
                        weight: '500'
                    },
                    color: '#a1a5b5'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                    }
                },
                x: {
                    ticks: {
                        maxRotation: 0,
                        minRotation: 0
                    }
                }
            }
        }
    });
</script>
