### CSS3渐变色
```css
background: linear-gradient(to bottom, #000000 0%,#ffffff 100%);
background: -webkit-linear-gradient(top, #000000 0%,#ffffff 100%);
background: -moz-linear-gradient(top, #000000 0%, #ffffff 100%);
background: -o-linear-gradient(top, #000000 0%,#ffffff 100%);
background: -ms-linear-gradient(top, #000000 0%,#ffffff 100%);
background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#000000), color-stop(100%,#ffffff));
```

### 单行溢出省略号
```css
overflow: hidden;text-overflow: ellipsis;white-space: nowrap;

display: -webkit-box;-webkit-line-clamp: 3;
```

### sublime text3使用技巧
* htmlpretty - 格式化插件（Ctrl+Shift+H） 
* Ctrl+Shift+Y  实现算术
* li*8>a[href="javascript:;"]{2009-12*$@0}
* 修改默认编码高亮：右下角选择，open

### 设置cmd默认启动路径
1、打开注册表regedit
2、进到目录：HKEY_CURRENT_USER\Software\Microsoft\Command Processor
3、新建字符串值：autorun
4、设置数据： cd /d E:\  