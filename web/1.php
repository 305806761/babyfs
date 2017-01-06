<?php
$time = strtotime('2018-01-05');
$term_id=24;
$section_id=14;
$etime = base64_encode($time);
$dtime = base64_decode($etime);
echo $time.'<br />';
echo $etime .'<br />';
echo $dtime.'<br />';
echo "http://cs.babyfs.cn/section/free?section_id=".$section_id."&term_id=".$term_id."&time=".$etime;
?>