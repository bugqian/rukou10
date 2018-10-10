<?php

$url=$_GET["redicturl"];
pregurl($url);

function pregurl($url)
{
    $api='http://sapi.gerenwang.net/getdomain/'.rand(5,20);
    //测试
//跳转到广告
    if(strpos($url, 'haread')){
        //type adshare-wba
        $domain=http_request($api.'?type=adshare-wba');
        $adid=substr($url, 7);
        header('Location:http://'.$domain.'/adshare/'.rand(100,99999).'?ad='.$adid,302);
        return;
    }
    if(strpos($url, 'fb39124c93e85079d78b54dd1c1e4dc5')){
        $domain=http_request($api.'/?type=login-jump-qun');
        // $domains=['204ptk.cn'];//备用域名
        header('Location:http://'.$domain.'/sej/e'.rand(3,30).'NnPim/?z=57&y=fb39124c93e85079d78b54dd1c1e4dc5',302);
    }else{
        $domain=http_request($api.'/?type=login-jump-video');
        $case_no=['a9600bb3f2be2db35d06050263d4a559','16dcc0551b5d6c70908fb801ef1aa127','aaa23caa38aa1071d98dc62197dc48fa81b5b','e010eb2b2899317956be4247072d603d','b7a10c71a7dddd72ddf0a7d8ed12bfdc'];
        $case_no=$case_no[array_rand($case_no)];
        header('Location:http://'.$domain.'/sej/eKNnP'.rand(3,30).'im/?z=57&y='.$case_no,302);
    }
    return;

}



  /*
    * GET 请求
    * @param string $url
    */
    function http_request($URI, $isHearder = false, $post = false)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URI);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);          //单位 秒，也可以使用
#curl_setopt($ch, CURLOPT_NOSIGNAL, 1);     //注意，毫秒超时一定要设置这个
#curl_setopt($ch, CURLOPT_TIMEOUT_MS, 200); //超时毫秒，cURL 7.16.2中被加入。从PHP 5.2.3起可使用
    curl_setopt($ch, CURLOPT_HEADER, $isHearder);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/45.0.2454.85 Safari/537.36');
    curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/tmp.cookie");
    curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/tmp.cookie");
    if(strpos($URI, 'https') === 0){
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    if($post){
        curl_setopt ($ch, CURLOPT_POST, 1);
        curl_setopt ($ch, CURLOPT_POSTFIELDS, $post);
    }
    $result = curl_exec($ch);
   
    curl_close($ch);
    return $result;

}
