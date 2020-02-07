const express = require('express');
const app = express();

app.get('/list_user', function (req, res) {
   console.log("/list_user GET 请求");
   res.send('用户列表页面');
})
const server = app.listen(8899, function() {
    console.log('启动成功');
});