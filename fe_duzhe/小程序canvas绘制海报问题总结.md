> 业务中碰到微信小程序需要生成海报进行朋友圈分享，这个是非常常见的功能，没想到实际操作的时候花了整整一天一夜才搞好...

## 网络图片绘制

业务非常简单，只需要将用到的图片，文案素材拼装到一张图片，保存到本地就可以了。

首先创建画布，将一张网上的图片画到画布上。

```js
const ctx = wx.createCanvasContext('shareCanvas');
ctx.drawImage("https://img3.doubanio.com/view/photo/l/public/p2327709524.jpg", 0, 0, 300, 400);
ctx.draw();
```

这时候出现一个问题：在模拟器上没有报错，可是真机测试却什么也没画出来。网上搜索一阵发现微信小程序的 canvas.drawImage 是不支持网络图片的，只支持本地图片。所以，任何的网络图片都需要先缓存到本地，再通过 drawImage 调用存储的本地资源进行绘制，缓存可以通过 wx.getImageInfo 和 wx.downloadFile 实现，这次选用了 wx.getImageInfo, wx.downloadFile 没有试过，不知道可不可以。

```js
wx.getImageInfo({
    src: 'https://img3.doubanio.com/view/photo/l/public/p2327709524.jpg',
    success: function (res) {
        console.log(res.width)
        console.log(res.path)
    }
})
```

这个方法可以拿到存储的本地图片地址，长宽以及一些简单的图形变化，将本地缓存的图片地址保存到全局变量或者缓存供 wx.drawImage 调用。

还有一点需要注意的是 draw 方法是异步的，如果图片还没加载成功，有可能画出来的是空的，所以 draw 方法通常都会带有定时器这样的回调。

```js
ctx.draw(true,setTimeout(function(){
    wx.canvasToTempFilePath({
        canvasId: 'shareCanvas',
        success: function(res){
            that.data.tmpPath = res.tempFilePath
        },
    })
},1000));
```

## 图片保存的授权问题

绘图后通过 1 秒的延时将画好的新图片保存到本地，然后通过 wx.saveImageToPhotosAlbum() 保存到手机相册。这一步存在授权问题，需要考虑拒绝授权后的兼容性，也就是如果用户拒接授权以后怎么办？常见的做法是先通过 wx.getSetting() 获取用户的权限设置，如果用户拒绝了访问相册的权限，可以跳转到授权设置页面要求用户更改授权信息。

小程序的授权设置 api 已经弃用了，现在只能通过组件形式，将 button 的 open-type 属性设置成 openSetting，自动跳转到设置页面，总体来说没有之前方便了。如果页面本来已经有 button可以先将 open-type 属性设成 null，当遇到需要跳转的逻辑再通过 setData 设置，这样处理非常复杂，很容易出错，但是可以节省页面或者跳转；另一种处理方式是，当没有授权时先跳转到说明页面，说明需要授权的信息，在这个页面上添加一个 open-type 的button，点击以后跳转到设置页面。

## 文字编辑换行

下一步是文字编辑的问题，微信画文字是不支持自动换行的，所以只能手动计算每一行能够容纳的文字个数进行手动换行，比如一个文字加间距占 10 px，一行整体可以使用 100 px，那就是每行只能容纳 10 个字，第 11 个字另起一行开始画。

将文字分割成 10 个字的数组：

```js
function canvasWorkBreak(maxWidth, fontSize, text) {
    const maxLength = maxWidth / fontSize
    const textLength = text.length
    let textRowArr = []
    let tmp = 0
    while (1) {
        textRowArr.push(text.substr(tmp, maxLength))
        tmp += maxLength
        if (tmp >= textLength) {
            return textRowArr
        }
    }
}
```

将数组一行一行画到画布上：

```js
var height = 200
for (let item of ['我的舍利佛','搜房法拉']) {
    if (item !== '') {
        ctx.setFontSize(16);
        ctx.setFillStyle("#484a3d");
        ctx.fillText(item, 20, height);
        height += 50;
    }
}
```

## 多图绘制

把每一种元素画完以后整个海报制作的流程就已经跑通了，但并不代表在实际业务中就可以使用了。首先面对的是海报生成的质量问题，假设我们的手机像素是 320 * 400 的，如果要将图片展示在手机上用于预览，只有两种选择：

- 画一个分辨率小于手机分辨率的海报，让手机能完整的展示出来。但是这样的海报由于分辨率小，下载到手机相册分享用大屏手机观看的时候就非常影响体验了。这种做法的解决方案可以是画 2 张图，手机预览时隐藏大图，只显示小图；下载的时候将大图保存起来。

- 画一张大图，直接通过 previewImage 进入手机预览模式，预览模式的图片可以直接保存到本地。这种方案的缺点在于预览模式无法设计 UI，且下载的时候不能自定义文案，由于下载保存的入口很隐蔽，用户不一定能发现。

## 图片太长怎么办？

上面的图实际上是比较长的，你可以截取一部分显示出来，这样图片看起来就会更协调。在通过正常比例绘制完图片以后，可以通过填充矩形的方式覆盖一部分图片，然后在矩形上输入其他的内容，这样图片的一部分就被隐藏起来了。

## 按钮置于最上层

由于 canvas 是优先级最高的，总是会覆盖页面上的其他内容，所以「保存图片」的按钮可能会被覆盖掉而显示不出来，可以通过在 button 上套一层 cover-view 来解决。

## 总结

图片绘制本来应该是一个非常简单也非常成熟的技术，其他的框架都会有对应的组件来处理这些事情，可是微信小程序的 canvas 绘制可以用「非常难用」来形容，希望微信团队能尽快优化。
