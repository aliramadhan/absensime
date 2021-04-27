<div>
  <canvas id="myChart"></canvas>
</div>

<script type="text/javascript">
  var arrayMonth = {!! json_encode($dataChart['month']) !!};
  var dataAttend = {!! json_encode($dataChart['attend']) !!};
  var dataNotsignin = {!! json_encode($dataChart['not sign in']) !!};
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
          // The type of chart we want to create
          type: 'line',

          // The data for our dataset
          data: {
            labels: arrayMonth,
            datasets: [{
              label: 'Attend',

              borderColor: '#3498db',
              data: dataAttend
            },{
              label: 'Not signin',

              borderColor: '#fc0303',
              data: dataNotsignin
            },]
          },

      // Configuration options go here
      options: {}
    });
  </script>