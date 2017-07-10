<?php
/**
 * Created by PhpStorm.
 * User: qiangbi
 * Date: 17-3-14
 * Time: 下午4:55
 */
namespace app\common;


use think\Controller;

class EmailUtil extends Controller
{

    /**
     * phpmailer工具发送邮件
     * @param $sendUser 发送者账号
     * @param $sendpwd  发送者密码
     * @param $subject  标题
     * @param $toUser   接收用户
     * @param $sendName 发送者显示名称
     * @param $sendBody 发送内容
     * @return array
     */
    public function phpmailerSend($sendUser, $sendpwd, $subject, $toUser, $sendBody,$fromname,$host)
    {
        $mail = new \PHPMailer;
        $mail->IsSmtp(true);                         // 设置使用 SMTP
        $mail->Host = $host;       // 指定的 SMTP 服务器地址
        $mail->SMTPAuth = true;                  // 设置为安全验证方式
        $mail->Username = $sendUser; // SMTP 发邮件人的用户名
        $mail->Password = $sendpwd;            // SMTP 密码
        $mail->From = $sendUser;
        $mail->FromName = $fromname;
        $mail->CharSet = "UTF-8";
        $mail->AddReplyTo("support@qiangbi.net","强比科技");//回复给谁
        $mail->AddAddress($toUser);
        //发送到谁 写谁$mailaddress
        $mail->WordWrap = 50;                // set word wrap to 50 characters
        $mail->IsHTML(true);                    // 设置邮件格式为 HTML
        $mail->Subject = $subject; //邮件主题// 标题
        $mail->Body = $sendBody;
        dump($sendUser);
        dump($sendpwd);
        dump($subject);
        dump($toUser);
        dump($sendBody);
        dump($fromname);
        dump($host);
        // 内容
        $sendInfo = $mail->Send();
        dump($mail->ErrorInfo);
        dump($sendInfo);

//        if (!$sendInfo) {
//            (new SendError())->add($sendUser, $toUser,$mail->ErrorInfo,0);
//        }
    }

    /**
     * 获取ip 接口
     */
    public function get_ip_info($ip)
    {
        $curl = curl_init(); //这是curl的handle
        //下面是设置curl参数
        $url = "http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip=$ip";
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl, CURLOPT_HEADER, 0); //don't show header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); //相当关键，这句话是让curl_exec($ch)返回的结果可以进行赋值给其他的变量进行，json的数据操作，如果没有这句话，则curl返回的数据不可以进行人为的去操作（如json_decode等格式操作）
        curl_setopt($curl, CURLOPT_TIMEOUT, 2);
        //这个就是超时时间了
        $data = curl_exec($curl);
        file_put_contents("ip1.txt",print_r(json_decode($data,true),true),FILE_APPEND);
        return json_decode($data, true);
    }
}