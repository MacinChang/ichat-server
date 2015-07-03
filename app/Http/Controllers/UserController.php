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
    public function getLogin(){
    	return \View::make('login');
    }
    public function postLogin(Request $request)
    {
        $account = $request->input('account');
		//$password = Hash::make(Input::get('password'));
		$password = $request->input('password');
		$res = \DB::table('user') -> where('account', $account) -> where('password', $password) -> get();
		if($res == NULL){
			return 'false';
		}
		else{
			return 'true';
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
		return $user;
	}

    public function postFindContact(){
		$account = Input::get('account');
		$res =  DB::table('user') -> where('account', $account) -> get();
		return $res;
	}
	
	//public 	


}