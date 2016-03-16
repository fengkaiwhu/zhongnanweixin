$(function () {
    
    var InterValObj;
    var count=60;//间隔时间 s
    var curCount=count;//剩余时间 s

    $("#telephone").blur(function(){
        var telephone = $(this).val().trim();
        if(telephone === ''){
            $("#information").html("请输入预留手机号");
        }else{
            $("#information").html('');
            re = /^1\d{10}$/;
            if(!re.test(telephone)){
                $("#information").html("手机号格式不正确");
            }
        }
    });

    $("#verifynum").blur(function(){
        var num = $(this).val().trim();
        if(num === ''){
            $("#information").html("请输入短信验证码");
        }else{
            $("#information").html('');
            re = /^\d{6}$/;
            if(!re.test(num)){
                $("#information").html("验证码为六位数字");
            }
        }
    });

    $("#verify").on("click", function(){
        var _constant_key = $("#_constant_key").val();
        var _sms_key = $("#_sms_key").val();
        
        if(_sms_key === ''){
            $("#information").html("请先获取验证码");
            return false;
        }

        var num = $("#verifynum").val().trim();
        if(num === ''){
            $("#information").html("请输入验证码!");
            return false;
        }
        re = /^\d{6}$/;
        if(!re.test(num)){
            $("#information").html("验证码为六位数字");
            return false;
        }

        $.ajax({
            type:"POST",
            url:"/interface/doVerify.php",
            dataType:"json",
            data:{
                "mkey": _sms_key,
                "ckey":_constant_key,
                "data":num
            },
            success:function(data){
                if(data.status !== 0){
                    $("#information").html(data.content);
                }else{
                    window.open("/reportList.php?ckey=" + _constant_key + "&mkey=" + _sms_key);
                }
            },
            error:function(){
                $("#information").html("请求出错,请稍后再试!");
            },
            beforeSend:function(){
            }
        });
    });

    $("#getnum").on("click", function(){
        var _constant_key = $("#_constant_key").val();
        var telephone = $("#telephone").val().trim();
        if(telephone === ''){
            $("#information").html("请输入手机号!");
            return false;
        }
        re = /^1\d{10}$/;
        if(!re.test(telephone)){
            $("#information").html("手机号格式不正确");
	    return false;
        }

        $.ajax({
            type:"POST",
            url:"/interface/phoneVerify.php",
            dataType:"json",
            data:{
                "telephone": telephone,
                "ckey":_constant_key
            },
            success:function(data){
                if(data.status !== 0){
                    $("#information").html(data.content);
                }else{
                    $("#information").html(data.content2);
                    $("#_sms_key").val(data.content);
                }
            },
            error:function(){
                $("#information").html("请求出错,请稍后再试!");
            },
            beforeSend:function(){
                curCount = count;
                $("#getnum").attr("disabled", "true");
                $("#telephone").attr("disabled", "true");
                $(this).html(curCount + "秒后重发");
                //启动计时器
                InterValObj = window.setInterval(SetRemainTime, 1000);
            }
        });
    });

    function SetRemainTime(){
        if(curCount === 0){
            window.clearInterval(InterValObj);
            $("#getnum").removeAttr("disabled");
            $("#telephone").removeAttr("disabled");
            $("#getnum").html("重新发送");
        }else{
            curCount--;
            $("#getnum").html(curCount + "秒后重发");
        }
    }
});
