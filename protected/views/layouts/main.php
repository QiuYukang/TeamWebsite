<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<head>

    <meta name="renderer" content="webkit">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=9">
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/icon.png"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/index.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.fancybox.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/select2.css"/>

    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/jquery.fancybox.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/index.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/slider.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/select2.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/js/pinyin.js"></script>
    <script type="text/javascript">  document.documentElement.className += " js";</script>

    <style type="text/css">
        [alt="icon_doc.gif"]{display:none;}
    </style>

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

<div id="header">
    <div class="header-container container">
        <ul class="header-nav-left">
            <li><a href="#">中文</a></li>
            <li>|</li>
            <li><a href="#">English</a></li>
        </ul>

        <ul class="header-nav-right">
            <?php if(!isset($authStrArr)) { ?>
            <li>
                <p>团队成员，请<a href="./index.php?r=site/login">登录</a></p>
            </li>
            <?php } else { ?>
                <li><p>你好，<?php echo Yii::app()->user->name."($authStrArr)"; ?></p></li>
                <li>|</li>
                <li><a href="./index.php?r=user/setting">修改密码</a></li>
                <?php if(isset(Yii::app()->user->is_admin) && Yii::app()->user->is_admin) echo '<li><a href="./index.php?r=user/admin">用户管理</a></li>'; ?>
                <li><a href="./index.php?r=site/logout">登出</a></li>

            <?php } ?>
        </ul>

    </div>
</div>

<div id="navi">
    <div <?php echo isset($this->breadcrumbs) && !empty($this->breadcrumbs) ? 'class="navi-container-small container"' :
            'class="navi-container container"';
    ?>>
        <a class="logo" href="index.php">
            <img <?php echo isset($this->breadcrumbs) && !empty($this->breadcrumbs) ? 'width="275px"' :
                'width="375px"';
                 ?> src="<?php echo Yii::app()->request->baseUrl; ?>/images/logo.png" alt="电子科技大学泛在无线网络团队"/>
        </a>
        <ul <?php echo isset($this->breadcrumbs) && !empty($this->breadcrumbs) ? 'class="navigations-small"' :
        'class="navigations"';
        ?>>
            <li class="sub">
                <a href="index.php" class="navi-name">
                    首页
                </a>
                <div class="navi-line hide"></div>
            </li>
            <li class="sub">
                <a href="index.php?r=site/introduction" class="navi-name">
                    团队介绍
                </a>
                <div class="navi-line hide"></div>
            </li>
            <li class="sub">
                <a href="index.php?r=site/direction" class="navi-name">
                    科研
                </a>
                <div class="navi-line hide"></div>
                <ul class="nav-ul-ul">
                    <li class="sub-navi-li ">
                        <a href="index.php?r=site/direction" class="subTitle">
                            研究方向
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href=<?php echo $auth ? "index.php?r=project/admin" : "index.php?r=project/index"; ?> class="subTitle">
                            科研项目
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            科研成果
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sub">
                <a href=<?php echo $auth ? "index.php?r=paper/admin" : "index.php?r=paper/index"; ?> class="navi-name">
                    学术成果
                </a>
                <div class="navi-line hide"></div>
                <ul class="nav-ul-ul">
                    <li class="sub-navi-li ">
                        <a href=<?php echo $auth ? "index.php?r=paper/admin" : "index.php?r=paper/index"; ?> class="subTitle">
                            论文
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href=<?php echo $auth ? "index.php?r=patent/admin" : "index.php?r=patent/index"; ?> class="subTitle">
                            专利
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href=<?php echo $auth ? "index.php?r=publication/admin" : "index.php?r=publication/index"; ?> class="subTitle">
                            著作
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href=<?php echo $auth ? "index.php?r=software/admin" : "index.php?r=software/index"; ?> class="subTitle">
                            软件著作权
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sub">
                <a href="#" class="navi-name">
                    硕博培养
                </a>
                <div class="navi-line hide"></div>
                <ul class="nav-ul-ul">
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            招生与就业
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            导师介绍
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            团队生活
                        </a>
                    </li>
                </ul>
            </li>
            <li class="sub">
                <a href="#" class="navi-name">
                    教学
                </a>
                <div class="navi-line hide"></div>
                <ul class="nav-ul-ul">
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            教学课程
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            实验建设
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            教学成果
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            教改项目
                        </a>
                    </li>
                    <li class="sub-navi-li ">
                        <a href="#" class="subTitle">
                            教改论文
                        </a>
                    </li>
                </ul>
            </li>
            <?php if($auth) { ?>
            <li class="sub">
                <a href="index.php?r=people/admin" class="navi-name">
                    团队成员
                </a>
                <div class="navi-line hide"></div>
            </li>
            <?php } ?>
        </ul>
    </div>
    <div class="clearfix"></div>
</div>

<?php if(isset($this->breadcrumbs) && !empty($this->breadcrumbs)) { ?>
    <div id="breadcrumbs">
        <div class="breadcrumbs-bg">
            <a class="breadcrumbs-home" href="/"><img src="<?php echo Yii::app()->request->baseUrl; ?>/css/img/breadcrumb_icon.png"></a>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'=>$this->breadcrumbs,
                'separator'=>'',
                'tagName'=>'span',
                'homeLink'=>false,
            )); ?>
        </div>
    </div>
<?php } ?>

<div id="main">
    <?php echo $content;?>
</div>

<div id="footer">
    <div class="container">
        <div class="position-left">
            <p style="color: #91ae8e;">关于我们</p>
            <p>泛在无线网络团队自上世纪80年代中期开始从事计算机网络、无线网络的研究工作，是国内开展无线网络技术研究的先行者之一。
            </p>
        </div>
        <div class="position-mid">
            <p style="color: #91ae8e;">常用链接</p>
            <p><a target="_blank" href="http://www.uestc.edu.cn/">电子科技大学 (uestc.edu.cn)</a>
            <p><a target="_blank" href="http://yz.uestc.edu.cn/">电子科技大学研招网 (yz.uestc.edu.cn)</a>
            </p>
        </div>
        <div class="position-right">
            <p style="color: #91ae8e;">联系我们</p>
            <p><a target="_blank" href="http://map.baidu.com/?poiShareUid=648e44c383466624fda77886">
                    地址: 成都市高新区（西区）西源大道2006号电子科技大学科研楼B区 邮编: 611731&nbsp;&nbsp;&nbsp;
                </a></p>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<div id="copyright">
    <p>Copyright &copy; <?php echo date('Y'); ?> zly&mirraico.</p>
    <p>All Rights Reserved.</p>
    <p><?php echo Yii::powered(); ?></p>
</div>

</body>
</html>
