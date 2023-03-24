<link href="{{asset('plugins/select2/css/select2.css')}}" rel="stylesheet">

<div class="card-body">
    <form class="flex flex-row" method="POST" enctype="multipart/form-data" id="formblast">
        @csrf
        <input type="hidden" name="type" value="button">
        {{-- <div class="col-md-12"> --}}
            <label for="textmessage" class="form-label">{{__('system.sender')}}</label>
            <select name="sender" id="sender" class="form-control" style="width: 100%;" required>
               @foreach ($numbers as $number)
               <option value="{{$number->body}}">{{$number->body}}</option>
               @endforeach
               
            </select>
        {{-- </div> --}}
        <div class="d-flex justify-content-between">

            <div class="col-md-7">
                
                <div>
                    <div class="tagsOption ">
                        <label for="inputEmail4" class="form-label">{{__('system.contactlist')}}</label>
                        <select name="tag" id="tag" class="form-control" style="width: 100%; height:200px;" required>
                          @foreach ($tags as $tag)
                              
                          <option value="{{$tag->id}}">{{$tag->name}}</option>
                          @endforeach
                           
                        </select>
                    </div>
                    <div class="d-flex justify-content-around">
                        <div class="col">
                            <label for="delay" class="form-label">{{__('system.delay')}}</label>
                            <input type="number" id="delay" min="1" max="60" name="delay" class="form-control">
                        </div>
                        <div class="col mx-2">
                            <label for="tipe" class="form-label">{{__('system.type')}}</label>
                            <select name="tipe" id="tipe" class="form-control" style="width: 100%; height:200px;">
                               <option value="immediately">{{__('system.immediately')}}</option>
                               <option value="schedule">{{__('system.schedule')}}</option>
                                 
                              </select>
                        </div>
                        
                    </div>
                    <div class="col d-none" id="datetime">
                
                        <label for="datetime" class="form-label">{{__('system.date_time')}}</label>
                        <input type="datetime-local" id="datetime2"  name="datetime" class="form-control">
                    </div>
                </div>

                <div class="d-flex justify-content-rounded">
                    <div class="col">
                        <label for="template1" class="form-label">{{__('system.template')}} #1</label>
                        <input type="text" name="template1" id="template1" placeholder="{{__('system.message_template_value')}}"  class="form-control">
                    </div>
                    <div class="col">
                        <label for="template2" class="form-label">{{__('system.template')}} #2</label>
                        <input type="text" name="template2" id="template2" placeholder="{{__('system.message_template_value')}}" class="form-control">
                    </div>
                </div>
             
               
             

                <span class="text-danger">{{__('system.message_template_helpCall')}}<span class="badge badge-secondary">{{__('system.message_template_helpCall_')}}</span> <br>{{__('system.message_template_helpLink')}}<span class="badge badge-secondary">{{__('system.message_template_helpLink_')}}</span>  <br>{{__('system.message_template_help_')}}</span>
<br>
                <label for="footer" class="form-label">{{__('system.message_footer_')}}</label>
                <input type="text" name="footer" id="footer" class="form-control">
    
            </div>
            <div class="col-md-5 mx-2">
                <label for="inputPassword4" class="form-label">{{__('system.message')}}</label>
                <textarea name="message" id="message" cols="30" rows="10" class="form-control">{{__('system.use_var_name')}}</textarea>
            </div>
         
        </div>

        <div class="mt-2" id="buttonblast">
            <button type="submit" id="buttonStartBlast" name="submit" class="btn btn-primary">{{__('system.start_blast')}}</button>
        </div>
    </form>
</div>

<script src="{{asset('js/pages/select2.js')}}"></script>
<script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
<script>
    
     
     

    $('#tipe').on('change',function(){
    
    if($(this).val() === 'schedule'){
        $('#datetime').removeClass('d-none')
    } else {
     $('#datetime').addClass('d-none')
    }
 })
     
      $('#buttonStartBlast').click((e)=> {
        e.preventDefault();
          let selected = []
        $('#lists option:selected').each(function() {
            selected.push($(this).val())
        });

        if(!$('#sender').val()    || !$('#message').val() || !$('#template1').val() || !$('#template2').val() || !$('#footer').val() || !$('#tag').val() || !$('#delay').val() ){
            return alert({{__('validation.req_fill_all_field')}});
        }
        if($('#tipe').val() === 'schedule' && !$('#datetime2').val()){
            return alert({{__('validation.req_set_datetime_type_schedule')}});
        }
        const template1 = $('#template1').val();
        const template2 = $('#template2').val();
       // console.log(template1.indexOf('|'))
        if(template1.indexOf('|') < 0 || template2.indexOf('|' ) < 0){
            return alert({{__('validation.wrong_type_template_')}})
        }
        const allow = ['url','call'];
        const tyP1 = template1.split('|')[0]; 
        const tyP2 = template2.split('|')[0]; 

        if(!allow.includes(tyP1) || !allow.includes(tyP2)){
            return alert({{__('validation.type_template_must_call_url')}})
        }
         

        let data;
        let typeReceipt
      
            data = {
                type : 'template',
               
                tag : $('#tag').val(),
                sender : $('#sender').val(),
                message : $('#message').val(),
                template1 : $('#template1').val(),
                template2 : $('#template2').val(),
                footer : $('#footer').val(),
                delay : $('#delay').val(),
                tipe : $('#tipe').val(),
                datetime : $('#datetime2').val(),
            }
            // return console.log(data);

       
        $('#buttonStartBlast').html(`<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                                {{__('system.process_blasting')}}`)
       $.ajax({
           method : 'POST',
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
           url : '{{route('blast')}}',
           data : data,
           dataType : 'json',
           success : (result) => {
             //  return console.log(result)
           window.location = ''
           },
           error : (err) => {
                console.log(err);
           }
       })
      })
    
    
</script>