<script src="<?php echo HTTP_ROOT;?>js/Chart.js"></script>
<div class="main-content">
    <div class="title-bar">
        <div class="row">
            <div class="col-md-6 filters">
                
            </div>
            <div class="col-md-6 text-right"><a href="<?php echo HTTP_ROOT;?>assessments">Assessments</a> / <a href="<?php echo HTTP_ROOT;?>assessments/assessmentResponses/<?php echo base64_encode(convert_uuencode($assessmentEntity["id"]));?>"><?php echo $assessmentEntity["assessment_title"]?></a> / Analysis</div>
        </div>
    </div>
    <div class="table-responsive">
        <div class="labelWrapper" style="float:left; width:30%;">
            <h4><strong><?php echo $assessmentEntity["assessment_title"]?></strong></h4>
            <h5>
                <?php echo $clientDetails["client_name"];?>
            </h5>
            <h6>
                Respondent Name: <?php echo $responseDetails["respondent_name"];?>
            </h6>
            <h6>
                Response Date: <?php echo date("d M, Y",strtotime($responseDetails["date_added"]));?>
            </h6>
		</div>
        <div class="wrapper" style="float:left; width:50%;">
            <canvas id="myChart" width="400" height="400"></canvas>			
		</div>	
    </div>
</div>
<script>
    var ctx = document.getElementById('myChart');
    var myOptions = {
        scale: {
            angleLines: {
                display:true
            },
            gridLines:{
                display:true,
                circular:true
            },
            ticks: {
                min: 0,
                max: 5,
                stepSize: 0.5,
               
            },
            pointLabels: {
                fontSize: 12
            }
        },
        legend: {
            reverse: true,
            position: 'bottom',
            labels: {
                usePointStyle:true,
            },
            
        }
    }

    /* THESE SHOULD COME FROM THE RESPONSE - index of the value in the array below = index of the 'labels' array */
    var dataSetCurrent = <?php echo $asisString;?>;
    var dataSetTarget = <?php echo $tobeString;?>;

        //var dataSetCurrent = [3.95, 3.8, 3.95, 3.95, 1.2, 4.9, 1.2, 3.9, null,3.9,3.5, 3.1, 3.2, 3, 3.1, 3.5, 3, 3.8, 3.9]; 
        //var dataSetTarget = [4, 4.4, 4, 4, 4, 5, 4, 4.5, null,4,4.2, 4.1, 4.1, 3, 3.8, 3.5, 4, 4, 4] 
        window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };
    
    var presets = window.chartColors;

    var myChart = new Chart(ctx, { // static

        type: 'radar',
        data: {
        labels: [ // static - if an area is not assessed, the value should be -1
            'Alignment & Governance', 
            'Methodology', 
            'Program Charter', 
            'Policies, Procedures & Standards', 
            'Scope Mgt.', 
            'Requirements Mgt.',
            'Release Mgt.',
            'Work Plan & Time Mgt.', 
            'Performance & Reporting', 
            'Communication Mgt.', 
            'Issue Mgt.', 
            'Risk Mgt.', 
            'Quality Mgt.',
            'Vendor & Procurement Mgt.',
            'Resource Mgt.',
            'Records & Configuration Mgt.',
            'Business & Value Case',
            'Financial Mgt.',
            'Stakeholder Mgt.'
        ],
        datasets: [
            {
            label: 'Current Maturity Level', 
            data: dataSetCurrent,
            backgroundColor: 'rgba(162, 0, 33, 0.2)',
            pointBorderColor: 'rgb(162, 0, 33)',
            pointBorderWidth: 1,
            borderWidth: 0,
            borderColor:'rgba(0, 0, 0, 0)',
            fill:true,
            order: 1,
            borderJoinStyle:"miter",
            borderColor: presets.red,
            pointRadius:5,
            pointBackgroundColor:"rgb(162, 0, 33)"
            },
            {
            label: 'Target Maturity Level',
            data: dataSetTarget,
            backgroundColor: 'rgba(0, 169, 171, 0.2)',
            pointBorderColor: 'rgb(0, 169, 171)',
            pointBorderWidth: 1,
            borderWidth: 0,
            borderColor:'rgba(0, 0, 0, 0)',
            fill:true,
            order: 0,
            borderJoinStyle:"miter",
            borderColor: presets.green,
            pointRadius:5,
            pointBackgroundColor:"rgb(0, 169, 171)"
            }
        ]
    },
        options: myOptions,
    });

</script>