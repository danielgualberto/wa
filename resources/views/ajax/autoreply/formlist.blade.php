<label for="message" class="form-label">{{__('system.autoreply_type_reply_button_label')}}</label>
<textarea type="text" name="message" class="form-control" id="message" required> </textarea>
<label for="button" class="form-label">{{__('system.button')}}</label>
<input type="text" name="button" class="form-control" id="buttonlist" >
<label for="name" class="form-label">{{__('system.autoreply_type_reply_list_name')}}</label>
<input type="text" name="name" class="form-control" id="namelist" required>
{{-- create input section and each section have list menu --}}
<label for="ttile" class="form-label">{{__('system.autoreply_type_reply_list_title')}}</label>
<input type="text" name="title" class="form-control" id="titlelist" required>
<button type="button" id="addlist" class="btn btn-primary btn-sm mt-4">{{__('system.button_add')}} {{__('system.list')}}</button>
<button type="button" id="reducelist" class="btn btn-danger btn-sm mt-4">{{__('system.button_delete')}} {{__('system.list')}}</button><br>

<div class="area-list">

</div>

<script>
  // add list when click,maximal 5 list
    $(document).ready(function() {
     
        var max_fields = 5; //maximum input boxes allowed
        var wrapper = $(".area-list"); //Fields wrapper
        var add_button = $("#addlist"); //Add button ID
        var x = 0; //initlal text box count
        $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (x < max_fields) { //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="form-group"><label for="list' + x + '" class="form-label">{{__('system.list')}} #' + x + '</label><input type="text" name="list[' + x + ']" class="form-control" id="list' + x + '" required></div>'); //add input box
        }
        });
        // reduce list when click
        $(document).on('click', '#reducelist', function(e) {
        e.preventDefault();
        if(x > 0){
            $('.form-group:last').remove();
            x--;
        }
        });
    });
</script>


