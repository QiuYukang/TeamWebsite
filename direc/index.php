<!DOCTYPE HTML>
<html>
<head>
<title>UESTC Network Tech Research Group - 研究方向</title>
<link href="css/bootstrap.css" rel="stylesheet" type="text/css" media="all">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="js/jquery-1.11.0.min.js"></script>
<!-- Custom Theme files -->
<link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/lrtk.css" rel="stylesheet" type="text/css" />
    <script src="js/lrtk.js"></script>
    <!-- Custom Theme files -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }
    </script>

<!--Google Fonts-->

<!-- start-smoth-scrolling -->
    <script type="text/javascript" src="js/move-top.js"></script>
    <script type="text/javascript" src="js/easing.js"></script>
    <link rel="stylesheet" id="sc" type="text/css" href="" />
    <link rel="stylesheet" type="text/css" href="../css/bootstrap-theme.min.css" />
    <script src="../js/bootstrap.min.js"></script>

	<script type="text/javascript">
        window.onload=function() {
            var sc = document.getElementById("sc");
            if (screen.width < 1366)  //获取屏幕的的宽度
            {
                sc.setAttribute("href", "css/720P.css");   //设置css引入样式表的路径

            }
        }
			jQuery(document).ready(function($) {
				$(".scroll").click(function(event){		
					event.preventDefault();
					$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
				});
			});
	</script>
</head>

<?php $auth = false; ?>

