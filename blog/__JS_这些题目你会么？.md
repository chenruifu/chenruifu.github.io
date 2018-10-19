### 基础

> 1、控制台执行下面的语句结果是什么？为什么？

```js
var a;typeof a;
var s='1s';s++;
!!"false";
!!undefined;
typeof -Infinity;
10%"0";
undefined == null;
false==="";
typeof "2E+2";
a=3e+3;a++;
```


2、执行下面的语句后，v的值是什么？

var v=v||10;

如果v分别是100、0、null ,结果又会是什么？


3、编写一个乘法口诀。


函数：

1、编写一个将16进制转换为颜色的函数。例：#0000FF -> rgb(0,0,255)

2、控制台执行下面的语句结果是什么？为什么？

patseInt(1e1);
patseInt('1e1');
patseFloat('1e1');
isFinite(0/10);
patseInt(20/0);
isNaN(parseInt(NAN));

3、下面alert()弹出的是什么？

var a=1;
function f(){
	function n(){
		alert(a);
	}
	var a=2;
	n();
}

f();

4、下面示例都会弹出 "Boo!" 警告框，解释下其中的原因

var f=alert;
eval('f("Boo!")');

var e;
var f=alert;
eval('e=f')('Boo!');

(function(){
	return alert;
})('Boo!');


对象：

1、下面this值指向的是全局对象还是对象o ？

function F(){
	function C(){
		return this;
	}
	return C();
}

var o=new F();


2、下面代码执行的结果是什么？

function C(){
	this.a=1;
	return false;
}
console.log(typeof new C());

3、下面代码执行的结果是什么？

c = [1,2,[1,2]];
c.sort();
c.join('--');
console.log(c);

4、创建一个与String()构造器相同的对象，可以通过以下测试。

var s=new myString('hello');
s.length; //5
s[0]; //h
s.toString(); //hello
s.valueOf(); //hello
s.charAt(1); //e
s.charAt('2'); //l
s.charAt('e'); //h
s.concat(' world'); //hello world;
s.slice(1,3); //el
s.slice(0,-1); //hell
s.split('e'); //["h","llo"]
s.split('e'); //["h","","o"]


4、创建一个与Array()构造器相同的对象。


4、创建一个与Math()构造器相同的对象。

myMath.rand(min,max,inclusive)--返回min到max区间的一个数；
myMath.min(array)--返回数组中的最小值；
myMath.max(array)--返回数组中的最大值；



