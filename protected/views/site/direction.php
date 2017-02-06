<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - 研究方向';
$this->breadcrumbs=array(
    '科研'=>array('site/direction'),
    '研究方向',
);
?>
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

<div class="cam-page-header">
    <div class="cam-wrap clearfix cam-local-navigation">
        <ul class="cam-unstyled-list cam-current">
            <li><a href="index.php?r=site/introduction">团队介绍</a></li>
            <li class="cam-current-page"><a href="#" class="active-trail">研究方向</a></li>
            <li><a href=<?php echo $auth ? "index.php?r=project/admin" : "index.php?r=project/index"; ?>>科研项目</a></li>
            <li><a href="#">科研成果</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    研究方向 Research direction
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <ul class="direction-list">
            <li><a href="index.php?r=site/direction#direction1">宽带无线移动网络</a></li>
            <li><a href="index.php?r=site/direction#direction2">无线自组织网络</a></li>
            <li><a href="index.php?r=site/direction#direction3">无线传感网/物联网</a></li>
            <li><a href="index.php?r=site/direction#direction4">无线网络新技术</a></li>
            <div class="clearfix"></div>
        </ul>
        <div class="direction-content">
            <div class="direction-item1">
                <h3 id="direction1">宽带无线移动网络</h3>
                <div class="direction-item1-left">
                    <h4>TD-LTE协议栈实现（国家科技重大专项 2014ZX03004003）</h4>
                    <h5>项目简介</h5>
                    <p>国家科技重大专项——“基于TD-LTE的宽带移动专用通信网络总体方案与测试评估研究”项目子课题。课题按照宽带移动专用通信网络总体方案和相应标准，集成和开发技术验证系统中基本网元的MAC及上层协议栈，并与基带和射频处理模块结合，形成包括终端、基站、网关等基本网元的验证系统，进一步开发能完成标准一致性测试的测试系统。</p>
                    <h5>研究成果</h5>
                    <p>1. 采用统一的架构的TD-LTE系统基本网元</p>
                    <p>2. 建设技术验证系统</p>
                    <p>3. 系统带宽：20MHz</p>
                    <p>4. 系统峰值速率：下行50Mb/s</p>
                    <h5>应用前景</h5>
                    <p>1. 宽带移动专用通信系统，具有以中速、高速、超高速三种为代表的宽带异构接入模式</p>
                    <p>2. 基于TD-LTE的集群系统，“一个系统、多种接入”，实现语音、图像、视频以及分组数据业务</p>
                    <p>3. 标准一致性测试</p>
                </div>
                <div class="direction-item1-right">
                    <img style="margin: 20px 0 10px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_1.png"/>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="direction-item2">
                <div class="direction-item2-left">
                    <img style="margin: 20px 0 10px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_2.png"/>
                </div>
                <div class="direction-item2-right">
                    <h4>绿色网络关键技术研究（国家863项目 2012AA011402）</h4>
                    <h5>项目简介</h5>
                    <p>该项目重点研究并突破通信网络（包括终端、无线/有线接入网、核心网、传输网）端到端低能耗绿色网络架构演进和管理技术、面向新业务新终端的网络融合技术、绿色网络的系统技术，构造端到端的绿色节能网络示范网络和评价体系，积极推进产业化进程。</p>
                    <h5>研究成果</h5>
                    <p>1. 基于能效的单小区网络-用户联合资源分配</p>
                    <p>2. 同构蜂窝多小区系统网高能效资源优化分配</p>
                    <p>3. 异构蜂窝多小区系统高能效拓扑控制</p>
                    <p>4. 异构蜂窝多小区系统高能效接入控制技术</p>
                    <h5>应用前景</h5>
                    <p>1. LTE/4G通信中的低能耗通信技术</p>
                    <p>2. 为5G节能技术的研究和进展提供理论基础和技术支持</p>
                    <p>3. 仿真平台和实验系统可扩展支持蜂窝网、WiFi、车联网等多网/多应用融合场景</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="direction-item3">
                <div class="direction-item3-left">
                    <h3 id="direction2">无线自组织网络</h3>
                    <h4>信息传输分系统研制（国家863重大项目 2005AA121120）</h4>
                    <h5>项目简介</h5>
                    <p>本项目构重点研究适应多种通信体制、多层次通信需求的分布式分级无线自组网体制，建了基于超短波扩频、跳频电台的多层次、全移动、大覆盖范围的无线自组织网络，满足了项目应用系统在应急、机动、救灾等的组网、通信、指挥等方面的需求。</p>
                    <h5>成果及应用</h5>
                    <p>1. 车载超短波扩频、跳频联合移动自组织网</p>
                    <p>2. 多种通信体制、大规模无线自组织网分级组网技术</p>
                    <p>3. 基于邻居信息的快速拓扑构建技术</p>
                    <p>4. 网内自组织、网间动态自组织互联</p>
                    <p>5. 大规模应急通信网</p>
                    <p>6. 军事战术通信网、分级指挥调度网</p>
                </div>
                <div class="direction-item3-right">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_3.png"/>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="direction-item4">
                <div class="direction-item4-left">
                    <img style="margin: 20px 0 10px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_4.png"/>
                </div>
                <div class="direction-item4-right">
                    <h4>车用无线自组织网络安全告警信息传输策略研究（国家自然基金项目 60802024）</h4>
                    <h5>项目简介</h5>
                    <p>在复杂多变的车用无线自组网环境下，基于IEEE 802.11p和IEEE 1609.4标准，研究控制信道与服务信道的协同机制，设计优化的车辆安全告警信息传输策略，增强安全告警信息传输的实时性与可靠性。</p>
                    <h5>成果及应用</h5>
                    <p>1. 车辆拥堵环境多信道协同访问控制</p>
                    <p>2. 区分业务优先级的MAC算法</p>
                    <p>3. 大干扰范围下的可靠广播策略</p>
                    <p>4. 基于内容相关性的安全信息投递策略</p>
                    <p>5. 基于NS-2的VANET组网与通信仿真模型</p>
                    <p>6. 智能交通系统、车间与车路通信平台</p>
                    <p>7. 无线多跳网络大干扰范围下的广播传输业务</p>
                    <p>8. 交通安全与故障告警系统、车载网络增值服务系统</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="direction-item5">
                <div class="direction-item5-left">
                    <h3 id="direction3">无线传感网/物联网</h3>
                    <h4>龙门山地震带小流域滑坡泥石流灾害监测预警技术研究与示范（国家科技支撑计划 2011BAK12B02）
                    </h4>
                    <h5>项目简介</h5>
                    <p>为降低山地滑坡、泥石流灾害带来的生命财产损失，克服山地环境下通信环境恶劣、传输故障率高、缺少市电供应、维护成本高昂等问题，建设高可靠、低能耗的异构无线灾害监测预警网络，提供持续、可靠的山地灾害监测预警数据。本项目在龙门上地震带建立灾害监测预警技术集成与应用示范点，为灾害监测预警技术的推广与应用奠定基础。</p>
                    <h5>成果及应用</h5>
                    <p>1. 分层架构，盲点中继技术，提高网络可靠性</p>
                    <p>2. 业务自适应式多通道接入技术</p>
                    <p>3. GPRS/ 3G/4G/卫星/WiFi多制式智能接入，适应山地恶劣多变的通信环境</p>
                    <p>4. 多维节能策略，提高网络生存期，减少运营成本</p>
                    <p>5. 极端恶劣情况下维持通信网络关键功能</p>
                </div>
                <div class="direction-item5-right">
                    <img style="margin: 20px 0 10px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_5.png"/>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="direction-item6">
                <div class="direction-item6-left">
                    <img style="margin: 20px 0 10px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_6.png"/>
                </div>
                <div class="direction-item6-right">
                    <h4>首都机场接续运输协调运行保障技术研究与示范应用（北京市交通行业科技项目）</h4>
                    <h5>项目简介</h5>
                    <p>为提高机场运力的高效、有序利用，创建快捷、舒适的旅客出行环境，本项目以首都机场为示范场所，基于信息采集与管理平台，对各种接续运输方式运力进行协调分析，建立首都机场接续运输协调运行保障技术示范系统，提供机场接接续运输协调运行保障功能，面向政府、企业、公众等多主体提供相应信息服务。</p>
                    <h5>成果及应用</h5>
                    <p>1. 首都机场接续运输协调运行保障示范系统</p>
                    <p>2. 多接续方式运力协调分析模型</p>
                    <p>3. 智能化动态调配技术</p>
                    <p>4. 可应用于多种交通枢纽的接续运输协调</p>
                    <p>5. 技术和数据可用于交通一体化出行系统</p>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="direction-item7">
                <h3 id="direction4">无线网络新技术</h3>
                <div class="direction-item7-left">
                    <h4>动态频谱资源共享宽带无线通信系统验证网络开发（国家863重点项目）</h4>
                    <h5>项目简介</h5>
                    <p>本项目研制出我国首套基于认知无线电技术的新型无线宽带网络系统，通过频谱感知动态使用空闲电视频道，提供无线宽带通信业务。并通过构建实验网络验证了该系统在不干扰电视广播信号的前提下，提供无线宽带网络服务。该技术可用于为城镇建设“超级无线”网络，提供基于动态频谱共享技术的下一代无线宽带通信设施。</p>
                    <h5>研究成果</h5>
                    <p>1. 电视广播信号的独立认知与协同认知技术</p>
                    <p>2. 认知网络组网与动态控制技术</p>
                    <p>3. 动态频谱共享系统的网络体系架构(集中、分布、混合)</p>
                    <p>4. 可动态重构协议栈架构</p>
                    <p>5. 混合式网络架构实验验证系统</p>
                </div>
                <div class="direction-item7-right">
                    <img style="margin: 20px 0 10px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_7.png"/>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="direction-item8">
                <div class="direction-item8-left">
                    <img style="margin: 20px 0 10px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/direction_8.png"/>
                </div>
                <div class="direction-item8-right">
                    <h4>Cross-Layer Investigation and Integration of Computing and Networking Aspects of Mobile Social Networks（欧盟第7框架科研合作项目）</h4>
                    <h5>项目简介</h5>
                    <p>从社会计算和无线传输网络角度分析移动社会网络（MSN）应用需求，研究MSN实际应用的网络架构，评估MSN网络容量负荷，设计资源分配策略。并实现典型MSN应用系统原型；验证相应的方法和策略。</p>
                    <h5>成果及应用</h5>
                    <p>1. 基于移动社会网络设计高效信息投递/共享策略</p>
                    <p>2. 构建移动社会网络测试平台</p>
                    <p>3. 实现具有典型应用(交友、社团、搜索)的MSN原型系统</p>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>