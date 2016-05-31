/**
 * Google Chart in Dashboad
 * Author: Hoan

 */
  // Load Charts and the corechart package.
  google.load("visualization", "1", {'packages':['corechart','bar']});
  

  // Draw the pie chart for Page Status when Charts is loaded.
  google.setOnLoadCallback(drawPageStatusChart);

  // Draw the pie chart for Page Updates when Charts is loaded.
  google.setOnLoadCallback(drawPageUpdatesChart);

  // Draw the pie chart for the Language when Charts is loaded.
  google.setOnLoadCallback(drawLanguageChart);

  // Draw the pie chart for the Visitors when Charts is loaded.
  google.setOnLoadCallback(drawVisitorsChart);

  // Draw the pie chart for the Visitors Collumn when Charts is loaded.
  google.setOnLoadCallback(drawCollumnVisitorsandLeads);

  // Callback that draws the pie chart Page Status
  function drawPageStatusChart() {

      // Create the data table for Page Status
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Live', window.pageOverview.pageStatus['live']],
        ['Approved', window.pageOverview.pageStatus['approved']],
        // ['Overdue', window.pageOverview.pageStatus['overdue']],
        ['Ready for Review', window.pageOverview.pageStatus['reviewed']],
        ['In Process', window.pageOverview.pageStatus['inProcess']],
        ['Not Started', window.pageOverview.pageStatus['notStarted']],
      ]);

      // Set options for Page Status pie chart.
      var options = {title:'Page Status',
                    pieHole: 0.4,
                    width:400,
                    height:300,
                     pieSliceTextStyle: {
                      color: '#000', 
                    },
                    sliceVisibilityThreshold: 0,
                    slices: {
                    0: { color: '#2CEA2C' },
                    1: { color: '#346EDE' },
                    // 2: { color: '#FF0030' },
                    2: { color: '#85ce1d' },
                    3: { color: '#7435C5' },
                    4: { color: '#FF0' }
                    }
                  };

      // Instantiate and draw the chart for Page Status pie chart.
      var chart = new google.visualization.PieChart(document.getElementById('PageStatusChart'));
      chart.draw(data, options);
      google.visualization.events.addListener(chart, 'select', selectHandler); 

      function selectHandler(e)     {   
        var status = data.getValue(chart.getSelection()[0].row, 0);
        if(status == 'Ready for Review') {
          status = 'reviewed';
        }
        var teamplate =  window.baseUrl +'/pages/click-status';
        $.ajax({
          url: teamplate,
          type: 'GET',
          cache: false,
          data: {
             status: status
          },
          success: function(data){
            if(data.status){
              window.location.href = window.baseUrl + '/cms/pages';
            }
            
          }
        });
      }
    }

  // Callback that draws the pie chart for Page Update.
  function drawPageUpdatesChart() {

      // Create the data table for Page Updates
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows(window.pageOverview.pageUpdate);

      // Set options for Page Update pie chart.
      var options = {title:'Page Updates',
                    pieHole: 0.4,
                    width:400,
                    height:300,
                    sliceVisibilityThreshold: 0,
                    pieSliceTextStyle: {
                      color: '#000', 
                    },
                  };


      // Instantiate and draw the chart for Page Updates pie chart.
      var chart = new google.visualization.PieChart(document.getElementById('PageUpdateChart'));
      chart.draw(data, options);
      google.visualization.events.addListener(chart, 'select', selectHandler); 

      function selectHandler(e)     {   
          var teamplate =  window.baseUrl +'/pages/click-last-update';
            $.ajax({
              url: teamplate,
              type: 'GET',
              cache: false,
              data: {
                 lastUpDate: true
              },
              success: function(data){
                if(data.status){
                  window.location.href = window.baseUrl + '/cms/pages';
                }
                
              }
            });
      }
    }

  // Callback that draws the pie chart for Page Language pie chart.
  function drawLanguageChart() {

      // Create the data table for Page Language
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows(window.pageOverview.pageLanguage);

      // Set options for Page Language pie chart.
      var options = {title:'Languages',
                    pieHole: 0.4,
                    width:400,
                    height:300,
                    sliceVisibilityThreshold: 0,
                    pieSliceTextStyle: {
                      color: '#000', 
                    },
                  };


      // Instantiate and draw the chart for Page Language pie chart.
      var chart = new google.visualization.PieChart(document.getElementById('PageLanguageChart'));
      chart.draw(data, options);
    }

  // Callback that draws the pie chart for Page Visitor pie chart.
  function drawVisitorsChart() {

      // Create the data table for Page Visitor
      var data = new google.visualization.DataTable();
      data.addColumn('string', 'Topping');
      data.addColumn('number', 'Slices');
      data.addRows([
        ['Passed', 1],
        ['Not run', 1],
        ['Failed', 2],
      ]);

      // Set options for Page Visitors Last pie chart.
      var options = {title:'Visitors Last 24 Hours',
                    pieHole: 0.4,
                    width:400,
                    height:300,
                    pieSliceTextStyle: {
                      color: '#000', 
                    },
                  };


      // Instantiate and draw the chart for Page Visitor pie chart.
      var chart = new google.visualization.PieChart(document.getElementById('PageVisitorsChart'));
      chart.draw(data, options);
    }
  
  // Callback that draws the Column for Visitor chart.
  function drawCollumnVisitorsandLeads() {
    var data = new google.visualization.arrayToDataTable([
      ['Visitors & Leads Last 7 Days', 'Distance', 'Brightness'],
      ['January', 8000, 23.3],
      ['February', 24000, 4.5],
      ['March', 30000, 14.3],
      ['April', 50000, 0.9],
      ['May', 60000, 13.1]
    ]);

    var options = {
      width: 900,
      series: {
        0: { axis: 'distance' }, // Bind series 0 to an axis named 'distance'.
        1: { axis: 'brightness' } // Bind series 1 to an axis named 'brightness'.
      },
      axes: {
        y: {
        }
      }
    };

  var chart = new google.charts.Bar(document.getElementById('CollumnVisitorsandLeads'));
  chart.draw(data, options);
};
