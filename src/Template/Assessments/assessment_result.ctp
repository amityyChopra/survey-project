<table class="tables">
    <thead>
        <tr class="title">
            <th width="70%">Assessment Details</th>
            <th class="text-center">Fill in</th>
            <th class="text-center">Action</th>
            <th class="text-center">Previous Responses</th>
        </tr>
    </thead>
    <tbody>
        <?php if(!empty($allAssessments)){?>
            <?php foreach($allAssessments as $assessment){?>
                <tr <?php if(!$assessment["disabled"]){?>class="disabled"<?php }?> id="changeThis">
                    <td>
                        <?php if(!empty($assessment["assessment_image"])){?>
                            <div class="image"><img width="60" src="<?php echo HTTP_ROOT?>img/assessments_images/medium/<?php echo $assessment["assessment_image"]?>"/></div>
                        <?php }else{?>
                            <div class="image"><img width="60" src="<?php echo HTTP_ROOT?>images/document.png"/></div>
                        <?php }?>
                        <div class="content"><h3><?php echo $assessment["assessment_title"]?></h3>
                        <p><?php echo substr($assessment["description"],0,200)?></p>
                    </td>
                    <td class="text-center">
                        <?php if(!empty($clientId)){?>
                        <a class="btn btn-primary" href="<?php echo HTTP_ROOT;?>Assessments/startAssessment/<?php echo base64_encode(convert_uuencode($assessment["id"]))."/".base64_encode(convert_uuencode($clientId));?>" role="button">Start</a>
                        <?php }else{?>
                            <a class="btn btn-primary" href="<?php echo HTTP_ROOT;?>Assessments/startAssessment/<?php echo base64_encode(convert_uuencode($assessment["id"]));?>" role="button">Start</a>
                        <?php }?>
                    </td>
                    <td class="text-center"><a href="<?php echo HTTP_ROOT?>Assessments/editAssessment/<?php echo base64_encode(convert_uuencode($assessment["id"]));?>"><span class="lnr lnr-pencil"></span></a></td>
                    <td class="text-center">
                        <?php if(!empty($clientId)){?>
                            <a class="btn btn-outline-primary" href="<?php echo HTTP_ROOT;?>Assessments/assessmentDetails/<?php echo base64_encode(convert_uuencode($assessment["id"]));?>/<?php echo base64_encode(convert_uuencode($clientId));?>" role="button">
                            <?php echo $clientResponses = $this->Online->getResponses($assessment["id"],$clientId)?>
                            </a>
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