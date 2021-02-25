<div class="main-content">
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6 filters">
        </div>
        <div class="col-md-6 text-right"><a href="<?php echo HTTP_ROOT;?>assessments">Assessments</a> / <?php echo $assessmentEntity["assessment_title"]?> / Responses</div>
      </div>
    </div>
      <div class="table-responsive">
      <table id="example" class="tables table-striped table-bordered">
            <thead>
              <tr class="title">
                <th>Responses #</th>
                <th class="text-center">Client</th>
                <th class="text-center">Respondent</th>
                <th class="text-center">Date complete</th>
                <th data-orderable="false" class="nosort">Edit</th>
                <th data-orderable="false" class="nosort">Analysis</th>
                
              </tr>
            </thead>
            <tbody>
              <?php if(!empty($allResponses)){?>
                <?php $i=1; foreach($allResponses as $response){?>
                  <tr>
                    <td><?php echo $i;?></td>
                    <td class="text-center"><?php echo $response["client"]["client_name"]?></td>
                    <td class="text-center"><?php echo $response["respondent_name"]?></td>
                    <?php
                      $newdate = date('d M Y', strtotime($response["date_added"])); // Format in which I want to display
                      $dateOrder = date('Y-m-d', strtotime($response["date_added"])); // Sort Order
                    ?>
                      <td data-order="<?php echo $dateOrder; ?>" class="text-center">
                        <?php echo $newdate;?>
                      </td>
                    <td class="text-center">
                      <a class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT;?>Assessments/editResponse/<?php echo base64_encode(convert_uuencode($response["id"]))?>">
                        <span class="lnr lnr-pencil"></span>
                      </a>
                      
                      <a onclick="return confirm('Are you sure?')" class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT."Assessments/deleteResponse/".base64_encode(convert_uuencode($response["id"]))?>"><span class="lnr lnr-trash"></span></a>
                    </td>
                    <td class="text-center">
                      <a class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT;?>Assessments/getAnalysis/<?php echo base64_encode(convert_uuencode($response["id"]));?>">
                        <span class="lnr lnr-chart-bars"></span>
                      </a>

                      <a class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT;?>Assessments/downloadJson/<?php echo base64_encode(convert_uuencode($response["id"]));?>">
                        <span class="lnr lnr-download"></span>
                      </a>
                    </td>
                    
                  </tr>
                <?php $i++;}?>
              <?php }?>
            </tbody>
          </table>		
        </div>
    	</div>