<?php
/**
 * Created by PhpStorm.
 * User: bugqian
 * Date: 2018/10/9
 * Time: 下午10:32
 */

namespace app\index\controller;


use think\Db;
use think\Model;

class Common extends Model
{

    private static $lb_case_content = "lb_case_content";/*case池*/
    //得到示例配置
    public static function getExampleSet()
    {
        $set = Db::table('lb_config')->where('group', 'example')->select();
        $data = [];
        foreach ($set as $key => $val) {
            $data[$val['name']] = $val['value'];
        }
        return $data;
    }

    /*判断访问case的状态*/
    public static function checkCaseNo($case_no, $frameid)
    {
        //查找可用case
        $case_nos = Db::table('lb_mk_content')->field('case_no')->where('statue', 1)->where('frameid', $frameid)->select();
        //判断当前case是否可用
        $res = Db::table('lb_mk_content')->where('case_no', $case_no)->where('statue', 1)->find();
        if (count($res) == 0) {
            $case_no = $case_nos[array_rand($case_nos)];
            $case_no = $case_no['case_no'];
        }
        return $case_no;
    }

    public static function getVid($case_no)
    {
        $content = Db::table('lb_mk_content')->field('config')->where('case_no', $case_no)->find();
        if (count($content) == 0) {
            return 'a05639pbar7';
        }
        $content = json_decode($content['config'], true);
        return $content['vid'];
    }


    /*通过case类型找落地域名*/
    public static function getLuodiByCasetype($case_no,$pid)
    {
        $type_luodi=Db::table('lb_mk_thirdplat')->field(['lbtype'])->where('status',2)->where('pid_type',$pid)->find();

        if ($case_no == 'fb39124c93e85079d78b54dd1c1e4dc5') {
            $type = 'back-qun';
            if($type_luodi['lbtype']=='new'){
                $type='back-qun-new';
            }

        } else if ($case_no == '8051fb1cfcea577c306e236fbbd55a73') {
            $type = 'back-hb';
        } else {

            $type = 'back';
            if($type_luodi['lbtype']=='new'){
                $type='back-new';
            }
        }
        $domains = Db::table('lb_mk_domain_pool')->where('status', 1)->where('account', 'busi-oss')->where('type', $type)->find();

        if(count($domains)==0) {
            $domains = Db::table('lb_mk_domain_pool')->where('status', 1)->where('account', 'busi')->where('type', $type)->find();
        }
        if (count($domains) == 0) {

            $domains = Db::table('lb_mk_domain_pool')->where('status', 1)->where('type', 'back-luodi')->find();
            $domains_arr = explode('.', $domains['domain']);
            $rand = self::getdomainpre();
            $domains['domain'] = $rand . '.' . $domains_arr[count($domains_arr) - 2] . '.' . $domains_arr[count($domains_arr) - 1];
        } else {
            if($domains['account']!='busi-oss'){
                $domains_arr = explode('.', $domains['domain']);
                $rand = self::getdomainpre();
                $domains['domain'] = $rand . '.' . $domains_arr[count($domains_arr) - 2] . '.' . $domains_arr[count($domains_arr) - 1];

            }
        }
        return $domains['domain'];

    }


    public static function getdomainpre()
    {

        $sec = Db::table('lb_mk_allset')->where('id', 1)->find();
        $domain_sec = $sec['domain_sec'];
        $time = 1528475481;
        $t = (time() - $time) / $domain_sec;
        $num = intval($t);
        //$pre = self::randStr(rand(5,15)). $num;
        $pre=$num;
        return $pre;
    }

    public static function getVideoCaseNo()
    {
        $case_nos = Db::table('lb_mk_content')->field(['weight', 'case_no', 'config'])->where('statue', 1)->where('weight','>',1)->where('frameid', 1)->select();
        $case_no = self::commonWeight($case_nos);
        $config = json_decode($case_no['config'], true);
        return ['case_no' => $case_no['case_no'], 'vid' => $config['vid']];
    }

    //权重通用方法
    public static function commonWeight($data)
    {
        $weight = 0;
        $tempdata = [];
        foreach ($data as $key => $val) {
            $weight += $val['weight'];
            for ($i = 0; $i < $val['weight']; $i++) {
                $tempdata[] = $val;
            }
        }
        $use = rand(0, $weight - 1);
        return $tempdata[$use];
    }

    public static function randStr($len)
    {
        $rand = '';
        $str = 'abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($i = 0; $i < $len; $i++) {
            $rand .= $str[rand(0, strlen($str) - 1)];
        }
        return $rand;
    }

    //得到域名
    public static function getadDomain()
    {
        $domains = Db::table('lb_mk_domain_pool')->where('status', 1)->where('type', 'adshare-wba')->find();
        return self::randStr(rand(5, 10)) . '.' . $domains['domain'];
    }

}