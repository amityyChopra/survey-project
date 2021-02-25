<div class="main-content">
		<div class="title-bar">
			<div class="row">
        <div class="col-md-6 filters"><i style="font-size:1.5rem" class="fa fa-filter" aria-hidden="true"></i> <input class="form-control" type="text" id="assessment_name" placeholder="Assessments"> 
                <select id="client_id" class="form-control">
                  <?php if(!empty($allClients)){?>
                    <option value="0">--Select Client--</option>
                    <?php foreach($allClients as $client){?>
                      <option <?php if(!empty($_GET["client_id"]) && $_GET["client_id"]==$client["id"]){?> selected="selected"<?php }?> value="<?php echo $client["id"]?>"><?php echo $client["client_name"]?></option>
                    <?php }?>
                  <?php }?>
                </select></div>
				<div class="col-md-6 text-right"><a href="<?php echo HTTP_ROOT;?>Assessments/addAssessment" class="btn btn-primary" role="button" aria-pressed="true"><span class="lnr lnr-plus-circle"></span> Add New Assessment</a></div>
			</div>
		</div>
		<div class="table-responsive">
        <table class="tables" id="changeThis">
          <thead>
            <tr class="title">
              <th width="70%">Assessment Details</th>
              <th class="text-center">Fill in</th>
              <th class="text-center">Action</th>
              <th class="text-center">Responses</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($allAssessments)){?>
              <?php foreach($allAssessments as $assessment){?>
                <tr <?php if(!$assessment["disabled"]){?>class="disabled"<?php }?>>
                    <td>
                      <?php if(!empty($assessment["assessment_image"])){?>
                        <div class="image"><img width="60" src="<?php echo HTTP_ROOT?>img/assessments_images/medium/<?php echo $assessment["assessment_image"]?>"/></div>
                      <?php }else{?>
                        <div class="image"><img width="60" src="<?php echo HTTP_ROOT?>images/document.png"/></div>
                      <?php }?>
                      <div class="content">
                        <h3><?php echo $assessment["assessment_title"]?></h3>
                        <p><?php echo substr($assessment["description"],0,200)?></p>
                      </div>
                    </td>
                    <td class="text-center">
                      <?php if(!empty($_GET["client_id"])){?>
                        <a class="btn btn-primary" href="<?php echo HTTP_ROOT;?>Assessments/startAssessment/<?php echo base64_encode(convert_uuencode($assessment["id"]))."/".base64_encode(convert_uuencode($_GET["client_id"]));?>" role="button">Start</a>
                      <?php }else{?>
                        <a href="javascript:void(0)" class="btn btn-light disabled" role="button" aria-disabled="true">Start</a>
                      <?php }?>
                    </td>
                    <td class="text-center"><a href="<?php echo HTTP_ROOT?>Assessments/editAssessment/<?php echo base64_encode(convert_uuencode($assessment["id"]));?>"><span class="lnr lnr-pencil"></span></a></td>
                    <td class="text-center">
                      <?php if(!empty($_GET["client_id"])){?>
                        <a class="btn btn-outline-primary" href="<?php echo HTTP_ROOT;?>Assessments/assessmentDetails/<?php echo base64_encode(convert_uuencode($assessment["id"]));?>/<?php echo base64_encode(convert_uuencode($_GET["client_id"]));?>" role="button">
                          <?php echo $clientResponses = $this->Online->getResponses($assessment["id"],$_GET["client_id"])?>
                        </a>
                      <?php }else{?>
                        <?php if(!empty($assessment["client_responses"])){?>
                          <a class="btn btn-outline-primary" href="<?php echo HTTP_ROOT;?>Assessments/assessmentResponses/<?php echo base64_encode(convert_uuencode($assessment["id"]));?>" role="button">
                            <?php echo $assessment["client_responses"][0]["total"]?>
                          </a>
                        <?php }?>
                      <?php }?>
                    </td>
                </tr>
              <?php }?>
            <?php }else{?>
              <tr>
                  <td colspan="4" class="text-center">No Assessment(s) Assigned</td>
              </tr>
            <?php }?>
          </tbody>
        </table>
      </div>
  </div>
  <style>
		tr.disabled td, tr.disabled th{
			background-color:#ccc;
		}
  </style>