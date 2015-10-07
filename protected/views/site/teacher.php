<?php
$this->breadcrumbs=array(
    '导师介绍',
);
?>


<style type="text/css">
    div.links.row {
        margin-top: 1em;
    }
    div.links a{
        margin-right: 4px;
    }
    div.teacher_info.row {
        margin-bottom: 2.5em;
    }
    .teacher_info p {
        margin: 0.1em;
        text-indent: 2em;
    }

    .teacher_info h2{
        font-size: 1.8rem;
    }

    .teacher_info h3{
        font-size: 1.5rem;
    }

    .teacher_info {
        background-color: #eee;
        border: 1px solid #999;

        margin-top: 0px;
        margin-bottom: 20px;
        padding-bottom: 0px;
        -webkit-box-shadow: 0 6px 10px rgba(0,0,0, .2);
        -moz-box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 6px 10px rgba(0, 0, 0, 0.2);
    }
    .inline {
        display: inline;
    }
</style>

<script>
    $(document).ready(function(){
        $(".more").hide();
        $(".view").click(function(){
            var text = ($(this).text() == "查看") ? "收起" : "查看";
            $(this).siblings(".more").fadeToggle();
            $(this).text(text);
        });
    });
</script>
<div class="container">
    <div class="row links">
        <div class="small-2"></div>
        <div class="small-2"></div>
        <div class="small-2"></div>
        <div class="small-2"></div>
        <div class="small-2"></div>
        <a class="button small radius" href="#prof_mao">毛玉明 教授</a>
        <a class="button small radius" href="#prof_leng">冷甦鹏 教授</a>
        <a class="button small radius" href="#prof_ma">马立香 副教授</a>
        <a class="button small radius" href="#prof_li">李龙江 副教授</a>
        <a class="button small radius" href="#yuqin">于秦  副教授</a>
        <a class="button small radius" href="#liuqiang">刘强 副教授</a>
        <a class="button small radius" href="#duanye">段景山 高级工程师</a>
        <a class="button small radius" href="#yangning">杨宁 副教授</a>
        <a class="button small radius" href="#changmeie">彭美娥 讲师</a>
        <a class="button small radius" href="#zhangke">张科 讲师</a>
        <a class="button small radius" href="#yangjianjun">杨建军 讲师</a>
        <a class="button small radius" href="#wufan">吴凡 讲师</a>
        <a class="button small radius" href="#weiyunkai">韦云凯 讲师</a>
        <a class="button small radius" href="#huangxiaoyan">黄晓燕 讲师</a>

    </div>
    <div id="prof_mao" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>prof_mao.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>毛玉明 教授</strong></h2>
            <h3>个人简历</h3>
            <p>1977年～1982年，电子科技大学通信专业、本科</p>
            <p>1982年～1984年，电子科技大学信息传输与处理专业，硕士</p>
            <p>1984年～1992年，电子科技大学通信与信息工程学院，助教讲师</p>
            <p>1992年～1999年，电子科技大学通信与信息工程学院，副教授</p>
            <p>1999年起，电子科技大学通信与信息工程学院，教授，博士生导师(2002年起)</p>
            <h3 class="inline">主要学术成绩</h3>


                <p>在七五预研项目PENET分组交换实验网中，提出网络管理控制模型，自主设计网络控制协议，在国内第一个成功研制出分组网网控中心系统； 获电子部科技进步一等奖和国家科技进步二等奖。</p>
                <p>军用分组无线网预研项目的创始人之一。在低速分组无线网、高速分组无线网、分组无线网应用系统项目中，对无线网络协议体系、无线信道访问协议、无线网管理技术、系统软件架构设计、系统应用等多方面做出突出贡献，获部级二、三等奖多次；提出IP路由高速转发技术，并成功研制成功我国第一台基于PC的高性能局域网路由器；获教育部科学技术一等奖一项。</p>
                <p>主持国家863无线移动自组织互联网重点项目，在国内首次提出并实现了具有无线mesh网结构的无线移动自组织互联网实验系统。提出了多级分层的无线自组织网络互联结构，并在超短波指挥调度系统中获得成功示范应用。</p>
                <p>荣获国防科工委“光华科技基金个人二等奖”、“国务院政府特殊津贴”、国家“百千万人才工程”国家级入选。</p>
            <br>
        </div>
    </div>

    <div id="prof_leng" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>prof_leng.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>冷甦鹏 教授</strong></h2>
            <h3>个人简历</h3>
            <p><strong>博士</strong>，<strong>教授</strong>，<strong>博士生导师</strong>，教育部“新世纪优秀人才支持计划”入选者，现于电子科技大学通信与信息工程学院从事科研和教学工作。研究领域包括无线自组织网、物联网/无线传感网、认知无线电网络、下一代宽带无线网络、无线移动互联网、智能交通技术等。曾在信息产业部第二十八研究所从事电子设备的设计开发工作，担任项目主持设计师，获江苏省科技进步二等奖一项。后于新加坡南洋理工大学（Nanyang Technological University）电子与电机工程学院从事无线自组织网络技术研究，获博士学位。毕业后于南洋理工大学网络技术研究中心从事下一代无线网络研究，任研究员。2005年9月作为引进人才任职于电子科技大学。2008年作为访问教授（Visiting Professor）对美国奥克兰大学（Oakland University）进行了学术访问与科研项目合作，并与挪威Simula国家研究实验室建立了长期的学术合作关系。</p>
            <h3 class="inline">主要学术成绩</h3>
            <p>目前为IEEE Commun. Society与Vehicular Technology Society 会员， International Journal of Ultra Wideband Commun. and Systems（Inderscience）编委，IEEE Commun. Magazine, IEEE Trans. on Wireless Commun.、IEEE Wireless Commun. Magazine、Computer Commun.(Elsevier), Computer Networks (Elsevier)、电子学报、通信学报等国内外10余家学术期刊审稿专家，GLOBECOM 2008～2010等10余个国际会议TPC Member，并为CHINACOM 2010 workshop 主席、IEEE ICCT 2011 Commun. Theory分会共同主席，科技部国际科技合作同行专家、国家863 科技项目申报同行专家。在国内外学术期刊及会议上发表了50余篇通信领域的高质量论文，其中SCI收录7篇，EI收录29篇，出版英文专著1部，并申请专利4项。作为课题负责人或主研人员参与了国家自然基金项目2项、国家863项目课题2项、国家科技重大专项项目课题4项、国家科技支撑项目1项、部级基金项目3项，校企合作项目多项。</p>
        </div>
    </div>

    <div id="prof_ma" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>prof_ma.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>马立香 副教授</strong></h2>
            <h3>个人简历</h3>
            <p>1984年7月重庆大学计算机及自动化系本科毕业；1984.7至1986.9,信产部711厂从事技术情报工作；1986.10至2001.6,信产部789厂从事军事通信网络的研制工作，其间参加多个国家级炮兵通信系统的研制，受聘高级工程师，通信主任设计师；2001年调入电子科技大学至今，受聘副教授，从事计算机网络及网络工程相关的教学与科研工作。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>数据通信与计算机网络、无线自组织网络、无线传感器网络、宽带无线网络和物联网技术。</p>
                <h3>主要学术成绩</h3>
                <p>参与编写出版教材2部，在国内期刊和国际会议上发表论文十余篇，其中EI收录3篇。曾获“重庆市劳动模范”称号，电子科大 “优秀主讲教师”。近几年参加国家863高科技2项，科技部重大专项科研项目2项。</p>

        </div>
    </div>




    <div id="prof_li" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>prof_li.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>李龙江 副教授</strong></h2>
            <h3>个人简历</h3>
            <p>1998年7月，本科毕业于西安邮电学院，获得计算机科学与技术专业学士学位</p>
            <p>2001年4月，硕士毕业于西安电子科技大学，获得计算机科学与技术专业硕士学位</p>
            <p>2001年4月至2003年8月，于中兴通讯股份有限公司南京研究所，担任软件研发工程师</p>
            <p>2007年10月，于上海交通大学电子与电气工程学院，获得计算机科学与技术专业博士学位</p>
            <p>2007年10月至今， 于电子科技大学通信与信息工程学院，从事教学与科研工作</p>
            <h3 class="inline">主要学术成绩</h3>

                <p>研究领域包括无线自组织网/传感器网络、宽带无线网络、移动互联网、三维可视化、物联网技术等。</p>
                <p>已发表10余篇通信网络领域的高质量论文, 第一作者EI收录论文9篇，其中SCI收录7篇，并申请该领域相关的专利3项。曾担任国际会议ChinaCom2010、IEEE ICCT '11（ICCT 2011 : IEEE 13th International Conference on Communication Technology）国际会议TPC Member，《IEEE GLOBECOM 2008 》《European Wireless conference2009 》与国际期刊《Wireless Personal Communications》《Wiley::Wireless Communications &amp; Mobile Computing》《Journal of Network and Computer Applications》等审稿专家。目前主持校企合作项目2项，并参与1项国家科技重大专项项目及2项自然基金项目。</p>

        </div>
    </div>

    <div id="yuqin" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>yuqin.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>于秦 博士/博士后 副教授</strong></h2>
            <h3>个人简历</h3>
            <p>996年毕业于重庆邮电大学获工学学士学位
                2002年和2006年毕业于电子科技大学，获工学硕士和工学博士学位
                2007年1月留校任教至今
                2007.6-2009.12在电子科技大学博士后科研流动站从事博士后研究工作
                2010.1-2011.1作为访问学者对美国Purdue University进行学术访问与科研项目交流
                2011.10-2014.2在迈普通信技术股份有限公司博士后科研工作站从事博士后研究工作。</p>



                <h3>主要学术成绩</h3>
                <p>主要研究方向为无线网络、移动通信及信息安全等。为IEEE、IEEE Comm. Society和IEICE会员及10余个国际会议TPC Member。先后在国内外杂志和国际会议发表高级别学术论文20余篇，申请并获授权国内发明专利10余件，并出版学术专著多部。参与并主持多项国家科技重大专项、863项目、国家自然科学基金、博士后科学基金和中央高校科研业务费项目及华为、中兴、迈普等企业合作项目。</p>

        </div>
    </div>


    <div id="liuqiang" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>liuqiang.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>刘强 博士 副教授</strong></h2>
            <h3>个人简历</h3>
            <p>1996年至今留校任教
                1996年电子科技大学获得学士学位
                2000年电子科技大学获得硕士学位
                2012年电子科技大学获得博士学位
                2012年5月进入电子科技大学计算机科学与技术博士后流动站从事博士后研究工作
                2012年12月-2013年12月在英国埃塞克斯大学作访问学者。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>无线自组织/传感器网络，物联网，分子通信，移动社会网络。</p>
                <h3>主要学术成绩</h3>
                <p>长期从事通信与网络相关的教学和科研工作。主讲“交换原理”课程。作为团队主要研究人员，主持1项国家科技支撑项目和1项横向项目，作为主研参与863、科技重大专项、自然科学基金等多项国家级科研项目。在国内外一流期刊和国际会议上发表论文十余篇。现为IEEE会员，担任Int. J. Commun. Syst.等多个期刊审稿人，BICT 2014 国际会议TPC Member。</p>

        </div>
    </div>

    <div id="duanye" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>duanye.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>段景山 高级工程师</strong></h2>
            <h3>个人简历</h3>
            <p>1999年毕业于电子科技大学获硕士学位，同年留校工作至今。作为团队骨干研究人员，具有较深厚的网络软件研发基础和丰富的软件实现经验。擅长网络协议、设备驱动等方面的设计与实现。获得省级教学成果一等奖、二等奖，学校“三育人”先进个人、“优秀主讲教师”、“青年教师教学优秀奖”等多种荣誉。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>无线自组织网络、网络协议、网络软件等</p>
                <h3>主要学术成绩</h3>
                <p>积极践行教学改革，参与质量工程、建设精品课程、主持教改项目。主讲《计算机通信网》、《软件技术基础》、《网络软件设计》、《网络社会学》、《数据通信网》、《TCP/IP协议原理》、《多媒体通信》、《局域网技术与组网工程》等课程。参与实验教学示范中心建设工作，并主持实验室专项建设项目。</p>

        </div>
    </div>

    <div id="yangning" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>yangning.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>杨宁 副教授</strong></h2>
            <h3>个人简历</h3>
            <p>11999年毕业于电子科技大学获硕士学位，同年留校工作至今。长期从事通信与网络相关的教学和科研工作。团队骨干研究人员，具有较深厚的网络协议设计与研发功底。擅长网络协议设计、网络组网与网络系统集成与实现。获得了学校 “优秀主讲教师”、“青年教师教学优秀奖”等多种荣誉。同时还是Cisco高级网络培训师。
            </p>


        </div>
    </div>

    <div id="changmeie" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>changmeie.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>彭美娥 讲师</strong></h2>
            <h3>个人简历</h3>
            <p>1991年毕业于重庆大学获工学学士学位1995年毕业于电子科技大学获工学硕士学位。同年留校任教至今。一直从事网络相关的教学与研究。参编并出版《接入网技术》、《局域网与城域网》两本教材。曾获部级科学技术进步奖二等奖及多项校教学成果奖。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>无线自组织网/传感器网络，数据通信与计算机网络，宽带接入网技术等。</p>
                <h3>教学情况</h3>
                <p>主讲《局域网与城域网》、《接入网技术》、《交换原理》、《软件技术基础》等多门课程。参与网络工程专业和实验室建设以及精品课程的建设。</p>

        </div>
    </div>

    <div id="zhangke" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>zhangke.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>张科 在职博士生 讲师</strong></h2>
            <h3>个人简历</h3>
            <p>2004年获得电子科技大学工学硕士学位，并留校任教至今。一直从事通信与网络方面的教学与科研工作。参与了多项863项目、国家科技支撑计划等项目。主讲《接入网技术》、《TCP/IP协议》本科课程。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>移动自组织网络，包括自组织网络组网体制、路由算法以及无线网络数据流量分析；智能电网与V2G相关技术，包括基于智能电网的电动汽车充放电调度、车载异构网络接入选择、信息投递策略等。</p>

        </div>
    </div>

    <div id="yangjianjun" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>yangjianjun.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>杨建军  在职博士生  讲师</strong></h2>
            <h3>个人简历</h3>
            <p>2003年毕业于电子科技大学获工学硕士学位，并留校任教至今。一直从事于无线通信与网络方面的教学与研究工作，参与了多项863项目。主讲《软件技术基础》、《交换原理》、《接入网技术》等本科课程。
            <h3 class="inline">主要研究方向</h3>

                <p>无线通信中的基于异构网络的资源分配和优化，绿色通信，CR网络中的频谱资源分配和优化以及基于LTE的集群通信中的移动性管理等。</p>


        </div>
    </div>

    <div id="wufan" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>wufan.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>吴凡  在职博士生  讲师</strong></h2>
            <h3>个人简历</h3>
            <p>2004年获得电子科技大学工学硕士学位，并留校任教至今。一直从事通信与网络方面的教学与科研。参与了多项国家科技重大专项，国家863计划项目。主讲《接入网技术》、《TCP/IP协议》本科课程。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>新一代无线网络资源分配与优化，移动自组织网络体系结构和组网技术等。</p>

        </div>
    </div>

    <div id="weiyunkai" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>weiyunkai.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>韦云凯  在职博士生  讲师</strong></h2>
            <h3>个人简历</h3>
            <p>2004年获得电子科技大学工学硕士学位，并留校工作至今。一直从事通信与网络方面的教学与科研。主持/参与了多项国家863、重大科技计划、科技支撑计划、自然科学基金等项目。获得多项国家发明专利，并发表多篇高水平文章。主讲《局域网与城域网》、《计算机通信网》等本科课程。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>无线网络与信息论，包括移动社会网络、物联网、实时视频流编码与传输等。 </p>


        </div>
    </div>

    <div id="huangxiaoyan" class="row teacher_info radius" style="width: 100%;">
        <div class="medium-3 columns">
            <img src="<?php echo Yii::app()->baseUrl.'/images/'?>huangxiaoyan.jpg"/>
        </div>
        <div class="medium-9 columns end">
            <h2><strong>黄晓燕  博士  讲师</strong></h2>
            <h3>个人简历</h3>
            <p>2004年毕业于电子科技大学获工学学士学位； 2007年毕业于电子科技大学获工学硕士学位，并留校任教至今；2012年毕业于电子科技大学获工学博士学位。一直从事通信与网络方面的教学与科研，先后承担多项国家863计划、国家科技重大专项等项目的主研工作。主讲《局域网与城域网》、《多媒体通信》等本科课程。。</p>
            <h3 class="inline">主要研究方向</h3>

                <p>宽带无线网络的资源管理与跨层优化、合作通信、认知无线电、无线传感器网络等。</p>

        </div>
    </div>
</div>