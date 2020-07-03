
$(function(){
        // 登录后样式展开
        $(".user-right").hover(function(){
            $(".user-down").show();
        },function(){
            $(".user-down").hide();
        })
         //手机端汉堡包按钮
         $(".hamburger-btn").click(function(){
            sidebarIn();
        });

            $(".hamburger-bg").click(function(){
              sidebarOut();
         });
         // 登录
            $(".i-login").click(function(){
                sidebarOut();
               $(".mask-bg").fadeIn();
               $(".register").fadeOut();
               $(".login").fadeIn();
            })
        // 注册
            $(".register-btn").click(function(){
                sidebarOut();
                $(".mask-bg").fadeIn();
                $(".register").fadeIn();
            })
         // 关闭
        $(".index-close").click(function(){
                $(".login").fadeOut();
                $(".register").fadeOut();
                $(".mask-bg").fadeOut();
        });
         // email和tel切换
        $(".add-tel").click(function(){
            $(".cut-email").hide();
            $(".cut-tel").show();
            $(this).addClass("on")
            $(".add-email").removeClass("on");
        })
        $(".add-email").click(function(){
            $(".cut-tel").hide();
            $(".cut-email").show();
            $(this).addClass("on")
            $(".add-tel").removeClass("on");
        })
  // 导航服务下拉
        $(".serve-trigger").hover(function(){
            $(".nav-down").show();
            $(".serve-trigger i").removeClass("fa-angle-down");
            $(".serve-trigger i").addClass("fa-angle-up");
        },function(){
            $(".serve-trigger i").removeClass("fa-angle-up");
            $(".serve-trigger i").addClass("fa-angle-down");
            $(".nav-down").hide();
        })

          // 回到顶部
            var speed = 1000;//自定义滚动速度
            $( "#toTop").click( function () {
                $( "html,body").stop().animate({ "scrollTop" : 0 }, speed);
        });
        $('#asid_share').hhShare({
        cenBox     : 'asid_share_box',  //里边的小层
        icon       : 'adid_icon',
        addClass   : 'red_bag',
        titleClass : 'asid_title',
        triangle   : 'asid_share_triangle', //鼠标划过显示图层，边上的小三角
        showBox    : 'asid_sha_layer' //鼠标划过显示图层
    });
    })
function sidebarOut(){
            $(".hamburger").fadeOut();
               $(".mobile-sidebar").css({
                  "right":"-300px"
               })
}
function sidebarIn(){
     $(".hamburger").fadeIn();
            $(".mobile-sidebar").css({
                "right":0
            })
}