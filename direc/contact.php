<!DOCTYPE HTML>
<html>
<head>
<title>Contact</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
<!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
<body  style="padding-top:100px">
<!-- //end-smoth-scrolling -->
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
                        <li><a href="../direc/about.php">团队简介</a></li>
                        <li><a href="../direc/index.php">研究方向</a></li>
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
                        <li><a href="../index.php?r=publication">专著</a></li>
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
<!--header end here-->
<!--contact start here-->
<div class="contact">
	<div class="container">
		<div class="contact-main">
			<div class="contact-top">
				<h3>联系我们</h3>
				<p>欢迎想报考我团队的同学通过以下方式联系我们！</p>
			</div>
            <form action="sendmail.php" method="post">
			<div class="contact-bottom">
				<div class="col-md-4 con-name">
					<input type="text" value="Name" name="name" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='Name';}">
				</div>
				<div class="col-md-4 con-name">
				    <input type="text" value="Your E-mail" name="email" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='My E-mail';}">
				</div>
				<div class="col-md-4 con-name">
				    <input type="text" value="Subject" class="no-mar"  name="title" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='Subject';}">
				</div>
				<textarea  name="content" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='Message';}">Message</textarea>
                <div class="col-md-4 con-name">
                    <input type="text" name="validate" class="no-mar" value="请输入验证码，请小写" onfocus="this.value='';" onblur="if (this.value == '') {this.value ='请输入验证码，请小写';}">
                </div>
                <div class="col-md-4 con-name">
                    <img  title="点击刷新" src="./captcha.php" align="absbottom" onclick="this.src='captcha.php?'+Math.random();"/>
                </div>
                <div class="col-md-4 con-name"></div>
				<input type="submit" value="Send Message">
			</div>
            </form>
            <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
		</div>
	</div>
</div>
<!--contact end here-->
<!--footer star here-->
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