<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js" integrity="sha512-ElRFoEQdI5Ht6kZvyzXhYG9NqjtkmlkfYk0wr6wHxU9JEHakS7UJZNeml5ALk+8IKlU6jDgMabC3vkumRokgJA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        const BASE_URL = '{{url("/")}}'
    </script>
</head>
<body>
    <div class="row">
        <div class="col-md-6">
            <form id="getTotalMessages">
                <div class="form-group">
                  <label for="period_start">Period Start</label>
                  <input required class="form-control datepicker" type="text" name="period_start">
                  <small id="emailHelp" class="form-text text-muted">Period Start</small>
                </div>
                <div class="form-group">
                  <label for="period_end">Period End</label>
                  <input required class="form-control datepicker" type="text" name="period_end">
                </div>
                <div class="form-group">
                    <label for="period_end">Period Group Unit</label>
                    <select name="period_group_unit" id="period_group_unit" class="form-control">
                        <option value="year">Year</option>
                        <option value="month">Month</option>
                        <option value="day">Day</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <div class="col-md-6">
            <div style="width: 700px; height: 700px"><canvas id="myChart"></canvas></div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('myChart');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: '# Total Messages',
                        data: [],
                        backgroundColor: [],
                        borderWidth: 1
                    }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
    $( function() {
      $( ".datepicker" ).datepicker({
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true
      });
      $('#getTotalMessages').on('submit', function(e){
        e.preventDefault();
        let periodStart = $(this).find('input[name="period_start"]').val();
        let periodEnd = $(this).find('input[name="period_end"]').val();
        let periodGroupUnit = $(this).find('select[name="period_group_unit"]').val();
        $.ajax({
            url: BASE_URL + '/message/total',
            method: "GET",
            data: {
                period_start: periodStart,
                period_end: periodEnd,
                period_group_unit: periodGroupUnit
            },success: function(response){
                if(response){
                    let label = []
                    let data = []
                    let backgroundColor = []
                    response.forEach(function (item, index) {
                        label.push(item.period_end + item.period_start)
                        data.push(item.total)
                        backgroundColor.push(getRandomColor())
                    });
                    myChart.data.labels = label
                    myChart.data.datasets[0].data = data
                    myChart.data.datasets[0].backgroundColor = backgroundColor
                    myChart.update()
                }
                
                
            }
        })
      })

    });

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }

    </script>

</body>
</html>