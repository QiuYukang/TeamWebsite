<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<!--[if IE 8]> 				 <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->

<head>
    <meta charset="utf-8" />
    <meta name="lang" content="zh" />
    <meta name="viewport" content="width=device-width" />

    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/custom.css" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-theme.min.css" />
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/bootstrap.min.js"></script>
    <link rel="stylesheet" id="sc" type="text/css" href="" />
    <link rel="stylesheet" id="lr" type="text/css" href="" />





    <script type="text/javascript">
        window.onload=function(){
            var sc=document.getElementById("sc");
            if(screen.width>1366)  //获取屏幕的的宽度
            {
                sc.setAttribute("href","<?php echo Yii::app()->request->baseUrl; ?>/css/wrh1080P.css");   //设置css引入样式表的路径

            }
            else{

                sc.setAttribute("href","<?php echo Yii::app()->request->baseUrl; ?>/css/wrh720P.css");

            }

            var lr=document.getElementById("lr");
            if(screen.width>1366)  //获取屏幕的的宽度
            {
                lr.setAttribute("href","<?php echo Yii::app()->request->baseUrl; ?>/css/lrtk1080P.css");   //设置css引入样式表的路径

            }
            else{

                lr.setAttribute("href","<?php echo Yii::app()->request->baseUrl; ?>/css/lrtk720P.css");

            }
        }
    </script>
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php
    $authStrArr=null;
    $auth = false;
    if(isset(Yii::app()->user->is_user) && Yii::app()->user->is_user) {
        $authStrArr = '普通用户';
        $auth = true;
    }
    if(isset(Yii::app()->user->is_manager) && Yii::app()->user->is_manager) {
        $authStrArr = '管理员';
        $auth = true;
    }
    if(isset(Yii::app()->user->is_admin) && Yii::app()->user->is_admin) {
        $authStrArr = '超级管理员';
        $auth = true;
    }
    ?>
    <?php $user = Yii::app()->user; ?>
</head>
<?php  if($_SERVER['REQUEST_URI']=="/team_web_app-master/index.php") { ?>
<body style="background-color: #EBEBEB;padding-top:40px" class="home-template">
<?php } else {?>
<body style="background-color: #EBEBEB;padding-top:105px" class="home-template">
<?php } ?>

