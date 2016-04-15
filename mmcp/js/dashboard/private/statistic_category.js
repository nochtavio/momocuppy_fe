$(document).ready(function(){
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  
  function drawChart() {
    var from = $('#txt_date_from').val();
    var to = $('#txt_date_to').val();
    ajaxLoader();
    $.ajax({
      url: baseurl + 'dashboard/statistic/statistic_category',
      type: 'POST',
      data:
        {
          from: from,
          to: to
        },
      dataType: 'json',
      success: function (result) {
        if (result['result'] === 's'){
          $('#curve_chart').show();
          $('#span_error').hide();
          var data = new google.visualization.DataTable();
          data.addColumn('string', 'Category Name');
          data.addColumn('number', 'Total Sold');
          
          for (var x = 0; x < result['total']; x++){
            data.addRow([result['category_name'][x], parseInt(result['total_order'][x])]);
          }
          
          var options = {
            title: 'Statistic Category',
            legend: { position: 'bottom' }
          };

          var chart = new google.visualization.BarChart(document.getElementById('curve_chart'));

          chart.draw(data, options);
        }
        else{
          $('#curve_chart').hide();
          $('#span_error').show();
          $('#span_error').html(result['message']);
        }
      }
    });
  };
  
  //Initial State
  $('#btn_apply').click(function(){
    drawChart();
  });
  
  $('#txt_date_from').datetimepicker({
    format: "YYYY-MM-DD"
  });
  
  $('#txt_date_to').datetimepicker({
    format: "YYYY-MM-DD"
  });
  //End Initial State
});
