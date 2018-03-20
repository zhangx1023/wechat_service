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
                                    <span class="text">Theme:</span>
                                    <span class="colors">
                                        <span class="color-default" data-style="default"></span>
                                        <span class="color-gray" data-style="gray"></span>
                                        <span class="color-purple" data-style="purple"></span>
                                        <span class="color-navy-blue" data-style="navy-blue"></span>
                                    </span>
                                </span>
                    </div>
                    <!--
                    <h3 class="page-title" style='line-height: 50px;font-size: 25px;'>
                        <i class="icon-th-list"></i> 动力100
                    </h3>
                    <ul style="float: left;" class="breadcrumb">
                        <li style="margin-bottom: 0px;"><a href="/dl/product/index.html"><i class="icon-home"></i></a><span
                                    class="divider">&nbsp;</span></li>
                        <li style="margin-bottom: 0px;"><a>产品管理</a><span class="divider">&nbsp;</span></li>
                        <li style="margin-bottom: 0px;"><a>添加产品</a><span class="divider-last">&nbsp;</span></li>
                    </ul>
                    -->
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-reorder"></i>添加产品</h4>
                        </div>
                        <div class="widget-body form">
                            <form class="form-horizontal" id="productForm" action="/dl/product/add.html" method="post">
                                <div class="control-group">
                                    <label class="control-label">排序号</label>
                                    <div class="controls">
                                        <input type="text" id="order_no" name="order_no" value="">
                                        <span class="help-inline">用于套餐产品的排序</span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">套餐编码</label>
                                    <div class="controls">
                                        <input type="text" id="code" name="code" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">商品名称</label>
                                    <div class="controls">
                                        <input type="text" id="title" name="title" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">套餐子标题</label>
                                    <div class="controls">
                                        <input type="text" id="sub_title" name="sub_title" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">充值套餐</label>
                                    <div class="controls">
                                        <input type="text" id="package" name="package" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">套餐类型</label>
                                    <div class="controls">
                                        <select name="pack_type" id="pack_type">
                                            <option value="1">月</option>
                                            <option value="2">季度</option>
                                            <option value="3">半年</option>
                                            <option value="4">年度</option>
                                            <option value="0">无</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">有效期</label>
                                    <div class="controls">
                                        <input type="text" id="effect_period" name="effect_period" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">原价价格</label>
                                    <div class="controls">
                                        <input type="text" id="original_price" name="original_price" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">标价价格</label>
                                    <div class="controls">
                                        <input type="text" id="price" name="price" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">实际价格</label>
                                    <div class="controls">
                                        <input type="text" id="real_price" name="real_price" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">可使用积分数</label>
                                    <div class="controls">
                                        <input type="text" id="use_score" name="use_score" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">送给用户积分数</label>
                                    <div class="controls">
                                        <input type="text" id="give_score" name="give_score" value="">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">状态</label>
                                    <div class="controls">
                                        <select name="status" id="status">
                                            <option value="1">正常</option>
                                            <option value="2">暂停</option>
                                        </select>
                                    </div>
                                </div>
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