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
                    "mkey":i.children("#mkey").val(),
                    "reportid":i.children("#reportid").val(),
                    "tablename":i.children("#tablename").val()
				},
				success:function (data) {
					if (data.status !== 0) {
						//i.next().html("<div style='text-align:center;'>请求出错!!</div>");
						i.next().html(data.content);
					}else {
                        var r_value = data.content;
                        var r_name = data.content2;
                        var r_compare = data.content3;
                        var result = "";
                        for(key in r_value){
                            if(key !== "SUMMARY" || key !== "DOCTORNAME"){
                                if(r_compare[key]){
                                    result = result + '<tr><td>' + r_name[key] + '</td><td>' + r_value[key] + '</td></tr>';
                                }else{
                                    result = result + '<tr class="danger"><td>' + r_name[key] + '</td><td>' + r_value[key] + '</td></tr>';
                                }
                            }
                        }
                        result = result + '<tr class="success"><td>' + r_name['SUMMARY'] + '</td><td>' + r_value['SUMMARY'] + '</td></tr>';
                        result = result + '<tr><td>' + r_name['DOCTORNAME'] + '</td><td>' + r_value['DOCTORNAME'] + '</td></tr>';
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
                                                result +
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
