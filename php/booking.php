<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/jquery.mobile-1.3.2.min.js"></script>
    <script src="/js/booking.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <title>预约体检</title>
</head>
<script type="text/javascript">
	
	function checkAll() {
		
		var name = document.getElementById("name").value;
		
		if (name == "" || name.length < 1) {
			alert("输入姓名有误");
			return false;
		}		
		
		var idNum = document.getElementById("idNum").value;
		
		var len = idNum.length;
		var aCity = {
			11 : "北京",
			12 : "天津",
			13 : "河北",
			14 : "山西",
			15 : "内蒙古",
			21 : "辽宁",
			22 : "吉林",
			23 : "黑龙江 ",
			31 : "上海",
			32 : "江苏",
			33 : "浙江",
			34 : "安徽",
			35 : "福建",
			36 : "江西",
			37 : "山东",
			41 : "河南",
			42 : "湖北 ",
			43 : "湖南",
			44 : "广东",
			45 : "广西",
			46 : "海南",
			50 : "重庆",
			51 : "四川",
			52 : "贵州",
			53 : "云南",
			54 : "西藏 ",
			61 : "陕西",
			62 : "甘肃",
			63 : "青海",
			64 : "宁夏",
			65 : "新疆",
			71 : "台湾",
			81 : "香港",
			82 : "澳门",
			91 : "国外 "
		}
		if (!(/(^\d{15}$)|(^\d{17}([0-9]|X)$)/.test(idNum))) {
			alert("输入身份证号不符合规定");
			return false;
		} else if (len == 18) {
			var valnum;
			var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5,
					8, 4, 2);
			var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4',
					'3', '2');
			var nTemp = 0, i;
			for (i = 0; i < 17; i++) {
				nTemp += idNum.substr(i, 1) * arrInt[i];
			}
			valnum = arrCh[nTemp % 11];
			if (valnum != idNum.substr(17, 1)) {
				alert("输入身份证号不符合规定");
				return false;
			} else if (aCity[parseInt(idNum.substr(0, 2))] == null) {
				alert("输入身份证号不符合规定");
				return false;
			}
		}
		
		var tel = document.getElementById("telephone").value;
		
		if (tel.length != 11) {
			alert("输入联系电话有误");
			return false;
		}
		
		var date = document.getElementById("date").value;
		
		date = date.replace(/-/g, "/");
		var nowDate = new Date();
		var checkDate = new Date(Date.parse(date));
		if (checkDate < nowDate) {
			alert("预约日期有误");
			return false;
		}
		
		alert("请确认预约信息，预约成功后无法手动更改！");
	}
</script>
<body onload="getvalue()">
  <?php
  require "../inc/mysql.class.php";
  
    function _getcurl($url) {
	
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $url);      
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22");
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		
		$output = curl_exec($ch);
		curl_close($ch);
		return $output;
	}
	
	$code = $_GET["code"];
	$state = $_GET["state"];
	//$appid = "wx777c25c676b36289";
	//$appsecret = "977d97c23c77a7af29f4889fab8ff9a3";
	
	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=". APPID. "&secret=". APPSECRET. "&code=". $code. "&grant_type=authorization_code";

	$content = _getcurl($url);
	$content = json_decode($content, true);
    $openid = $content['openid'];

    try{
        $db = new mysqlpdo($dbinfo);
        $sql = "select ORGANIZATIONID, ORGANIZATIONNAME from t_check_organization";
        $result = $db->query($sql);
        $result = $result->fetchAll();
        $organization = "";
        foreach($result as $key=>$value){
            if($key == 0){
                $organization .="<option selected='selected' value='".$value["ORGANIZATIONID"]."'>".$value["ORGANIZATIONNAME"]."</option>"; 
                $firstid = $value["ORGANIZATIONID"];
            }else
                $organization .="<option value='".$value["ORGANIZATIONID"]."'>".$value["ORGANIZATIONNAME"]."</option>"; 

        }
    }
    catch(PDOException $e){
        //FIXME
    }

    try{
        $sql = "select PACKAGEID, PACKAGENAME from t_check_package where ORGANIZATIONID='$firstid'";
        $result = $db->query($sql);
        $result = $result->fetchAll();
        $package = "";
        foreach($result as $key=>$value){
            if($key == 0){
                $package .= "<option selected='selected' value='".$value["PACKAGEID"]."'>".$value["PACKAGENAME"]."</option>";
            }else{
                $package .= "<option value='".$value["PACKAGEID"]."'>".$value["PACKAGENAME"]."</option>";

            }
        }
    }
    catch(PDOException $e){
        //FIXME
    }
    
  ?>
  <div data-role="page">
    <div data-role="content">
      <h3 style="text-align:center;">预约体检</h3>
      <form action="/php/booking_ensure.php" method="post">
                <div data-role="fieldcontain" style="align:center">
                    <table width="100%">
                        <tr>
                            <td>
                              <label for="name">姓名：</label>
                            </td>
                            <td>
                                <input type="text" name="name" id="name" placeholder="请输入姓名" />
                                <input type="hidden" name="userId" id="userId" value="<?=$openid?>" readonly="readonly" />
                            </td>
                        </tr>
                        <tr>
                            <td>
                              <label for="idNum">身份证号：</label>
                            </td>
                            <td>
                                <input type="text" name="idNum" id="idNum" placeholder="请输入身份证号" />
                            </td>
                        </tr>
                        <tr>
                          <td>
                                <label for="sex">性别：</label>
                            </td>
                            <td>
                                <fieldset data-role="controlgroup" data-type="horizontal">
                                  <label for="male">男性</label>
                                  <input type="radio" name="sex" id="male" value="1" checked>
                                  <label for="female">女性</label>
                                  <input type="radio" name="sex" id="female" value="2">
                              </fieldset>
                          </td>
                        </tr>
                        <tr>
                          <td>
                             <label for="age">年龄：</label>
                          </td>
                           <td>
                            <input type="range" name="age" id="age" value="30" min="0" max="120">
                        </td>
                  </tr>
                  <tr>
                      <td>
                         <label for="telephone">电话：</label>
                     </td>
                     <td>
                      <input type="text" name="telephone" id="telephone" placeholder="请输入电话" />
                  </td>
              </tr>
              <tr>
                  <td>
                     <label for="date">预约时间：</label>
                 </td>
                 <td>
                  <input type="date" name="date" id="date" />
              </td>
          </tr>
          <tr>
              <td>
                 <label for="group">体检机构：</label>
             </td>
             <td>
              <fieldset data-role="controlgroup">
                  <select name="institution" id="institution" data-native-menu="false">
                    <?php
                       echo $organization; 
                    ?>
                 </select>
             </fieldset>
             </td>
         </tr>
          <tr>
              <td>
                 <label for="group">套餐选择：</label>
             </td>
             <td>
              <fieldset data-role="controlgroup">
                  <select name="group" id="group" data-native-menu="false">
                    <?php echo $package; ?>                     
                 </select>
             </fieldset>
             </td>
         </tr>
  <tr align="center">
      <td colspan=2>
         <input type="submit" value="--提交预约信息--" onclick="return checkAll()">
     </td>
  </tr>
  </table>
  </div>
  </form>
  </div>
  </div>
</body>
</html>
