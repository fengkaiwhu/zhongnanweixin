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
                    $("#group").html('');
                    for(i == 0; i< length(data.content); i++){
                        if(i === 0)
                            $("#group").prepend("<option selected='selected' value='" + data.content[i]["PACKAGEID"] + "'>"+data.content[i]["PACKAGENAME"]+"</option>");
                        else
                            $("#group").prepend("<option value='" + data.content[i]["PACKAGEID"] + "'>"+data.content[i]["PACKAGENAME"]+"</option>");

                    }
                }
            },
            error:function(){
                alert(data.content);
            },
            beforeSend:function(){
            }
        });
    });
});
