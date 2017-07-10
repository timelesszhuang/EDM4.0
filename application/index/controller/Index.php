<?php
namespace app\index\controller;
use app\common\EmailUtil;
use app\index\model\Directories;
use think\Controller;
use think\Db;

class Index extends Controller
{
    public function index()
    {
        if (file_exists("number.lock")) {
            $modify_time = filemtime("number.lock");
            $change_time = time() - $modify_time;
            if ($change_time < 100) {
                exit;
            }
        }
        $emailUtil = new EmailUtil();
        $Account = Db::name('Account')->count();
        $AccountData = Db::name('Account')->select();
        $emailnum = Db::name('Directories')->field('id,email,contacts')->select();
        $num =  file_get_contents('1.txt');
        $num1 = file_get_contents('2.txt');
        while (1) {
            if($num >=500){
                $num =0;
            }
            $emaildata = $AccountData[$num];
            $Directoriesdata = $emailnum[$num1];
            $sendUser = $emaildata['account'];
            $sendpwd =$emaildata['pwd'];
            $hosts = $emaildata["hosts"];
            $toUser = $Directoriesdata['email'];
            $fromname = 'QiangBi Technology Corporation';
            $sendBody = $this->template();
            $subject="Dear ".$Directoriesdata['contacts'] .' We provide wonderful Website design';
            $emailUtil->phpmailerSend($sendUser, $sendpwd, $subject, $toUser, $sendBody,$fromname,$hosts);
            Db::name('Directories')
                ->where('id', $Directoriesdata['id'])
                ->update(['is_send' => '20']);
            ++$num;
            ++$num1;
            file_put_contents('1.txt',$num);
            file_put_contents('2.txt',$num1);
            file_put_contents('number.lock','14');
            sleep(5);
        }
    }

    public function template(){
        $doc=<<<EOF
        <div id="contentDescription" style="line-height:1.5;text-align:justify;text-justify:inter-ideograph">
    <div><br></div>
    Hi,<br>
    <br>
    We are a team of 150+ individuals highly experienced in creating wonderful Website design and development for our
    clients to increase their business and to help them in generating a good profit.<br>
    <br>
    <strong>We are expert in the following:</strong><br>
    &nbsp;<br>
    ·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Website Design &amp; Redesign - (<strong>Logo design, Photoshop to
    HTML/ HTML5 &amp; PHP</strong>)<br>
    ·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Open Source Development - (<strong>Word Press, Joomla, Drupal,
    Mambo, Laravel, Cake PHP Development</strong>)<br>
    ·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ecommerce Solutions - (<strong>Magneto, Big Commerce, Oscommerce,
    x-cart, Zen Cart, Shop Site, PrestaShop, Open cart, Storefront, NopCommerce etc.</strong>)<br>
    ·&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Mobile Application Development for <strong>Android, iPhone,
    Windows &amp; Blackberry</strong><br>
    &nbsp;<br>
    <strong>Also we offer for hire dedicated professional designer, Developers, Mobile apps Developers, Search Engine
        Optimizer, PPC Experts ETC...</strong><br>
    &nbsp;<br>
    If you want to know the price/cost and examples of our website design project, please share your requirements and
    website URL.<br>
    &nbsp;<br>
    Thank you<br>
    &nbsp;<br>
    <strong>Cheers</strong><br>
    <strong>Zhao Xingzhuang</strong><br>
    <strong>Business Development Executive</strong><br>
    <strong>Hand Phone: +86 13698612743</strong><br>
    <strong>Global Offices: BEIJING CHINA|JINAN |Australia|HONGKONG</strong><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>
    <strong>Disclaimer:&nbsp; </strong>The CAN-SPAM Act of 2003 (Controlling the Assault of Non-Solicited Pornography
    and Marketing Act) establishes requirements for those who send commercial email, spells<br>
    out penalties for spammers and companies whose products are advertised in spam if they violate the law, and gives
    consumers the right to ask mailers to stop spamming&nbsp; them. The above mail is in accordance to the Can Spam act
    of 2003: There are no deceptive subject lines and is a manual process through our efforts on World Wide Web. You can
    opt out by sending to <a href="mailto:xingzhuang@cio.club"
                             target="_blank"><strong>xingzhuang@cio.club</strong></a>&nbsp;&nbsp;<br>


</div>     
EOF;
        return $doc;


    }


}


