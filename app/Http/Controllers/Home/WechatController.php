<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cache;
use Auth;
use App\User;
use Storage;
use Endroid\QrCode\QrCode;

class WechatController extends Controller
{

    public function wechat_web_login()
    {
        if(Auth::check()){
            return redirect('/home');
        }
        return view('wechat_web_login');
    }
    public function api_web_login()
    {
        $code = request()->code;


        if((!$code)||!Cache::has($code)){
            $code = uniqid();
            $filename =$code.'.png';
            Cache::put($code,'login',10);
            $qrCode = new QrCode("http://wechat-scan-login.jc91715.top/wechat/{$code}/login");
            \Log::info(storage_path('app/public/'.$filename));
            $qrCode->writeFile(storage_path('app/public/'.$filename));
        }
        $filename =$code.'.png';
        $msg ='请扫码登录';
        $errorCode=1;
        if(Cache::has($code.'login_state')){
            $login_state = Cache::get($code.'login_state');
            switch ($login_state){
                case 'scan':
                    $errorCode =1;
                    $msg = '已扫描';
                    break;
                case 'cancel':
                    $errorCode = 1;
                    $msg = '已取消';
                    break;
                case 'confirm':
                    $errorCode=0;
                    $msg = '已确认登录';
                    break;
            }
        }
        return json_encode(['errorCode'=>$errorCode,'code'=>$code,'msg'=>$msg,'qrcode_url'=>asset('storage/'.$filename),'redirect'=>route('web.login').'?code='.$code]);
    }
    public function web_login()
    {
        $code = request()->code;
        if(!Cache::has($code)){
            abort(404);
        }
        if(!Cache::has($code.'login_state')){
            abort(404);
        }
        if(Cache::get($code.'login_state')!='confirm'){
            abort(404);
        }
        $user = User::where('rand_key',$code)->first();
        if(!$user){
            abort(404,'code 失效');
        }
        Cache::forget($code);
        Auth::login($user);
        return redirect()->to(route('home'));
    }

   public function login_code_state($code)
   {
       if (!Cache::has($code)) {
           return json_encode(['errorCode'=>1,'msg'=>'登陆已过期']);
       }
       Cache::put($code.'login_state','scan',10);
       return json_encode(['errorCode'=>0,'msg'=>'ok']);

   }

   public function confirm_login()
   {
        $code = request()->input('code');
        if(!$code){
            return json_encode(['errorCode'=>1,'msg'=>'缺少参数']);
        }
       if (!Cache::has($code)) {
           return json_encode(['errorCode'=>1,'msg'=>'登陆已过期']);
       }
        $user = Auth::user();
        $user->rand_key = $code;
        $user->save();
        Cache::put($code.'login_state','confirm',10);

       return json_encode(['errorCode'=>0,'msg'=>'已确认登陆']);


   }
   public function cancel_login()
   {
       $code = request()->input('code');
       if(!$code){
           return json_encode(['errorCode'=>1,'msg'=>'缺少参数']);
       }
       if (!Cache::has($code)) {
           return json_encode(['errorCode'=>1,'msg'=>'登陆已过期']);
       }
       Cache::put($code.'login_state','cancel',10);

       return json_encode(['errorCode'=>0,'msg'=>'已取消登陆']);
   }
}
