const http = require('http');
const fs = require('fs');
const conf = {
    path: process.cwd(),
    listen: 1231
}
module.exports = function(){
    http.createServer(function (req, res) {
        const reqUrl = conf.path +''+ req.url;
        fs.stat(reqUrl, (err, stats) => {
            if(err){
                res.writeHead(404, {'Content-Type': 'text/plain'});
                res.end(reqUrl+":改地址不存在");
                return;
            }
            if(stats.isFile()){
                res.end('这是一个文件');
            }else if(stats.isDirectory()){
                fs.readdir(reqUrl, (err, files) => {
                    console.log(files);
                })
                res.end('这是一个目录');
            }
        })
    }).listen(conf.listen);
}

// 终端打印如下信息
console.log('Server running at http://127.0.0.1:1231/');