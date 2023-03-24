<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Number;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use App\Models\Integration;
class ApiController extends Controller
{
    
    
    
    public function messageText(Request $request)
    {
        $requestData = $request->all();
        $requiredKeys = ['api_key', 'sender', 'number', 'message'];
        $hasRequiredKeys = array_intersect($requiredKeys, array_keys($requestData)) == $requiredKeys;
        $number = Number::whereBody($request->sender)->first();
        if ($hasRequiredKeys) {
            $requestNumber = preg_replace("/[^0-9]/", "", $request->number);
            $requestMessage = $request->message;
            $data = [
                'token' => $request->sender,
                'number' => $requestNumber,
                'text' => $requestMessage
            ];
            if ($number->status == 'Disconnect') {
                return response()->json([
                    'status' => false ,
                    'msg' => __('validation.sender_not_connected'),
                    ],Response::HTTP_BAD_REQUEST);
            }
            $sendMessage = json_decode($this->postMsg($data, 'backend-send-text'));
            if (!$sendMessage->status) {
                return response()->json([
                    'status' => false ,
                    'msg' => $sendMessage->msg ?? $sendMessage->message,
                    ],Response::HTTP_BAD_REQUEST);
            }
            $number->messages_sent += 1;
            $number->save();
            return response()->json([
                'status' => true ,
                'data' => $sendMessage->data,
                ],Response::HTTP_OK);
        } else {
            $token = $request->integration;
            $integration = Integration::where('token', $token)->first();
            if ($integration) {
                $data = $integration->data;
                // foreach ($requestData as $key => $value) {
                //     $data = str_replace("{".$key."}", $value, $data);
                // }
                function replaceArrayValues($requestData, &$data, $keys = []) {
                    foreach ($requestData as $key => $value) {
                        $currentKeys = array_merge($keys, [$key]);
                        if (is_array($value)) {
                            replaceArrayValues($value, $data, $currentKeys);
                        } else {
                            $currentKey = implode(".", $currentKeys);
                            $data = str_replace("{".$currentKey."}", $value, $data);
                        }
                    }
                }
                replaceArrayValues($requestData, $data);
                $data = json_decode($data, true);
                $requestNumber = preg_replace("/[^0-9]/", "", $data["number"]);
                $range_from = $data["range_from"];
                $range_to = $data["range_to"];
                for ($key = 0; $key < count($data["accordion"]); $key++) {
                    $messageType = $data["accordion"][$key]["message_type$key"];
                    if ($messageType == "text") { /* ---------- // ---------- TEXT ---------- // ---------- */
                        $message = $data["accordion"][$key]["message$key"];
                        $data = [
                            'token' => $request->sender,
                            'number' => $requestNumber,
                            'text' => $message
                        ];
                        if ($number->status == 'Disconnect') { return response()->json(['status' => false ,'msg' => __('validation.sender_not_connected')],Response::HTTP_BAD_REQUEST); }
                        // if ($key >= 1) { sleep(rand($range_from,$range_to)); }
                        $sendMessage = json_decode($this->postMsg($data, 'backend-send-text'));
                            if (!$sendMessage->status) {
                                return response()->json([
                                    'status' => false ,
                                    'msg' => $sendMessage->msg ?? $sendMessage->message,
                                    ],Response::HTTP_BAD_REQUEST);
                            }
                            $number->messages_sent += 1;
                            $number->save();
                            return response()->json([
                                'status' => true ,
                                'data' => $sendMessage->data,
                                ],Response::HTTP_OK);
                    } elseif ($messageType == "media") { /* ---------- // ---------- MEDIA ---------- // ---------- */
                        $type = $data["accordion"][$key]["type$key"];
                        $url = $data["accordion"][$key]["url$key"];
                        $message = $data["accordion"][$key]["message$key"];
                        $fileName = pathinfo($url, PATHINFO_FILENAME);
                        $data = [
                            'type' => $type,
                            'token' => $request->sender,
                            'url' => $url,
                            'number' => $requestNumber,
                            'caption' => $message,
                            'fileName' => $fileName,
                            'type' => $type
                        ];
                        if ($number->status == 'Disconnect') { return response()->json(['status' => false ,'msg' => __('validation.sender_not_connected')],Response::HTTP_BAD_REQUEST); }
                        $sendMessage = json_decode($this->postMsg($data, 'backend-send-media'));
                        if (!$sendMessage->status) {
                            return response()->json( ['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message]);
                        }
                        $number->messages_sent += 1;
                        $number->save();
                        return response()->json(['status' => true, 'data' => $sendMessage->data]);
                    } elseif ($messageType == "button") { /* ---------- // ---------- BUTTON ---------- // ---------- */
                        $url = $data["accordion"][$key]["url$key"];
                        $footer = $data["accordion"][$key]["footer$key"];
                        $message = $data["accordion"][$key]["message$key"];
                        $buttons = [];
                        $buttons[] = ['displayText' => $data["accordion"][$key]["button".$key."[1]"]];
                        if(isset($data["accordion"][$key]["button".$key."[2]"])){
                            $buttons[] = ['displayText' => $data["accordion"][$key]["button".$key."[2]"]];
                        }
                        if(isset($data["accordion"][$key]["button".$key."[3]"])){
                            $buttons[] = ['displayText' => $data["accordion"][$key]["button".$key."[3]"]];
                        }
                        $data = [
                            'token' => $request->sender,
                            'number' => $requestNumber,
                            'button' => json_encode($buttons),
                            'message' => $message,
                            'footer' => $footer ,
                            'image' => $url ?? '',
                        ];
                        if ($number->status == 'Disconnect') {
                            return response()->json(['status' => false, 'msg' => __('validation.sender_not_connected')], Response::HTTP_BAD_REQUEST);
                        }
                        $sendMessage = json_decode($this->postMsg($data, 'backend-send-button'));
                        if (!$sendMessage->status) {
                            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message]);
                        }
                        $number->messages_sent += 1;
                        $number->save();
                        return response()->json(['status' => true, 'data' => $sendMessage->data]);
                    } elseif ($messageType == "template") { /* ---------- // ---------- TEMPLATE ---------- // ---------- */
                        $url = $data["accordion"][$key]["url$key"];
                        $footer = $data["accordion"][$key]["footer$key"];
                        $message = $data["accordion"][$key]["message$key"];
                        $templates = [];
                        $makeTemplate1 = $this->createTemplate($data["accordion"][$key]["template".$key."[1]"],1);
                        if(!$makeTemplate1['status']){
                            return response()->json([
                                'status' => false ,
                                'msg' => $makeTemplate1['msg'],
                                ],Response::HTTP_BAD_REQUEST);
                        } else {
                            $templates[] = $makeTemplate1['data'];
                        }
                        if($data["accordion"][$key]["template".$key."[2]"]){
                            $makeTemplate2 = $this->createTemplate($data["accordion"][$key]["template".$key."[2]"],2);
                            if(!$makeTemplate2['status']){
                                return response()->json([
                                    'status' => false ,
                                    'msg' => $makeTemplate2['msg'],
                                    ],Response::HTTP_BAD_REQUEST);
                            } else {
                                $templates[] = $makeTemplate2['data'];
                            }
                        }
                        if($data["accordion"][$key]["template".$key."[3]"]){
                            $makeTemplate3 = $this->createTemplate($data["accordion"][$key]["template".$key."[3]"],3);
                            if(!$makeTemplate3['status']){
                                return response()->json([
                                    'status' => false ,
                                    'msg' => $makeTemplate3['msg'],
                                    ],Response::HTTP_BAD_REQUEST);
                            } else {
                                $templates[] = $makeTemplate3['data'];
                            }
                        }
                        $data = [
                            'token' => $request->sender,
                            'number' => $requestNumber,
                            'button' => json_encode($templates),
                            'text' => $message,
                            'footer' => $footer,
                            'image' => $url ?? '',
                        ];
                        if ($number->status == 'Disconnect') {
                            return response()->json(['status' => false, 'msg' => __('validation.sender_not_connected')], Response::HTTP_BAD_REQUEST);
                        }
                        $sendMessage = json_decode($this->postMsg($data, 'backend-send-template'));
                        if (!$sendMessage->status) {
                            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message],Response::HTTP_BAD_REQUEST);
                        }
                        $number->messages_sent += 1;
                        $number->save();
                        return response()->json(['status' => true, 'data' => $sendMessage->data],Response::HTTP_OK);
                    } elseif ($messageType == "list") { /* ---------- // ---------- LIST ---------- // ---------- */
                        $footer = $data["accordion"][$key]["footer$key"];
                        $message = $data["accordion"][$key]["message$key"];
                        $title = $data["accordion"][$key]["title$key"];
                        $buttontext = $data["accordion"][$key]["buttontext$key"];
                        $section['title'] = $title;
                        $i = 0;
                        $section['rows'][] = [
                            'title' => $data["accordion"][$key]["list".$key."[1]"],
                            'rowId' => 'id1',
                            'description' => ''
                        ];
                        if($data["accordion"][$key]["list".$key."[2]"]){
                            $i++;
                            $section['rows'][] = [
                                'title' => $data["accordion"][$key]["list".$key."[2]"],
                                'rowId' => 'id2',
                                'description' => ''
                            ];
                        }
                        if($data["accordion"][$key]["list".$key."[3]"]){
                            $i++;
                            $section['rows'][] = [
                                'title' => $data["accordion"][$key]["list".$key."[3]"],
                                'rowId' => 'id3',
                                'description' => ''
                            ];
                        }
                        if($data["accordion"][$key]["list".$key."[4]"]){
                            $i++;
                            $section['rows'][] = [
                                'title' => $data["accordion"][$key]["list".$key."[4]"],
                                'rowId' => 'id4',
                                'description' => ''
                            ];
                        }
                        if($data["accordion"][$key]["list".$key."[5]"]){
                            $i++;
                            $section['rows'][] = [
                                'title' => $data["accordion"][$key]["list".$key."[5]"],
                                'rowId' => 'id5',
                                'description' => ''
                            ];
                        }
                        $data = [
                            'token' => $request->sender,
                            'number' => $requestNumber,
                            'list' => json_encode($section),
                            'text' => $message,
                            'footer' => $footer,
                            'title' => $title,
                            'buttonText' => $buttontext,
                        ];
                        if ($number->status == 'Disconnect') {
                            return response()->json(['status' => false, 'msg' => __('validation.sender_not_connected')], Response::HTTP_BAD_REQUEST);
                        }
                        $sendMessage = json_decode($this->postMsg($data, 'backend-send-list'));
                        if (!$sendMessage->status) {
                            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message],Response::HTTP_BAD_REQUEST);
                        }
                        $number->messages_sent += 1;
                        $number->save();
                        return response()->json(['status' => true, 'data' => $sendMessage->data],Response::HTTP_OK);
                    }
                }
            } else {
                return response()->json([
                    'status' => false ,
                    'msg' => 'Token inválido',
                    ],Response::HTTP_BAD_REQUEST);
            }
        }
        
        
        
    }



    public function messageMedia(Request $request){
       
        if(!isset($request->url) || !isset($request->type)){
         return response()->json([
             'status' => false ,
             'msg' => __('validation.wrong_parameters'),
         ],Response::HTTP_BAD_REQUEST);
        }
        if(!in_array($request->type,['image','video','audio','pdf','xls','xlsx','doc','docx','zip'])){
            return response()->json([
                'status' => false ,
                'msg' => __('validation.invalid_type_media'),
            ],Response::HTTP_BAD_REQUEST);
        }
        $url = $request->url;
        $fileName = pathinfo($url, PATHINFO_FILENAME);
        $data = [
            'type' => $request->type,
            'token' => $request->sender,
            'url' => $request->url,
            'number' => $request->number,
            'caption' => $request->message,
            'fileName' => $fileName,
            'type' => $request->type
        ];
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false ,'msg' => __('validation.sender_not_connected')],Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-media'));
        if (!$sendMessage->status) {
            return response()->json( ['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data]);
    
       
     
     }
  


     public function messageButton(Request $request){
       
        if(!isset($request->button1) || !isset($request->footer)){
         return response()->json([
             'status' => false ,
             'msg' => __('validation.wrong_parameters'),
         ],Response::HTTP_BAD_REQUEST);
        }

        $buttons = [];
        $buttons[] = ['displayText' => $request->button1];
        if(isset($request->button2)){
            $buttons[] = ['displayText' => $request->button2];
        }
        if(isset($request->button3)){
            $buttons[] = ['displayText' => $request->button3];
        }
           

        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'button' => json_encode($buttons),
            'message' => $request->message,
            'footer' => $request->footer ,
            'image' => $request->image ?? '',
        ];
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false, 'msg' => __('validation.sender_not_connected')], Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-button'));
        if (!$sendMessage->status) {
            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message]);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data]);
       
        
     }
 
     public function messageTemplate(Request $request){
       if(!$request->has('template1') || !$request->has('footer')){
           return response()->json([
               'status' => false ,
               'msg' => __('validation.wrong_parameters'),
           ],Response::HTTP_BAD_REQUEST);
       }

        $templates = [];
        $makeTemplate1 = $this->createTemplate($request->template1,1);
        if(!$makeTemplate1['status']){
           return response()->json([
              'status' => false ,
              'msg' => $makeTemplate1['msg'],
           ],Response::HTTP_BAD_REQUEST);
        } else {
            $templates[] = $makeTemplate1['data'];
        }
        if($request->has('template2')){
            $makeTemplate2 = $this->createTemplate($request->template2,2);
            if(!$makeTemplate2['status']){
                return response()->json([
                    'status' => false ,
                    'msg' => $makeTemplate2['msg'],
                ],Response::HTTP_BAD_REQUEST);
            } else {
                $templates[] = $makeTemplate2['data'];
            }
        }
        if($request->has('template3')){
            $makeTemplate3 = $this->createTemplate($request->template3,3);
            if(!$makeTemplate3['status']){
                return response()->json([
                    'status' => false ,
                    'msg' => $makeTemplate3['msg'],
                ],Response::HTTP_BAD_REQUEST);
            } else {
                $templates[] = $makeTemplate3['data'];
            }
        }
      
      
        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'button' => json_encode($templates),
            'text' => $request->message,
            'footer' => $request->footer,
            'image' => $request->image ?? '',
        ];

        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false, 'msg' => __('validation.sender_not_connected')], Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-template'));
        if (!$sendMessage->status) {
            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message],Response::HTTP_BAD_REQUEST);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data],Response::HTTP_OK);
     }

     public function messageList(Request $request){
        if(!$request->has('list1') || !$request->has('footer') || !$request->has('title') || !$request->has('name')){
            return response()->json([
                'status' => false ,
                'msg' => __('validation.wrong_parameters'),
            ],Response::HTTP_BAD_REQUEST);
        }

        $section['title'] = $request->title;

        $i = 0;
        $section['rows'][] = [
            'title' => $request->list1,
            'rowId' => 'id1',
            'description' => '' 
        ];
        if($request->has('list2')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list2,
                'rowId' => 'id2',
                'description' => '' 
            ];
        }
        if($request->has('list3')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list3,
                'rowId' => 'id3',
                'description' => '' 
            ];
        }
        if($request->has('list4')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list4,
                'rowId' => 'id4',
                'description' => '' 
            ];
        }
        if($request->has('list5')){
            $i++;
            $section['rows'][] = [
                'title' => $request->list5,
                'rowId' => 'id5',
                'description' => '' 
            ];
        }
       

        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'list' => json_encode($section),
            'text' => $request->message,
            'footer' => $request->footer,
            'title' => $request->title,
            'buttonText' => $request->name,
        ];
       
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json(['status' => false, 'msg' => __('validation.sender_not_connected')], Response::HTTP_BAD_REQUEST);
        }
        $sendMessage = json_decode($this->postMsg($data, 'backend-send-list'));
        if (!$sendMessage->status) {
            return response()->json(['status' => false, 'msg' => $sendMessage->msg ?? $sendMessage->message],Response::HTTP_BAD_REQUEST);
        }
        $number->messages_sent += 1;
        $number->save();
        return response()->json(['status' => true, 'data' => $sendMessage->data],Response::HTTP_OK);

     
       
     }


    public function createTemplate($template,$no){
        try {
            //code...
            $allowType = ['callButton', 'urlButton', 'idButton'];
            $type = explode('|', $template)[0] . 'Button';
            $text = explode('|', $template)[1];
            $urlOrNumber = explode('|', $template)[2];
    
            if (!in_array($type, $allowType)) {
                return ['status' => false, 'msg' => __('validation.wrong_type_template').$no];
            }
    
            $ty = explode('|', $template)[0];
            $type = $ty ==  'id' ? 'quickReplyButton' : $type;
            if ($ty == 'url') {
                $typePurpose = 'url';
            } else if ($ty == 'call') {
                $typePurpose = 'phoneNumber';
            } else {
                $typePurpose = 'id';
            }

             

            $data = ["index" => $no, $type => ["displayText" => $text, $typePurpose => $urlOrNumber]];
            return ['status' => true, 'data' => $data];
        } catch (\Throwable $th) {
            return [
                'status' => false,
                'msg' => __('validation.not_valid_type_template').$no,
            ];
        }
        
    }


    public function postMsg($data, $url)
    {
        try {

            $post = Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER') . '/' . $url, $data);
            return $post->body();
            if (json_decode($post)->status === true) {
                $c = Number::whereBody($data['sender'])->first();
                $c->messages_sent += 1;
                $c->save();
            }
            return $post;
        } catch (\Throwable $th) {
            return json_encode(['status' => false, 'msg' => __('validation.node_already_running')]);
        }
    }



    public function generateQr(Request $request){
        if(!$request->has('number') || !$request->has('api_key')){
            return response()->json([
                'status' => false ,
                'msg' => __('validation.wrong_parameters'),
            ],Response::HTTP_BAD_REQUEST);
        }
       // check user by api key
        $user = User::whereApiKey($request->api_key)->first();
        if($user->is_expired_subscription){
            return response()->json([
                'status' => false ,
                'msg' => __('system.subscription_expired'),
            ],Response::HTTP_BAD_REQUEST);
        }
        if(!$user){
            return response()->json(['status' => false, 'msg' => __('validation.wrong_api_key')],Response::HTTP_BAD_REQUEST);
        }
        $number = Number::whereBody($request->number)->first();
        $allnumber = Number::whereUserId($user->id)->get();
        if(!$number){
            if($user->limit_device <= count($allnumber) ){
                return response()->json(['status' => false, 'msg' => __('validation.reached_limit_devices')],Response::HTTP_BAD_REQUEST);
            }
            $number = new Number();
            $number->body = $request->number;
            $number->user_id = $user->id;
            $number->status = 'Disconnect';
            $number->save();
        }
        try {
            //code...
            $post = Http::withOptions(['verify' => false])->asForm()->post(env('WA_URL_SERVER') . '/backend-generate-qr', [
                'token' => $request->number,
            ]);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'msg' => __('validation.node_already_running')],Response::HTTP_BAD_REQUEST);
        }
     // send respon json from post
     return response()->json(json_decode($post->body()),Response::HTTP_OK);
        
       
    }
    
    // Webhook
    public function messageWebhook(Request $request)
    {
        $data = [
            'token' => $request->sender,
            'number' => $request->number,
            'text' => $request->message
        ];
        $number = Number::whereBody($request->sender)->first();
        if ($number->status == 'Disconnect') {
            return response()->json([
                'status' => false ,
                'msg' => __('validation.sender_not_connected'),
            ],Response::HTTP_BAD_REQUEST);
         }

        $sendMessage = json_decode($this->postMsg($data, 'backend-send-text'));
        if (!$sendMessage->status) {
            return response()->json([
                'status' => false ,
                'msg' => $sendMessage->msg ?? $sendMessage->message,
            ],Response::HTTP_BAD_REQUEST);
         }
        $number->messages_sent += 1;
        $number->save();
        
        return response()->json([
            'status' => true ,
            'data' => $sendMessage->data,
        ],Response::HTTP_OK);
        
    
    }
}
