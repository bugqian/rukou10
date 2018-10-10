<?php
/**
 * Created by PhpStorm.
 * User: bugqian
 * Date: 2018/10/9
 * Time: 下午9:51
 */

namespace app\index\controller;


use think\Controller;
use think\Request;

class Getluodi extends Controller
{
    public function getLuodi(Request $request)
    {
        $param = $request->param();
        $case_no = $param['redicturl'];//案例编号
        if (strpos($case_no, 'haread')) {
            $adid = substr($case_no, 7);
            header('Location:http://' . Common::getadDomain() . '/adshare/' . rand(100, 99999) . '?ad=' . $adid, 302);
            return;
        }

//        if (strpos($case_no, 'fb39124c93e85079d78b54dd1c1e4dc5')){
//
//            header('Location: http://ijj.anxugene.com/video/boNEJsoJ0B4w5?redicturl=ppdnxssvqwfb39124c93e85079d78b54dd1c1e4dc5.gif&djxtu=39&t=1538637331');
//            return;
//        }else{
//
//            header('Location: http://ijj.18662517007.com/video/boNEJsoJ0B4w5?redicturl=ppdnxssvqwfb39124c93e85079d78b11154dd1c1e4dc5.gif&djxtu=39&t=1538637331');
//            return;
//        }
        $exampleset = Common::getExampleSet();
        //区分视频和群case的线路pid

        if (strpos($case_no, '8051fb1cfcea577c306e236fbbd55a73')) {
            $pids = json_decode($exampleset['hbpid']);
            $frame = 'a=hb&b=case';
            $frameID = 4;
            $case_no = '8051fb1cfcea577c306e236fbbd55a73';
            $vid = time();
        } else if (strpos($case_no, 'fb39124c93e85079d78b54dd1c1e4dc5')) {
            $pids = json_decode($exampleset['qunpid']);
            $frame = 'a=spequnsdfsds&b=case';
            $frameID = 2;
            $case_no = 'fb39124c93e85079d78b54dd1c1e4dc5';
            $vid = time();
        } else {
            $pids = json_decode($exampleset['videopid']);
            $frame = 'a=spevnVUukFtLcnSfedJL&b=case';
            $frameID = 1;
            $caseinfo = Common::getVideoCaseNo();
            $case_no = $caseinfo['case_no'];
            $vid = $caseinfo['vid'];
        }

        $pid = $pids[array_rand($pids)];
        //第三步 得到case的框架
        $case_no = Common::checkCaseNo($case_no, $frameID);
        //第四步 得到code
        $code = Common::randStr(rand(10, 20));//x
        //第五步 得到back-luodi域名
        $domain = Common::getLuodiByCasetype($case_no,$pid);
        $back = '';
        if (isset($param['ct']) || isset($param['f'])) {
            $back = '&ct=' . $param['ct'] . '&f=' . $param['f'];
        }
        //第六步 拼接成链接
        $url = 'http://' . $domain . '/?z=' . $pid . '&y=' . $case_no . '&x=' . $code . '&v=' . $vid . '&' . $frame . $back;
        if (isset($param['tip'])) {
            $url = 'http://' . $domain . '/?z=' . $pid . '&y=' . $case_no . '&x=' . $code . '&v=' . $vid . '&' . $frame . '&tip=' . $param['tip'] . $back;
        }
        header('Location: ' . $url);

    }

}