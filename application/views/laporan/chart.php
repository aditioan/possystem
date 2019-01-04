<?php $this->load->view('element/head');?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Chart Index
                <small>Chart</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <ul class="nav nav-tabs">
                <!-- <li role="presentation"><a href="<?php echo site_url('neraca');?>">List Neraca</a></li>
                <li role="presentation"><a href="<?php echo site_url('neraca/create');?>">Input Neraca</a></li>
                <li role="presentation"><a href="<?php echo site_url('neraca/record');?>">Record Neraca</a></li> -->
                <li role="presentation" class="active"><a href="<?php echo site_url('neraca/chart');?>">Chart</a></li>
              </ul>
              <div class="box">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-area-chart"></i>Monthly Recap KAS</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="col-md-8">
                    <p class="text-center">
                      <strong>Data KAS: 01-01-<?php echo date('Y');?> sampai <?php echo date('d-m-Y');?> (dalam Rupiah)</strong>
                    </p>
                    <div class="chart">
                      <!-- Sales Chart Canvas -->
                      <canvas id="areaChart" style="height: 190px;"></canvas>
                      <canvas id="pieChart" style="height: 190px;" hidden="true"></canvas>
                      <canvas id="lineChart" style="height: 190px;"></canvas>
                      <canvas id="barChart" style="height: 190px;"></canvas>
                    </div><!-- /.chart-responsive -->
                  </div><!-- /.col -->
                  <div class="col-md-4">
                    <p class="text-center">
                      <strong>Total Transaction</strong>
                    </p>
                    <div class="progress-group">
                      <span class="progress-text">Total Kas Masuk Periode Ini</span>
                      <span class="progress-number"><b><span class="form-price-format"><?php echo $income['chart_income'];?></span></b>/<span class="form-price-format"><?php echo $kas;?></span></span>
                      <div class="progress sm">
                        <div class="progress-bar progress-bar-blue" style="width: <?php echo $kas != 0? $income['chart_income']/$kas*100: '0';?>%"></div>
                      </div>
                    </div><!-- /.progress-group -->
                    <div class="progress-group">
                      <span class="progress-text">Total Kas Keluar Periode Ini</span>
                      <span class="progress-number"><b><span class="form-price-format"><?php echo $outcome['chart_outcome'];?></span></b>/<span class="form-price-format"><?php echo $kas;?></span></span>
                      <div class="progress sm">
                        <div class="progress-bar progress-bar-red" style="width: <?php echo $kas != 0? $outcome['chart_outcome']/$kas*100: '0';?>%"></div>
                      </div>
                    </div><!-- /.progress-group -->
                  </div><!-- /.col -->
                </div><!-- ./box-body -->
                <div class="box-footer">
                  <div class="col-sm-4 col-xs-6">
                    <div class="description-block border-right">
                      <?php
                        $monthly_sales = '';
                        $monthly_sales_before = '';
                        switch (date('m')) {
                            case '01':
                                $monthly_sales = $january_income;
                                $monthly_sales_before = 0;
                                break;
                            
                            case '02':
                                $monthly_sales = $february_income;
                                $monthly_sales_before = $january_income;
                                break;
                            
                            case '03':
                                $monthly_sales = $march_income;
                                $monthly_sales_before = $february_income;
                                break;
                            
                            case '04':
                                $monthly_sales = $april_income;
                                $monthly_sales_before = $march_income;
                                break;
                            
                            case '05':
                                $monthly_sales = $may_income;
                                $monthly_sales_before = $january_income;
                                break;
                            
                            case '06':
                                $monthly_sales = $june_income;
                                $monthly_sales_before = $may_income;
                                break;
                            
                            case '07':
                                $monthly_sales = $july_income;
                                $monthly_sales_before = $june_income;
                                break;
                            
                            case '08':
                                $monthly_sales = $august_income;
                                $monthly_sales_before = $july_income;
                                break;
                            
                            case '09':
                                $monthly_sales = $september_income;
                                $monthly_sales_before = $august_income;
                                break;
                            
                            case '10':
                                $monthly_sales = $october_income;
                                $monthly_sales_before = $september_income;
                                break;
                            
                            case '11':
                                $monthly_sales = $november_income;
                                $monthly_sales_before = $october_income;
                                break;
                            
                            case '12':
                                $monthly_sales = $december_income;
                                $monthly_sales_before = $november_income;
                                break;
                        }
                      ?>
                      <?php if ($monthly_sales > $monthly_sales_before) {
                          echo "<span class='description-percentage text-green'><i class='fa fa-caret-up'>";
                      } elseif ($monthly_sales == $monthly_sales_before) {
                          echo "<span class='description-percentage text-yellow'><i class='fa fa-caret-left'>";
                      } else {
                          echo "<span class='description-percentage text-red'><i class='fa fa-caret-down'>";
                      } ?>
                      </i> <?php echo ($monthly_sales_before == '0') ? '100' : ($monthly_sales-$monthly_sales_before)/$monthly_sales_before*100 ;?>%</span>
                      <h5 class="description-header"><span class="form-price-format"><?php echo $monthly_sales;?></span></h5>
                      <span class="description-text">TOTAL KAS MASUK BULAN INI</span>
                    </div><!-- /.description-block -->
                  </div><!-- /.col -->
                  <div class="col-sm-4 col-xs-6">
                    <div class="description-block border-right">
                      <?php
                        $monthly_purchase = '';
                        $monthly_purchase_before = '';
                        switch (date('m')) {
                            case '01':
                                $monthly_purchase = $january_outcome;
                                $monthly_purchase_before = 0;
                                break;
                            
                            case '02':
                                $monthly_purchase = $february_outcome;
                                $monthly_purchase_before = $january_outcome;
                                break;
                            
                            case '03':
                                $monthly_purchase = $march_outcome;
                                $monthly_purchase_before = $february_outcome;
                                break;
                            
                            case '04':
                                $monthly_purchase = $april_outcome;
                                $monthly_purchase_before = $march_outcome;
                                break;
                            
                            case '05':
                                $monthly_purchase = $may_outcome;
                                $monthly_purchase_before = $january_outcome;
                                break;
                            
                            case '06':
                                $monthly_purchase = $june_outcome;
                                $monthly_purchase_before = $may_outcome;
                                break;
                            
                            case '07':
                                $monthly_purchase = $july_outcome;
                                $monthly_purchase_before = $june_outcome;
                                break;
                            
                            case '08':
                                $monthly_purchase = $august_outcome;
                                $monthly_purchase_before = $july_outcome;
                                break;
                            
                            case '09':
                                $monthly_purchase = $september_outcome;
                                $monthly_purchase_before = $august_outcome;
                                break;
                            
                            case '10':
                                $monthly_purchase = $october_outcome;
                                $monthly_purchase_before = $september_outcome;
                                break;
                            
                            case '11':
                                $monthly_purchase = $november_outcome;
                                $monthly_purchase_before = $october_outcome;
                                break;
                            
                            case '12':
                                $monthly_purchase = $december_outcome;
                                $monthly_purchase_before = $november_outcome;
                                break;
                        }
                      ?>
                      <?php if ($monthly_purchase > $monthly_purchase_before) {
                          echo "<span class='description-percentage text-green'><i class='fa fa-caret-up'>";
                      } elseif ($monthly_purchase == $monthly_purchase_before) {
                          echo "<span class='description-percentage text-yellow'><i class='fa fa-caret-left'>";
                      } else {
                          echo "<span class='description-percentage text-red'><i class='fa fa-caret-down'>";
                      } ?>
                      </i> <?php echo ($monthly_purchase_before == '0') ? '100' : ($monthly_purchase-$monthly_purchase_before)/$monthly_purchase_before*100 ;?>%</span>
                      <h5 class="description-header"><span class="form-price-format"><?php echo $monthly_purchase;?></span></h5>
                      <span class="description-text">TOTAL KAS KELUAR BULAN INI</span>
                    </div><!-- /.description-block -->
                  </div><!-- /.col -->
                  <div class="col-sm-4 col-xs-6">
                    <div class="description-block">
                      <?php if (($monthly_sales-$monthly_purchase) > ($monthly_sales_before-$monthly_purchase_before)) {
                          echo "<span class='description-percentage text-green'><i class='fa fa-caret-up'>";
                      } elseif (($monthly_sales-$monthly_purchase) == ($monthly_sales_before-$monthly_purchase_before)) {
                          echo "<span class='description-percentage text-yellow'><i class='fa fa-caret-left'>";
                      } else {
                          echo "<span class='description-percentage text-red'><i class='fa fa-caret-down'>";
                      } ?>
                      </i> <?php echo (($monthly_sales_before-$monthly_purchase_before) == '0') ? '100' : ($monthly_sales-$monthly_purchase)/($monthly_sales_before-$monthly_purchase_before)*100 ;?>%</span>
                      <h5 class="description-header"><span class="form-price-format"><?php echo ($monthly_sales-$monthly_purchase); ?></span>,-</h5>
                      <span class="description-text">TOTAL KAS BULAN INI</span>
                    </div><!-- /.description-block -->
                  </div>
                </div><!-- /.box-footer -->
              </div><!-- /.box -->
            </div>
          </div>
          <!-- row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
