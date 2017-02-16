<!DOCTYPE HTML>
<html>
<head>
    <title>Contact</title>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery-1.11.0.min.js"></script>
    <!-- Custom Theme files -->
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <!-- Custom Theme files -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </script>

    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css" />
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>
</head>
<body style="padding-top:100px">

<div class="navbar  navbar-default navbar-fixed-top" style="background-color: #ffffff;">
    <div class="container" >
        <div class="clearfix" style="height:4em;">
            <div class="container">
                <img  style="height:100%;" src="../images/logo.png" />
            </div>
        </div>
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="navbar-collapse collapse exp1">
            <ul class="nav navbar-nav">
                <li class="default"><a href="../index.php">首页</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;团队介绍&nbsp; <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../direc/about.html">团队简介</a></li>
                        <li><a href="../direc/index.html">研究方向</a></li>
                        <li><a href="../direc/contact.php">联系我们</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;科研&nbsp; <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../index.php?r=project">科研项目</a></li>
                        <li><a href="../index.php?r=award">科研成果</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;学术成果&nbsp; <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href= "../index.php?r=paper/index">论文</a></li>
                        <li><a href="../index.php?r=patent">专利</a></li>
                        <li><a href="../index.php?r=publication">著作</a></li>
                        <li><a href="../index.php?r=software">软件著作权</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;硕博培养&nbsp; <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../index.php?r=site/enrollment">招生要求</a></li>
                        <li><a href="../index.php?r=site/teacher">导师介绍</a></li>
                        <li><a href="../index.php?r=site/fun">素质拓展</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;教学&nbsp; <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../index.php?r=course">教学课程</a></li>
                        <li><a href="#">实验建设</a></li>
                        <li><a href="../index.php?r=awardTeaching">教学成果</a></li>
                        <li><a href="../index.php?r=projectTeaching">教改项目</a></li>
                        <li><a href="../index.php?r=paperTeaching">教改论文</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>&nbsp;欢迎！</a></li>
            </ul>
        </div>
    </div>
</div>
<div style="height: 150px"></div>

<?php
$sys=$_SESSION["a_session"];
$validate="";
if(isset($_POST["validate"])){
    $validate=$_POST["validate"];

    if($validate!=$sys){
//判断session值与用户输入的验证码是否一致;
       ?>

        <div class="container">
            <div class="team-main">
                <div class="team-top">
                    <div class="col-md-3 team-top-left">

                    </div>
                    <div class="col-md-6 team-top-left" style="text-align:center;">
                        <img src="images/NO.jpg">
                        <div class="team-details">
                            <h4>糟糕！</h4>
                            <P>验证码输入错误！</P><a class="btn btn-default btn-lg" href="contact.php">返回</a>
                        </div>
                    </div>
                    <div class="col-md-3 team-top-left">

                    </div>
                </div>
            </div>
        </div>
    <?php }else{


require_once "email.class.php";
    //******************** 配置信息 ********************************
    $smtpserver = "smtp.126.com";//SMTP服务器
    $smtpserverport =25;//SMTP服务器端口
    $smtpusermail = "uestcfanzai@126.com";//SMTP服务器的用户邮箱
    $smtpemailto = '250180874@qq.com';//发送给谁
    $smtpuser = "UESTCfanzai";//SMTP服务器的用户帐号
    $smtppass = "xwjaykhqwtqsijux";//SMTP服务器的用户密码
    $mailtitle = $_POST['title'];//邮件主题
    $name = $_POST['name'];
    $email = $_POST['email'];
    $mailcontent = "<h1>老师您好！我的名字是：".$name."<br>我的邮箱是：".$email."<br>我的留言：</h1><p>".$_POST['content']."</p>";//邮件内容
    $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
    //************************ 配置信息 ****************************
    $smtp = new smtp($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
    $smtp->debug = false;//是否显示发送的调试信息
    $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);

    if($state==""){ ?>
            <div class="container">
                <div class="team-main">
                    <div class="team-top">
                        <div class="col-md-3 team-top-left">

                        </div>
                        <div class="col-md-6 team-top-left" style="text-align:center;">
                            <img src="images/NO.jpg">
                            <div class="team-details">
                                <h4>糟糕！</h4>
                                <P>发送失败。我们的设置可能有些问题！请稍后再试！</P><a class="btn btn-default btn-lg" href="contact.php">返回</a>
                            </div>
                        </div>
                        <div class="col-md-3 team-top-left">

                        </div>
                    </div>
                </div>
            </div>
    <?php  } else { ?>
            <div class="container">
                <div class="team-main">
                    <div class="team-top">
                        <div class="col-md-3 team-top-left">

                        </div>
                        <div class="col-md-6 team-top-left" style="text-align:center;">
                            <img src="images/YES.jpg">
                            <div class="team-details">
                                <h3>恭喜！</h3>
                                <p>发送成功！老师将会看到你的留言。</p><a class="btn btn-default btn-lg" href="index.php"><p>返回</p></a>
                            </div>
                        </div>
                        <div class="col-md-3 team-top-left">

                        </div>
                    </div>
                </div>
            </div>
    <?php }}}?>

  <div style="height: 150px"></div>
<div class="footer">
    <div class="container">
        <div class="footer-main">
            <div class="footer-top">
                <div class="col-md-4 footer-news">
                    <h5>UESTC 泛在无线网络团队</h5>
                </div>
                <div class="col-md-8 ftr-email">

                </div>
                <div class="clearfix"> </div>
            </div>

        </div>
    </div>
</div>
<!--footer end here-->
</body>
</html>
