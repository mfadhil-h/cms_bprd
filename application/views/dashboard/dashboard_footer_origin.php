</div>
<script src="<?php echo assets_site;?>adminlte/plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="<?php echo assets_site;?>plugins/jQueryUI/jquery-ui.min.js"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo assets_site;?>bootstrap/js/bootstrap.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo assets_site;?>adminlte/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<link rel="stylesheet" href="<?php echo assets_site;?>adminlte/plugins/daterangepicker/daterangepicker.css"></link>
<link rel="stylesheet" href="<?php echo assets_site;?>adminlte/plugins/datepicker/datepicker3.css"></link>

<script src="<?php echo assets_site;?>adminlte/plugins/daterangepicker/moment.min.js"></script>
<script src="<?php echo assets_site;?>adminlte/plugins/datepicker/bootstrap-datepicker.js"></script> 
<script src="<?php echo assets_site;?>adminlte/plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?php echo assets_site;?>adminlte/plugins/fastclick/fastclick.js"></script>
<script src="<?php echo assets_site;?>adminlte/dist/js/app.min.js"></script>
<script src="<?php echo assets_site;?>adminlte/plugins/chartjs/Chart.js"></script>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
<style type="text/css">
    
    #predefined-daterange {
      background-color: transparent;
      border-color: rgba(0, 0, 0, 0.1);
      cursor: pointer;
      padding: 7px 10px;
      border: 1px solid #ccc;
      width: 100%;
      color: #919ca8;
    }
</style>
<script>
    function predefinedDatePickerSet () {
        var el = $('#predefined-daterange span')

        const start = moment().subtract(30, 'days')
        const end = moment()

        let cb = (start, end) => {
            let value = start.format('DD MMMM YYYY') + ' - ' + end.format('DD MMMM YYYY')

            el.html(value)
            $('input[name="date_range"]').val(value)
        }

        el.daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb)

        cb(start, end)

            $('.daterangepicker').addClass('show-calendar')
    };

    function refreshDashboard(){
        $.post(
              "<?php echo base_url('welcome/refreshData') ?>",
              {
                  'merchantid': $('#merchant_id').val(),
                  'dateRange' : $('#date_range').val()
              }, function (data) {
                    //$('#message').html(data.message);
                        var dataSummary=data['summaryData'];
                        console.log(dataSummary)
                        //alert(dataSummary['paymentStatus']);
                        var areaChartDataSummary = {
                        labels: dataSummary['paymentStatus'],
                        datasets: [
                            {
                                label: 'All Data',
                                fillColor: dataSummary['fillcolor'],
                                strokeColor: dataSummary['fillcolor'],
                                pointStrokeColor: dataSummary['fillcolor'],
                                pointHighlightFill: '#fff',
                                pointHighlightStroke: dataSummary['fillcolor'],
                                data: dataSummary['paymentStatusCounter']
                            }
                        ]
                    };

                    $('#paymentChart').remove();
                    $(".chart").append('<canvas id="paymentChart"></canvas>');

                    var barChartCanvasSummary = $('#paymentChart').get(0).getContext('2d');
                    var barChartSummary = new Chart(barChartCanvasSummary);
                    var barChartDataSummary = areaChartDataSummary;
                    var barChartOptionsSummary = {
                        //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                        scaleBeginAtZero: true,
                        //Boolean - Whether grid lines are shown across the chart
                        scaleShowGridLines: true,
                        //String - Colour of the grid lines
                        scaleGridLineColor: 'rgba(0,0,0,.05)',
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
                        barValueSpacing: 1,
                        //Number - Spacing between data sets within X values
                        barDatasetSpacing: 1,
                        //String - A legend template
                        legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                        //Boolean - whether to make the chart responsive
                        responsive: true,
                        maintainAspectRatio: true
                    };
                    
                    barChartOptionsSummary.datasetFill = false;
                    barChartSummary.Bar(barChartDataSummary, barChartOptionsSummary);

                    $( "tr" ).remove();
                    for(var i=0;i<dataSummary['paymentStatus'].length;i++){
                        $( "table" ).append( "<tr><td style='padding-right:10px;' id='paymentStatus"+i+"'></td><td style='padding-right:10px;'> | </td><td style='padding-right:10px;' id='paymentStatusCounter"+i+"'>Total Transaksi : </td><td style='padding-right:10px;'> | </td><td style='padding-right:10px;' id='paymentStatusDescription"+i+"'>Total Pajak : Rp. </td></tr>" );

                    }

                    for(var i=0;i<dataSummary['paymentStatus'].length;i++){
                        var paymentStatus = '#paymentStatus'+i;
                        var paymentStatusCounter = '#paymentStatusCounter'+i;
                        var paymentStatusDescription = '#paymentStatusDescription'+i;
                        
                        $(paymentStatus).html(dataSummary['paymentStatus'][i]);
                        $(paymentStatusCounter).html('Total Transaksi : ' + dataSummary['paymentStatusCounter'][i]);
                        $(paymentStatusDescription).html('Total Pajak : Rp. ' + new Intl.NumberFormat('de-DE').format(dataSummary['paymentStatusDescription'][i]));
                    }


                    
                    var chart = new CanvasJS.Chart("chartContainer", {
                        animationEnabled: true,
                        // title: {
                        //     text: "PHO 24"
                        // },
                        data: [{
                            type: "pie",
                            startAngle: 240,
                            yValueFormatString: "\"Rp. \"#,##0.##",
                            indexLabel: "{label} ({y})",
                            dataPoints: data['dataPoints']
                        }]
                    });
                    chart.render();
                }, "json"
          );
    }
    $(document).ready(function() {
        refreshDashboard();
        predefinedDatePickerSet();
        setInterval(function(){
             refreshDashboard();
        },25000);
        $('#btnSubmit').click(function(event){
            refreshDashboard();
        });
    });
</script>

</body>
</html>