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
    public function getLogin(Request $request)
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
    	//return 'register';
	}
	public function postRegister(){
		return 'success';
	}
    public function anyFindContact(){
			$account = Input::get('account');
			$res =  DB::table('user') -> where('account', $account) -> get();
			return $res;
		}

}