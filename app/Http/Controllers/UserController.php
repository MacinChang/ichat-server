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
    	return 'true';
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
		return json_encode($res[0]);
	}
	//测试-添加好友
	public function getAddContact(){
		return \View::make('add_contact');
	}

	//添加好友
	public function anyAddContact(Request $request){
		$from = $request->input('from');
		$to = $request->input('to');
		//$info = $request -> input('info');
		$remark = $request -> input('remark');
		$class_id1 = $request -> input('class_id');
		$res = \DB::table('user_class') -> where('account', $to) -> first();
		$class_id2 = $res -> Id;
		$res1 = \DB::table('contact_relation') -> insert(array('user_id' => $from, 'contact_id' => $to, 'class_id' => $class_id1, 'remark' => $remark));
		$res2 = \DB::table('contact_relation') -> insert(array('user_id' => $to, 'contact_id' => $from, 'class_id' => $class_id2, 'remark' => 'noremark'));
		if($res1 && $res2){
			return  'true';
		}else{
			return 'false';
		}
	}
	//通过好友请求
	public function postPassRequest(Request $request){
		$id = $request->input('id');

	}
	//删除好友
	public function anyDelContact(Request $request){
		$user_id = $request->input('user_id');
		$contact_id = $request->input('contact_id');
		//删除好友关系
		$res1 = \DB::table('contact_relation') -> where('user_id', $user_id) 
					-> where('contact_id', $contact_id) -> delete();
		$res2 = \DB::table('contact_relation') -> where('user_id',  $contact_id)
					->  where('contact_id', $user_id) -> delete();
		if($res1 && $res2){
			return 'true';
		}else{
			return 'false';
		}
	}

	//加载主面板
	public function anyLoadPanel(Request $request){
		$account =  $request->input('account');
		$self = \DB::table('user') -> where('account', $account) 
			-> select('account', 'nickname', 'head', 'level', 'age', 'gender', 'signature', 'state') ->first();
		$res_class = \DB::table('user_class') -> where('account', $account) 
						-> orderBy('Id', 'ASC') -> get();
		$class = array();
		//$i = $res[0] -> Id;
		$i  = 0;
		$contacts = array();
		//return  $res_class;
		foreach($res_class as $node_class){
			$classname = $res_class[$i] -> name;
			$class_id = $res_class[$i] -> Id;
			$res_contact = \DB::table('contact_relation') -> where('class_id', $node_class -> Id) -> get();
			//return $res_contact;
			if($res_contact == NULL){
				//return 1;
				$contacts = array('classname' => $classname, 'class_id' => $class_id, 'contact' => 'null');
				array_push($class, $contacts);
				//return $class;
				$contacts = array();
				$i++;
				continue;
			}
			foreach($res_contact as $node_contact){
				$temp = \DB::table('user') -> where('account', $node_contact -> contact_id) 
					-> select('account', 'nickname', 'head', 'level', 'age', 'gender', 'signature', 'state') ->get();
				$temp = (array)$temp[0];
				$temp['remark'] = $node_contact -> remark;
				array_push($contacts, $temp);
				//return $contacts;
			}
			$contacts = array('classname' => $classname, 'class_id' => $class_id, 'contact' => $contacts);
			array_push($class, $contacts);
			//return  $contacts;
			$contacts = array();
			$i++;
		}
		$data = array('self' => (array)$self, 'contact' => $class);
		// echo '<pre>';
		// print_r($data);
		// echo '</pre>';
		return json_encode($data);
		//加载分组和组内好友
	}
	//加载资料卡
	public function anyGetInfo(Request $request){
		$account = $request->input('account');
		$res =  \DB::table('user') -> where('account', $account) -> get();
		return json_encode($res[0]);
		//return 1;
		//获取账号资料
	}
	//设置头像
	public function anySetHead(Request $request){
		$account = $request -> input('account');
		$head = $request -> input('head');
		$res = \DB::table('user') -> where('account', $account) -> update(array('head' => $head));
		if($res){
			echo $head;
			return 'true';
		}else{
			return 'false';
		}
	}
	//设置状态
	public function anySetState(Request $request){
		$account = $request -> input('account');
		$state = $request -> input('state');
		$res = \DB::table('user') ->  where('account', $account) -> update(array('state' => $state));
		if($res){
			return 'true';
		}else{
			return  'fasle';
		}
	}
	//设置备注
	public function anySetRemark(Request $request){
		$user_id = $request -> input('user_id');
		$contact_id = $request -> input('contact_id');
		$remark = $request -> input('remark');
		$res = \DB::table('contact_relation') -> where('user_id', $user_id)
		 -> where('contact_id', $contact_id) -> update(array('remark' => $remark));
		if($res){
			return 'true';
		}else{
			return  'fasle';
		}
	}
	//更改分组名
	public function anySetClassname(Request $request){
		$account = $request -> input('account');
		$class_id = $request -> input('class_id');
		$name = $request -> input('classname');
		$res = \DB::table('user_class') -> where('Id', $class_id) -> update(array('name' => $name));
		if($res){
			//echo mysql_error();
			return 'true';
		}else{
			return  'fasle';
		}
	}
	//删除分组
	public function anyDelClass(Request $request){
		$account = $request -> input('account');
		$class_id = $request -> input('class_id');
		$res = \DB::table('contact_relation') -> where('user_id', $account) -> select('class_id') -> first();
		$id = $res -> class_id;
		$res = \DB::table('contact_relation') -> where('user_id',  $account) 
			-> where('class_id', $class_id) -> update(array('class_id' => $id));
		$res = \DB::table('user_class') -> where('Id', $class_id) -> delete();
		if($res){
			return 'true';
		}else{
			return  'fasle';
		}
	}
	//新建分组
	public function anyNewClass(Request $request){
		$account = $request -> input('account');
		$name = $request -> input('classname');
		$res = \DB::table('user_class') -> insert(array('name' => $name, 'account' => $account));
		//echo $res;
		if($res){
			$res = \DB::table('user_class') -> where('account', $account) -> where('name', $name) -> select('Id') -> first();
			return  $res -> Id;	
		}
	}

	//设置个人资料
	public function anySetInfo(Request $request){

		$account = $request -> input('account');
		$gender = $request -> input('gender');
		$signature = $request -> input('signature');
		$nickname = $request -> input('nickname');
		$phone = $request -> input('phone');
		$age = $request -> input('age');
		//$level = $request -> input('level');
		$home = $request -> input('home');
		$location = $request -> input('location');
		$birth = $request -> input('birth');
		$data = array('account' => $account, 'gender' => $gender, 'nickname' => $nickname, 
				'phone' => $phone, 'age' => $age, 'hometown' => $home, 
				'location' => $location, 'birth' => $birth, 'signature' => $signature);
		//return  $data;
		$res = \DB::table('user') -> where('account', $account) -> update($data);

	}
	//修改分组
	public function anySetClass(Request $request){
		$user_id = $request -> input('user_id');
		$contact_id = $request -> input('contact_id');
		$class_id = $request -> input('class_id');
		//echo $user_id;
		$res = \DB::table('contact_relation') -> where('user_id', $user_id) 
			-> where('contact_id', $contact_id) -> update(array('class_id' => $class_id));
		if($res){
			return 'true';
		}else{
			//mysql_error();
			return 'false';
		}
	}
	//刷新消息
	public function postUpdate(){
		//检测新的个人消息

		//检测新的群消息
		//检测新的好友申请
		//检测新的加群申请
	}
}