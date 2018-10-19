## NodeJS介绍

* 单线程的。区别于PHP、JAVA等后端语言多线程模式。占用内存小，可以处理高并发...
* 非阻塞IO的。例：A用户访问网站，去读取文件，这时候B用户进来，先处理B用户，等A用户的读取文件回调后，再返回给A用户。
* 事件驱动（事件环）。客户端请求建立连接时，提交数据等行为，会触发相应的事件。在一个时刻只能执行一个事件回调函数，但在执行事件回调的中途，可以处理其他的事件。
* POST请求。大文件会分成一个个小包，防止进程阻塞。
* require引用模块。require('./mod/a.js')项目相对地址模块; require('a.js')等价于node_modules文件夹下的a.js; require('a')等价于node_modules文件夹下的a/index.js
* node_modules在本项目目录能找到，在上级目录也是能找到的
* npm init。package.json项目身份证，依赖模块，项目简介...
* npm root -g 返回全局的路径地址，npm root 返回当前路径