$(function () {
    
    $("#institution").bind("change", function(){
        var id = $(this).val();
        $.ajax({
            type:"POST",
            url:"/interface/getPackByOrid.php",
            dataType:"json",
            data:{
                "orid": id
            },
            success:function(data){
                if(data.status !== 0){
                    alert(data.content);
                }else{
                    $("#group").empty();
                    for(var i = 0; i< data.content.length; i++){
                        if(i === 0)
                            $("#group").prepend("<option selected='selected' value='" + data.content[i]["PACKAGEID"] + "'>"+data.content[i]["PACKAGENAME"]+"</option>");
                        else
                            $("#group").prepend("<option value='" + data.content[i]["PACKAGEID"] + "'>"+data.content[i]["PACKAGENAME"]+"</option>");

                    }
                }
                $("#group").selectmenu("refresh");
            },
            error:function(){
                alert(data.content);
            },
            beforeSend:function(){
            }
        });
    });
});
