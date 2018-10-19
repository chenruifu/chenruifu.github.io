## 目录指令
mkdir       创建目录（-p 确保目录名称存在，不存在的就创建）
rmdir       删除目录
pwd         查看当前工作目录
ls          浏览当前目录
cd          切换目录
ln          创建同步链接（-s 软链接）
wget        下载文件（-c 继续上一次未完成的下载）
tar         解压文件

## 文件指令
touch       新建文件
cat         查看文件
rm          删除文件（-f 强制性删除）
cp          复制文件（-a 复制目录）
mv          剪切/重命名

## 文本编辑vi
vi          编辑文件（默认进入命令模式）
a           命令模式 切换到 编辑模式
:           命令模式 切换到 末行模式
esc键       编辑模式 或 末行模式 退回到 命令模式

yy          命令模式下__复制一行（可以是2yy复制两行）
p           命令模式下__黏贴
dd          命令模式下__删除一行（可以是2dd删除两行）
/           命令模式下__查找

w           末行模式下__写入
q           末行模式下__退出
!           末行模式下__强制退出

## 运行级别
runlevel    查看当前级别
init        切换级别（0：关机，6：重启，3：文本化界面，5：图形化）

## 网卡设置
ping        查看网络是否连通
ifconfig    查看当前IP
route       查看网关

网络配置文件：/etc/sysconfig/network-scripts/ifcfg-***
开启当前配置：onboot=yes
重启服务：service network restart
查看DNS：cat /etc/resolv.conf

## 用户操作
su          切换用户

超级用户：root
普通用户：默认只能操作用户目录/home/[username]

## 

## 虚拟机安装CentOS 7
1. 新建虚拟机根据提示默认一直下一步就行了
![20183819141](http://cdn.chenrf.com/20183819141.png)

2. 开机前，设置使用的CentOS系统IOS镜像文件
![201838191738](http://cdn.chenrf.com/201838191738.png)

3. 开机，选择第一项安装
![201838191922](http://cdn.chenrf.com/201838191922.png)

4. 设置后开始安装
![201838192442](http://cdn.chenrf.com/201838192442.png)

5. 设置下管理员root密码，创建用户随意
![201838192616](http://cdn.chenrf.com/201838192616.png)

> 安装成功后，上不了网（解决方案）
![20183819548](http://cdn.chenrf.com/20183819548.png)
![2018382250](http://cdn.chenrf.com/2018382250.png)
![2018382277](http://cdn.chenrf.com/2018382277.png)
```
//切换到网络配置目录（必须是root,或者系统管理员）
cd /etc/sysconfig/network-scripts

//查看目录下的文件，找到 ifcfg-***（每个系统的名称可能都是不一样的）

//修改该文件中的onboot=yes（不知道怎么修改，自行百度linux vi编辑器）
vi ifcfg-***

//重启网络服务（两个命令都能用，后者是7的新指令）
service network restart(CentOS 6)
systemctl restart network(CentOS 7)

//ping下网络看能不能连接成功
ping www.baidu.com
```

## NodeJS安装
1. 切换到任意目录可以操作的目录下载NodeJS官网的安装包
![20183822206](http://cdn.chenrf.com/20183822206.png)
```
//下载安装包到当前工作目录
wget https://npm.taobao.org/mirrors/node/v8.9.3/node-v8.9.3-linux-x64.tar.xz

//也可以在后台下载（查看）
wget -bc https://npm.taobao.org/mirrors/node/v8.9.3/node-v8.9.3-linux-x64.tar.xz
cat wget-log
```
2. 解压安装包
```
//解压文件到root目录下
tar -xvf node-v8.9.3-linux-x64.tar.xz -C /root/

//文件夹重命名，默认解压后文件夹名跟压缩包的名称一致（重命名为nodejs）
mv node-v8.9.3-linux-x64 nodejs
```
3. 查看是否安装成功
![201839113914](http://cdn.chenrf.com/201839113914.png)
```
//切换到安装目录下的 bin 目录
./node -v
```
4. 设置全局变量（在任意目录下都能用node命令）
```
//方式一（只在当前的session有效）
export PATH=[安装路径]/bin:$PATH
export PATH=/root/nodejs/bin:$PATH

//方式二（修改环境变量 /etc/profile 文件）
//在export PATH USER LOGNAME MAIL HOSTNAME HISTSIZE HISTCONTROL 一行的上面添加
export PATH=/root/nodejs/bin:$PATH
//使修改的配置文件生效
source /etc/profile 

//方式三（设置软连接）
ln -s [安装路径]/bin/node /usr/local/bin
ln -s /root/nodejs/bin/node /usr/local/bin
ln -s /root/nodejs/bin/npm /usr/local/bin
//如果软链接设置报错，可以进到 /usr/local/bin 下删除对应的文件
```


## 安装MongoDB数据库（大致跟上面安装NodeJS类似）

1. 下载安装包
![2018399298](http://cdn.chenrf.com/2018399298.png)
```
//下载安装包到当前工作目录
wget https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-amazon-3.6.3.tgz

//因为是国外的镜像下载比较慢，可以在后台下载（等下载完再查看）
wget -bc https://fastdl.mongodb.org/linux/mongodb-linux-x86_64-amazon-3.6.3.tgz
cat wget-log
```
2. 解压安装包
```
//解压文件到root目录下
tar -xvf mongodb-linux-x86_64-amazon-3.6.3.tgz -C /root/

//文件夹重命名，默认解压后文件夹名跟压缩包的名称一致（重命名为nodejs）
mv mongodb-linux-x86_64-amazon-3.6.3 mongodb
```
3. 查看是否安装成功
![201839144221](http://cdn.chenrf.com/201839144221.png)
```
//切换到安装目录下的 bin 目录
./mongod -v
```
4. 设置全局变量（在任意目录下都能用 mongod 命令）
```
//方法同上面NodeJS设置的类似这里推荐使用方式二
//在export PATH USER LOGNAME MAIL HOSTNAME HISTSIZE HISTCONTROL 一行的上面添加
export PATH=/root/mongodb/bin:$PATH
//使修改的配置文件生效
source /etc/profile 
```

## Git安装
```
//安装预编译好的 Git 二进制安装包
yum install git-core

git clone       克隆现有仓库
git pull        拉取代码
git add         添加提交文件
git commit      提交代码
git push        推送代码到远端

```







