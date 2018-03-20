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
                            <h4><i class="icon-reorder"></i>发送模板消息 - 可用模板ID</h4>
                            <h5>充值成功提醒：</h5>
                            <h6>jFldswVmBZ_UimNFrMF8-kkBDx5lPo-P-UDTgfW4-v8   :keyword3</h6>
                            <h5>实名认证结果通知：</h5>
                            <h6>iUZdtbbAunkT7FyuDb9idm37ZTdJWFJKHG6IO407i88   :keyword2</h6>
                            <h5>实名认证提醒：</h5>
                            <h6>_c5n2x0Z9ajjR6-KTFNpY63-bjCtEsVXVYEW9kEbtQU   :keyword2</h6>
                        </div>
                        <div class="widget-body form">
                            <form class="form-horizontal" id="productForm" action="/wechat/template/sendmsg"
                                  method="post">
                                <div class="control-group">
                                    <label class="control-label">openid</label>
                                    <div class="controls">
                                        <input type="text" id="touser" name="touser" value="">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">模板ID</label>
                                    <div class="controls">
                                        <input type="text" id="template_id" name="template_id" value="">
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
                                <div class="control-group">
                                    <label class="control-label">first-1</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[first][value]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">first-2</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[first][color]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">keyword1-1</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[keyword1][value]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">keyword1-2</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[keyword1][color]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">keyword2-1</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[keyword2][value]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">keyword2-2</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[keyword2][color]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">keyword3-1</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[keyword3][value]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">keyword3-2</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[keyword3][color]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">remark-1</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[remark][value]" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">remark-2</label>
                                    <div class="controls">
                                        <input type="text" id="data" name="data[remark][color]" value="">
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