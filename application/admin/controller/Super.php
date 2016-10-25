<?php
// +----------------------------------------------------------------------
// | StarCMS  全新起点  用心创造
// +----------------------------------------------------------------------
// | Copyright (c) 深圳乐创网络科技有限公司
// +----------------------------------------------------------------------
// | Author: Alen <1621523332@qq.com>   
// +----------------------------------------------------------------------
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use app\User\Api\UserApi;
//全局控制器，不需要登录
class Super extends Controller{
    /**
     * 初始化方法
     * @author tangtanglove
     */
    protected function _initialize()
    {
        // 检测程序安装
//      if(!is_file(ROOT_PATH . 'data/install.lock')){
//          $this->redirect(url('install/index/index'));
//      }
        load_config();// 加载接口配置   
        $config =   cache('DB_CONFIG_DATA');
		$this->assign("meta_title",$config["WEB_SITE_TITLE"]);
		$this->assign("meta_description",$config["WEB_SITE_DESCRIPTION"]);
		$this->assign("meta_keyword",$config["WEB_SITE_KEYWORD"]);   
    }

   /**
	* login 后台用户登录
	* @author Alen 2016-10-15 20:59:07
	*/
    public function login()
    {
        if (Request::instance()->isPost()) {
        	$username = input('post.username');
            $password = input('post.password');
        	/* 调用UC登录接口登录 */
            $User = new UserApi;
			$uid = $User->login($username, $password);
			if(0 < $uid){ //UC登录成功
                /* 登录用户 */
                $Member = model('Member');
                if($Member->login($uid)){ //登录用户
                    //TODO:跳转到登录前页面
                    $this->success('登录成功！', url('Index/index'));
                } else {
                    $this->error($Member->getError());
                }

            } else { //登录失败
                switch($uid) {
                    case -1: $error = '用户不存在或被禁用！'; break; //系统级别禁用
                    case -2: $error = '密码错误！'; break;
                    default: $error = '未知错误！'; break; // 0-接口参数错误（调试阶段使用）
                }
                $this->error($error);
            }
//          $username = input('post.username');
//          $password = input('post.password');
//          $captcha  = input('post.captcha');
//          // 实例化验证器
//          $validate = Loader::validate('Login');
//          // 验证数据
//          $data = ['username'=>$username,'password'=>$password,'captcha'=>$captcha];
//          // 加载语言包
//          $validate->loadLang();
//          // 验证
//          if(!$validate->check($data)){
//              return $this->error($validate->getError());
//          }
//          $where['username'] = $username;
//          $where['status']   = 1;
//          $userInfo = Db::name('Users')->where($where)->find();
//          if ($userInfo && $userInfo['password'] === minishop_md5($password,$userInfo['salt'])) {
//              $session['uid']       = $userInfo['id'];
//              $session['username']  = $userInfo['username'];
//              $session['nickname']  = $userInfo['nickname'];
//              $session['email']     = $userInfo['email'];
//              $session['mobile']    = $userInfo['mobile'];
//              // 记录用户登录信息
//              session('admin_user_auth',$session);
//              return $this->success('登陆成功！',url('admin/index/index'));
//          } else {
//              return $this->error('密码错误！');
//          }

        } else {
        	if(is_login()){
                $this->redirect('Index/index');
            }else{
            	return $this->fetch('login');
			}	
        }
    }

    /**
     * 系统验证码方法
     * @author  tangtanglove <dai_hang_love@126.com>
     */
    public function captcha()
    {
        $captcha = new \org\Captcha(config('captcha'));
        $captcha->entry();
    }
}
