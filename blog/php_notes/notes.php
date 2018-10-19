<?php  
//20160814
mysql_connect();//连接数据库
mysql_select_db();//选择数据库
mysql_query('set names utf8');//设置返回传入的字符集
mysql_query("select * from name");//sql
mysql_error();//返回上一条执行数据库的错误

mysql_fetch_row();//遍历数据，索引数组
mysql_fetch_array();//遍历数据，索引+关联数组，可以设置第二个参数
mysql_fetch_assoc();//遍历数据，关联数组
mysql_fetch_object();//遍历数据，对象

mysql_num_rows();//获取结果集中的数目,可以先判断有没有数据，在遍历数据
mysql_result(标识符, 第几条,字段或序号);//获取结果集中某个字段
mysql_affected_rows();//最近一次增，删，改受影响的行数

// 类,关键字extends只能继承一个父类，单继承原则
//方法名跟父类一样的话，会被重写
class nba extends abc{
	public static $b=1;
	//静态关键字static,
	//调用本类：self(static)::静态属性(方法)，调用父类parent::
	//静态方法 不能访问属性
	public $a=1;//公共的
	protected $b=2;//受保护的，只有自身和子类能访问
	private $c=3;//私有的，不能被子类访问
	function __construct(){}// 构造函数，类实例时自动执行
	function __destruct(){}// 析构函数，类调用完后执行
	final public function abc(){}//final关键字禁止子类重写
	//parent:: 关键字可以访问父类被重写的方法
	//static:: ，self::关键字可以访问自身方法
}


// 接口，关键字extends实现接口继承
interface ic{
	//接口中不需要实现方法
	public function eat();
}
//implements 关键字实现某个接口
class a implements ic(){
	//必须提供接口中定义的方法
	public function eat(){}
}
var_dump($obj instanceof ic);//instanceof 判断是否实现了某个接口


//定义抽象类
abstract class id{
	//abstract标明这个方法是抽象方法，不需要具体实现
	abstract public function eat();
}
class h extends id{
	//继承抽象类需要定义抽象类中的抽象方法
	public function eat(){}
}


// 魔术方法
class mo{
	//__tostring	当对象被当作string使用时，会自动调用;echo $obj;
	public function __tostring(){}
	//__invoke		当对象被当作方法使用时，会自动调用;$obj();
	public function __invoke(){}
	//$name:方法名称;$arguments:传入的参数。当对象访问不存在的方法名称时，会自动调用。称为重载
	public __call($name,$arguments){}
	//当对象访问不存在的静态方法名称时，会自动调用。称为重载
	public static __callStatic($name,$arguments){
		//调用 类名::静态方法名
	}
	//读取不可访问或未定义的属性时，被调用,$name被调用的属性名
	public __get($name){}
	//在给不可访问或未定义的属性赋值时，被调用;$name被调用的属性名,$value属性值
	public __set($name,$value){}
	//当对不可访问属性调用isset()或empty()时，被调用
	public __isset($name){}
	//当对不可访问属性调用unset()时，被调用
	public __unset($name){}
	//clone 复制.初始化复制 
	public __clone(){}
	
}
 

// mysqli安装
// 1.php.ini--开启php_mysqli.dll
// 2.php.ini--配置extension_dir=""  ext所在目录
//检测mysqli扩展是否开启4种方式
phpinfo();//查看php环境信息
var_dump(extension_loaded("mysqli"));//检测扩展是否加载
var_dump(function_exists("mysqli_connect"));//检测函数是否存在
print_r(get_loaded_extensions());//打印当前已开启的扩展

$mysqli=new mysqli('127.0.0.1','root','root','test');//连接数据库
$mysqli=new mysqli();
$mysqli->connect('127.0.0.1','root','root','test');//连接数据库
$mysqli->select_db('test');//选择数据库
$mysqli->set_charset('utf8');//设置字符集
$mysqli->connect_errno();//错误编号
$mysqli->connect_error();//错误信息
$mysqli->close();



// 页面静态化
file_put_contents(filename, data);//生成缓存文件
ob_start()//打开输出控制缓冲
ob_get_contents(oid)//返回输出缓冲区内容
ob_clean(oid)//清空输出缓冲区
ob_get_clean(oid)//得到当前缓冲区并删除


?>