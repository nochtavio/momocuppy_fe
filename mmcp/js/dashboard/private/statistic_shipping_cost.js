$(document).ready(function(){
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);
  
  function drawChart() {
    var from = $('#txt_date_from').val();
    var to = $('#txt_date_to').val();
    ajaxLoader();
    $.ajax({
      url: baseurl + 'dashboard/statistic/statistic_shipping_cost',
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
          data.addColumn('string', 'Date');
          data.addColumn('number', 'Total Cost');
          
          for (var x = 0; x < result['total']; x++){
            data.addRow([result['order_date'][x], parseInt(result['total_cost'][x])]);
          }
          
          var options = {
            title: 'Statistic Shipping Cost',
            legend: { position: 'bottom' }
          };

          var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

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
  
  function post(path, parameters) {
    var form = $('<form></form>');

    form.attr("method", "post");
    form.attr("action", path);

    $.each(parameters, function(key, value) {
      var field = $('<input></input>');

      field.attr("type", "hidden");
      field.attr("name", key);
      field.attr("value", value);

      form.append(field);
    });

    // The form needs to be a part of the document in
    // order for us to be able to submit it.
    $(document.body).append(form);
    form.submit();
  }
  
  //Function Get Object
  exportExcel = function ()
  {
    //Filter
    var from = $('#txt_date_from').val();
    var to = $('#txt_date_to').val();
    //End Filter
    
    post(baseurl + 'dashboard/statistic/export_excel', {
        page: 'shipping_cost',
        from: from,
        to: to
      }
    );
  };
  //End Function Get Object
  
  //Initial State
  $('#btn_apply').click(function(){
    drawChart();
  });
  
  $('#btn_export').click(function(){
    exportExcel();
  });
  
  $('#txt_date_from').datetimepicker({
    format: "YYYY-MM-DD"
  });
  
  $('#txt_date_to').datetimepicker({
    format: "YYYY-MM-DD"
  });
  //End Initial State
});
