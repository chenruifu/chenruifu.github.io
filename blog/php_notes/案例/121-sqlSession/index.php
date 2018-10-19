<?php 
header("Content-Type: text/html; charset=utf-8");
class session{
	static $db;//数据库操作句柄
	static $table;//数据库表名
	static $max_time;//session保存时间
	static $card;//用户标签
	//SESSION初始化
	static function run(){
		if(ini_get("session.save_handler") == "user" || ini_set("session.save_handler", "user")){
			session_set_save_handler(
				array(__CLASS__,"start"),
				array(__CLASS__,"close"),
				array(__CLASS__,"read"),
				array(__CLASS__,"write"),
				array(__CLASS__,"destroy"),
				array(__CLASS__,"gc"));
				ob_start();
				//error_reporting(0);//阻止错误输出
				self::$db = new mysqli("localhost","root","root","ruei");
				!mysqli_connect_errno() or die("数据库连接错误");
				self::$db->query("SET NAMES GBK");
				//SESSION表
				self::$table="session";
				self::$max_time = 600;
				self::$card = md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']);
				session_start();				
		} 
	}
	//开启
	static function start($path,$session_id){
		return true;
	}
	//关闭
	static function close(){
		self::gc(self::$max_time);
		self::$db->close();
		return true;
	}
	//读取
	static function read($sid){
		$sql="select data from ".self::$table." where sid='".$sid."' and card='".self::$card."'";
		$result = self::$db->query($sql);
		$row = $result->fetch_assoc();
		return self::$db->affected_rows>0?$row['data']:'';
	}
	//写入
	static function write($sid,$data){
		$sql="select data from ".self::$table." where sid='".$sid."' and card='".self::$card."'";
		$result = self::$db->query($sql);//发送一条 MySQL 查询
		$row = $result->fetch_assoc();//从结果集中取得一行作为关联数组
		$mtime = time();
		if(self::$db->affected_rows>0){//取得前一次 MySQL 操作所影响的记录行数
			$sql = "update ".self::$table." set data='".$data."',mtime='".$mtime."' where sid='".$sid."'";		
			echo $sql;
		}else{
			$sql = "insert into ".self::$table." (sid,data,mtime,ip,card) values('".$sid."','".$data."','".time()."','".$_SERVER['REMOTE_ADDR']."','".self::$card."')";
		}
		return self::$db->query($sql)?true:false;
	}
	//卸载
	static function destroy($sid){
		$sql = "delete from ".self::$table." where sid=".$sid;
		self::$db->query($sql);
		return true;
	}
	//垃圾回收
	static function gc($max_time){
		$max_time = self::$max_time;
		$sql = "delete from ".self::$table." where mtime<'".(time()-$max_time)."'";
		self::$db->query($sql);
		return true;
	}
}
session::run();
?>