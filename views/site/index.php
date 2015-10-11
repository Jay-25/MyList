<?php
/* @var $this yii\web\View */
$this->title = 'MyList';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>
    
    

</div>

<script type="text/javascript">
$(function() {

	$.getJSON(
			//"http://115.28.76.20/mylist/web/index.php?r=my/data",
			"<?php echo Yii::$app->urlManager->createUrl('my/runaction'); ?>",
			{"data":"CAction_Item","paras":{"oper":"+","id":"8","data":{"name":"4444","timestamp":"2015-10-11","detail":{"2":{"cid":1,"name":"机票/车票/船票","selected":1},"3":{"cid":1,"name":"预订酒店","selected":0},"57":{"cid":6,"name":"牙膏牙刷","selected":1},"60":{"cid":6,"name":"护肤/化妆用品","selected":0}}},"cuid":"wwwww"}},
            function(data){
				alert(Serialize(data));
            }
        );
	/*	
	SafeAjax({
		type: "GET",
		url: "<?php echo Yii::$app->urlManager->createUrl('my/data'); ?>",
		data: {data: 'CData_Column', paras: {cuid: 'wwwww'  }},
		success: function (result) {
			alert(22);
			$(".site-index").text(result);
		}
	});
	*/
	/*
	$.ajaxSetup({
        error: function (x, e) {
            alert("暂无具体内容！");
            return false;
        }
    });
    
	$.getJSON(
			"<?php echo Yii::$app->urlManager->createUrl('my/data'); ?>",
			{data: 'CData_Column', paras: {cuid: 'wwwww'  }},
            function(data){
				$(".site-index").text(Serialize(data.data));
            }
        );
    */
/*
	$.getJSON(
			"http://115.28.76.20/mylist/web/index.php?r=my/data",
			{data: 'CData_Column', paras: {cuid: 'wwwww'  }},
            function(data){
                alert(Serialize(data));
            }
        );
*/
});
</script>