<?php $this->load->view('element/footer');?>
<script type="text/javascript">
$(function() {
    <?php if ($this->session->flashdata('message_success') != ''): ?>
    toastr.success("<?php echo $this->session->flashdata('message_success') ?>");
    <?php endif ?>
    <?php if ($this->session->flashdata('message_error') != ''): ?>
    toastr.error("<?php echo $this->session->flashdata('message_error') ?>");
    <?php endif ?>
});
$(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //--------------
    //- AREA CHART -
    //--------------

    // Get context with jQuery - using jQuery's .get() method.
    var areaChartCanvas = $("#areaChart").get(0).getContext("2d");
    // This will get the first returned node in the jQuery collection.
    var areaChart = new Chart(areaChartCanvas);

    var areaChartData = {
      labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
      datasets: [
        {
          label: "Pengeluaran",
          fillColor: "rgba(245, 105, 84, 1)",
          strokeColor: "rgba(245, 105, 84, 1)",
          pointColor: "rgba(245, 105, 84, 1)",
          pointStrokeColor: "#c1c7d1",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(245, 105, 84, 1)",
          data: ['<?php echo $january_outcome;?>', '<?php echo $february_outcome;?>', '<?php echo $march_outcome;?>', '<?php echo $april_outcome;?>', '<?php echo $may_outcome;?>', '<?php echo $june_outcome;?>', '<?php echo $july_outcome;?>', '<?php echo $august_outcome;?>', '<?php echo $september_outcome;?>', '<?php echo $october_outcome;?>', '<?php echo $november_outcome;?>', '<?php echo $december_outcome;?>']
        },
        {
          label: "Pemasukan",
          fillColor: "rgba(60,141,188,0.9)",
          strokeColor: "rgba(60,141,188,0.8)",
          pointColor: "#3b8bba",
          pointStrokeColor: "rgba(60,141,188,1)",
          pointHighlightFill: "#fff",
          pointHighlightStroke: "rgba(60,141,188,1)",
          data: ['<?php echo $january_income;?>', '<?php echo $february_income;?>', '<?php echo $march_income;?>', '<?php echo $april_income;?>', '<?php echo $may_income;?>', '<?php echo $june_income;?>', '<?php echo $july_income;?>', '<?php echo $august_income;?>', '<?php echo $september_income;?>', '<?php echo $october_income;?>', '<?php echo $november_income;?>', '<?php echo $december_income;?>']
        }
      ]
    };
    //console.log(datasets);
    var areaChartOptions = {
      //Boolean - If we should show the scale at all
      showScale: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: false,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - Whether the line is curved between points
      bezierCurve: true,
      //Number - Tension of the bezier curve between points
      bezierCurveTension: 0.3,
      //Boolean - Whether to show a dot for each point
      pointDot: false,
      //Number - Radius of each point dot in pixels
      pointDotRadius: 4,
      //Number - Pixel width of point dot stroke
      pointDotStrokeWidth: 1,
      //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
      pointHitDetectionRadius: 20,
      //Boolean - Whether to show a stroke for datasets
      datasetStroke: true,
      //Number - Pixel width of dataset stroke
      datasetStrokeWidth: 2,
      //Boolean - Whether to fill the dataset with a color
      datasetFill: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true
    };

    //Create the line chart
    areaChart.Line(areaChartData, areaChartOptions);

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChart").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = areaChartOptions;
    lineChartOptions.datasetFill = false;
    lineChart.Line(areaChartData, lineChartOptions);

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
      {
        value: 700,
        color: "#f56954",
        highlight: "#f56954",
        label: "Chrome"
      },
      {
        value: 500,
        color: "#00a65a",
        highlight: "#00a65a",
        label: "IE"
      },
      {
        value: 400,
        color: "#f39c12",
        highlight: "#f39c12",
        label: "FireFox"
      },
      {
        value: 600,
        color: "#00c0ef",
        highlight: "#00c0ef",
        label: "Safari"
      },
      {
        value: 300,
        color: "#3c8dbc",
        highlight: "#3c8dbc",
        label: "Opera"
      },
      {
        value: 100,
        color: "#d2d6de",
        highlight: "#d2d6de",
        label: "Navigator"
      }
    ];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);

    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $("#barChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = areaChartData;
    barChartData.datasets[1].fillColor = "#00a65a";
    barChartData.datasets[1].strokeColor = "#00a65a";
    barChartData.datasets[1].pointColor = "#00a65a";
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "rgba(0,0,0,.05)",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: true,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);
  });
</script>