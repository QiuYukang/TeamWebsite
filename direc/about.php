<!DOCTYPE HTML>
<html>
<head>
    <title>UESTC Network Tech Research Group - 团队简介</title>
    <link href="/direc/css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/direc/js/jquery-1.11.0.min.js"></script>
    <!-- Custom Theme files -->
    <link href="/direc/css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <!-- Custom Theme files -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!--Google Fonts-->

    <!-- start-smoth-scrolling -->
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

    <style>


        /*
         * Masthead for nav
         */

        .blog-masthead {
            background-color: #428bca;
            -webkit-box-shadow: inset 0 -2px 5px rgba(0,0,0,.1);
            box-shadow: inset 0 -2px 5px rgba(0,0,0,.1);
        }

        /* Nav links */
        .blog-nav-item {
            position: relative;
            display: inline-block;
            padding: 10px;
            font-weight: 500;
            color: #cdddeb;
        }
        .blog-nav-item:hover,
        .blog-nav-item:focus {
            color: #fff;
            text-decoration: none;
        }

        /* Active state gets a caret at the bottom */
        .blog-nav .active {
            color: #fff;
        }
        .blog-nav .active:after {
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 0;
            margin-left: -5px;
            vertical-align: middle;
            content: " ";
            border-right: 5px solid transparent;
            border-bottom: 5px solid;
            border-left: 5px solid transparent;
        }


        /*
         * Blog name and description
         */

        .blog-header {
            padding-top: 20px;
            padding-bottom: 20px;
        }
        .blog-title {
            margin-top: 30px;
            margin-bottom: 0;
            font-size: 60px;
            font-weight: normal;
        }
        .blog-description {
            font-size: 20px;
            color: #999;
        }


        /*
         * Main column and sidebar layout
         */

        .blog-main {
            font-size: 18px;
            line-height: 1.5;
        }

        /* Sidebar modules for boxing content */
        .sidebar-module {
            padding: 15px;
            margin: 0 -15px 15px;
        }
        .sidebar-module-inset {
            padding: 15px;
            background-color: #f5f5f5;
            border-radius: 4px;
        }
        .sidebar-module-inset p:last-child,
        .sidebar-module-inset ul:last-child,
        .sidebar-module-inset ol:last-child {
            margin-bottom: 0;
        }


        /* Pagination */
        .pager {
            margin-bottom: 60px;
            text-align: left;
        }
        .pager > li > a {
            width: 140px;
            padding: 10px 20px;
            text-align: center;
            border-radius: 30px;
        }


        /*
         * Blog posts
         */

        .blog-post {
            margin-bottom: 60px;
        }
        .blog-post-title {
            margin-bottom: 5px;
            font-size: 40px;
        }
        .blog-post-meta {
            margin-bottom: 20px;
            color: #999;
        }


        /*
         * Footer
         */

        .blog-footer {
            padding: 40px 0;
            color: #999;
            text-align: center;
            background-color: #f9f9f9;
            border-top: 1px solid #e5e5e5;
        }
        .blog-footer p:last-child {
            margin-bottom: 0;
        }
    </style>
</head>

<?php $auth = false; ?>

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
                <li><a href="./about.php">团队简介</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;科研&nbsp; <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="./index.php">研究方向</a></li>
                        <li><a href=<?php echo $auth ? "../index.php?r=project/admin" : "../index.php?r=project/index"; ?>>科研项目</a></li>
                        <li><a href="../index.php?r=award">科研成果</a></li>
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
                        <li><a href=<?php echo $auth ? "../index.php?r=paper/admin" : "../index.php?r=paper/index"; ?>>论文</a></li>
                        <li><a href=<?php echo $auth ? "../index.php?r=patent/admin" : "../index.php?r=patent/index"; ?>>专利</a></li>
                        <li><a href=<?php echo $auth ? "../index.php?r=publication/admin" : "../index.php?r=publication/index"; ?>>著作</a></li>
                        <li><a href=<?php echo $auth ? "../index.php?r=software/admin" : "../index.php?r=software/index"; ?>>软件著作权</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">&nbsp;硕博培养&nbsp; <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="../index.php?r=site/enrollment">招生与就业</a></li>
                        <li><a href="../index.php?r=site/teacher">导师介绍</a></li>
                        <li><a href="../index.php?r=site/fun">团队生活</a></li>
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
                <li><?php if(isset( $authStrArr)) echo '<a href="../index.php?r=people/admin">人员管理</a>'; else  echo '<a></a>';?></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a>&nbsp;欢迎！</a></li>
            </ul>
        </div>
    </div>
</div>
<!--header end here-->
<!--start-about-->
<div class="banner">
    <div class="container">
        <div class="banner-main">
            <h2>团队长期从事网络体系与协议的研究<br></h2>
            <p>紧跟该领域的前沿技术，理论研究与系统开发实现并重，尤其在无线网络研究方面成效卓著。</p>

        </div>
    </div>
