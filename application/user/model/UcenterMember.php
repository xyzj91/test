<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace app\user\model;
use think\Model;
use think\Debug;
/**
 * 会员模型
 */
class UcenterMember extends Model{
	/**
	 * 数据库连接
	 * @var string
	 */
	// 设置当前模型的数据库连接
    protected $connection = [
        // 数据库类型
        'type'        => DB_TYPE,
        // 服务器地址
        'hostname'    => DB_HOSTNAME,
        // 数据库名
        'database'    => DB_DATABASE,
        // 数据库用户名
        'username'    => DB_NAME,
        // 数据库密码
        'password'    => DB_PWD,
        // 数据库编码默认采用utf8
        'charset'     => DB_CHARSET,
        // 数据库表前缀
        'prefix'      => DB_PREFIX,
        // 数据库调试模式
        'debug'       => false,
    ];
	
	protected $_validate = array(
		/* 验证用户名 */
		array('username', 'require|length:1,30|checkDenyMember|unique:member','-1|-1|-2|-3'), //用户名长度不合法
		/* 验证密码 */
		array('password', 'length:6,30','-4'), //密码长度不合法
		/* 验证邮箱 */
		array('email', 'email|length:1,32|checkDenyEmail|unique:member','-5|-6|-7|-8'), //邮箱格式不正确
		/* 验证手机号码 */
		array('mobile', '//|checkDenyMobile|unique:member', '-9|-10|-11'), //手机格式不正确 TODO:
	);
	
	/* 用户模型自动验证 */
//	protected $_validate = array(
//		/* 验证用户名 */
//		array('username', '1,30', -1, 0, 'length'), //用户名长度不合法
//		array('username', 'checkDenyMember', -2, 0, 'callback'), //用户名禁止注册
//		array('username', '', -3, 0, 'unique'), //用户名被占用
//
//		/* 验证密码 */
//		array('password', '6,30', -4, 0, 'length'), //密码长度不合法
//
//		/* 验证邮箱 */
//		array('email', 'email', -5, 0), //邮箱格式不正确
//		array('email', '1,32', -6, 0, 'length'), //邮箱长度不合法
//		array('email', 'checkDenyEmail', -7, 0, 'callback'), //邮箱禁止注册
//		array('email', '', -8, 0, 'unique'), //邮箱被占用
//
//		/* 验证手机号码 */
//		array('mobile', '//', -9, 0), //手机格式不正确 TODO:
//		array('mobile', 'checkDenyMobile', -10, 0, 'callback'), //手机禁止注册
//		array('mobile', '', -11, 0, 'unique'), //手机号被占用
//	);

	/* 插入时用户模型自动完成 */
	protected $insert = array(
		'password',
		'reg_time',
		'reg_ip',
		'update_time',
		'status'=> 1
	);
	
	protected function setPasswordAttr($value){
		return think_ucenter_md5($value, UC_AUTH_KEY);
	}
	protected function setReg_timeAttr($value){
		return getTime();
	}
	protected function setUpdate_timeAttr($value){
		return getTime();
	}
	protected function setReg_ipAttr($value){
		return get_client_ip(1);
	}

