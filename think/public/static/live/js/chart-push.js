$(function () {
    $("#discuss-box").keydown(function(event){
        if (event.keyCode == 13) {  // 回车监听
            var text = $("#discuss-box").val();
            var url = 'http://172.19.129.235:9502?s=index/chart/index';
            var data = {
                'content':text,
                'game_id':1
            };
            $.post(url, data, function(ret){
                if (ret.status == 1) {
                    $("#discuss-box").val('');
                }
            }, 'json');
        }
    });
});