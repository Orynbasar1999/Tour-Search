<?php

/* @var $this yii\web\View */
/* @var $availableCities array*/

$this->title = 'My Yii Application';

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


?>

<script type="text/javascript">
    function generateTable(json) {
        var numOfTours = json.length;
        if(numOfTours) {
            var table = document.createElement("table");
            table.setAttribute('class', 'table table-striped table-bordered');
            var col = [];
            for (var i = 0; i < numOfTours; i++) {
                for (var key in json[i]) {
                    if (col.indexOf(key) === -1) {
                        col.push(key);
                    }
                }
            }
            var tHead = document.createElement('thead');
            var hRow = document.createElement('tr');
             for (var i = 0; i<col.length; i++) {
                var th = document.createElement('th');
                th.setAttribute('style', 'text-align:center; text-transform:uppercase')
                th.innerHTML = col[i];
                hRow.appendChild(th);
            }
             tHead.appendChild(hRow);
             table.appendChild(tHead);

             var tBody = document.createElement('tbody');

             for (var i = 0; i < numOfTours; i++) {
                var bRow = document.createElement('tr');

                for (var j = 0; j < col.length; j++) {
                    var td = document.createElement('td');
                    td.innerHTML = json[i][col[j]];
                    bRow.appendChild(td);
                }
                tBody.appendChild(bRow);
            }
             table.appendChild(tBody);

             var divContainer = document.getElementById('result');
             divContainer.innerHTML = '';
             divContainer.appendChild(table);



        }
    }
</script>


<div class="site-index">

    <div class="jumbotron">
        <h1>Tour Search</h1>

        <p class="lead">Enter the required information</p>

        <div class="row">
            <?php $form = ActiveForm::begin(['id' => 'SearchTourForm',
                'action' => '/yii-application/backend/web/index.php?r=post/index'
                ]); ?>
            <div class="col-lg-3">
                <?= $form->field($model, "depCity")->dropDownList(ArrayHelper::map($availableCities, 'id', 'name'), [
                    'prompt' => 'Select',
                    'onchange' => '
                    $.post("index.php?r=site/list-countries&id='.'"+$(this).val(), function (data) {
                        $("select#searchtourform-arrcountry").html(data);
                        });',
                    ])->label("City")?>
            </div>
            <div class="col-lg-2">
                <?= $form->field($model, "arrCountry")->dropDownList($availableCountries, [
                        'prompt' => '-'
                ])->label("Country")?>
            </div>
            <div class="col-lg-4">
                <?= $form->field($model, "date")->input("date")->label("Date")?>
            </div>
            <div class="col-lg-2">
                <?= $form->field($model, "numOfNights")->dropDownList([
                    5 => '5',
                    6 => '6',
                    7 => '7',
                    8 => '8',
                    9 => '9',
                    10 => '10',
                    11 => '11',
                    12 => '12',
                    13 => '13',
                    14 => '14',
                    15 => '15',
                ],['prompt' => 'Select'])->label("Nights")?>
            </div>
            <div class="col-lg-1">
                <?= Html::submitButton("Search", ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
        <div id="numOfTours"></div>
        <div id="numOfCol"></div>
        <div id="result"></div>


    </div>


</div>


<?php
$js = <<<JS
 $('form').on('beforeSubmit', function(response){
 var data = $(this).serialize();
 $.ajax({
 url: '../../backend/web/index.php?r=post/index',
 type: 'POST',
 data: data, 
 success: function(res){
     generateTable(JSON.parse(res));
 },
 error: function(XMLHttpRequest, textStatus) {
                            alert(textStatus);
                            console.log(XMLHttpRequest);
 }
 });
 return false;
 });
JS;

$this->registerJs($js);
?>




