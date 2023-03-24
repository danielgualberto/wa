<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ManageIntegration;

class IntegrationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $integrations = Integration::where('user_id',Auth::user()->id)->paginate(10);
        $manage_integrations = ManageIntegration::all();
        return view('pages.integration', compact('integrations','manage_integrations'));
        // return view('pages.integration');
        // return view('pages.integration',[
        //     'integrations' => Integration::where('user_id',Auth::id())->whereDevice(session()->get('selectedDevice'))->latest()->paginate(15),
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details($id)
    {
        $integration = Integration::where('id', $id)->first();
        $manage_integrations = ManageIntegration::all();
        return view('pages.integration-manager', compact('integration','manage_integrations'));
        // return view('pages.integration-manager');
    }
    
    public function add()
    {
        $manage_integrations = ManageIntegration::all();
        return view('pages.integration-add', compact('manage_integrations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // $validatedData = $request->validate([
        //     'user_id' => 'required',
        //     'user_sender' => 'required',
        //     'integration' => 'required',
        //     'token' => 'required',
        //     'name' => 'required',
        //     'number' => 'required',
        //     'range_from' => 'required',
        //     'range_to' => 'required',
        // ]);
        
        $qt = $request->qt;
        $accordion = [];
        
        for ($key = 0; $key <= $qt; $key++) {
            $message_type = $request->input("message_type$key");
            if ($message_type == 'text') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                ];
            } elseif ($message_type == 'media') {
                $item = [
                    "message_type$key" => $message_type,
                    "url$key" => $request->input("url$key"),
                    "type$key" => $request->input("type$key"),
                    "message$key" => $request->input("message$key"),
                ];
            } elseif ($message_type == 'button') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                    "footer$key" => $request->input("footer$key"),
                    "url$key" => $request->input("url$key"),
                    "button".$key."[1]" => $request->input("button".$key."-1"),
                    "button".$key."[2]" => $request->input("button".$key."-2"),
                    "button".$key."[3]" => $request->input("button".$key."-3"),
                ];
            } elseif ($message_type == 'template') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                    "footer$key" => $request->input("footer$key"),
                    "url$key" => $request->input("url$key"),
                    "template".$key."[1]" => $request->input("template".$key."-1"),
                    "template".$key."[2]" => $request->input("template".$key."-2"),
                    "template".$key."[3]" => $request->input("template".$key."-3"),
                ];
            } elseif ($message_type == 'list') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                    "footer$key" => $request->input("footer$key"),
                    "title$key" => $request->input("title$key"),
                    "buttontext$key" => $request->input("buttontext$key"),
                    "list".$key."[1]" => $request->input("list".$key."-1"),
                    "list".$key."[2]" => $request->input("list".$key."-2"),
                    "list".$key."[3]" => $request->input("list".$key."-3"),
                    "list".$key."[4]" => $request->input("list".$key."-4"),
                    "list".$key."[5]" => $request->input("list".$key."-5"),
                ];
            }
            array_push($accordion, $item);
        }
        
        $data = [
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "number" => $request->input("number"),
            "range_from" => $request->input("range_from"),
            "range_to" => $request->input("range_to"),
            "accordion" => $accordion,
        ];
        
        $integration = new Integration;
        // $integration->user_id = $validatedData['user_id'];
        // $integration->user_sender = $validatedData['user_sender'];
        // $integration->manage_integration_id = $validatedData['integration'];
        // $integration->token = $validatedData['token'];
        $integration->user_id = Auth::user()->id;
        $integration->user_sender = $request->input('user_sender');
        $integration->manage_integration_id = $request->input('integration');
        $integration->token = $request->input('token');
        $integration->data = json_encode($data);
        $integration->save();
        
        return redirect()->route('integration')->with('alert',[
            'type' => 'success',
            'msg' => __('Integração adicionada com sucesso!')
        ]);
        
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
        // $validatedData = $request->validate([
        //     'user_id' => 'required',
        //     'user_sender' => 'required',
        //     'integration' => 'required',
        //     'token' => 'required',
        //     'name' => 'required',
        //     'number' => 'required',
        //     'range_from' => 'required',
        //     'range_to' => 'required',
        // ]);
        
        $qt = $request->qt;
        $accordion = [];
        
        for ($key = 0; $key <= $qt; $key++) {
            $message_type = $request->input("message_type$key");
            if ($message_type == 'text') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                ];
            } elseif ($message_type == 'media') {
                $item = [
                    "message_type$key" => $message_type,
                    "url$key" => $request->input("url$key"),
                    "type$key" => $request->input("type$key"),
                    "message$key" => $request->input("message$key"),
                ];
            } elseif ($message_type == 'button') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                    "footer$key" => $request->input("footer$key"),
                    "url$key" => $request->input("url$key"),
                    "button".$key."[1]" => $request->input("button".$key."-1"),
                    "button".$key."[2]" => $request->input("button".$key."-2"),
                    "button".$key."[3]" => $request->input("button".$key."-3"),
                ];
            } elseif ($message_type == 'template') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                    "footer$key" => $request->input("footer$key"),
                    "url$key" => $request->input("url$key"),
                    "template".$key."[1]" => $request->input("template".$key."-1"),
                    "template".$key."[2]" => $request->input("template".$key."-2"),
                    "template".$key."[3]" => $request->input("template".$key."-3"),
                ];
            } elseif ($message_type == 'list') {
                $item = [
                    "message_type$key" => $message_type,
                    "message$key" => $request->input("message$key"),
                    "footer$key" => $request->input("footer$key"),
                    "title$key" => $request->input("title$key"),
                    "buttontext$key" => $request->input("buttontext$key"),
                    "list".$key."[1]" => $request->input("list".$key."-1"),
                    "list".$key."[2]" => $request->input("list".$key."-2"),
                    "list".$key."[3]" => $request->input("list".$key."-3"),
                    "list".$key."[4]" => $request->input("list".$key."-4"),
                    "list".$key."[5]" => $request->input("list".$key."-5"),
                ];
            }
            array_push($accordion, $item);
        }
        
        $data = [
            "name" => $request->input("name"),
            "description" => $request->input("description"),
            "number" => $request->input("number"),
            "range_from" => $request->input("range_from"),
            "range_to" => $request->input("range_to"),
            "accordion" => $accordion,
        ];
        
        $integration = Integration::find($id);
        // $integration->user_id = $validatedData['user_id'];
        // $integration->user_sender = $validatedData['user_sender'];
        // $integration->manage_integration_id = $validatedData['integration'];
        // $integration->token = $validatedData['token'];
        $integration->user_id = Auth::user()->id;
        $integration->user_sender = $request->input('user_sender');
        $integration->manage_integration_id = $request->input('integration');
        $integration->token = $request->input('token');
        $integration->data = json_encode($data);
        $integration->save();
        
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
        $integration = Integration::find($id);
        $integration->delete();
        return redirect()->route('integration')->with('alert',[
            'type' => 'success',
            'msg' => __('Integração deletada com sucesso!')
        ]);
    }
    
}
