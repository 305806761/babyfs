<?php
/**
 * Created by PhpStorm.
 * User: malil
 * Date: 2016/10/10
 * Time: 14:17
 */

namespace app\models;
use Yii;
use yii\base\Model;


class Tool extends Model
{
    /**
     * 生成随机数
    **/
    static function GetCode($len=4) {
        $secret = '';
        for ( $i = 0; $i<$len; $i++ ) {
                if ( 0==$i ) {
                    $secret .= chr(rand(49, 57));
                } else {
                    $secret .= chr(rand(48, 57));
                }
            }

        return $secret;
    }

    /**
     * 设置cookie的有效时间
     **/

    static function cookieset($k, $v, $expire = 0) {
        //$pre = substr(md5($_SERVER['HTTP_HOST']), 0, 4);
        //$k = "{$pre}_{$k}";
        $arr = explode('.', $_SERVER['HTTP_HOST']);
        $domain = '.' . $arr[count($arr)-2] . '.' . $arr[count($arr)-1];
        if ( $expire==0 ) {
            $expire = time()+30*86400;
        } else {
            $expire += time();
        }
        setCookie($k, $v, $expire, '/', $domain);
    }

    /**
     * 设置cookie的有效时间
     **/

    static function sessionset($k, $v, $expire = 0) {
        //$pre = substr(md5($_SERVER['HTTP_HOST']), 0, 4);
        //$k = "{$pre}_{$k}";
        $arr = explode('.', $_SERVER['HTTP_HOST']);
        $domain = '.' . $arr[count($arr)-2] . '.' . $arr[count($arr)-1];
        if ( $expire==0 ) {
            $expire = time()+30*86400;
        } else {
            $expire += time();
        }
        setCookie($k, $v, $expire, '/', $domain);
    }

    /**
     * 发送短信
     **/

    static function Send($mobile,$message)
    {
        header("Content-type: text/html; charset=utf-8");
        date_default_timezone_set('PRC'); //设置默认时区为北京时间
        //短信接口用户名 $uid
        $uid = 'TCLK02695';
        //短信接口密码 $passwd
        $passwd = '123321';

        $num =$mobile;
        //短信内容进行中文转码
        $msg = rawurlencode(mb_convert_encoding($message, "gb2312", "utf-8"));
        //内容参数填充
        $gateway = "http://inolink.com/ws/BatchSend2.aspx?CorpID={$uid}&Pwd={$passwd}&Mobile={$num}&Content={$msg}&Cell=&SendTime=";
        //提交短信，并获取提交返回值
        $result = file_get_contents($gateway);
        return $result >=0 ? true : $result;
    }

    static private function GetHttpContent($fsock = null) {
        $out = null;
        while ( $buff = @fgets($fsock, 2048) ) {
            $out .= $buff;
        }
        fclose($fsock);
        $pos = strpos($out, "\r\n\r\n");
        $head = substr($out, 0, $pos); //http head
        $status = substr($head, 0, strpos($head, "\r\n")); //http status line
        $body = substr($out, $pos+4, strlen($out)-($pos+4)); //page body
        if ( preg_match("/^HTTP\/\d\.\d\s([\d]+)\s.*$/", $status, $matches) ) {
            if ( intval($matches[1])/100==2 ) {
                return $body;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    static public function DoGet($url) {
        $url2 = parse_url($url);
        $url2["path"] = ($url2["path"]=="" ? "/" : $url2["path"]);
        $url2["port"] = ($url2["port"]=="" ? 80 : $url2["port"]);
        $host_ip = @gethostbyname($url2["host"]);
        $fsock_timeout = 2; //2 second
        if ( ($fsock = fsockopen($host_ip, 80, $errno, $errstr, $fsock_timeout))<0 ) {
            return false;
        }
        $request = $url2["path"] . ($url2["query"] ? "?" . $url2["query"] : "");
        $in = "GET " . $request . " HTTP/1.0\r\n";
        $in .= "Accept: */*\r\n";
        $in .= "User-Agent: Payb-Agent\r\n";
        $in .= "Host: " . $url2["host"] . "\r\n";
        $in .= "Connection: Close\r\n\r\n";
        if ( !@fwrite($fsock, $in, strlen($in)) ) {
            fclose($fsock);
            return false;
        }
        return self::GetHttpContent($fsock);
    }

    static public function DoPost($url, $post_data = array()) {
        $url2 = parse_url($url);
        $url2["path"] = ($url2["path"]=="" ? "/" : $url2["path"]);
        $url2["port"] = ($url2["port"]=="" ? 80 : $url2["port"]);
        $host_ip = @gethostbyname($url2["host"]);
        $fsock_timeout = 2; //2 second
        if ( ($fsock = fsockopen($host_ip, 80, $errno, $errstr, $fsock_timeout))<0 ) {
            return false;
        }
        $request = $url2["path"] . ($url2["query"] ? "?" . $url2["query"] : "");
        $post_data2 = http_build_query($post_data);
        $in = "POST " . $request . " HTTP/1.0\r\n";
        $in .= "Accept: */*\r\n";
        $in .= "Host: " . $url2["host"] . "\r\n";
        $in .= "User-Agent: Lowell-Agent\r\n";
        $in .= "Content-type: application/x-www-form-urlencoded\r\n";
        $in .= "Content-Length: " . strlen($post_data2) . "\r\n";
        $in .= "Connection: Close\r\n\r\n";
        $in .= $post_data2 . "\r\n\r\n";
        unset($post_data2);
        if ( !@fwrite($fsock, $in, strlen($in)) ) {
            fclose($fsock);
            return false;
        }
        return self::GetHttpContent($fsock);
    }

    static function HttpRequest($url, $data = array()) {
        if ( !function_exists('curl_init') ) {
            return empty($data) ? self::DoGet($url) : self::DoPost($url, $data);
        }
        $ch = curl_init();
        if ( is_array($data)&&$data ) {
            $formdata = http_build_query($data);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $formdata);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 2);
        $result = curl_exec($ch);
        return $result ? $result : (empty($data) ? self::DoGet($url) : self::DoPost($url, $data));
    }

    /**
     *   对象转换 数组 函数
     *  @param $Object  需要转换的对象
     *  return array
     */
    static function objectArray($Object) {
        $arr = array();
        $_arr = is_object($Object) ? get_object_vars($Object) : $Object;
        foreach ($_arr as $key => $val) {
            $val = (is_array($val) || is_object($val)) ? self::objectArray($val) : $val;
            $arr[$key] = $val;
        }
        return $arr;
    }

    //跳转，可带提示
    static function Redirect($url = null, $message = '', $type = 'notice')
    {
        $url = empty($url) ? $_SERVER['HTTP_REFERER'] : $url;
        $url = empty($url) ? '/' : $url;
        if ( $message ) {
            self::cookieset($type,$message,10);
//            if (!Yii::$app->session->isActive) {
//                Yii::$app->session->open();
//            }
//            Yii::$app->session->set($type,$message);
        }
        header("Location: {$url}");
        exit;
    }







}