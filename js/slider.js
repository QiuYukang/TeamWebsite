$(function(){
    var current = 0;
    var length = $("#slider").find(".slider-item").length;

    var play = function(num){
        $("#slider").find(".slider-item").hide();
        var currentSlider = $($("#slider").find(".slider-item")[num]);
        currentSlider.fadeIn();

        $(".slider-anchor").removeClass("active");
        $($(".slider-anchor")[num]).addClass("active");
        current = num;
    };
    play(0);
    var next = function(){
        if(current == length-1){
            current = 0;
        }else{
            current = current+1;
        }
        play(current);
    };

    var  prev = function(){
        if(current == 0){
            current = length-1;
        }else{
            current = current -1;
        }
        play(current);
    };

    for(var i=0;i<length;i++){
        (function(i){
            $(".slider-anchor-container").find(".slider-anchor").eq(i).on("click",function(){
                play(i);
            })
        })(i)
    }

    $(".slider-left").on("click",function(){
        prev();
    })

    $(".slider-right").on("click",function(){
        next();
    })


    var timer = setInterval(function(){
        next();
    },5000);


    $("#slider .slider-item").on("click",function(){
        var url = $(this).attr("data-href");
        if(url === "#"){
            return;
        }
        window.open(url,'_blank');
    })
})
