<!-- sparkline chart JavaScript -->
<script src="<?= base_url(); ?>assets/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script>
<script src="<?= base_url(); ?>assets/bower_components/jquery-sparkline/jquery.charts-sparkline.js"></script>
<script type="text/javascript">
    $("#spViews").sparkline(<?php echo "[";foreach($viewsWeb as $key => $count){echo $count;echo ",";}echo "]"; ?>, {
       type: 'line',
       width: '100%',
       height: '50',
       lineColor: '#2cabe3',
       fillColor: '#2cabe3',
       minSpotColor:'#2cabe3',
       maxSpotColor: '#2cabe3',
       highlightLineColor: 'rgba(0, 0, 0, 0.2)',
       highlightSpotColor: '#2cabe3'
   });
   $("#spMonthViews").sparkline(<?php echo "[";foreach($viewsMonthWeb as $key => $count){echo $count;echo ",";}echo "]"; ?>, {
      type: 'line',
      width: '100%',
      height: '50',
      lineColor: '#2cabe3',
      fillColor: '#2cabe3',
      minSpotColor:'#2cabe3',
      maxSpotColor: '#2cabe3',
      highlightLineColor: 'rgba(0, 0, 0, 0.2)',
      highlightSpotColor: '#2cabe3'
  });
</script>
