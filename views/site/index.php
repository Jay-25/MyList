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
			{data: 'CAction_Item', 
                paras: {oper: '^', cuid:'wwwww', data: 
                {"-2":{"timestamp":"2015-10-15","name":"111","detail":{"3":{"cid":"1","name":"预订酒店","selected":0},"5":{"cid":"1","name":"办理签证","selected":0},"39":{"cid":"5","name":"毛衣","selected":0}}}}
                }},
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