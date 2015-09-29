<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle=Yii::app()->name . ' - 招生要求';
$this->breadcrumbs=array(
    '招生要求',
);
?>

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

<script type="text/javascript">
    $(document).ready(function(){
        $("#myNav").affix({
            offset: {
                top: 125
            }
        });
    });

</script>



    <div class="row" id="section-1">

        <div class="col-sm-8 blog-main">

            <div class="blog-post">
                <img src="images/Enhead.png" alt="" />
                <h2 style="color:#a89574;" >招生要求</h2>
                <hr style=" border:1px #a89574 solid; " />
                <ul>
                    <li><h4 style="color: #a89574;font-size: 17px;">个人素养</h4>
                        <p>希望学生性格阳光开朗、诚实、自信，优良的团队协作精神，优良的沟通和表达能力。</p>
                    </li>
                    <li><h4 style="color:#a89574;font-size: 17px;" id="section-2">基础知识</h4>
                        <p>希望学生拥有<strong>扎实的通信网络专业基础</strong>；具备优良的数学基础和外语基础， 最好是通过英语六级，能够进行日常基本的英语口头交流、快速阅读英文技术文献、 撰写英文论文。</p>
                    </li>
                    <li>
                        <h4 style="color:#a89574;font-size: 17px;">基本技能</h4>
                        <p>希望学生对网络和编程真正感兴趣，至少能在一种操作系统环境下熟练编程, 至少掌握一种软件语言进行熟练编程。具有课外编写程序的经 历和锻炼，具有项目研发编程经验者更佳。</p>
                    </li>
                </ul>
            </div><!-- /.blog-post -->

            <div class="blog-post">
                <h2 style="color: #a89574" id="section-3">招生规模</h2>
                <hr style=" border:1px #a89574 solid; " />
                <p>团队招生的人数取决于学校和学院招收研究生的政策，每年会有小的波动。我们团队招生的人数大致情况如下：</p>
                <ul>
                    <li><strong>硕士生：</strong>每年招生27-29人（含保研和考研）</li>
                    <li><strong>博士生：</strong>每年招生3-4人（含直博、硕博连读、考博）</li>
                </ul>
            </div><!-- /.blog-post -->

            <div class="blog-post">
                <h2 style="color:#a89574" >培养模式</h2>
                <hr style=" border:1px #a89574 solid; " />
                <p>团队招生的人数取决于学校和学院招收研究生的政策，每年会有小的波动。我们团队招生的人数大致情况如下：</p>
                <ul>
                    <li><h4 style="color:#a89574;font-size: 17px;">指导形式</h4>
                        <p>团队研究生统一管理，团队老师集体指导的形式。团队研究生的日程管理由团队统一实施，学生参与项目由团队统一调度，在项目人员调度上会充分考虑学生的意愿和能力，根据具体情况进行整体协调。</p>
                    </li>
                    <li><h4 style="color:#a89574;font-size: 17px;" >项目统一调度</h4>
                        <p>团队对于每一个项目/课题都有指定老师作为实际负责人，负责人针对项目/课题要求划分研究任务，每个任务对应成立一个任务组，首先，学生根据特长兴趣报名参加小组（可报多个），然后，由团队根据项目和报名情况统一调度和调整。
                            每个任务组都会指定老师小组长和学生小组长。小组或项目/课题会定期组织开会，学生汇报项目进展情况，对研究中出现的问题进行分析和讨论。在项目的研究过程中，学生不仅经历了一个科研项目全部过程各个环节的训练，同时通过定期的文字报告和口头报告，其技术报告撰写能力和语言表达能力都得到了提升，还进一步地培养了学生的团队协作能力。为学生毕业走向社会打下了很好的基础。</p>
                        <div style="text-align:center" >
                        <img style="width:80%;" src="images/zhaosheng.png" alt="" />
                        </div>
                    </li>
                    <li><h4 style="color:#a89574;font-size: 17px;" id="section-4">多方面培养</h4>
                        <p>读研期间，要求学生参与项目经过项目的锻炼是必须的。同时，团队鼓励学生积极参与提升技术能力的各种活动。并给予一定的奖励。团队主要从以下几个方面进行额外的培养:
                            为了选拔保送研究生，团队每年6-7月进行为期40-60天的软件训练，一方面让保研的学生体验是否真的对网络和编程感兴趣，同时团队也从中选拔一些优秀的学生。
                            对于已经入校的学生，团队不定期的举办团队内部的分组软件竞赛，由团队老师出题，分组成员自由组合，规定时间（一般1-2周）内，小组提交设计报告，分组展示软件成果、答辩，老师和学生当评委，每次评出2个最好的组，给予精神奖励，还有物质奖励哦！
                            团队鼓励学生走出团队，走出学校去参加更高级别的各种竞赛，并支助参赛的差旅费用等，对获奖的小组进行精神奖励的同时进行物质奖励。</p>
                    </li>
                </ul>
            </div><!-- /.blog-post -->

            <div class="blog-post">
                <h2 style="color:#a89574" >就业情况</h2>
                <hr style=" border:1px #a89574 solid; " />
                <p>团队研究生毕业后就业面广，范围宽。毕业生就业情况历年都不错。主要集中在互联网、通信网络等相关领域，相关领域的知名企业和公司，大、中城市。 以下是近几年团队学生的就业情况统计：</p>

            </div><!-- /.blog-post -->

            <table class="table table-hover">
                <caption>近5年（2011年—2015年）毕业研究生的就业情况</caption>
                <thead>
                <tr>
                    <th>就业单位</th>
                    <th>就业地点</th>
                    <th>2011人数</th>
                    <th>2012人数</th>
                    <th>2013人数</th>
                    <th>2014人数</th>
                    <th>2015人数</th>

                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>华为技术有限公司</td>
                    <td>成都、深圳</td>
                    <th>3</th>
                    <th>4</th>
                    <th>2</th>
                    <th></th>
                    <th>4</th>
                </tr>
                <tr>
                    <td>中兴通讯股份有限公司</td>
                    <td>深圳，成都，上海，南京</td>
                    <th>2</th>
                    <th>5</th>
                    <th></th>
                    <th>1</th>
                    <th>1</th>
                </tr>
                <tr>
                    <td>北京百度网讯科技有限公司</td>
                    <td>北京</td>
                    <th></th>
                    <th>1</th>
                    <th>1</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>阿里巴巴网络有限公司</td>
                    <td>杭州、北京</td>
                    <th>1</th>
                    <th>1</th>
                    <th></th>
                    <th>4</th>
                    <th>4</th>
                </tr>
                <tr>
                    <td>腾讯科技（深圳）有限公司</td>
                    <td>深圳、成都</td>
                    <th>1</th>
                    <th>1</th>
                    <th>1</th>
                    <th></th>
                    <th>2</th>
                </tr>
                <tr>
                    <td>去哪儿网</td>
                    <td>北京</td>
                    <th></th>
                    <th></th>
                    <th>1</th>
                    <th>2</th>
                    <th>2</th>
                </tr>
                <tr>
                    <td>奇虎360科技有限公司</td>
                    <td></td>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>1</th>
                    <th>2</th>
                </tr>
                <tr>
                    <td>TP-LINK</td>
                    <td>深圳</td>
                    <th>1</th>
                    <th>1</th>
                    <th>1</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>思科系统(中国)网络技术有限公司</td>
                    <td>成都</td>
                    <th></th>
                    <th></th>
                    <th>1</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>三星（中国）投资有限公司</td>
                    <td>广州</td>
                    <th></th>
                    <th></th>
                    <th>1</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>美国通用电气公司</td>
                    <td>北京</td>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>1</th>
                    <th>1</th>
                </tr>
                <tr>
                    <td>其他网络（IT）公司</td>
                    <td>成都、杭州、北京、上海、深圳等</td>
                    <th>4</th>
                    <th>3</th>
                    <th>4</th>
                    <th>7</th>
                    <th>5</th>
                </tr>
                <tr>
                    <td>科研院所</td>
                    <td>成都、洛阳、绵阳、广州等</td>
                    <th>5</th>
                    <th></th>
                    <th>1</th>
                    <th>2</th>
                    <th>1</th>
                </tr>
                <tr>
                    <td>金融企业（银行、网银等金融服务企业）</td>
                    <td>成都、上海、厦门</td>
                    <th></th>
                    <th>1</th>
                    <th></th>
                    <th>4</th>
                    <th>3</th>
                </tr>
                <tr>
                    <td>运营商（中国移动、中国电信等</td>
                    <td>昆明、宜昌</td>
                    <th></th>
                    <th></th>
                    <th>2</th>
                    <th>1</th>
                    <th>1</th>
                </tr>
                <tr>
                    <td>政府部门（公务员）</td>
                    <td>成都、重庆、北京</td>
                    <th>3</th>
                    <th></th>
                    <th>1</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>部队</td>
                    <td></td>
                    <th>3</th>
                    <th>1</th>
                    <th>2</th>
                    <th>2</th>
                    <th></th>
                </tr>
                <tr>
                    <td>出国深造读博</td>
                    <td></td>
                    <th>1</th>
                    <th></th>
                    <th></th>
                    <th>2</th>
                    <th></th>
                </tr>
                <tr>
                    <td>本校读博</td>
                    <td></td>
                    <th>1</th>
                    <th>1</th>
                    <th>2</th>
                    <th></th>
                    <th></th>
                </tr>
                </tbody>
            </table>




        </div><!-- /.blog-main -->

        <div class="col-sm-3 col-sm-offset-1 blog-sidebar">

            <div class="sidebar-module">
                <ul class="nav nav-tabs nav-stacked" id="myNav">
                    <li class="active" id="tion-1"><a href="#section-1" >招生要求</a></li>
                    <li id="tion-2"><a href="#section-2">招生规模</a></li>
                    <li id="tion-3"><a href="#section-3">培养模式</a></li>
                    <li id="tion-4"><a href="#section-4">就业情况</a></li>
                </ul>
            </div>
<!--            <div class="sidebar-module">-->
<!--                <h4>Elsewhere</h4>-->
<!--                <ol class="list-unstyled">-->
<!--                    <li><a href="#">GitHub</a></li>-->
<!--                    <li><a href="#">Twitter</a></li>-->
<!--                    <li><a href="#">Facebook</a></li>-->
<!--                </ol>-->
<!--            </div>-->
        </div><!-- /.blog-sidebar -->

    </div><!-- /.row -->

</div><!-- /.container -->