<?php 
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
//use Illuminate\Database\Seeder;
//use App\Page;
class UserController extends Controller {

    /**
     * 显示所给定的用户个人数据。
     *
     * @param  int  $id
     * @return Response
     */
    //测试-用户列表
    public function getUserList(){
    	$res = \DB::table('user') -> get();
    	echo '<pre>';
    	print_r($res);
    	echo '</pre>';
    }
    //测试-登录界面
    public function getLogin(){
    	return \View::make('login');
    }

    //用户登录
    public function postLogin(Request $request)
    {
        $account = $request->input('account');
		$password = $request->input('password');
		//$password = $request->input('password');
		$res = \DB::table('user') -> where('account', $account) -> get();
		if($res == NULL){
			return 'false';
		}
		else{
			//$res = array($res);
			$hash = $res[0]->password;
			if(crypt($password, $hash) == $hash){
				\DB::table('user') -> where('account', $account) -> update(array('state' => 1));
				return  'true';
			}
			return 'false';
		}
    }
    //注册界面
    public function getRegister(){
		return \View::make('register');
    	//return rand(1001, 100000);
    	//return 'register';
	}

	//注册用户
	public function postRegister(Request $request){
		$nick = $request->input('nick');
		$password = \Hash::make($request->input('password'));
		$phone = $request->input('phone');
		$account = rand(10001, 99999);
		$res = \DB::table('user') -> where('account', $account) -> get();
		while($res != NULL){
			$account = rand(10001, 99999);
			$res = \DB::table('user') -> where('account', $account) -> get();
		}
		$user = array('account' => $account, 'password' => $password, 'phone' => $phone, 'nickname' => $nick);
		\DB::table('user') -> insert($user);
		echo '<pre>';
    	print_r($user);
    	echo '</pre>';
    	//return $user;
	}

	//查找好友
    public function anyFindContact(Request $request){
		$account = $request->input('account');
		$res =  \DB::table('user') -> where('account', $account) -> get();
		$data = array($res[0]);
		return json_encode($data);
	}
	//测试-添加好友
	public function getAddContact(){
		return \View::make('add_contact');
	}

	//发送添加好友请求
	public function postAddContact(Request $request){
		$from = $request->input('from');
		$to = $request->input('to');
		date_default_timezone_set('PRC');
		$cache = array('from' => $from, 'to' => $to, 'time' => date('Y-m-d H:i:s', time()));
		$res = \DB::table('cache_add_contact') -> where('from', $from) -> where('to', $to) -> first();
		if($res == NULL){
			\DB::table('cache_add_contact') -> insert($cache);	
		}
		else{
			\DB::table('cache_add_contact') -> where('from', $from) -> where('to', $to) -> update($cache);
		}
		$res = \DB::table('cache_add_contact') -> where('from', $from) -> where('to', $to) -> get();
		return $res;
	}
	//通过好友请求
	public function postPassRequest(Request $request){
		$id = $request->input('id');

	}
	//删除好友
	public function postDeleteContact(Request $request){
		$user_id = $request->input('user_id');
		$contact_id = $request->input('contact_id');
		//删除好友关系
	}

	//加载主面板
	public function postLoadPanel(Request $request){
		$account =  $request->input('account');
		$res = \DB::table('contact_relation') -> where('user_id', $account) -> orderBy('class_id', 'ASC') -> get();
		//加载分组和组内好友
	}
	//加载资料卡
	public function anyGetInfo(Request $request){
		$account = $request->input('account');
		$res = \DB::table('user') -> where('account', $account) -> get();
		return $res;
		//获取账号资料
	}

	//刷新消息
	public function postUpdate(){
		//检测新的个人消息
		//检测新的群消息
		//检测新的好友申请
		//检测新的加群申请
	}
}