<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="/css/jquery.mobile-1.3.2.min.css">
    <script src="/js/jquery-1.8.3.min.js"></script>
    <script src="/js/jquery.mobile-1.3.2.min.js"></script>
    <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
    <title>体检导航</title>
	<style>
	th {
		border-bottom: 1px solid #d6d6d6;
	}

	tr:nth-child(even) {
		background: #e9e9e9;
	}
	</style>
</head>

<body>
		<div data-role="content">
             <table width="100%">
			<tr>
				<td>
				  <label for="name">排队号票：</label>
				</td>
				<td>
					<input type="text" name="ticket" id="ticket" placeholder="06352156"  readonly="readonly" onblur="upDate(this)" />
				</td>
			</tr>
			<tr>
				<td>
				  <label for="name">我的套餐：</label>
				</td>
				<td>
					<?php
					$group = "常规体检A";
					echo "<label for='name'>". $group. "</label>";
					?>
				</td>
			</tr>
            </table>

		</div>
	<?php
	
	$r1 = array(array("office"=>"口腔科", "number"=>9, "state"=>"正常", "detail"=>"口腔科注意事项口腔科注意事项口腔科注意事项口腔科注意事项", "image"=>"/img/buju.jpg"), 
				array("office"=>"内科", "number"=>22, "state"=>"正常", "detail"=>"内科注意事项内科注意事项内科注意事项内科注意事项内科注意事项", "image"=>"/img/buju.jpg"), 
				array("office"=>"放射科", "number"=>17, "state"=>"正常", "detail"=>"放射科注意事项放射科注意事项放射科注意事项放射科注意事项放射科注意事项", "image"=>"/img/buju.jpg"), 
				array("office"=>"心电图室", "number"=>5, "state"=>"正常", "detail"=>"心电图室注意事项心电图室注意事项心电图室注意事项心电图室注意事项", "image"=>"/img/buju.jpg"), 
				array("office"=>"眼科", "number"=>3, "state"=>"正常", "detail"=>"眼科注意事项眼科注意事项眼科注意事项眼科注意事项眼科注意事项眼科注意事项", "image"=>"/img/buju.jpg"), 
				array("office"=>"化验室", "number"=>31, "state"=>"正常", "detail"=>"化验室注意事项化验室注意事项化验室注意事项化验室注意事项化验室注意事项", "image"=>"/img/buju.jpg"));

		echo "<table width='90%' align='center'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th width='*'>科目</th>";
		echo "<th width='60px' align='center'>排队号</th>";
		echo "<th width='60px' align='center'>状态</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		foreach ($r1 as $value) {
			echo "<tr>";
			echo "<td>". $value['office']. "</td>";
			echo "<td>". $value['number']. "</td>";
			echo "<td>". $value['state']. "</td>";
			echo "</tr>";
		}
		echo "</tbody>";
		echo "</table>";
		
		echo "<div data-role='content'>";
		echo "<div data-role='collapsible-set'>";				
		foreach ($r1 as $value) {
			echo "<div data-role='collapsible'>";
			echo "<h3>". $value['office']. "详细信息</h3>";
			echo "<p>". $value['detail']. "</p>";
            echo "<img src=". $value['image']. " width='100%' />";
			echo "</div>";
		}
		echo "</div>";
		echo "</div>";

	?>
</body>
</html>
