<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use App\Imports\ContactImport;
use App\Models\Contact;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ContactController extends Controller
{
    
    public function index($tag){
  

       
       $contacts = Contact::whereUserId(Auth::user()->id)->whereTagId($tag)->get();
        
    $tag = Tag::with('contacts')->get()->find($tag);
   // dd($tag->contacts);
        return view('pages.contact',[
            'contacts' => $contacts,
            'tag' => $tag
        ]);
    }

    public function store(Request $request){

        // $request->validate([
        //     'number' => ['unique:contacts']
        // ]);
   
        Contact::create([
            'user_id' => Auth::user()->id,
            'tag_id' => $request->tag,
            'name' => $request->name,
            'number' => $request->number
        ]);

        return back()->with('alert',[
            'type' => 'success',
            'msg' => __('validation.contacts_added')
        ]);


    }


    public function import(Request $request){
      try {
        Excel::import(new ContactImport($request->tag),$request->file('fileContacts')->store('temp'));
        return back()->with('alert',[
            'type' => 'success',
            'msg' => __('validation.contacts_import_success')
        ]);
      } catch (\Throwable $th) {
        return back()->with('alert',[
            'type' => 'danger',
            'msg' => __('validation.contacts_import_error')
        ]);
      }
        
    

    }
    public function export(Request $request){
       
       return  Excel::download(new ContactsExport($request->tag),'contacts.xlsx');
    }

    public function destroyAll(Request $request){
       
     Contact::whereTagId($request->tag)->delete();
        return back()->with('alert',[
            'type' => 'success',
            'msg' => __('validation.contacts_deleted_all')
        ]);
    }

    public function destroy($id){
        Contact::find($id)->delete();
        return back()->with('alert',[
            'type' => 'success',
            'msg' => __('validation.contacts_deleted').$id.__('validation.contacts_deleted_')
        ]);
    }
}
