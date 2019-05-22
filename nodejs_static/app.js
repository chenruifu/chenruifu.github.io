const http = require('http');
const fs = require('fs');
const conf = {
    path: process.cwd(),
    listen: 1231
}

http.createServer(function (req, res) {
    const reqUrl = conf.path +''+ req.url;
    fs.stat(reqUrl, (err, stats) => {
        res.writeHead(343, {'Content-Type': 'text/plain'});

        // 发送响应数据 "Hello World"
        res.end(`${err}`);
    })
    // 发送 HTTP 头部 
    // HTTP 状态值: 200 : OK
    // 内容类型: text/plain
    
}).listen(conf.listen);

// 终端打印如下信息
console.log('Server running at http://127.0.0.1:8888/');