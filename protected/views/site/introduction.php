<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name . ' - 团队介绍';
$this->breadcrumbs=array(
    '团队介绍',
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
            <li class="cam-current-page"><a href="#" class="active-trail">团队介绍</a></li>
            <li><a href="index.php?r=site/direction">研究方向</a></li>
            <li><a href=<?php echo $auth ? "index.php?r=project/admin" : "index.php?r=project/index"; ?>>科研项目</a></li>
            <li><a href="#">科研成果</a></li>
        </ul>
    </div>
    <div class="cam-wrap clearfix cam-page-sub-title cam-recessed-sub-title">
        <div class="cam-column">
            <div class="cam-content-container">
                <h1 class="cam-sub-title">
                    团队介绍 Team Introduction
                </h1>
            </div>
        </div>
    </div>
</div>
<div class="cam-content cam-recessed-content">
    <div class="cam-wrap clearfix">
        <div class="introduce-content">
            <h2>基本情况</h2>
            <p>泛在无线网络团队自上世纪80年代中期开始从事计算机网络、无线网络领域的研究工作，是国内开展无线网络技术研究的先行者之一。
            </p>
            <p>团队目前有教师15人，其中教授、博士生导师3人，副教授6人，高级工程师1人，讲师6人。博士6人，在职博士研究生4人。在读全日制博士研究生10人，硕士研究生90余人。
            </p>
            <p>毛玉明教授/冷甦鹏教授为团队负责人，毛玉明教授是享受国家特殊津贴的专家，国家百千万人才入选者，国内较早研究无线自组织网络架构和协议的人员之一，在无线网络组网相关研究方面具有较深造诣和知名度。冷甦鹏教授是学校从新加坡南洋理工大学引进的优秀海归人才，教育部21世纪优秀人才项目获得者，学校百人计划获得者，现任通信与信息工程学院主管科研副院长。2015年，学校引进的我国千人计划获得者杨鲲教授加盟我们团队，进一步提升了我们团队的整体实力。
            </p>
            <p>团队自上世纪80年代中期开始从事计算机网络、无线网络领域的研究工作，是国内开展无线网络技术研究的先行者之一。“七五”以来，先后完成了包括电子预研项目、国家重大专项项目、国家863项目、国家科技支撑计划项目、国家自然基金、教育部重点项目，以及校企合作项目数十项，取得丰硕成果。获得多项国家级和省部级科研成果奖励。</p>
            <p>团队创建并承担了网络工程专业的建设，创建了网络工程专业人才培养体系、课程体系和实验体系。出版系列网络工程相关教材，承担所有网络工程专业课程的教学。主持“通信与信息系统国家级实验教学示范中心”建设。承建的骨干传输系统实验室、路由与互连实验室、网络工程实验室、综合接入网实验室等国内技术一流。多门课程获得省级精品课程，网络工程专业获批国家级特色专业建设点。</p>
            <img style="margin: 10px 0 20px 0" src="<?php echo Yii::app()->request->baseUrl; ?>/images/introduce_1.png"/>
            <p>团队研究的不同方向都承接了大量的科研项目。其中，无线自组织网络方向有国家863重大重点项目3项，国家自然基金项目1项，部级项目1项。无线传感网与物联网方向有国家科技支撑计划2项，国家科技重大专项1项，国家自然基金项目1项。宽带无线移动网络方向有国家科技重大专项5项，部级项目1项。无线网络新技术方面有国家863重大重点项目1项，国家自然基金项目2项，国家科技重大专项1项，还有学校首个欧盟合作项目。</p>
            <p>团队研究的主要支撑技术涉及到操作系统方面，软件技术，网络协议技术和网络仿真技术。其中操作系统涉及到Windows系统、Linux系统、Android系统。软件技术涉及到C、C++高级语言、操作系统网络驱动软件设计、通信协议软件设计、传感网协议与应用软件设计。网络协议技术涉及到TCP/IP协议、无线信道访问MAC技术、无线网络组网协议、无线路由协议技术、传感器网组网协议。网络仿真技术涉及Opnet网络仿真、NS2/3仿真技术、MATLAB仿真还有一些其它仿真。</p>
            <h2>技术优势</h2>
            <p>团队近几年完成了十余项国家重大专项、863高科技计划项目及国家自然基金项目，自主研发多种无线组网设备，自主设计并实现多种无线网络组网结构、路由协议、MAC协议并获得多项授权专利。技术底蕴深厚，大项目研发经验丰富。
            </p>
            <p>团队长期从事网络体系与协议的研究，并紧跟该领域的前沿技术，理论研究与系统开发实现并重，尤其在无线网络研究方面成效卓著。在以下方面技术实力国内突出：</p>
            <p>1. 网络体系结构设计与分析技术</p>
            <p>2. 网络协议设计与协议分析技术</p>
            <p>3. 协议软件实现技术</p>
            <p>4. 网络工程与应用技术</p>
            <h2>部分团队导师介绍</h2>
            <p style="font-weight: bold;">毛玉明 教授</p>
            <p>在七五预研项目PENET分组交换实验网中，提出网络管理控制模型，自主设计网络控制协议，在国内第一个成功研制出分组网网控中心系统，获电子部科技进步一等奖和国家科技进步二等奖；分组无线网预研项目的创始人之一，在低速分组无线网、高速分组无线网、分组无线网应用系统项目中，对无线网络协议体系、无线信道访问协议、无线网管理技术、系统软件架构设计、系统应用等多方面做出突出贡献，获部级二、三等奖多次；提出IP路由高速转发技术，并成功研制成功我国第一台基于PC的高性能局域网路由器，获教育部科学技术一等奖一项。</p>
            <p>主持国家863无线移动自组织互联网重点项目，在国内首次提出并实现了具有无线mesh网结构的无线移动自组织互联网实验系统。提出了多级分层的无线自组织网络互联结构，并在超短波指挥调度系统中获得成功示范应用。</p>
            <p>荣获国防科工委“光华科技基金个人二等奖”、“国务院政府特殊津贴”、国家“百千万人才工程”国家级入选。</p>
            <p style="font-weight: bold;">冷甦鹏 教授</p>
            <p>近年承担国家自然科学基金、欧盟FP7国际合作项目、国家863、国家科技重大专项、国家科技支撑计划项目、省部级及企业合作项目/课题共20余项，主持12项。近年在IEEE Trans.、INFOCOM、ICC等知名学术期刊和国际会议发表论文90余篇, 其中SCI/EI数据库收录50余篇, 出版英文专著及章节3部。申请国家发明专利21项，已授权8项。曾获省级科技进步二等奖两项。</p>
            <p>任国家留学基金评审专家、中国博士后科学基金评审专家、国家863计划项目同行评审专家，Intern. J. of Ultra Wideband Comm. and Sys. (Inderscience) 编委，IEEE Comm. Magazine、IEEE Trans. Wireless Comm.、电子学报、通信学报等国内外10余家知名学术期刊审稿专家，担任CHINACOM 2014分会共同主席、IEEE ICESS2013 TPC副主席、IEEE ICCT 2011分会共同主席、CHINACOM 2010 Workshops共同主席、及 GLOBECOM 2008-2012等20余个国际会议TPC成员。</p>
            <p style="font-weight: bold;">杨鲲 教授</p>
            <p>长期致力于无线通信网络、核心IP网络及移动计算等方向的科学理论和产业化研究，并在网络融合与虚拟化等领域获得了一系列开拓性和创新性成果。先后在IEEE JSAC、IEEE TWC、IEEE TMC，IEEE TVT， IEEE Network等国际权威期刊和顶级国际会议（如PerCom， INFOCOM）发表论文约200篇，其代表性文章发表在通信领域最权威期刊IEEE JSAC上，引用超过100次以上。近5年主持承担的欧盟第7框架计划FP7和英国自然科学研究项目十余项，累计科研经费达4000万人民币。拥有英国发明专利1项。</p>
            <p>目前是国家第十一批“千人计划”入选者，IET（原IEE） Fellow，IEEE 高级会员，IEEE InterCloud 全球项目的初创成员及其6个执行常委之一。是多家著名国际期刊(如IEEE Communication Surveys & Tutorials, IJSCN, IJTS, IJCS等)的编委会成员；是欧盟若干个技术白皮书的起草者之一；多个国家（如法国、挪威、以色列、加拿大、新加坡）基金委的评审专家。中国科技部973项目、自然基金委评审人。曾担任20余次国际学术会议(如ICC、GLOBECOM等)TCP主席。</p>
            <div>
                <div class="introduce-teacher-first">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/introduce_teacher_1.png">
                    <p>毛玉明 教授</p>
                </div>
                <div class="introduce-teacher">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/introduce_teacher_2.png">
                    <p>冷甦鹏 教授</p>
                </div>
                <div class="introduce-teacher">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/introduce_teacher_3.png">
                    <p>杨鲲 教授</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>