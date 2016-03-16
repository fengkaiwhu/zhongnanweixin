$(function () {
	$(".ajax-data").one('click', function (event) {
			//alert("test");
			//$(this).next().html("<div style='text-align:center;'><img src='img/loading1.gif' class='img-responsive img-thumbnail'></div>");
			
			var i = $(this);
			$.ajax({
				type:"POST",
				url:"/interface/subjectResult.php",
				dataType:"json",
				data:{
				},
				success:function (data) {
					if (data.status !== 0) {
						i.next().html("<div style='text-align:center;'>请求出错!!</div>");
					}else {
						var h = "";
						h = h + '<div class="table-responsive">'+
								 		'<table class="table table-condensed table-bordered">'+								 		
								 			'<thead>'+
								 				'<colgroup>'+
								 					'<col width="50%"><col>'+
								 					'<col><col>'+
								 				'</colgroup>'+
								     			'<tr>'+
								         		'<th>项目名称</th>'+
								         		'<th>检查结果</th>'+
								    			'</tr>'+
								 			'</thead>'+				 
								 			'<tbody>'+
								     			'<tr>'+
								         		'<td>白细胞</td>'+
								        			'<td>8.17</td>'+
								     			'</tr>'+
								     			'<tr class="danger">'+
								        			'<td>红细胞</td>'+
								         		'<td>5.4 &uarr;</td>'+
								     			'</tr>'+
								     			'<tr>'+
								         		'<td>血小板</td>'+
								         		'<td>316</td>'+
								     			'</tr>'+
								     			'<tr class="danger">'+
								         		'<td>血红蛋白</td>'+
								         		'<td>164.8 &darr;</td>'+
								     			'</tr>'+
								 			'</tbody>'+
								 		'</table>'+
						'</div>';		
						i.next().html(h);					
					}
				},
				error:function () {
					i.next().html("<div style='text-align:center;'>网络错误!!</div>");				
				},
				beforeSend:function () {
					i.next().html("<div style='text-align:center;'><img src='/img/loading1.gif' class='img-responsive img-thumbnail'></div>");				
				}			
			});
		});

});