<body style="padding-top:100px">
<!-- //end-smoth-scrolling -->
<!--header start here-->
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

      <div class="work">
      	<div class="container">
				<div class="work-top">
                    <h1>研究领域与方向 </h1>
				</div>
				<div class="work-bottom">
					<div class="col-md-3 portfolio-wrapper">		
							<a href="images/b-w1.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title">
						     <img src="images/b-w1.jpg" alt="" class="img-responsive"><div class="b-wrapper"><h2 class="b-animate b-from-left    b-delay03"><img src="images/link.png" alt=""/></h2>
						  		</div></a>
                         <div class="work-details">
					   	  <a href="#section-1">
                              <h3>宽带无线移动网络 </h3>
                              <p>TD-LTE协议栈实现</p><br>
                          </a>
					   </div>
					</div>
					<div class="col-md-3 portfolio-wrapper">		
							<a href="images/b-w2.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title">
						     <img src="images/b-w2.jpg" alt="" class="img-responsive"><div class="b-wrapper"><h2 class="b-animate b-from-left    b-delay03"><img src="images/link.png" alt=""/></h2>
						  		</div></a>
                         <div class="work-details">
                             <a href="#section-2">
					   	         <h3>无线自组织网络</h3>
                                 <p>信息传输分系统研制、绿色网络关键技术研究</p>
                             </a>
					   </div>
					</div>
					<div class="col-md-3 portfolio-wrapper">		
							<a href="images/b-w3.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title">
						     <img src="images/b-w3.jpg" alt="" class="img-responsive"><div class="b-wrapper"><h2 class="b-animate b-from-left    b-delay03"><img src="images/link.png" alt=""/></h2>
						  		</div></a>
                         <div class="work-details">
                             <a href="#section-3">
					   	        <h3>无线传感网/物联网</h3>
					   	        <p>门山地震带小流域滑坡泥石流灾害监测预警技术研究与示范</p>
                             </a>
					   </div>
					</div>
					<div class="col-md-3 portfolio-wrapper">		
							<a href="images/b-w4.jpg" class="b-link-stripe b-animate-go  swipebox"  title="Image Title">
						     <img src="images/b-w4.jpg" alt="" class="img-responsive"><div class="b-wrapper"><h2 class="b-animate b-from-left    b-delay03"><img src="images/link.png" alt=""/></h2>
						  		</div></a>
                         <div class="work-details">
                             <a href="#section-4">
					   	        <h3>无线网络新技术</h3>
                                 <p>动态频谱资源共享宽带无线通信系统验证网络</p>
                             </a>
					   </div>
					</div>
				<div class="clearfix" id="section-1"> </div>
			 </div>
		  </div>
	<div class="recent-posts" >
		<div class="container">
				<div class="recent-bottom" >
					<div class="col-md-6 recent-left">
						<h3>宽带无线移动网络</h3>
                        <h4>TD-LTE协议栈实现（国家科技重大专项  2014ZX03004003）</h4>
                        <p><strong>项目简介</strong></p>
						<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;国家科技重大专项——“基于TD-LTE的宽带移动专用通信网络总体方案与测试评估研究”项目子课题。课题按照宽带移动专用通信网络总体方案和相应标准，集成和开发技术验证系统中基本网元的MAC及上层协议栈，并与基带和射频处理模块结合，形成包括终端、基站、网关等基本网元的验证系统，进一步开发能完成标准一致性测试的测试系统。</p>

                        <p><strong>研究成果</strong></p>
                        <p>· 采用统一的架构的TD-LTE系统基本网元</p>
                        <p>· 建设技术验证系统</p>
                        <p>· 系统带宽：20MHz</p>
                        <p>· 系统峰值速率：下行50Mb/s</p>

                        <p><strong>应用前景</strong></p>
                        <p>· 宽带移动专用通信系统，具有以中速、高速、超高速三种为代表的宽带异构接入模式</p>
                        <p>· 基于TD-LTE的集群系统，“一个系统、多种接入”，实现语音、图像、视频以及分组数据业务</p>
                        <p>· 标准一致性测试</p>
					</div>
					<div class="col-md-6 recent-right">
                        <br><br>
                        <img src="images/p1.jpg" alt="" class="img-responsive">
                    </div>
                </div>
			</div>

	       <div class="clearfix"> </div>

        <hr/>
    <div class="container">
        <div class="recent-bottom">
            <div class="col-md-6 recent-right">
                <img src="images/p2.jpg" alt="" class="img-responsive">
            </div>
            <div class="col-md-6 recent-right">
                <h4>绿色网络关键技术研究（国家863项目 2012AA011402）</h4>
                <p><strong>项目简介</strong></p>
                <p>该项目重点研究并突破通信网络（包括终端、无线/有线接入网、核心网、传输网）端到端低能耗绿色网络架构演进和管理技术、面向新业务新终端的网络融合技术、绿色网络的系统技术，构造端到端的绿色节能网络示范网络和评价体系，积极推进产业化进程。</p>
                <p id="section-2"><strong>应用前景</strong></p>
                <p>LTE/4G通信中的低能耗通信技术</p>
                <p>为5G节能技术的研究和进展提供理论基础和技术支持。</p>
                <p>仿真平台和实验系统可扩展支持蜂窝网、WiFi、车联网等多网/多应用融合场景。</p>
                <p><strong>研究成果</strong></p>
                <p>基于能效的单小区网络-用户联合资源分配</p>
                <p>同构蜂窝多小区系统网高能效资源优化分配</p>
                <p>异构蜂窝多小区系统高能效拓扑控制</p>
                <p>异构蜂窝多小区系统高能效接入控制技术</p>
            </div>
        </div>
    </div>

        <div class="clearfix"> </div>


        <div class="container" >
            <br><hr style=" border:1px #a89574 solid; " /><br>
            <div class="recent-bottom" >
                <div class="col-md-6 recent-left">
                    <h3>无线自组织网络</h3>
                    <h4>信息传输分系统研制(国家863重大项目，2005AA121120，2005-2006)</h4>
                    <p><strong>项目简介</strong></p>
                    <p>本项目构重点研究适应多种通信体制、多层次通信需求的分布式分级无线自组网体制，建了基于超短波扩频、跳频电台的多层次、全移动、大覆盖范围的无线自组织网络，满足了项目应用系统在应急、机动、救灾等的组网、通信、指挥等方面的需求。</p>
                    <br><br><br>
                    <img src="images/p3.jpg" alt="" class="img-responsive">
                </div>
                <div class="col-md-6 recent-right">
                    <img src="images/post2.jpg" alt="" class="img-responsive">
                    <p><strong>应用前景</strong></p>
                    <p>车载超短波扩频、跳频联合移动自组织网</p>
                    <p>多种通信体制、大规模无线自组织网分级组网技术</p>
                    <p>基于邻居信息的快速拓扑构建技术</p>
                    <p>网内自组织、网间动态自组织互联</p>
                    <p>大规模应急通信网</p>
                    <p>军事战术通信网、分级指挥调度网</p>
                    <br>
                </div>
            </div>
        </div>
        <hr/>

        <div class="container">
            <div class="recent-bottom">
                <div class="col-md-6 recent-right">
                    <img src="images/f4.jpg" alt="" class="img-responsive">
                    <img src="images/p4.jpg" alt="" class="img-responsive" id="section-3">

                </div>
                <div class="col-md-6 recent-right">
                    <h4>车用无线自组织网络安全告警信息传输策略研究（国家自然基金项目，60802024，2009-2011）</h4>
                    <p><strong>项目简介</strong></p>
                    <p>在复杂多变的车用无线自组网环境下，基于IEEE 802.11p和IEEE 1609.4标准，研究控制信道与服务信道的协同机制，设计优化的车辆安全告警信息传输策略，增强安全告警信息传输的实时性与可靠性。</p>
                    <p><strong>应用前景</strong></p>
                    <p>车辆拥堵环境多信道协同访问控制</p>
                    <p>车辆拥堵环境多信道协同访问控制</p>
                    <p>区分业务优先级的MAC算法</p>
                    <p>大干扰范围下的可靠广播策略</p>
                    <p>基于内容相关性的安全信息投递策略</p>
                    <p>基于NS-2的VANET组网与通信仿真模型</p>
                    <p> 智能交通系统、车间与车路通信平台</p>
                    <p>无线多跳网络大干扰范围下的广播传输业务</p>
                    <p>交通安全与故障告警系统、车载网络增值服务系统</p>

                </div>
            </div>
        </div>

        <div class="container" >
            <br><hr style=" border:1px #a89574 solid; " /><br>
            <div class="recent-bottom" >
                <div class="col-md-6 recent-left">
                    <h3>无线传感网/物联网</h3>
                    <h4>龙门山地震带小流域滑坡泥石流灾害监测预警技术研究与示范（国家科技支撑计划，2011BAK12B02，2011-2015）</h4>
                    <p><strong>项目简介</strong></p>
                    <p>为降低山地滑坡、泥石流灾害带来的生命财产损失，克服山地环境下通信环境恶劣、传输故障率高、缺少市电供应、维护成本高昂等问题，建设高可靠、低能耗的异构无线灾害监测预警网络，提供持续、可靠的山地灾害监测预警数据。本项目在龙门上地震带建立灾害监测预警技术集成与应用示范点，为灾害监测预警技术的推广与应用奠定基础。</p>
                    <br>
                    <img src="images/p5.1.jpg" alt="" class="img-responsive">
                </div>
                <div class="col-md-6 recent-right">
                    <img src="images/post3.jpg" alt="" class="img-responsive">
                    <p><strong>应用前景</strong></p>
                    <p>分层架构，盲点中继技术，提高网络可靠性</p>
                    <p>业务自适应式多通道接入技术</p>
                    <p>GPRS/ 3G/4G/卫星/WiFi多制式智能接入，适应山地恶劣多变的通信环境</p>
                    <p>多维节能策略，提高网络生存期，减少运营成本</p>
                    <p>极端恶劣情况下维持通信网络关键功能</p>
                    <img src="images/p5.3.jpg" alt="" class="img-responsive">
                    <br>
                </div>
            </div>
        </div>
        <hr/>

        <div class="container">
            <div class="recent-bottom">
                <div class="col-md-6 recent-right">
                    <img src="images/f5.jpg" alt="" class="img-responsive">
                    <br><br>
                    <p id="section-4"><strong>应用前景</strong></p>
                    <p>首都机场接续运输协调运行保障示范系统</p>
                    <p>多接续方式运力协调分析模型</p>
                    <p>智能化动态调配技术</p>
                    <p>可应用于多种交通枢纽的接续运输协调</p>
                    <p>技术和数据可用于交通一体化出行系统</p>

                </div>
                <div class="col-md-6 recent-right">
                    <h4>首都机场接续运输协调运行保障技术研究与示范应用（北京市交通行业科技项目，2013-2014）</h4>
                    <p><strong>项目简介</strong></p>
                    <p>为提高机场运力的高效、有序利用，创建快捷、舒适的旅客出行环境，本项目以首都机场为示范场所，基于信息采集与管理平台，对各种接续运输方式运力进行协调分析，建立首都机场接续运输协调运行保障技术示范系统，提供机场接接续运输协调运行保障功能，面向政府、企业、公众等多主体提供相应信息服务。</p>
                    <img src="images/p6.jpg" alt="" class="img-responsive">
                </div>
            </div>
        </div>

        <div class="container" >
            <br><hr style=" border:1px #a89574 solid; " /><br>
            <div class="recent-bottom" >
                <div class="col-md-6 recent-left">
                    <h3>无线网络新技术</h3>
                    <h4>动态频谱资源共享宽带无线通信系统验证网络开发（国家863重点项目 2009～2012）</h4>
                    <p><strong>项目简介</strong></p>
                    <p>本项目研制出我国首套基于认知无线电技术的新型无线宽带网络系统，通过频谱感知动态使用空闲电视频道，提供无线宽带通信业务。并通过构建实验网络验证了该系统在不干扰电视广播信号的前提下，提供无线宽带网络服务。该技术可用于为城镇建设“超级无线”网络，提供基于动态频谱共享技术的下一代无线宽带通信设施。</p>
                    <br>
                    <img src="images/p7.2.jpg" alt="" class="img-responsive">
                </div>
                <div class="col-md-6 recent-right">
                    <img src="images/post4.jpg" alt="" class="img-responsive">
                    <p><strong>应用前景</strong></p>
                    <p>电视广播信号的独立认知与协同认知技术</p>
                    <p>认知网络组网与动态控制技术</p>
                    <p>动态频谱共享系统的网络体系架构(集中、分布、混合)</p>
                    <p>可动态重构协议栈架构</p>
                    <p>混合式网络架构实验验证系统</p>

                    <br><br>
                </div>
            </div>
        </div>
        <hr/>

        <div class="container">
            <div class="recent-bottom">
                <div class="col-md-6 recent-right">
                    <img src="images/f6.jpg" alt="" class="img-responsive">
                    <br><br>
                    <p><strong>应用前景</strong></p>
                    <p>基于移动社会网络设计高效信息投递/共享策略</p>
                    <p>构建移动社会网络测试平台</p>
                    <p>实现具有典型应用(交友、社团、搜索)的MSN原型系统</p>
                </div>
                <div class="col-md-6 recent-right">
                    <h4>Cross-Layer Investigation and Integration of Computing and Networking Aspects of Mobile Social Networks （欧盟第7框架科研合作项目，2013～2017）</h4>
                    <p><strong>项目简介</strong></p>
                    <p>从社会计算和无线传输网络角度分析移动社会网络（MSN）应用需求，研究MSN实际应用的网络架构，评估MSN网络容量负荷，设计资源分配策略。并实现典型MSN应用系统原型；验证相应的方法和策略。</p>
                    <img src="images/p8.jpg" alt="" class="img-responsive">
                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"> </div>
</div>
<a href="#0" class="cd-top">Top</a>
<link rel="stylesheet" href="css/swipebox.css">
	<script src="js/jquery.swipebox.min.js"></script> 
	    <script type="text/javascript">
			jQuery(function($) {
				$(".swipebox").swipebox();
			});
</script>

<!--footer star here-->
<div class="footer">
  <div class="container">
	  <div class="footer-main">
		<div class="footer-top">
			<div class="col-md-8 footer-news">
			<h5>UESTC 泛在无线网络团队</h5>
			</div>
			<div class="col-md-4 ftr-email">

			</div>
			<div class="clearfix"> </div>
		</div>

		</div>
	</div>
</div>
<!--footer end here-->
</body>
</html>