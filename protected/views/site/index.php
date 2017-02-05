<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="slider-bg">
    <div class="container">
        <div class="shadow-left"></div>
        <div class="shadow-right"></div>
    </div>
</div>
<div class="container ">
    <div class="main-content">
        <div id="slider">

            <div class="slider-wrapper">
                <a href="javascript:;" data-href="#"
                   class="slider-item" >
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_1.png" alt="" style="max-width:960px;max-height:400px;">
                </a>
                <a href="javascript:;" data-href="#"
                   class="slider-item" style="display: none;">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_2.png" alt="" style="max-width:960px;max-height:400px;">
                </a>
                <a href="javascript:;" data-href="#"
                   class="slider-item" style="display: none;">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_3.png" alt="" style="max-width:960px;max-height:400px;">
                </a>
                <a href="javascript:;" data-href="#"
                   class="slider-item" style="display: none;">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_4.png" alt="" style="max-width:960px;max-height:400px;">
                </a>
                <a href="javascript:;" data-href="#"
                   class="slider-item" style="display: none;">
                    <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_5.png" alt="" style="max-width:960px;max-height:400px;">
                </a>
            </div>
            <div class="slider-anchor-container">
                <a href="javascript:;" class="slider-left"></a>
                <a href="javascript:;" class="slider-right"></a>

                <a href="javascript:;" class="slider-anchor active"></a>
                <a href="javascript:;" class="slider-anchor "></a>
                <a href="javascript:;" class="slider-anchor "></a>
                <a href="javascript:;" class="slider-anchor "></a>
                <a href="javascript:;" class="slider-anchor "></a>
            </div>
        </div>
    </div>

    <div class="container content-final">
        <div class="left-news-content" role="tabpanel">
            <div class="left-news-content-bg"></div>
            <div class="nav-container">
                <ul class="nav nav-tabs clearfix" role="tablist">
                    <li class="active">
                        <a href="#" data='content_1' >宽带无线移动网络
                            <div class="line"></div>
                        </a>
                    </li>
                    <li >
                        <a href="#" data="content_2">无线自组织网络
                            <div class="line"></div>
                        </a>
                    </li>
                    <li >
                        <a href="#" data="content_3">无线传感网/物联网
                            <div class="line"></div>
                        </a>
                    </li>
                    <li >
                        <a href="#" data="content_4">无线网络新技术
                            <div class="line"></div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="tab-content clearfix">
                <div id="content_1" class="tab-pane">

                    <div class="news-one-info-left">
                        <a href="index.php?r=site/direction#direction1" class="summary">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_content_1.png"
                                 style="max-width: 400px;max-height: 270px;" alt="">
                        </a>
                    </div>
                    <div class="news-list-info-right">
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <a href="index.php?r=site/direction#direction1">了解更多</a>
                    </div>
                </div>
                <div id="content_2" class="tab-pane" style="display:none">
                    <div class="news-one-info-left">
                        <a href="index.php?r=site/direction#direction2" class="summary">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_content_2.png"
                                 style="max-width: 400px;max-height: 270px;" alt="">
                        </a>
                    </div>
                    <div class="news-list-info-right">
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <a href="index.php?r=site/direction#direction2">了解更多</a>
                    </div>
                </div>

                <div id="content_3" class="tab-pane" style="display:none">
                    <div class="news-one-info-left">
                        <a href="index.php?r=site/direction#direction3" class="summary">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_content_3.png"
                                 style="max-width: 400px;max-height: 270px;" alt="">
                        </a>
                    </div>
                    <div class="news-list-info-right">
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <a href="index.php?r=site/direction#direction3">了解更多</a>
                    </div>
                </div>

                <div id="content_4" class="tab-pane" style="display:none">
                    <div class="news-one-info-left">
                        <a href="index.php?r=site/direction#direction4" class="summary">
                            <img src="<?php echo Yii::app()->request->baseUrl; ?>/images/home_content_4.png"
                                 style="max-width: 400px;max-height: 270px;" alt="">
                        </a>
                    </div>
                    <div class="news-list-info-right">
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <p>这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字这是一段测试文字。</p>
                        <a href="index.php?r=site/direction#direction4">了解更多</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="right-news-content">
            <div class="left-news-content-bg right-news-content-bg"></div>
            <div class="title-red" style="border-bottom: 1px solid #d7d7d7;margin-bottom: 18px;padding-bottom: 10px">
                <a href="#"  class="green"  style="border-bottom: 1px solid #2a959e;padding-bottom: 10px;">学术论文</a>

            </div>
            <table>
                <tr>
                    <td width="48px">
                        <div class="year">2017</div>
                        <div class="month">Feb</div>
                    </td>
                    <td>
                        <a href="#" class="summary">An Energy Saving Data Delivery Scheme in ...</a>
                    </td>
                </tr>
                <tr>
                    <td width="48px">
                        <div class="year">2016</div>
                        <div class="month">Dec</div>
                    </td>
                    <td>
                        <a href="#" class="summary">Optimal Resource Allocation for Energy-Efficient ...</a>
                    </td>
                </tr>
                <tr>
                    <td width="48px">
                        <div class="year">2016</div>
                        <div class="month">Nov</div>
                    </td>
                    <td>
                        <a href="#" class="summary"> Joint Optimization of Throwbox Deployment ...</a>
                    </td>
                </tr>
                <tr>
                    <td width="48px">
                        <div class="year">2016</div>
                        <div class="month">Sep</div>
                    </td>
                    <td>
                        <a href="#" class="summary">Connectivity-aware Media Access Control protocol ...</a>
                    </td>
                </tr>
                <tr>
                    <td width="48px">
                        <div class="year">2016</div>
                        <div class="month">Jun</div>
                    </td>
                    <td>
                        <a href="#" class="summary">Group Bidding for Guaranteed Quality of ...</a>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align: right">
                        <a href="index.php?r=paper/index" style="  color: #2a959e;font-size: 13px;position: relative;top: -20px;">更多</a>
                    </td>
                </tr>
            </table>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

