<html>
<head>
    <title> نمودار</title>
    <script src="chart.min.js"></script>
    <style>
        #wrapper-chart{
            width: 1300px;
            height: 400px;
            display: inline-block;
        }
    </style>
</head>
<?php
$conn = mysqli_connect(HOST, USERNAME, PASSWORD, DATABASENAME);

$quarySelect = "SELECT * FROM temp";
$result=mysqli_query($conn, $quarySelect);

$quarySelect = "SELECT temp FROM currenttemp";
$currentResult=mysqli_query($conn, $quarySelect);
$currentRow = $currentResult->fetch_assoc();


$data = [];
$limit = $result->field_count;

$i=0;
while($row = $result->fetch_assoc()) {
    $current_list = [];

    $current_list['label'] = $row['date'];
    $current_list['value'] = $row['temp'];

    $color = rand(0, 255) . "," . rand(0, 255) . "," . rand(0, 255);
    $color = "rgba(" . $color . ", X)";

    $bg_color = str_replace("X", "0.2", $color);
    $border_color = str_replace("X", "1", $color);

    $current_list['color'] = [$bg_color, $border_color];

    $data[$i] = $current_list;
    $i++;
}

$json_data = json_encode($data);


?>
<div style="width: 100%;background-color: #ff5757;border-radius: 50px">
    <p style="text-align: center;font-size: 40px;">دمای فعلی: <?php echo $currentRow['temp']; ?></p>
</div>
<div id="wrapper-chart" style="">
    <canvas id="chrt"></canvas>
</div>
<script>
    <?php echo "const json_args = '{$json_data}';" ?>
    const chartArgs = JSON.parse(json_args);
</script>
<script>
    if (typeof chartArgs != "undefined" && chartArgs[0]) {
        var ctx = document.getElementById('chrt');

        cleanChartArgs = {
            labels: [],
            value: [],
            bgColor: [],
            borderColor: []
        };


        for (let i = 0; i < chartArgs.length; i++) {
            const currentIndex = chartArgs[i];

            cleanChartArgs.labels.push(currentIndex.label);
            cleanChartArgs.value.push(currentIndex.value);
            cleanChartArgs.bgColor.push(currentIndex.color[0]);
            cleanChartArgs.borderColor.push(currentIndex.color[1]);

        }

        if (ctx) {

            var myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: cleanChartArgs.labels,
                    datasets: [{
                        label: ['full data'],
                        data: cleanChartArgs.value,
                        backgroundColor: cleanChartArgs.bgColor,
                        borderColor: cleanChartArgs.borderColor,
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }
    }
</script>
</html>
