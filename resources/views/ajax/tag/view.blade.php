<table id="datatable1" class="display" style="width:100%">
    <thead>
        <tr>
            <th>{{__('system.table_name')}}</th>
            <th>{{__('system.table_number')}}</th>
          
            {{-- <th class="d-flex justify-content-center">__('system.table_action')</th> --}}
        </tr>
    </thead>
    <tbody>
       @foreach ($contacts as $contact)
           
       <tr>
           <td>{{$contact->name}}</td>
           <td>{{$contact->number}}</td>
           {{-- <td>
               <div class="d-flex justify-content-center">
                   <button class="btn btn-success btn-sm mx-3">__('system.button_add')</button>
               </div>
            </td> --}}
        </tr>
        @endforeach
      

    </tbody>
    <tfoot></tfoot>
</table>