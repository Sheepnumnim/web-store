$(document).ready(function(){
    var $ccount = $("#hidden_ccount").val();
    for(var i=0; i<parseInt($ccount, 10); i++) {
        var obj_name = "#csId_hidden" + i;
        let obj_id = $(obj_name).val();
        $("#cEdit" + obj_id).click(function(){
            $("#cEdit" + obj_id).addClass("d-none");
            $("#cSave" + obj_id).removeClass("d-none");
            $("#cCancel" + obj_id).removeClass("d-none");
            $("#cPos" + obj_id).removeAttr("disabled");
            $("#csGroup" + obj_id).removeAttr("disabled");
            $("#cName" + obj_id).removeAttr("disabled");
            $("#csImage" + obj_id).addClass("d-none");
            $("#csImage" + obj_id).attr("src", "");
            $("#csImage" + obj_id).attr("src", "");
            $("#csGroup_div" + obj_id).removeClass("d-none");
            $("#csFile" + obj_id).removeClass("d-none");
            console.log("clicked: " + obj_id);
        });

        $("#cCancel" + obj_id).click(function(){
            $("#cEdit" + obj_id).removeClass("d-none");
            $("#cSave" + obj_id).addClass("d-none");
            $("#cCancel" + obj_id).addClass("d-none");
            $("#cPos" + obj_id).attr("disabled", "true");
            $("#csGroup" + obj_id).attr("disabled", "true");
            $("#cName" + obj_id).attr("disabled", "true");
            $("#csImage" + obj_id).removeClass("d-none");
            $("#csImage" + obj_id).attr("src", $("#csImage_hidden" + obj_id).val());
            $("#csGroup_div" + obj_id).addClass("d-none");
            $("#csFile" + obj_id).addClass("d-none");
            console.log("clicked: " + obj_id);
        });

        $("#cSave" + obj_id).click(function(){
            $pos = $("#cPos" + obj_id).val();
            $("#hidden_cpos").val($pos);
            $("#hidden_csubmit").val("save");
        });
        
        $("#cDelete" + obj_id).click(function(){
            $("#cPos" + obj_id).removeAttr("disabled");
            $("#hidden_cid").val(obj_id);
            $("#hidden_csubmit").val("delete");
        });

        let radioName = "categoryGroup_show" + obj_id;
        $('input[name='+radioName+']').change(function(){
            var value = $( 'input[name='+radioName+']:checked' ).val();
            if(value == 'new group')
            {
                $("#csGroupInput" + obj_id).focus();
            }
        });
        
        $("#csGroupInput" + obj_id).focus(function(){
            $('input[name='+radioName+'][value=new group]').attr('checked', 'checked');
        });
    }

    var $pcount = $("#hidden_pcount").val();
    for(var i=0; i<parseInt($pcount, 10); i++) {
        var obj_name = "#psId_hidden" + i;
        let obj_id = $(obj_name).val();
        $("#pEdit" + obj_id).click(function(){
            $("#pEdit" + obj_id).addClass("d-none");
            $("#pSave" + obj_id).removeClass("d-none");
            $("#pCancel" + obj_id).removeClass("d-none");
            $("#psName" + obj_id).removeAttr("disabled");
            $("#psCategory" + obj_id).removeAttr("disabled");
            $("#psImage" + obj_id).addClass("d-none");
            $("#psImage" + obj_id).attr("src", "");
            $("#psFile" + obj_id).removeClass("d-none");
            $("#psFav" + obj_id).addClass("active");
            checkPFavActive(obj_id);
            console.log("clicked: " + obj_id);
        });

        $("#pCancel" + obj_id).click(function(){
            $("#pEdit" + obj_id).removeClass("d-none");
            $("#pSave" + obj_id).addClass("d-none");
            $("#pCancel" + obj_id).addClass("d-none");
            $("#psName" + obj_id).attr("disabled", "true");
            $("#psCategory" + obj_id).attr("disabled", "disabled");
            $("#psImage" + obj_id).removeClass("d-none");
            $("#psImage" + obj_id).attr("src", $("#psImage_hidden" + obj_id).val());
            $("#psFile" + obj_id).addClass("d-none");
            $("#psFav" + obj_id).removeClass("active");
            console.log("clicked: " + obj_id);
        });

        if($("#psFav_hidden" + obj_id).val() == 1) {
            $("#psFav" + obj_id).addClass("selected");
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

function checkPFavActive(temp_id) {
    $("#psFav" + temp_id).click(function(){
        if($("#psFav" + temp_id).hasClass("active")) {
            $("#psFav" + temp_id).toggleClass("selected");
            if($("#psFav" + temp_id).hasClass("selected")) {
                $("#psFav_hidden" + temp_id).val(1);
            } else {
                $("#psFav_hidden" + temp_id).val(0);
            }
            console.log("psFav_hidden" + temp_id + ": " + $("#psFav_hidden" + temp_id).val());
        }
        else {
            console.log("this fav button is not active now.");
        }
    });
    
}

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