
var wsUrl = "ws://172.19.129.235:9503";

var websocket = new WebSocket(wsUrl);

//实例对象的onopen属性
websocket.onopen = function (evt) {
    //websocket.send('hello');
    console.log("conected-swoole-success");
}

// 实例化 onmessage
websocket.onmessage = function (evt) {
    var html = push(evt.data);
    $('#comments').append(html);
    console.log("ws-server-return-data:" + evt.data);
}

//onclose
websocket.onclose = function (evt) {
    console.log("close");
}
//onerror

websocket.onerror = function (evt, e) {
    console.log("error:" + evt.data);
}

function push(data) {
    data = JSON.parse(data);
    var html = '<div class="comment">'
    html += '<span>xixi </span>';
    html += '<span>' + data.content + '</span></div>'
    return html;
}