$(function(){
    if ($("#VideoPage")[0]) {
        //fancybox
        $('.fancybox').fancybox({
            width: 680,
            height: 480,
            iframe: {
                scrolling : 'no'
            },
            helpers : {
                overlay : {
                    locked : false // try changing to true and scrolling around the page
                }
            }
        });
    } else {
        //fancybox
        $('.fancybox').fancybox({
            helpers : {
                overlay : {
                    locked : false // try changing to true and scrolling around the page
                }
            }
        });
    }

    //tab
    $('.nav-tabs a').click(function (e) {
        $($(this).parents()[1]).find("li").removeClass("active");
       var targetContent = $( $(this).parents()[3] ).find(".tab-content")[0];
       $(targetContent).find(".tab-pane").hide();
       var target = $(this).attr("data");
       $("#"+target+"").fadeIn(300);
       $(this).parent().addClass("active");
    })

    $(".nav-container .nav-tabs a").mouseover(function(){
        console.log(1);
        $($(this).parents()[1]).find("li").removeClass("active");
        var targetContent = $( $(this).parents()[3] ).find(".tab-content")[0];
        $(targetContent).find(".tab-pane").hide();
        var target = $(this).attr("data");
        $("#"+target+"").stop();
        $("#"+target+"").fadeIn(300);
        $(this).parent().addClass("active");
    })

    //导师列表
    /*
    $(".tutor-row").on("click",".tutor-head",function(){
        var data = $(this).attr("data-description");
        if(data == ""){
            return;
        }

        $("#tutor-tab-container .totur-detail").hide();
        $("#tutor-tab-container .triangle").hide();

        var $detail = $($(this).parents()[2]).find(".totur-detail");
        $(this).find(".triangle").show();
        $($detail).html(data).slideDown("fast");
    })
    */
});
