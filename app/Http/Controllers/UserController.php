<?php 
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;
use App\Page;
class UserController extends Controller {

    /**
     * 显示所给定的用户个人数据。
     *
     * @param  int  $id
     * @return Response
     */

    public function getUserList(){
    	$res = \DB::table('user') -> get();
    	echo '<pre>';
    	print_r($res);
    	echo '</pre>';

    }
    public function getLogin(){
    	return \View::make('login');
    }
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
				return  'true';
			}
			return 'false';
		}
    }
    public function getRegister(){
		return \View::make('register');
    	//return rand(1001, 100000);
    	//return 'register';
	}
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
    	return $user;
	}

    public function getFindContact(Request $request){
		$account = $request->input('account');
		$res =  \DB::table('user') -> where('account', $account) -> get();
		return $res;
	}

	public function getAddContact(){
		return \View::make('add_contact');
	}

	public function postAddContact(Request $request){
		$from = $request->input('from');
		$to = $request->input('to');
		$cache = array('from' => $from, 'to' => $to, 'time' => time());
		\DB::table('cache_add_contact') -> insert($cache);
		return $cache;
	}

	//public function 

}