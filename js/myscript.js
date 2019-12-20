$(document).ready(function(){
    var $ccount = $("#hidden_ccount").val();
    for(var i=0; i<parseInt($ccount, 10); i++) {
        var obj_name = "#hidden_cid" + i;
        let obj_id = $(obj_name).val();
        $("#cedit" + obj_id).click(function(){
            $("#cedit" + obj_id).addClass("d-none");
            $("#csave" + obj_id).removeClass("d-none");
            $("#ccancel" + obj_id).removeClass("d-none");
            $("#cpos" + obj_id).removeAttr("disabled");
            $("#cgroup" + obj_id).removeAttr("disabled");
            $("#cname" + obj_id).removeAttr("disabled");
            $("#cimage" + obj_id).addClass("d-none");
            // $("#cimage" + obj_id).text("change image");
            $("#cimage" + obj_id).attr("src", "");
            $("#cimage" + obj_id).attr("src", "");
            $("#hiddengroup" + obj_id).removeClass("d-none");
            $("#cfile" + obj_id).removeClass("d-none");
            console.log("clicked: " + obj_id);
        });

        $("#ccancel" + obj_id).click(function(){
            $("#cedit" + obj_id).removeClass("d-none");
            $("#csave" + obj_id).addClass("d-none");
            $("#ccancel" + obj_id).addClass("d-none");
            $("#cpos" + obj_id).attr("disabled", "true");
            $("#cgroup" + obj_id).attr("disabled", "true");
            $("#cname" + obj_id).attr("disabled", "true");
            $("#cimage" + obj_id).removeClass("d-none");
            // $("#cimage" + obj_id).text("image");
            $("#cimage" + obj_id).attr("src", $("#hidden_cimg" + obj_id).val());
            $("#hiddengroup" + obj_id).addClass("d-none");
            $("#cfile" + obj_id).addClass("d-none");
            console.log("clicked: " + obj_id);
        });

        $("#csave" + obj_id).click(function(){
            $pos = $("#cpos" + obj_id).val();
            $("#hidden_cpos").val($pos);
            $("#hidden_csubmit").val("save");
        });
        
        $("#cdelete" + obj_id).click(function(){
            $("#cpos" + obj_id).removeAttr("disabled");
            $("#hidden_cid").val(obj_id);
            $("#hidden_csubmit").val("delete");
        });
    }

    var $pcount = $("#hidden_pcount").val();
    for(var i=0; i<parseInt($pcount, 10); i++) {
        var obj_name = "#hidden_pid" + i;
        let obj_id = $(obj_name).val();
        $("#pedit" + obj_id).click(function(){
            $("#pedit" + obj_id).addClass("d-none");
            $("#psave" + obj_id).removeClass("d-none");
            $("#pcancel" + obj_id).removeClass("d-none");
            $("#pName" + obj_id).removeAttr("disabled");
            $("#pcName" + obj_id).removeAttr("disabled");
            $("#pimage" + obj_id).addClass("d-none");
            $("#pimage" + obj_id).attr("src", "");
            $("#pfile" + obj_id).removeClass("d-none");
            $("#pFav" + obj_id).addClass("active");
            $("#pFav" + obj_id).click(function(){
                $(this).toggleClass("selected");
                if($(this).hasClass("selected")) {
                    $("#hiddenfav" + obj_id).val(1);
                } else {
                    $("#hiddenfav" + obj_id).val(0);
                }
                console.log("hiddenfav" + obj_id + ": " + $("#hiddenfav" + obj_id).val())
            });
            console.log("clicked: " + obj_id);
        });

        $("#pcancel" + obj_id).click(function(){
            $("#pedit" + obj_id).removeClass("d-none");
            $("#psave" + obj_id).addClass("d-none");
            $("#pcancel" + obj_id).addClass("d-none");
            $("#pName" + obj_id).attr("disabled", "true");
            $("#pcName" + obj_id).attr("disabled", "disabled");
            $("#pimage" + obj_id).removeClass("d-none");
            $("#pimage" + obj_id).attr("src", $("#hidden_pimg" + obj_id).val());
            $("#pfile" + obj_id).addClass("d-none");
            $("#pFav" + obj_id).removeClass("active");
            console.log("clicked: " + obj_id);
        });

        if($("#hiddenfav" + obj_id).val() == 1) {
            $("#pFav" + obj_id).addClass("selected");
        }
    }

    $('a.zoomable').click(function () {
        var img = $(this);
        if(img.attr('src') != "") {
            var bigImg = $('<img />').css({
                'max-width': '100%',
                'max-height': '100%',
                'display': 'inline'
            });
            bigImg.attr({
                src: img.attr('src'),
                alt: img.attr('alt'),
                title: img.attr('title')
            });
            var over = $('<div />').text(' ').css({
                'height': '100%',
                'width': '100%',
                'background': 'rgba(0,0,0,.82)',
                'position': 'fixed',
                'top': 0,
                'left': 0,
                'opacity': 0.0,
                'cursor': 'pointer',
                'z-index': 9999,
                'text-align': 'center'
            }).append(bigImg).bind('click', function () {
                $(this).fadeOut(300, function () {
                    $(this).remove();
                });
            }).insertAfter(this).animate({
                'opacity': 1
            }, 300);
        }
    });
});

// var Data;
// function getData(id) {
//     return $.ajax({
//         url: 'checkCategoryInProduct.php',
//         method: 'POST',
//         data: {
//             id: id
//         },
//         success: function(response) {
//             Data = response;
//         }
//     });
// }
// https://stackoverflow.com/questions/44644114/whats-a-non-deprecated-way-of-doing-a-synchronous-ajax-call-using-jquery

function cvalidate() {
    var ename = document.getElementById( "hidden_csubmit" );
    if(ename.value == "save") {
        var pos = $("#hidden_cpos").val();
        var confirm_text = $.ajax({
            type: 'POST',
            async: false,
            data: {
                pos: pos
            },
            url: "checkUpdate.php"
        }).responseText;

        // return confirm(confirm_text);
        if(confirm_text == "Save?") {
            return confirm(confirm_text);
        } 
        else {
            alert(confirm_text);
            return false;
        }
    }
    if(ename.value == "delete") {
        // var confirm_text = "delete?";
        var id = $("#hidden_cid").val();

        var confirm_text = $.ajax({
            type: 'POST',
            async: false,
            data: {
                id: id
            },
            url: "checkDelete.php"
        }).responseText;
        
        // getData(id).done(function(response){
        //     confirm_text = response;
        //     //access response data here
        // });

        // alert(id);
        return confirm(confirm_text);
        // return false;
    }
    else {
        return confirm('error occured. : ' + ename.value);
    }
}