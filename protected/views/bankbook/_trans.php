<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//print_r($cdata);
?>
<table>


<?
foreach ($cdata->Transactions as $transaction) {
    echo "<tr><td>".$transaction->id ."</td><td>". Yii::t('app',$transaction->Type->name) ."</td><td>". $transaction->date ."</td><td>". $transaction->sum ."</td></tr>";
}
?>
</table>