	/**
	 * 检测用户名是不是被禁止注册
	 * @param  string $username 用户名
	 * @return boolean          ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMember($username){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 检测邮箱是不是被禁止注册
	 * @param  string $email 邮箱
	 * @return boolean       ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyEmail($email){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 检测手机是不是被禁止注册
	 * @param  string $mobile 手机
	 * @return boolean        ture - 未禁用，false - 禁止注册
	 */
	protected function checkDenyMobile($mobile){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 根据配置指定用户状态
	 * @return integer 用户状态
	 */
	protected function getStatus(){
		return true; //TODO: 暂不限制，下一个版本完善
	}

	/**
	 * 注册一个新用户
	 * @param  string $username 用户名
	 * @param  string $password 用户密码
	 * @param  string $email    用户邮箱
	 * @param  string $mobile   用户手机号码
	 * @return integer          注册成功-用户信息，注册失败-错误编号
	 */
	public function register($username, $password, $email, $mobile){
		$data = array(
			'username' => $username,
			'password' => $password,
			'email'    => $email,
			'mobile'   => $mobile,
		);

		//验证手机
		if(empty($data['mobile'])) unset($data['mobile']);

		/* 添加用户 */
		if($this->create($data)){
			$uid = $this->add();
			return $uid ? $uid : 0; //0-未知错误，大于0-注册成功
		} else {
			return $this->getError(); //错误详情见自动验证注释
		}
	}

	/**
	 * 用户登录认证
	 * @param  string  $username 用户名
	 * @param  string  $password 用户密码
	 * @param  integer $type     用户名类型 （1-用户名，2-邮箱，3-手机，4-UID）
	 * @return integer           登录成功-用户ID，登录失败-错误编号
	 */
	public function login($username, $password, $type = 1){
		$map = array();
		switch ($type) {
			case 1:
				$map['username'] = $username;
				break;
			case 2:
				$map['email'] = $username;
				break;
			case 3:
				$map['mobile'] = $username;
				break;
			case 4:
				$map['id'] = $username;
				break;
			default:
				return 0; //参数错误
		}
		/* 获取用户数据 */
		$user = $this->where($map)->find();
		if($user['status']){
			/* 验证用户密码 */
			if(think_ucenter_md5($password, UC_AUTH_KEY) === $user['password']){
				$this->updateLogin($user['id'],$password); //更新用户登录信息
				return $user['id']; //登录成功，返回用户ID
			} else {
				return -2; //密码错误
			}
		} else {
			return -1; //用户不存在或被禁用
		}
	}

	/**
	 * 获取用户信息
	 * @param  string  $uid         用户ID或用户名
	 * @param  boolean $is_username 是否使用用户名查询
	 * @return array                用户信息
	 */
	public function info($uid, $is_username = false){
		$map = array();
		if($is_username){ //通过用户名获取
			$map['username'] = $uid;
		} else {
			$map['id'] = $uid;
		}

		$user = $this->where($map)->field('id,username,email,mobile,status')->find();
		if(is_array($user) && $user['status'] = 1){
			return array($user['id'], $user['username'], $user['email'], $user['mobile']);
		} else {
			return -1; //用户不存在或被禁用
		}
	}

	/**
	 * 检测用户信息
	 * @param  string  $field  用户名
	 * @param  integer $type   用户名类型 1-用户名，2-用户邮箱，3-用户电话
	 * @return integer         错误编号
	 */
	public function checkField($field, $type = 1){
		$data = array();
		switch ($type) {
			case 1:
				$data['username'] = $field;
				break;
			case 2:
				$data['email'] = $field;
				break;
			case 3:
				$data['mobile'] = $field;
				break;
			default:
				return 0; //参数错误
		}

		return $this->create($data) ? 1 : $this->getError();
	}

	/**
	 * 更新用户登录信息
	 * @param  integer $uid 用户ID
	 */
	protected function updateLogin($uid,$password){
		$data = array(
			'last_login_time' => getTime(),
			'last_login_ip'   => get_client_ip(1),
		);
		$this->save($data,["id"=>$uid]);
	}

	/**
	 * 更新用户信息
	 * @param int $uid 用户id
	 * @param string $password 密码，用来验证
	 * @param array $data 修改的字段数组
	 * @return true 修改成功，false 修改失败
	 * @author huajie <banhuajie@163.com>
	 */
	public function updateUserFields($uid, $password, $data){
		if(empty($uid) || empty($password) || empty($data)){
			$this->error = '参数错误！';
			return false;
		}

		//更新前检查用户密码
		if(!$this->verifyUser($uid, $password)){
			$this->error = '验证出错：密码不正确！';
			return false;
		}

		//更新用户信息
		$data = $this->create($data);
		if($data){
			return $this->where(array('id'=>$uid))->save($data);
		}
		return false;
	}

	/**
	 * 验证用户密码
	 * @param int $uid 用户id
	 * @param string $password_in 密码
	 * @return true 验证成功，false 验证失败
	 * @author huajie <banhuajie@163.com>
	 */
	protected function verifyUser($uid, $password_in){
		$password = $this->getFieldById($uid, 'password');
		if(think_ucenter_md5($password_in, UC_AUTH_KEY) === $password){
			return true;
		}
		return false;
	}

}
