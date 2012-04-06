/*<![CDATA[*/
$.cookie = function(name, value, options)
{
    if (typeof value != 'undefined')
    {
        options = options || { };
        var expires = '';
        if (options.expires && ( typeof options.expires == 'number' || options.expires.toGMTString))
        {
            var date;
            if (typeof options.expires == 'number')
            {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            }
            else
            {
                date = options.expires;
            }
            expires = '; expires=' + date.toGMTString();
        }
        var path = options.path ? '; path=' + options.path : '';
        var domain = options.domain ? '; domain=' + options.domain : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    }
    else
    {
        var cookieValue = null;
        if (document.cookie && document.cookie != '')
        {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++)
            {
                var cookie = $.trim(cookies[i]);
                if (cookie.substring(0, name.length + 1) == (name + '='))
                {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
function JRshrinkHeaderMulti(mode, imgId, cid)
{
    if (mode == 1)
    {
        cMod = 0;
    }
    else
    {
        cMod = 1;
    }
    $.cookie("upshrink_" + imgId, cMod);
    $("#" + imgId).attr("src", window.jr_expandImg_url + (cMod ? "expand.gif" : "shrink.gif"));
    if (cMod)
    {
        $("#" + cid).hide();
    }
    else
    {
        $("#" + cid).show();
    }
}
function fbGetPreview(content, sitemid) {
    var templatePath = document.postform.templatePath.value;
    var content = escape(content);
    $.ajax({url:"index2.php",
    data : { msgpreview : content, Itemid : sitemid , option: "com_fireboard" , func: "getpreview" , no_html: 1},
    type: "POST",
    beforeSend : function (req){
        $('#previewContainer').show();
        $('#previewMsg'). html("<img src='"+templatePath+"/images/preview_loading.gif' />");
    },
    success : function (req){
        $('#previewMsg'). html(req)
        return;
    }
    });
    return false;
}
$(function()
{
    $(".hideshow").click(function()
    {
        var imgId = $(this).attr("id");
        var cId = imgId.split("__")[1];
        var cVal = $.cookie("upshrink_" + imgId);
        JRshrinkHeaderMulti(cVal, imgId, cId);
    }).each(function()
    {
        var imgId = $(this).attr("id");
        var cId = imgId.split("__")[1];

        if ($.cookie("upshrink_" + imgId) == 1)
        {
            JRshrinkHeaderMulti(0, imgId, cId);
        }
    });
});
/*]]>*/