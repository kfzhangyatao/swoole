
var wsUrl = "ws://172.19.129.235:9502";

var websocket = new WebSocket(wsUrl);

//实例对象的onopen属性
websocket.onopen = function(evt) {
    //websocket.send('hello');
    console.log("conected-swoole-success");
}

// 实例化 onmessage
websocket.onmessage = function(evt) {
    var html = push(evt.data);
    $('#match-result').prepend(html);
    console.log("ws-server-return-data:" + evt.data);
}

//onclose
websocket.onclose = function(evt) {
    console.log("close");
}
//onerror

websocket.onerror = function(evt, e) {
    console.log("error:" + evt.data);
}


function push(data) {
    data = JSON.parse(data);
    var html = '<div class="frame">';
    html += '<h3 class="frame-header">';
    html += '<i class="icon iconfont icon-shijian"></i>第'+ data.type +'节 01：30</h3>';
    html += '<div class="frame-item">';
    html += '<span class="frame-dot"></span>';
    html += '<div class="frame-item-author">';
    html += '<img src="./imgs/team1.png" width="20px" height="20px" />'+ data.name +'</div>';
    html += '<p>08:44 ' + data.content +'</p></div></div>';
    return html;
}
