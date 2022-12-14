$(document).ready(function () {
	refreshDashboard();
    predefinedDatePickerSet();
    dashboardMerchantKecamatan();
    $('.el-hidden').hide()
    $('#btnSubmit').click(function(event){
         
    let dateRange = $('#date_range').val() 
    let date = dateRange.split('-')
    let startDate = new Date(date[0])
    let endDate = new Date(date[1])

    let monthStart 	= startDate.getMonth()
	let monthhEnd 	= endDate.getMonth()

	let yearStart 	= startDate.getFullYear()
    let yearEnd 	= endDate.getFullYear()
   
    if ((monthStart != monthhEnd  && yearStart != yearEnd) || (monthStart != monthhEnd  && yearStart == yearEnd) || (monthStart == monthhEnd  && yearStart != yearEnd)) {
        toastr['warning']('Silahkan pilih tanggal mulai dan tanggal akhir pada periode(bulan dan tahun) yang sama')
        return false
    }
        refreshDashboard();
    });
})

function predefinedDatePickerSet () {
    var el = $('#predefined-daterange span')
    //const start = moment().subtract(30, 'days')
    const end = moment()

    let date = new Date()
    let firstDay = new Date(date.getFullYear(), date.getMonth(), 1);
    const start = moment(firstDay)

    console.log
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

function dashboardMerchantKecamatan () {
    $('.call-suban').click(function (e) {
        let el = $(this)
        let subanId = el.attr('data-suban-id')
        let ppn = el.attr('data-pajak')

        if (subanId == 'all') {
            $('.el-hidden').hide()
        } else {
            $('.el-hidden').show()
        }
        
        if (ppn == 0) {
        	$('.el-hidden').hide()
        	toastr['warning']('Data Pajak 0 ')
        }

        chartKecamatan(subanId)
        chartMerchant(subanId)
    })
}

function chartKecamatan(subanId) {
    $.post(
          "chartKecamatanMerchant",
          {
              'suban_id': subanId,
              'type'    : 'kecamatan'
          }, function (data) {
                var dataSummary=data['summaryData'];
                
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

                $('#chartKecamatan').remove();
                $(".chart-kecamatan").append('<canvas id="chartKecamatan"></canvas>');

                var barChartCanvasSummary = $('#chartKecamatan').get(0).getContext('2d');
                var barChartSummary = new Chart(barChartCanvasSummary);
                var barChartDataSummary = areaChartDataSummary;
                var barChartOptionsSummary = {
                    scaleBeginAtZero: true,
                    scaleShowGridLines: true,
                    scaleGridLineColor: 'rgba(0,0,0,.05)',
                    scaleGridLineWidth: 1,
                    scaleShowHorizontalLines: true,
                    scaleShowVerticalLines: true,
                    barShowStroke: true,
                    barStrokeWidth: 2,
                    barValueSpacing: 1,
                    barDatasetSpacing: 1,
                    legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                    responsive: true,
                    maintainAspectRatio: true
                };
                
                barChartOptionsSummary.datasetFill = false;
                barChartSummary.Bar(barChartDataSummary, barChartOptionsSummary);

            }, "json"
    );   
}

function chartMerchant(subanId) {
    $.post(
          "chartKecamatanMerchant",
          {
              'suban_id': subanId,
              'type'    : 'merchant'
          }, function (data) {
                var dataSummary=data['summaryData'];
                
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

                $('#chartMerchant').remove();
                $(".chart-merchant").append('<canvas id="chartMerchant"></canvas>');

                var barChartCanvasSummary = $('#chartMerchant').get(0).getContext('2d');
                var barChartSummary = new Chart(barChartCanvasSummary);
                var barChartDataSummary = areaChartDataSummary;
                var barChartOptionsSummary = {
                    scaleBeginAtZero: true,
                    scaleShowGridLines: true,
                    scaleGridLineColor: 'rgba(0,0,0,.05)',
                    scaleGridLineWidth: 1,
                    scaleShowHorizontalLines: true,
                    scaleShowVerticalLines: true,
                    barShowStroke: true,
                    barStrokeWidth: 2,
                    barValueSpacing: 1,
                    barDatasetSpacing: 1,
                    legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                    responsive: true,
                    maintainAspectRatio: true
                };
                
                barChartOptionsSummary.datasetFill = false;
                barChartSummary.Bar(barChartDataSummary, barChartOptionsSummary);

            }, "json"
    );   
}

function get_data_header(){
    let a = 0;
    let ppn = 0
    let allPpn = 0
   $.post(
          "get_data_header",
          {
          }, function (data) {
                for (let i = 0; i < 5; i++) {
                    a++
                    ppn = format_number(parseInt(data.subanData[i]['ppn'], 10))
                    allPpn = format_number(parseInt(data.totalTax))
                    $(`.id-suban-${a}`).attr('data-suban-id',data.subanData[i]['suban_id'])
                    $(`.id-suban-${a}`).attr('data-pajak',data.subanData[i]['ppn'])
                    $(`.name-suban-${a}`).html(data.subanData[i]['suban_name'])
                    $(`.ppn-suban-${a}`).html(ppn)
                    
                }
                
                $(`.suban-all`).html(allPpn)
                
            }, "json"
    ); 
}
function refreshDashboard(){
    $.post(
          "refreshData",
          {
              'merchantid': $('#merchant_id').val(),
              'dateRange' : $('#date_range').val()
          }, function (data) {
                $('.offline-branch').html(data.offlineBranch)
                $('.online-branch').html(data.onlineBranch)
                
                var dataSummary=data['summaryData'];
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
                    scaleBeginAtZero: true,
                    scaleShowGridLines: true,
                    scaleGridLineColor: 'rgba(0,0,0,.05)',
                    scaleGridLineWidth: 1,
                    scaleShowHorizontalLines: true,
                    scaleShowVerticalLines: true,
                    barShowStroke: true,
                    barStrokeWidth: 2,
                    barValueSpacing: 1,
                    barDatasetSpacing: 1,
                    legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                    responsive: true,
                    maintainAspectRatio: true
                };
                
                barChartOptionsSummary.datasetFill = false;
                barChartSummary.Bar(barChartDataSummary, barChartOptionsSummary);

                $( "tr" ).remove();
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

    get_data_header()
}