<?php if($_SERVER['REQUEST_URI']=="/team_web_app-master/index.php") { ?>
    <div class="navbar  navbar-default navbar-fixed-top" style="background-color: #ffffff;">
        <div class="container" >
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
                    <li><a href="./direc/about.php">团队简介</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;科研&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./direc/index.php">研究方向</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=project/admin" : "index.php?r=project/index"; ?>>科研项目</a></li>
                            <li><a href="./index.php?r=award">科研成果</a></li>
                        </ul>
                    </li>
                    <?php  $pro=substr($_SERVER['REQUEST_URI'],33,5);
                    if($pro=="paper")  {?>
                    <li class="dropdown active">
                        <?php } else {?>
                    <li class="dropdown">
                        <?php }?>

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;学术成果&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href=<?php echo $auth ? "index.php?r=paper/admin" : "index.php?r=paper/index"; ?>>论文</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=patent/admin" : "index.php?r=patent/index"; ?>>专利</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=publication/admin" : "index.php?r=publication/index"; ?>>专著</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=software/admin" : "index.php?r=software/index"; ?>>软件著作权</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;硕博培养&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./index.php?r=site/enrollment">招生与就业</a></li>
                            <li><a href="./index.php?r=site/teacher">导师介绍</a></li>
                            <li><a href="./index.php?r=site/fun">团队生活</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;教学&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./index.php?r=course">教学课程</a></li>
                            <li><a href="#">实验建设</a></li>
                            <li><a href="./index.php?r=awardTeaching">教学成果</a></li>
                            <li><a href="./index.php?r=projectTeaching">教改项目</a></li>
                            <li><a href="./index.php?r=paperTeaching">教改论文</a></li>
                        </ul>
                    </li>
                    <li><?php if(isset( $authStrArr)) echo '<a href="./index.php?r=people/admin">人员管理</a>'; else  echo '<a></a>';?></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(isset( $authStrArr)) { ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                <?php echo "&nbsp;欢迎！".Yii::app()->user->name."($authStrArr)&nbsp;"; ?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="./index.php?r=user/setting">修改密码</a></li>
                                <?php if(isset(Yii::app()->user->is_admin) && Yii::app()->user->is_admin) echo '<li><a href="./index.php?r=user/admin">用户管理</a></li>'; ?>
                                <li><a href="./index.php?r=site/logout">登出&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <li><a href="./index.php?r=site/login">&nbsp;登录&nbsp;</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>




    <div class="grid">

        <figure class="effect-layla">
            <img src="images/eg.jpg"  alt="img03"/>
            <a href="direc/index.php"><figcaption>
                    <h2><span>电子科技大学</span></h2>
                    <h1><span>泛在无线</span>网络团队</h1>
                    <p>Click to get more information</p>

                </figcaption>
            </a>
        </figure>
    </div>




<?php } else { ?>

    <div class="navbar  navbar-default navbar-fixed-top" style="background-color: #ffffff;">
        <div class="container" >
            <div class="clearfix" style="height:4em;">
                <div class="container">
                    <img  style="height:100%;" src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" />
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
                    <li class="default"><a href="index.php">首页</a></li>
                    <li><a href="./direc/about.php">团队简介</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;科研&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./direc/index.php">研究方向</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=project/admin" : "index.php?r=project/index"; ?>>科研项目</a></li>
                            <li><a href="./index.php?r=award">科研成果</a></li>
                        </ul>
                    </li>
                    <?php  $pro=substr($_SERVER['REQUEST_URI'],33,5);
                    if($pro=="paper")  {?>
                    <li class="dropdown active">
                        <?php } else {?>
                    <li class="dropdown">
                        <?php }?>

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;学术成果&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href=<?php echo $auth ? "index.php?r=paper/admin" : "index.php?r=paper/index"; ?>>论文</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=patent/admin" : "index.php?r=patent/index"; ?>>专利</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=publication/admin" : "index.php?r=publication/index"; ?>>专著</a></li>
                            <li><a href=<?php echo $auth ? "index.php?r=software/admin" : "index.php?r=software/index"; ?>>软件著作权</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;硕博培养&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./index.php?r=site/enrollment">招生与就业</a></li>
                            <li><a href="./index.php?r=site/teacher">导师介绍</a></li>
                            <li><a href="./index.php?r=site/fun">团队生活</a></li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;教学&nbsp; <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="./index.php?r=course">教学课程</a></li>
                            <li><a href="#">实验建设</a></li>
                            <li><a href="./index.php?r=awardTeaching">教学成果</a></li>
                            <li><a href="./index.php?r=projectTeaching">教改项目</a></li>
                            <li><a href="./index.php?r=paperTeaching">教改论文</a></li>
                        </ul>
                    </li>
                    <li><?php if(isset( $authStrArr)) echo '<a href="./index.php?r=people/admin">人员管理</a>'; else  echo '<a></a>';?></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if(isset( $authStrArr)) { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <?php echo "&nbsp;欢迎！".Yii::app()->user->name."($authStrArr)&nbsp;"; ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="./index.php?r=user/setting">修改密码</a></li>
                            <?php if(isset(Yii::app()->user->is_admin) && Yii::app()->user->is_admin) echo '<li><a href="./index.php?r=user/admin">用户管理</a></li>'; ?>
                            <li><a href="./index.php?r=site/logout">登出&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
                        </ul>
                    </li>
                    <?php } else { ?>
                    <li><a href="./index.php?r=site/login">&nbsp;登录&nbsp;</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
<?php  } ?>

<div class="container"  style="background-color: #EBEBEB">



    <?php if(isset($this->breadcrumbs)):?>
        <?php $this->widget('zii.widgets.CBreadcrumbs', array(
            'links'=>$this->breadcrumbs,
            'separator'=>'',
            'homeLink'=>false,
        )); ?>
    <?php endif?>
    <div class="row">
        <div class="container" id="content"  style="background-color: #EBEBEB">
            <?php echo $content;?>
        </div>
    </div>
</div>
<div class="footer-top bg-fblue" style="background-color:#D3D3D3">
    <br/>
    <div class="container">
        <div class="medium-4 columns">
            <div class="property-info">
                <h3>泛在无限网络团队</h3><hr>
                <p>泛在无线团队自上世纪80年代中期开始从事计算机网络、无线网络领域的研究工作，是国内开展无线网络技术研究的先行者之一。
                </p>
            </div>
        </div>

        <div class="medium-4 columns" >
            <div class="learn-links">
                <h3 class="">相关链接</h3><hr>
                <ul>
                    <!--                        <li><a href="#">网络体系结构与协议</a></li>-->
                    <!--                        <li><a href="#">无线自组织网络</a></li>-->
                    <!--                        <li><a href="#">无线传感网(WSN)与物联网</a></li>-->
                    <!--                        <li><a href="#">宽带无线移动网络技术</a></li>-->
                    <!--                        <li><a href="#">无线网络新技术</a></li>-->
                    <li><a style="color: #767676;" href="http://www.uestc.edu.cn/">电子科技大学官网 (uestc.edu.cn)</a></li>
                    <li><a style="color: #767676;" href="http://yz.uestc.edu.cn/">电子科技大学研招网 (yz.uestc.edu.cn)</a></li>
                    <li><a style="color: #767676;" href="http://www.jwc.uestc.edu.cn/">电子科技大学教务处 (jwc.uestc.edu.cn)</a></li>
                </ul>
            </div>
        </div>

        <div class="medium-4 columns">
            <div class="connect-links">
                <h3 class="">关于我们</h3><hr>
                <p>成都市高新区（西区）西源大道2006号电子科技大学清水河校区科研楼B区 邮编：611731</p>
            </div>
        </div>
    </div>
    <br/>
</div>

</div>
<div id="footer">
    <p class="text-muted" align="center">Copyright &copy; <?php echo date('Y'); ?> zly&mirraico.<br/>
    All Rights Reserved.<br/>
    <?php echo Yii::powered(); ?></p>
</div>
<!-- footer -->
<!--<footer class="footer" style="background-color: #B0B0B0">-->
<!--    <div class="container">-->
<!--        <p class="text-muted">protected by UESTC</p>-->
<!--    </div>-->
<!--</footer>-->


<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/zepto.js"></script>

<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation.min.js"></script>
<!--
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.alerts.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.clearing.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.cookie.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.forms.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.interchange.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.joyride.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.magellan.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.orbit.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.placeholder.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.reveal.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.section.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.tooltips.js"></script>
	-->
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.dropdown.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation/foundation.topbar.js"></script>
<script>
    $(document).foundation();
    if (!("ontouchstart" in document.documentElement)) {
        document.documentElement.className += " no-touch";
    }
</script>
</body>
</html>