</div>
<div class="container">
    <div class="row" id="section-1">

        <div class="col-sm-12 blog-main">

            <div class="blog-post">
                <h2 style="color:#a89574;" >&nbsp;&nbsp;&nbsp;&nbsp;基本情况</h2>
                <hr style=" border:1px #a89574 solid; " />
                <ul>
                    <li>
                        <p>团队目前有教师15人，其中教授、博士生导师3人，副教授6人，高级工程师1人，讲师6人。博士6人，在职博士研究生4人。在读全日制博士研究生10人，硕士研究生90余人。</p>
                    </li>
                    <li>
                        <p>毛玉明教授/冷甦鹏教授为团队负责人，毛玉明教授是享受国家特殊津贴的专家，国家百千万人才入选者，国内较早研究无线自组织网络架构和协议的人员之一，在无线网络组网相关研究方面具有较深造诣和知名度。冷甦鹏教授是学校从新加坡南洋理工大学引进的优秀海归人才，教育部21世纪优秀人才项目获得者，学校百人计划获得者，现任通信与信息工程学院主管科研副院长。2015年，学校引进的我国千人计划获得者杨鲲教授加盟我们团队，进一步提升了我们团队的整体实力。</p>
                    </li>
                    <li>

                        <p>团队自上世纪80年代中期开始从事计算机网络、无线网络领域的研究工作，是国内开展无线网络技术研究的先行者之一。“七五”以来，先后完成了包括电子预研项目、国家重大专项项目、国家863项目、国家科技支撑计划项目、国家自然基金、教育部重点项目，以及校企合作项目数十项，取得丰硕成果。获得多项国家级和省部级科研成果奖励。</p>
                    </li>
                    <li>
                        <p>创建并承担了网络工程专业的建设，创建了网络工程专业人才培养体系、课程体系和实验体系。出版系列网络工程相关教材，承担所有网络工程专业课程的教学。主持“通信与信息系统国家级实验教学示范中心”建设。承建的骨干传输系统实验室、路由与互连实验室、网络工程实验室、综合接入网实验室等国内技术一流。多门课程获得省级精品课程，网络工程专业获批国家级特色专业建设点。</p>
                    </li>
                </ul>
            </div><!-- /.blog-post -->

            <div class="blog-post">
                <h2 style="color: #a89574" id="section-3">&nbsp;&nbsp;&nbsp;&nbsp;技术优势</h2>
                <hr style=" border:1px #a89574 solid; " />
                <ul>
                    <li><p>近几年完成了十余项国家重大专项、863高科技计划项目及国家自然基金项目，自主研发多种无线组网设备，自主设计并实现多种无线网络组网结构、路由协议、MAC协议并获得多项授权专利。技术底蕴深厚，大项目研发经验丰富。</p></li>
                    <li><p>长期从事网络体系与协议的研究，并紧跟该领域的前沿技术，理论研究与系统开发实现并重，尤其在无线网络研究方面成效卓著。在以下方面技术实力国内突出：
                        <ul>
                            <li><p>网络体系结构设计与分析技术</p></li>
                            <li><p>网络协议设计与协议分析技术</p></li>
                            <li><p>协议软件实现技术</p></li>
                            <li><p>网络工程与应用技术</p></li>
                        </ul>
                        </p>
                    </li>
                </ul>
            </div><!-- /.blog-post -->

        </div><!-- /.blog-main -->


    </div><!-- /.row -->
</div>

<div class="team-mem">
    <div class="container">
        <div class="team-main">
            <h2 style="color: #a89574" id="section-3">&nbsp;&nbsp;&nbsp;&nbsp;部分团队教师</h2>
            <hr style=" border:1px #a89574 solid; " />
            <div class="team-top">
                <div class="col-md-4 team-top-left">
                    <img src="images/t1.jpg" src="">
                    <div class="team-details">
                        <h4>毛玉明 教授</h4>
                        <P>荣获国防科工委“光华科技基金个人二等奖”、“国务院政府特殊津贴”、国家“百千万人才工程”国家级入选。</P>
                    </div>
                </div>
                <div class="col-md-4 team-top-left">
                    <img src="images/t2.jpg" src="">
                    <div class="team-details">
                        <h4>冷甦鹏 教授</h4>
                        <P>博士，教授，博士生导师，教育部“新世纪优秀人才支持计划”入选者。</P>
                    </div>
                </div>
                <div class="col-md-4 team-top-left">
                    <img src="images/t3.jpg" src="">
                    <div class="team-details">
                        <h4>杨坤 教授</h4>
                        <P>“重庆市劳动模范”称号，电子科大 “优秀主讲教师”。</P>
                    </div>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
    </div>

<!--end-team-->
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