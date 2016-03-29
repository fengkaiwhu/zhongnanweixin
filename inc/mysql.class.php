<?php
/*
 *数据库连接基本信息
 *dbname: 数据库名
 *username: 登录用户名
 *passwd: 登录数据库的密码
 */
$dbinfo=array(
    "dsn"=>"mysql:host=127.0.0.1;dbname=hospital",
    "username"=>"root",
    "passwd"=>"nercms"
);

define("DB_HOST", "127.0.0.1");
define("DB_PORT", "3306");
define("DB_USER", "root");
define("DB_PASS", "nercms");
define("DB_NAME", "hospital");
define("APPID", "wx777c25c676b36289");
define("APPSECRET", "977d97c23c77a7af29f4889fab8ff9a3");

class mysqlpdo extends PDO{
    //构造函数第一个参数表示数据库信息,第二个参数表示是否使用事物
    function __construct($dbinfo, $isTransaction = False){
        parent::__construct($dbinfo["dsn"],$dbinfo["username"],$dbinfo["passwd"]);
        if($isTransaction){
            $this->setAttribute(PDO::ATTR_AUTOCOMMIT, 0);
            //$this->beginTransaction();
            //$this->commit();
            //$this->rollback();
        }
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $this->exec('SET NAMES utf8');
    }

    function commit(){
        $this->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
        return parent::commit();
    }

    function rollback(){
        $this->setAttribute(PDO::ATTR_AUTOCOMMIT, 1);
        return parent::rollback();
    }

    //计算select语句返回的行数,
    //要获得其他语句如update影响的行数,1. 通过exec可以直接获取 2. prepare+execute方式可以通过PDOStatement::rowCount()方式得到影响行数
    //对于大多数数据库，PDOStatement::rowCount() 不能返回受一条 SELECT 语句影响的行数,可以通过count(*)的方式获取一共有多少行
    //可以用来验证登录,返回0代表登录失败
    //$sql = "select count(*) from fruit where calories > 60"
    function selectNumRows($sql){
        $res = parent::prepare($sql);
        if($res->execute() == True){
            return $res->fetchColumn();//fetchColumn表示取集合中下一行的第一列值
        }else{
            throw new PDOException("查询失败!");
        }
    }
    
    //根据唯一ID获取表中的某一个字段
    //select * from table where id=ID
    function getNameById($sql, $name){
        $res = parent::query($sql);
        $r = $res->fetchAll();
        return $r[0][$name];
    }

    //抛出异常
    //throw new PDOException($message);
}
?>
