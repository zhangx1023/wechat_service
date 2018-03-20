<!DOCTYPE html> <!--[if IE 8]>
<html lang="en" class="ie8"> <![endif]--> <!--[if IE 9]>
<html lang="en" class="ie9"> <![endif]--> <!--[if !IE]><!-->
<html lang="en"> <!--<![endif]--> <!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8"/>
    <title>showboom - 销售管理平台</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>
</head>
<body class="fixed-top">
<div id="container" class="row-fluid">
    <div id="main-content">
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span12">
                    <div id="theme-change" class="hidden-phone">
                        <i class="icon-cogs"></i>
                                <span class="settings">
                                    <span class="colors">
                                        <span class="color-default" data-style="default"></span>
                                        <span class="color-gray" data-style="gray"></span>
                                        <span class="color-purple" data-style="purple"></span>
                                        <span class="color-navy-blue" data-style="navy-blue"></span>
                                    </span>
                                </span>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>群发文本消息</h4>
                        </div>
                        <div class="widget-body form">
                            <form class="form-horizontal" id="productForm" action="/wechat/Mass/sendByOpenid"
                                  method="post">
                                <div class="control-group">
                                    <label class="control-label">openid-1</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser[]" value="">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">openid-2</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser[]" value="">
                                    </div>
                                </div>
                               <div class="control-group">
                                    <label class="control-label">openid-3</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser[]" value="">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">openid-4</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser[]" value="">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">openid-5</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser[]" value="">
                                    </div>
                                </div>
                                <!-- <div class="control-group">
                                    <label class="control-label">openid-6</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser[]" value="">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">openid-7</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser[]" value="">
                                    </div>
                                </div>-->
                                <div class="control-group">
                                    <label class="control-label">文本信息内容</label>
                                    <div class="controls">
                                        <input type="text" id="text" name="text[content]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">URL</label>
                                    <div class="controls">
                                        <input type="text" id="url" name="url" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">消息来源</label>
                                    <div class="controls">
                                        <input type="text" id="source" name="source" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <input type="submit" name="发送" id="发送">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    /*jQuery(document).ready(function () {
     App.init();
     initFormValidator();
     });
     // 建立产品
     $("#add-submit").click(function () {
     var order_no = parseInt($('#order_no').val());
     if (!jQuery.isNumeric(order_no)) {
     alert("排序号必须为数字！");
     $('#order_no').css('borderColor', 'red');
     return false;
     }
     $("#productForm").submit();
     });

     $('#file_input').change(function () {
     $('#img-form').submit();
     });

     function refreshImage(status, id, name, url) {
     if (status) {
     $('#' + id + '').attr('src', url);
     $('input[name="' + name + '"]').val(url);
     }
     }*/

</script>
</body>
<!-- END BODY -->
</html>