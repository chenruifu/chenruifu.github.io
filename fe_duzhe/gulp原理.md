## 什么是gulp？

简单的讲，gulp是一个构建工具，一个streaming构建工具，一个nodejs写的构建工具


## 什么是node

Node 是一个基于Chrome JavaScript V8引擎建立的一个平台，可以利用它实现 Web服务，做类似PHP的事。

npm的全称：Node Package Manager   Node包管理器

我们在Node.js上开发时，会用到很多别人已经写好的javascript代码，

如果每当我们需要别人的代码时，都根据名字搜索一下，下载源码，解压，再使用，会非常麻烦。于是就出现了包管理器npm。

大家把自己写好的源码上传到npm官网上，如果要用某个或某些个，直接通过npm安装就可以了，不用管那个源码在哪里。

并且如果我们要使用模块A，而模块A又依赖模块B，模块B又依赖模块C和D，此时npm会根据依赖关系，

把所有依赖的包都下载下来并且管理起来。试想如果这些工作全靠我们自己去完成会多么麻烦！

```
//卸载插件
npm uninstall < name > [-g] [--save-dev]

//更新插件
npm update < name > [-g] [--save-dev] 

//更新全部插件
npm update [--save-dev] 

//安装插件
npm install < name > [--save-dev] 


//安装package全部插件
npm install


//产看当前安装列表
npm list

//帮助
npm help
```

## cnpm

```
$ npm install -g cnpm --registry=https://registry.npm.taobao.org
```

## 回到gulp

### gulp.task(name[, deps], fn)

gulp.task方法用来定义任务

name 为任务名
deps是当前定义的任务需要依赖的其他任务，为一个数组。当前定义的任务会在所有依赖的任务执行完毕后才开始执行。如果没有依赖，则可省略这个参数
fn 为任务函数，我们把任务要执行的代码都写在里面。该参数也是可选的

```
gulp.task('mytask', ['array', 'of', 'task', 'names'],
     function() { //定义一个有依赖的任务
     // Do something
})
```

### gulp.src(globs[, options])

globs参数是文件匹配模式(类似正则表达式)，用来匹配文件路径(包括文件名)，当然这里也可以直接指定某个具体的文件路径。当有多个匹配模式时，该参数可以为一个数组

options为可选参数。通常情况下我们不需要用到

下面我们重点说说Gulp用到的glob的匹配规则以及一些文件匹配技巧

![201811122447](http://cdn.chenrf.com/201811122447.png)

gulp.task(name, fn)，注册一个 gulp 任务

gulp.watch(glob, fn)，实时监控内容，当 glob 内容变化时，执行 fn

gulp.src(glob)，glob 是目标文件的路径，返回一个可读的 stream

gulp.dest(gloc)，glob 是输出路径，返回一个可写的 stream



