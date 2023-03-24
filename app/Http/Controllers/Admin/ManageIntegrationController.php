<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ManageIntegration;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ManageIntegrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $manage_integrations = ManageIntegration::paginate(10);
        // $manage_integrations = ManageIntegration::all();
        // return dd($manage_integrations);
        return view('pages.admin.manageintegration', compact('manage_integrations'));
        // return view('pages.admin.manageintegration');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        $manage_integration = ManageIntegration::where('id', $id)->first();
        return view('pages.admin.integration', compact('manage_integration'));
        // return view('pages.admin.integration');
    }
    
    public function add()
    {
        return view('pages.admin.integration-add');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'user_level' => 'required',
            'name' => 'required',
            'tags' => 'required',
            'integration' => 'required',
        ]);
        
        $qt = $request->qt;
        $accordion = [];
        
        for ($key = 0; $key <= $qt; $key++) {
            // try {
            //     $request->validate([
            //         "name$key" => 'required',
            //         "tags$key" => 'required',
            //         "lang$key" => 'required',
            //     ]);
            // } catch (ValidationException $e) {
            //     return redirect()->back()->withErrors($e->validator)->withInput()->with('alert',[
            //         'type' => 'danger',
            //         'msg' => __('Preencha todos os campos!')
            //     ]);
            // }
            
            $item = [
                    "description$key" => $request->input("description$key"),
                    "lang$key" => $request->input("lang$key"),
                    "published$key" => $request->boolean("published$key"),
            ];
            array_push($accordion, $item);
        }
        
        $data = [
            "name" => $request->input("name"),
            "tags" => $request->input("tags"),
            "beta" => $request->boolean("beta"),
            "image" => $request->input("image"),
            "integration" => $request->input("integration"),
            "status" => $request->boolean("status"),
            "accordion" => $accordion,
        ];
        
        $manage_integration = new ManageIntegration;
        $manage_integration->user_id = $validatedData['user_id'];
        $manage_integration->user_level = $validatedData['user_level'];
        $manage_integration->data = json_encode($data);
        $manage_integration->save();
        
        return redirect()->route('admin.manage_integration')->with('alert',[
            'type' => 'success',
            'msg' => __('Integração adicionada com sucesso!')
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $manage_integration=ManageIntegration::find($request->id);
        $manage_integration->user_id=$request->user_id;
        $manage_integration->user_level=$request->user_level;
        $manage_integration->name=$request->name;
        $manage_integration->description=$request->description;
        $manage_integration->beta=$request->beta;
        $manage_integration->image=$request->image;
        $manage_integration->tags=$request->tags;
        $manage_integration->lang=$request->lang;
        $manage_integration->status=$request->status;
        $manage_integration->save();
        return back()->with('alert',[
            'type' => 'success',
            'msg' => __('Integração ? com sucesso!')
        ]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('pages.admin.integration');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'user_id' => 'required',
            'user_level' => 'required',
            'name' => 'required',
            'tags' => 'required',
            'integration' => 'required',
        ]);
        
        $qt = $request->qt;
        $accordion = [];
        
        for ($key = 0; $key <= $qt; $key++) {
            // try {
            //     $request->validate([
            //         "name$key" => 'required',
            //         "tags$key" => 'required',
            //         "lang$key" => 'required',
            //     ]);
            // } catch (ValidationException $e) {
            //     return redirect()->back()->withErrors($e->validator)->withInput()->with('alert',[
            //         'type' => 'danger',
            //         'msg' => __('Preencha todos os campos!')
            //     ]);
            // }
            
            $item = [
                    "description$key" => $request->input("description$key"),
                    "lang$key" => $request->input("lang$key"),
                    "published$key" => $request->boolean("published$key"),
            ];
            array_push($accordion, $item);
        }
        
        $data = [
            "name" => $request->input("name"),
            "tags" => $request->input("tags"),
            "beta" => $request->boolean("beta"),
            "image" => $request->input("image"),
            "integration" => $request->input("integration"),
            "status" => $request->boolean("status"),
            "accordion" => $accordion,
        ];
        
        $manage_integration = ManageIntegration::find($id);
        $manage_integration->user_id = $validatedData['user_id'];
        $manage_integration->user_level = $validatedData['user_level'];
        $manage_integration->data = json_encode($data);
        $manage_integration->save();
        
        return redirect()->back()->with('alert',[
            'type' => 'success',
            'msg' => __('Integração atualizada com sucesso!')
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manage_integration = ManageIntegration::find($id);
        $manage_integration->delete();
        return redirect()->route('admin.manage_integration')->with('alert',[
            'type' => 'success',
            'msg' => __('Integração deletada com sucesso!')
        ]);
    }
}
