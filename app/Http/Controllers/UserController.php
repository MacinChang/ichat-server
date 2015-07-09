<?php 
namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
//use Request;
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
		//$ip = $_SERVER['REQUEST_URI'];
		$ip = getenv('REMOTE_ADDR');
		echo "{$ip} ";
		//echo $ip;
		//$password = $request->input('password');
		$res = \DB::table('user') -> where('account', $account) -> get();
		if($res == NULL){
			return 'false';
		}
		else{
			//$res = array($res);
			$hash = $res[0]->password;
			if(crypt($password, $hash) == $hash){
				\DB::table('user') -> where('account', $account) -> update(array('state' => 1, 'address' => $ip));
				return  'true';
			}
			return 'false';
		}
    }
    //设置端口
    public function anySetPort(Request $request){
    	$account = $request -> input('account');
    	$port = $request -> input('port');
    	//echo "$port";
    	$res = \DB::table('user') -> where('account', $account) -> update(array('port' => $port));
    	return 'true';
    }
    //注册界面
    public function getRegister(){
		return \View::make('register_1');
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
		}		$head = "AABkyXgB7XwJPJVd1/clJFJuZWgwhTJlOpzMJBkLmYcMHRw6Zo55OkUoZAwls8xTRDInZYrInBQiMmae4pz3OjS4z93tuZ/3eb/3-32/z6kr19prr7X3/q9hr737OZhezCDwh4KMvAyAh4cHyIF/AAz6PJ-24mVhYxsrLpiJjRGcy8XKVphBVMLFFmZsAXdgMIKbIazFGCUYGRAmYoxaUEUeRVsp-HWEnJs9XM1NSd3YzcJYyIRRQpxE1EUYlLWCO8AYXKwsrZHCLmKMWyqFwXdsMzcjw1YXBwsxRknsWAzailcYpGzs4QxQLiinMQ8vP4OAEBcvlJdfkPcsA4SHl4-bh4-bl4-TFyLMIyTMC2X4/mEUJwHfRO1NTIVVL8p8Hw6kxBivOzjYCnNzOzs7cznzcdnYm3HzCgkJcfNAuCEQTrAHJ9LV2gHmwmmNZNpW8kPPRTjS2B5h64CwsWbA6oUZ2Tg6iDEyYgf6-fm-LivbnwNZI7/DBgLI7QKz5ebl4uH-nZCJ8U8ZW0d7y62pmRhzwy3hVnBrByQox/tbORBSRcWfor8dzsrqt5JIB2kncAXfEfmtJFLd1RbOrQpH2jjaG8OlncCZMP1u8kgHVfgvcP-BKrD7bxXZXrdxsEFet/kbAH-y/xZGB4Tp30wEy/lbMbgL4m/EsJxtsS2f2ja1KDYIpOzhMAcbe3UbG0vxbXe98mP2DFJSDKxaCGsTG2ckmyg3bu9fPvNLEfwizAEuDvo0lJNHgJOHTx10aAiPMD-Eg0dQmIdnh5Ltnjg6FMH4MYE5wH6vBSq0U8uf-uLqsTFBmLr-Iy2/eu7QYWIsbGpjbwVzEEdYwczg3LbWZqLcvxp39NxyXGF5a6QDzNoYLn9RHGzgQiBMhCEQIX4jISick18Aws9pJMgvxAmDmwpy8vJDTQQEIbxQCJxvCw5FxZ3if1F90cbYERs731WbgKr5eWEQIx44Dyc4hBAnrym/ACfMmE-AU8hUCERewNgELiT4Q/UO8b-oVrZHgFkPZrmjD3b2/-4Qv1Hzl6HkEEjQyVx3OB/ogluZTQ1u9-fWHwxLxFaGsoXZI-HYABZj/BHBP1Paz4yFldlKBMIwY2xuEzfGejXcRJT7T62/pvVT8rsY4q8G/Gcob-vfIf73Yzhfh1vvFhrbqrZ6/b0SpI2pgzPMHi5pBvrEvwjYbYV/lsDVLMqN3QYsEf8HbICEOf1nFuDlPcdjDDPh5eSHCpwDvZvfiFOIj4eHE27MxwPnFzAxOsf708L/gQV-pZX/Kxb45bvG12HWZnATce4fbvuj4X/RaMY21k5w-38ndMAAhYF1D9weKW5qb2PFALO1tUQYw7BhyO1kbfK9cPi55zE42DDsSKrbkO/Q8b-4VhO4PeLfcdEds/wJE8P/Y2v-j4Pyn-1r22bdC0qG7fz6503ux978100RW0iB9cDFbceUwYYTNj3/6z0Q3MbAYlR4B-A/6pB/mkRxxP8Uht-1m/x3S5Htye0Q/512m/-0Gtke5Tdqfo32A/kdAO/Y-ER/JinhHyWRJFjUYSsX5I5u2ISNtcoFmNmfW38wwN30Rx0lKQOVOifFKwnhk5Hh5ZXmk4Ty8AhKgfvaRWlJbBX4--13u/XP-kW5/9nsdixCysbSxl7RxgQuDlaav6R/Ne8A5hdbXkrqir2NKcISLo5Ulb3AIC8tdY5X6Nw5TggXON3f9tuhB3s-EQYrQrA62doCxEGZv7Th9tfGVnaWjluVmwCEB/xw82L//S66k40rqrO76E42rugvSQ1rhIM45PtoOM07pLCHKOEt9NTAawM4dmm4Tbi9ryBc4JbaFxFgBY/E1qUQQf7vQric30rq/K3kDs53yW2n2XHA33LO7Vbw-gC8ueD-eXXxF7/9WQ//T778WtL/pFYcXXuD4ACyO7kH1-744HD34MIBZHdyD67d8cHh7sGFA8ju5B5cu-ODw92DCweQ3ck9uHbHB4e7BxcOILuTe3Dtjg8Odw8uHEB2J/fg2h0fHO4eXDiA7E7uwbU7PjjcPbhwANmd3INrd3xwuHtw4QCyO7kH1-744HD34MIBZHdyD67d8cHh7sGFA8ju5B5cu-ODw92DCweQ3ck9uHbHB4e7BxcOILuTe3Dtjg8Odw8uHEB2J/fg2h0fHO4eXDiA7E7uwbU7PjjcPbhwANmd3INrd3xwuHtw4QCyO7kH1-744HD34MIBZHdyD67d8cHh7sGFA8ju5B5cu-ODw92DCweQ3cld4SL59VUAcGvwGwCcwV/1x7wHpIAD-/cT7Sc8QEREREx8gISU4hDpwYOkx48cJaOgPUFPR3uChoaBmYuFgfEsEw0NqwDbWfC3-/n56VmExAQholx8/BCsEjxiYmLSg6THDh06BjlFcwryb38wzwHyA3g0eDT4eIzAPnI8fHI8zEuAHgDwCMGvOMB-y8H3D94-fALC/UQHiEkOgh2K/wD24eHj7yPAJyQkIAB7e4J8gICc8MgpXsn9R1VgRIx2FJCbYUkHmC4U1FCqvp1l5jOy9yYmoaI-dvzE6TMsrGzs/NBzAoJCwlIXpWVk5eQV1NQ1NLW0dXTB3zE2NbuOMEc6ODo5u7i6-dzy9fO/fScgPOJeZFT0/QcxySmPUtPSMzKzCp8UFT8teVZa9qL25au6-obGpvaOzq7unt53fUOfhkc-j459GZ-Ym19YXFpeWV1bx64LD8DfXtbPleGsixxc1z4CAnwCIuy68PY5gw8-OQHhKd79RyRViGB2RxkhNw9QXAhLKqghZuJTnaU0sn9LQsXMP3R6Dru0rZX9s4V5/7dW9nNhv9bVB5Di44HGwycHJICVddaMPC5YUYnrDLP2J8koU8F9EQjzugjrhqjCYlq3vudrFt/WyrN4Xiy0xdfnGpsbMMWM8fZZ-3GJWwej/nChH-t7PCmkPuXGzyOwkrVZl9p6G3owrEjhlCrPRSn6fMPujNeOdsKEMZ90KGhuzMi1Dl95q3Pu3ReZWKbZR8fo7l1zU5FmrMVvDyJTYE3E/-1PtvNna9SPKAOHFx/K6/t5E56t0bBXBkh6SzpOUc1E8z5Kk2afqGUiKhZvariat1JzDwMMF9tXHRVppXX6AvuQWOKJAQa9zDgVot/SKX7KJ5FPvmxtda/SJ55MjRw9vrwIbbnmplXZQop8MdscyGx9rpCngbEi-5UBZcTF-/3v90coI2smjCQ-iH/0K4cEDbxPvVC-UiaOAWZRfO-eD2tcUsuslh1AEzcPuqncHJemXGTJNvm-LLzfvkSat6pWd5Rs-i2P9jTXYQBGTcXe8Vg6t4Q3WW-VponrOHVSsgtX736yOBfoON9ff2J6fuyOHCyI9DHena-xY2JIfbroOafzNVArqEKUUNTbx-fr8Y3plNxnaOitPeoC2qFZsqZ2Xa9ti71YuaMSwharEjJ1zJ8GOsKQtC9ZVlMsBwdpyDtpyGtGNLLWamV6HGn3LVlbcp3ge0YdFFF4ha-W265x5fjw/srAFwYihXNnXstHT/WFXi4ym5GTQT4eE9tv63r8q7fF0yhGvrdfWmPq4ZS2PbFiX9AcPRtvngaw5vk0kCyEnJhMsK5Ev7n5xMZ6QFyLoAFCJu6T3iPmkpfwqqwDIWzQoLyu-EblsBw77-t9IkFByM6xYldHF9enXK97ZcfQsiWRMOvNiirD0evahmsufsbzqIP0QxhgUrMSSZkEQ33-dDykceMsyh8D5Oqt0jjmKqUsmmVqRvfdyZem0Cq096VQOU/481G9oX0Dj3kWSCqK7AUI77N7yw/ifXyak-P77OMqJGHDuS/w5Cnr8oH9ahgguKtpVfSriIvf7KrzjOO210AVYvs4vQNY8-/zkpg8rhflJm0olBnMZiL1FmNbvPJQ6QsZy5yhr8nbMwLnah519M-63Q9ZUS5JyjOtnLlu/Mx36AGVXL-VCSxU2lUroILjzB3e0qeHzsSP-XS-RJV5Vh7yjFd5mDV-JWdzJqR6g755ZVbwK-JbWYgBSB19kBzA8UVZnTU5ANj5sF-1eGA5M1R2c1nxYE7YU7xa/FBblwl2dtaj8tl8X0IOTs65REj5rQne85px6DuvAxDemKxnCFYmcG6x7LmxyvEyd6jS7jTyodAc5XPmIS0JFH6mgTsdMe2CwaZBKklVu/CMh7iZ93quBbfvRPXrEVezIG7fldtpB9RTn/3BBgTHIROWA8lePDZ/kwrpN4-OSDxlEi8LLNUYmRd7eLqWdt1L0GxNTiIkUQn4EqoiTXknE8dgukvNmr6-GCD6tqkEy2wBmh5d7H7suw2huobmZyopVAwamyhUpAEKFQU8I4Ag4vk-v3atawDVNQpsDlgqhptw1m1HeZGOzkG7ylm4xOq0Xr7Pm4WS2zZk/l5jWgNoolGkemZLci8I3JrPH8kBrAD2SVMkdf6jgo-x8eTdnCDIgfS3F6xEEkUfYkNdChvqnmKtRJm3MYADBpDS63Lvb6u3O1gLORv2rK-hliFgPoHSRVPxsDHS8sQlIlEBbPJA-1W1srZ0OWR0e62ASYBs1H2Vxrlo84PiOjZBKJmDfpMkduXH8D9-5rvPHs4oS/fJCdZqfmr4RI5SjkTNd7Jzuk9JsHGDo4ajelbg7uLAoetPdD5KOjOH2Lf7kLAdY08pP-ylpn/MNaNVP4RJKHES1sNeroiqYXuNLlNeaV1IU/uMAfRZvo2tdXB8jp9qF2FIDmAjxTpO2-Pq-TnS-hE0lUQtBujOdRs9f9Z2v3xeivTbYp1PeIMw4m/B/cZgMBl06wfEVjueRkksCNopxUm4lh9KLiHynSlonsVfkhi6hAEOVLZubNSsYwBfd5rCKVtP-xAk6b6XWzF1VVPzQr-Nx3FltIjmtIcEtIB79HnrBLK-PRdl2o8BWuUk-AwF4lSbCySe1XaY0xrEoEW8TKG8oVF3vmgm52CAH51kl61aNxZ9FqALEhPLcAwgXk2JNjXUTu/PldZBt5RigPhQL9OQqfcJa-NEo9cxgNYT7rWl1fwFshy1mT8pUrTguF-zRpAwQz-XES91vwYprDyLAXg0xqseUaiaHSq-qUmrPouwaIo9TWzfohOTFlNGwpr8CHY55tjMKRdT6XCBkzraJuTKybf6nM-7CmCD1x8bvKd37BvYXeOnQ-VADuSzzWn5mrSNYnPBY2StIy/9TMIXi6n5oA9aCnfNvjpgUwrarPpmvbvyh86BlK8YgGA0Izlg/WgXOPSNn4/9YlpHdCq/seGgyHFUjzx6De3Q5FE9-QgDeGAAYbjH5IdYlXdghpODnSeIPVykWe2Xo4kB9LwFvgU409fGtMfSymdwpWlksav3D0hlzbb6JRWVBC/P86wchtyuvUUb0l3mLZ84Xx9EovDtstiBK963yOeKs5Vy-kdfBLDmNnsHsCbu2/HsB4OGrVAlQYZW2qTxZA1bgFJKpMRHuuIn6kustbp3ztdeRCZYLy28Q2soU/tHyuV7sY-vlEi5QfVOj6iAGWx-oWNrYSa/gqkJDCZPKaR9VIGNl/y37P6Ybt8TxVl1cRT9D9s/NMZ2UvPHhYtmv4o/LnyoqeWgdWHc7RCWUakexNIy9I2WxhxkVKdI0NT01Kv2Yfra-RKFoSnuV-1THsQ3MEBV5eRSg8lqhTgJJYc4gjvgg0Rry4pYRQK/dpnBilN0XLXqEoWKnuzT7fQCppjP44rp3ArX66qfO0EwQF7E5sLG-L21H6Cv9ZQLphSC0w99UYbCRzVYYoBnqLA8o51EBdm3ZjEl0drNPlSPWtv15IBvUsMgjtsQZvfr11teiK24ZetT0tOeFiVJwX0KTXimQM2uORjJNF9XQfpNwNWTOTPf66qr68O21Gm6ciqlJAelCxeIkggS3qT7XNGhYW78XDpI81keHSkTdg8SKXbIw-9kAG/nxIJ6NL9bNndtQdfZsyfa3o9PS2sW3Gu5LkBTRpvj6cne4hV2ochC9a62ZVerWFrcfQ33hRKlUvHb5q80O8k2LnGhJuOOhQwpv0Vfpho1tw9cBAvkfsNU4WpK9/gmEtYMa2vVbs4ZVwlHWTXdK0mqldIK4RXxdxjNBF9wqTrJcWG5XxvRlLTyeV6uHz-pMftHtDnht98Zc79zOZwGfN-Xkt/r4uyP-OywmapoXjlgc3q9qsq/aXhu/uWlKGFpL5ZTc/Ro6QbU5GfUIlU-lyZrzb3Q2lBpt5CXqDXqUxggPxIDtOlWPK0aII1IN/U8LIv-UqlTDfPiijYevCwx99WtUi-mQIb0kbcQgeam72qZfshNHvqVnmf50S3z/tJlnVrlXU4Y4OYaveGtVwvfIgYWuN5KUy7UJ25Z/j-wuu22C2xb/exOq4/8CJoDecaQvss35q-ELeXcfu-2fym3-dOTvLPMOrra-42No0LKEszXvM40TQyzyeRSusqsO18er1W/4uSp0Kk6HUpzLJWoA5aZVBhlRBpgFLhaYqvcXnWSLNKYo1N9WHGj49KcCFyXXKvUWFHxaT6IU1RI2CKNRhlAksj64uYNMULK9bqjhx93npL2vBf2uXFB/nFWX8iGD2jtB9nQqyoYIBTeuomEuoQMXQItfwnJK/5pk1A4JsHOyzuOgtPZ9hTBLXyHIBEy5bpq2hdD5kbZWfwrlkvp0AMLECFmOIHs0aZBz5d6CehiE2V4Ziub69lR5kU8F/z2crm3p86HJl6k5VU6-7F43etSREfTV8FvHZ66G9Q2zfO8Wi8RLPB3NCzLpklgSgdrrQF-lKk5/cJnic0F/Y/DkzLKK9lfvIq1qgftPGUSnFzpgyq4cyZPiDotPz3KHyiIjJz2QUNfYIAXhXPKm/gmG9nj-i2Tl0orLa6bQgdzclfooqhyHnduxp4Tv47y82KTew1uKAp2vYcVkdF9VugQ55GP7y9ZCd94r3ctYH0S6dYte9tDJH01QjGqe/7DCRm1z40lkZZ2LTaXoHHTOmce9JB6dKxEtsae3U4s/mixGfbpaxN9jnV3cvS0m-2gFb72YiEquueoP407iRMkogYMPlX097AtG1Yn5dBNlmyQNaw3U0E1FCBui56vi1SkPdbGCYXc1BCv22N482dpg34lc3HDpXZUFSoOUuU484Z1Cky-j3jyEp4PzNNIzNCPWNzfej-59Z6Pj14gUwvkwQBOCUudiydYk6va1rbqmuSt-ibf0/1wHJyzf-T28HERGfkpYEMu8949tYh3h3ntna4WvhmelI/tIbcbbrw8uWzB/IefSEXd6QfIOt4VJfHikuTV-A5tFBPMe-z4fO-IwLf0appF-mCO8CiYf7a43GvD5snsGy/V/EVT0keswbquz85XsxM1chwJ7jstOlllDy3b897nMZ0pzKVmt7-UhYqgnc4MgTbpvs-uZqFnXzmTPjvSIlgZhp6Dt3a0lz4wc/cbODV2DL9NS3rIcEkgQSNfgn1owhVOqOrWFfW1cKpaq6dtzGXsdn5TUQA6z-ZtTwB78BOR9wg-Udf-3svBz3uyLD9ENnBtgN-K-G1fxQgNPfex/Tk65t0lq-QF8mQXvdKe3eDhlVHYeB4qyxDc1T/rNROi1qK9hjQvEjsSkA8T-YB42tGILmijyqZ87oYYuJJK76J6RTjgmsf4nJ2xIW3r57z-lwfd41pabJteHYOEH7M/kH9-teEPlxEr4KhlecFk5WRr9sSs1/IJ6h6pAdAt90v0IBMfV1NfKpg9Q7-68iy7uDGb4lqTHKyBqdim1zAwtXf1KB4G8HTveT26JpX8wZzjw0Q56vlGCIo4cGyFpXpUH9yFrITctG4EZ2EAvN7f1HRjBlOfghvAek6KZHzjEAY4VYseQsuUBmwTrat4aJmyWYmvPEuCC2QrCLAUVJYEd99pspCfZcWIqLsIZ27kM3zjciGx-URwPkknJicD5zDARm31dDr6td7xhxYHRVy9rn99reqSYdg6b0attSh7fen9viD1h7eOE9FQASENnzI0PtCjpZzolxbo0bc4PrNigCPi2Quynd1omkr6kdar4KgzIf4k6dmohhML6NITpRpQae5HHzJE74foEnL7xrJ-SxnXF/BFdX701CwNe76vrJpUJttMJKSimc8gmNdr2i1e6eDqgGuxSiuJ3vnZZ2t6xuLxS6cpx-jKhYg9xFAUOUn4aV6aap0a5dyHFN4wl9uG-cSlhHe5fTP0a1IjvW4apnTykC/du6XkWgPveRjFbVhYMDVnpPi7pbySs1Lpn1djSeKPqxcvQTU0KFUo2MGs2av6VtqedkhBOCT3NOuEeBHeQnUdeQht9aat4SZx9s088DqBeiPEBgMYTIKQQW0pl7TJVq67oR58Har2oT-furV3PR8h7wsPmEBATa0dqKgnHcrp912T-Jpvp9WTas/-3Ydyy630SZneaH4UPC27v0qWrzFVyavjcD51BzZhLMKCVNNfq0z2L8r/KD921HxeTiumYds1n77AzTfQfrck0Pgx/bORTX2r3vvGSN7pbUo7XovRvi3QP1KfNttxqWA8QYFNmSDETeGb2jCYVrYLkmfV9BigWQTdh5oq7tOiHsYAa/6o98qbURUbHZvtKO4W2jWzb51eqAjBsvIUDNBgXYuuAo8Gbb6q2cJ6b2tzx8vfE8580qB79Cw/MvFhNkV5fgu98u1YmIJqROGTjRDDLePfIclHYQCGyYT1UfNXWp0HTlg1iok-UbT2Ba1P6xh/AtyFPBK-koxM5sz2bPiAxxYXrZRA9PHP16oDLMHcMhpfMBbUPKVzx5SFOSJckaQ56Li8JhGDj/eh05Qz9MJup8ET4vFFyR32qq/jXqMbQFf2YIAL5oMc1auvMADTewzQU4YBvijqEXpq4m920yWApzObwfo2MIYmBUiiJMq8iikvUX-Q0AWrP2nFkKvRmw4JXxPGLqf/iD6tT8pO7uTbqCvJXh/RUvNTPSC-2MeWbnWx3bx5SfGgbqBuoVool/GxSJFNr8hMAxErJDTuRSuBL7NaqLRjFJ2IbZLNtM8gktlTeai9KoIo5oXKldyUr21rFQZaqkfsH-VVH32aXNo19zRYi1nPBz2IAU4Yrio6oNZdMUC18YZFx3oX/Zih69imbsl8dWncIco71IEOrnbf3lFLfNTTjCteSh3bcNerZ3ks2h2WSbzBNWp/K2WOg4pjR1Drp6-NFmwopl3K-lIovW/mWdBawZnBpF78OuUMlo5YLXHhe1lDnw/M2HjnnoAOC1lWN8w/zM6YPgWRQ30wGOm2voM83RNY9IBZdPMpzeHnNpRKyyJrjtxP-q9ejpb2zi2XkfJ2AypdG9ZHy6v9q/7otCq-1bV0EMFp5HuyUUdcy0zIQH0eOFk2nDXMWDF1-OA7nerAeVGPVmhujBElu3yWHcqzrPqtV3oGWJzN0NZoQJXXCAxQPUyaE2mZoAcFtq5/6iQxPChqIT1HFGFrmW-4crUhWGqDZlF8oKnSuNZwnix6c8gAX2B9TeKjxJvKlKGiEG5fPKezGk3eytfMEUZwQXc2B1GawhTHUkNTx04VaZWv8S5NDa-0Ka/ZSh5jaMt6U6NOZWQLHGfuuYpKrHFlixHgaajnvBnqOTcpk5AoacYaI8snl84R5mvo4daTuvTMfiBzZFMhHVrmDM3I0Td-FXPOnzh8ZozJaSDULEHhs-nq66He1L6CfkFaOWV0pZ2Mr052HWd88ym2DZKxZFW-R3LtDefv4pmy9FX0Kd8VPnAnyKmHdHWQ4rlEri0d52pKlkvUu5ykIJ13JR/VLaM2LMy1SaXlr0Z9TFucjTRZLrg7nGsFxQBUBgYX3yeRqvJNJMaihMfAOiAmEqpEQv6OrpMxiZIS6-BtiZlG39InVdQLPDuWciw2CNR7l0p/l1eYV8wKaMGbGgq/n2ci8OqFkllN/uD-u-/kFgUzJk5u-4NXYH9M-8MEyMhAQ11F5oWHcRb2uTNOusp372bKQQU-nKQFd66XEnXl91ODXVRd9A0EjoNB29OyQq3a3zpaOvaYFshbeE531t0iKd3g0n34taNiVFXlxELzrF3OYWv9C7qUdkr8w6-JSpbGepfcWJnmxTav53U8A9cCsAcXDvGLdIslmVfqfQ22UYy-NaMQy5/AGHP1eFf4XSH5ZVEutQex6wX5-qv6tielwgeY2F9-qvCIDVd0xABkxflTLbYXMcBE2mC4m9bp47pe6c2D7Fkutwb0xRf6MhIHQ7VCXSlIpsQzrnCEdy9lcqVaXDVl2zc7lR4tMXS1rKuxqB3uKGi6RrFu-izyGKBlQBUeMRot5X9S55W9bGaDhwzgYk9DtuZquEmY/Tq7s4oJTJulZJse-Wjvrs/Fi9qGQ/Ez8ujxBRh4OSk5-fNycivzBKQGziTkggd9xrT63B9pZ8dFzhxLudjt7aJwu8bD3mP5TUyIyF0Op09eOZOFrewedGWTXHFkFzldfvCXpUbzrE3K7jeeWj/8XAWJPN1ZJ08GHsqS8t2Jb6lrDLz0Mo43i2hmmRofV7QsX6t-67BE4gEp4mPOsG2yPwQJmO5dW/hCRjLhozm7VPT-jqN-bsy7PPwh/XfRimUlTHjHjAcCvk62BZaVLvXqxrcHmbwIYM0Sxs91Rb1S1DD4NKB4N2Smbgw/zeKto74CJ71i1LI9IDkfotar1br-NOlMekYLksma66W3xYn2IktX11RHEoMWa/Am/K6w0AmWw/6khyXT3uqZvYlvHERR12fpnr477PtM0tfIa8kp3SfYYjTDNPyjRjgL64T9Aeg43cnViOIjPRoEN9tVusvZulTfzrj3nq3jZHd0nnEyYIcrntYPJjc5eWd6KU-37H3gXYGXuqLdbfp1k-w0h3oZeqK1J6wemZOBf-/dfVrPgSIrWF7JlyK7rb75zrI-BKF4KYXdQxYDhNnTr69tWdjiLxZ2MRxKUAxHlXFrgiHkQPcMDCYA-2zFXkaWdtX4ejcUvY/d0q3/N3V/9RH3J73fC7utS6AM67yUolug5VgnFNWNRqZK-LI1KRIn1J0uOVFrqfRdNAndpHA8U5r98AFXGkTO64bDvsDvrz6PKQ-5915mTM5DMy3QLIjGwyTMlBUs4AMt6MD0DGzV7jELTgxvvJo4cKYK8Lj/xnOygyN41SIN6u/XN95zyOm9f5ud/l3nGl02eq0bgcF0bL7nZOWSEfBrYYmveb8QSrt7WqS9h74ayaYw7slcJ5mnP-byyRMR0958P6emjoiwqkhBgX2qQon9mMvHq8vHh0OozpV4dC83e9WTg0Vy8Vc9RwotitGRmdaoXF2NtDHwhpL9MrY0ITYqi99Hyid/nLbrdtrrsxFCrvpxrZrG4Yh7KnYf-mqL3SezB8jy4mubyRWYZVhCASa6TYuwvMInUFoRL7MbHh90ZFF2hpKRpuZUSTrjb9FB60H-5-5yL5v3sTzZpF-7D-Z9T6Hlm9IUV/Cwj-qrFeXu5K38qN2zeiCzYNL-x9VPpBGa7Im51hXrD58vj5cfe3MsqMttQ0mhHRFfQfspBqykHyVi42/0X8RfgHCEXldLc7TacWYJyV4Sru-hiNdG4lc5dYZcRQtFvhbsGq/Mk/AkPRVa-HUUA0h3dIKpblrcBZvwOIxrdZljZvJpC0ML2A5xRNzIntReOivA956KR5n5qt9J48iGRcGsQPkP0USUzCN5IZ7PevjFqJoEY9YJA06TZJ70E3UnGYEmBNjW5VOFWOuEyKdOg6eKfE4zMyFT5vUIed2m8i9uUKRuu6a3ikxUZr658Mu0S--jQscEvxC1aVpRaHIpTrSeU70XNzIDRvYjuR8e/f0n3oOM8fcL/PijEw0i3wLqcA0hHTkaVXziq1LIolm3SWkP5-NV/3TZdYm3W3ZgWz71ywa5igIXupZEnGJqFarK7-glubs7h0ldozE5/IxpIYf3EKu5mUqfcHzr8Eljq09XfT5nMdeYKD4bYyKYQ7eZ1-QNfDp054iuOckxb1Iuex7hwrme2JIRjtv59QWLm/GMFm8wgFd60s3MVn-f-ZJ-CpUrH/TqEcThUlPY6DGmZoGXFus-TiVSTSm8-ri0LLj9KLP/l8rGPPPR0UuZQeH0iVOE1AIQ/ctguBFdYz-x8vi-tLT-huyo0Kir6AuvN/H3ul9XP9ykVgZv9zmK1gZ/peft/2rYhcbnVukoGXUhaum657xCGaIPNzUXdtpoBdbKCoPRn6oCOVo4zaHxcfRfWnMbkXlXYXNkIJSoFN4M8KZYbWpflf8qC0Ks5CZzlHpftEDhJeIGkXvsZzyrTGCtqR6bZgixzenKuELXaOojZ1XOnO9vtt2vjB/xsepZW9H9Is799Zf8YVe1NSGNx85PETX30h6kiZhRdD1eqZ7J7nl1I5jGod07xL5l-pHWspruGz6aLPVZiFide3DKxwp/9Q7TdkdiqzOaTQlht-uWpmrB41D3tMFrvZVAfvwcbdenb5OqbsH5akKR82aJY2nu6yYxq82viaaHWsjueIlfhK-2wsR1NrhnF0TTvu9g11IyoS16/Y2OvOFSi7Q3Mh25n3JOpi5CJIWHeeV8FfZBBEUXGboURl/AKCldPWSbzEr75xaWbdtjxn-mtN6tlLaVb3G8dLe2bQ8WBT24aduDS0Q5ZidQRyepVsJftI3LDc3Qdnm/SZy/LQNROsBMJyRmS9b2-UE-47LG8lWJjo2QvEa-Owj//Hwz0K3jlGvyCaGPiF6u31KKaE49OxxGRB7Kxzpz0J5IOVpMimSpz4TnlQ2BreQJaVJzciZpkqzEawDReULxUl7KzwYpsSEyubKqSpfBuH/eXNezwZm6Gn4ous1I5W4JOXD6CvHgOTKa-MOy4hU9QavRNbrpfrEVmcuBfOFcMFUNGVsB8D-rYkOsXVhiVtY5hDpUBe20SbTvGoR/RXu2Rl/P9-gSxRtqUVGypOpWTLoYlVDOjtf6gZ5NrFBScIMjaE62toXlYgdT6dPSKmfELRO5LzIkBVMp7Y8j2aT15sw/a4ynLSLorKStUUbgYapVvpoXTfHrlfLB6yVdP1rK0s1A8GwsdmajflXl1-sVeo0M2NurCb1PMcBCu00zypf-1yve/4-CGnEitVHRbnGpReFvjiDCz7G/Dj0I2L3C11a42zuaddXCIrCx-6D26XizN72fLjTbQmyJxAjdOUteJJBJ2hbKn156QTrKBr-SW--ZRVa9v6xSRK6j6H5FpXjTQTh7Vh0/8JhWgC7Hbd7eFVqYvB7XWeiWi557VLXgM5tfe2A6RuSDS05hNkdqMk3i8KNYj3oxfxrHa3YGdylUao5IHzlrl-x7UfJGoi1A6yse8JFXpXeFFZbZFsIJRYNVq8bJBMy7/wLzAih7";
		$user = array('account' => $account, 'password' => $password, 'phone' => $phone, 'nickname' => $nick, 'head' => $head,'level' => 1, 'signature' => 'default signature', 'gender' => 0, 'age' => 0);
		\DB::table('user') -> insert($user);
		\DB::table('user_class') -> insert(array('name' => 'my friends', 'account' => $account));
		return view('welcome', ['account' => "$account"]);
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
		$res2 = \DB::table('contact_relation') -> insert(array('user_id' => $to, 'contact_id' => $from, 'class_id' => $class_id2, 'remark' => 'null'));
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