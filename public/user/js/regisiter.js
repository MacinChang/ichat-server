    function $(id){ //通过id获取对象
 	  return document.getElementById(id);
    }
    function check_email(str,id){
     var re =  /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
     if(re.test(str)){
      $(id).style.display="inline";
      $("wemail").innerHTML="<i id='mail_bg'></i>";
      $("mail_bg").id="main_bg";
    }else{
      $(id).style.display="inline";
      $("wemail").innerHTML="<i id='mail_bg'></i>邮箱格式错误";
    }          
  }
  function check_tel(str,id){
  	 var re=/^(1(([35][0-9])|(47)|[8][01236789]))\d{8}$/;
  	 if(re.test(str)){
  	 //	$(id).style.display="none";
      $(id).style.display="inline";
      $("wtel").innerHTML="<i id='tel_bg'></i>";
      $("tel_bg").id="main_bg"; 
  	 }else{
        $(id).style.display="inline";
        $("wtel").innerHTML="<i id='tel_bg'></i>手机号输入错误";
  	 }
  }
  function check_null(str,id){//检查输入是否为空
     if(str===""){
     	$(id).style.display="inline";
     }else{
     	$(id).style.display="inline";
      $("wpwd_1").innerHTML="<i id='main_bg'></i>";
      alert($("wpwd_1").innerHTML);
     }
  }
  
   $("email").onblur=function(){
  	 /*check_email(this.value,"wemail");*/
  };
  /*检测手机号是否正确*/
  $("tel").onblur=function(){
  	 check_tel(this.value,"wtel");
  };
  /*检测密码*/
  $("pwd_1").onblur=function(){
  	if (this.value==="") 
  	{$("wpwd_1").style.display="inline";
     $("wpwd_1").innerHTML="<i id='pwd_bg'></i>密码不能为空";
    }
  	else{
      $("wpwd_1").style.display="inline";
      $("wpwd_1").innerHTML="<i id='main_bg'></i>";
  	}
  };
    $("pwd_2").onblur=function(){
  	if ($("pwd_1").value!=$("pwd_2").value){
  		$("wpwd_2").style.display="inline";
      $("wpwd_2").innerHTML="<i id='checkpwd_bg'></i>两次输入的密码不同";
  	}else if($("pwd_2").value==""){
       $("wpwd_2").style.display="none";
      }
     else{
  		$("wpwd_2").style.display="inline";
      $("wpwd_2").innerHTML="<i id='main_bg'></i>";
  	}
  };

