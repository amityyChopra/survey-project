<div class="main-content">
	<?php echo $this->Form->create(null,array("id"=>"addClient",'type' => 'file'))?>	
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6"><h4>Edit Assessment</h4></div>
				<div class="col-md-6 text-right">
					<div class="custom-control custom-switch">
						<input <?php if($assessmentEntity["disabled"]){?> checked="checked"<?php }?> type="checkbox" name="disabled" class="custom-control-input" id="customSwitch1">
					  	<label class="custom-control-label" for="customSwitch1"></label>
						<?php if($assessmentEntity["disabled"]){$text="Enabled"; }else{$text="Disabled";}?>
					  	<span class="text-primary" id="valueOfSwitch4"><?php echo $text;?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-conatiner">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Assessment Name *</label>
						<input type="text" class="form-control required"  value="<?php echo $assessmentEntity["assessment_title"]?>" name="assessment_title" id="first-name" placeholder="Assessment Title">
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-2">
							<?php if(!empty($assessmentEntity["assessment_image"])){?>
								<img id="replaceImage" src="<?php echo HTTP_ROOT?>img/assessments_images/medium/<?php echo $assessmentEntity["assessment_image"]?>"/>
								<a id="hideRemoveIcon" href="javascript:void(0);" onclick="removeImage('Assessments',<?php echo $assessmentEntity['id']?>)" style="position: absolute;left: 0;top: -14px;font-size: 24px;color: #f00;"><i class="fa fa-times-circle"></i></a>
							<?php }else{?>
								<img id="replaceImage" src="<?php echo HTTP_ROOT;?>images/document.png">
							<?php }?>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="firstname">Upload Pic</label>
								<input type="file" class="form-control" name="photo" id="imageUpload" placeholder="Photo">
							</div>
						</div>
						<div class="col-md-2">
							<input type="hidden" id="token" value="<?php echo $this->request->getParam('_csrfToken'); ?>">
							<label for="firstname">&nbsp;</label>
							<button type="button" id="previewUpload" class="btn btn-primary mb-2">Upload</button>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Version No *</label>
						<input type="text" class="form-control required" value="<?php echo $assessmentEntity["version"]?>" name="version" placeholder="Version No">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="Position">Assessment Description *</label>
						<textarea class="form-control required" id="exampleFormControlTextarea1" name="description" rows="3"><?php echo $assessmentEntity["description"]?></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="LoginEmail">Valid From *</label>
						<input type="text" class="form-control required" readonly name="valid_from" value="<?php echo date("d M Y",strtotime($assessmentEntity["valid_from"]))?>" id="from" placeholder="Valid from">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Valid To *</label>
						<input type="text" class="form-control required" readonly name="valid_to" value="<?php echo date("d M Y",strtotime($assessmentEntity["valid_to"]))?>" id="to" placeholder="Valid to">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="Position">Copy / Paste JSON *</label>
						<textarea class="form-control required" id="exampleFormControlTextarea1" name="json_data" rows="3"><?php echo $assessmentEntity["json_data"]?></textarea>
					</div>
				</div>
			</div>
			
		</div>
		<div class="mt-4 text-center">
			<button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
			<a onclick="checkAssessment(<?php echo $assessmentEntity['id'];?>)" type="submit" class="btn btn-danger btn-lg mb-2">Delete</a>
		</div>
	</form>		
</div>
<script>
	function checkAssessment(assessmentId){
		$.ajax({
			url:"<?php echo HTTP_ROOT;?>Assessments/checkAssessment/"+assessmentId,
			success:function(resp){
				if(resp>0){
					if(confirm('Are you sure? This assessment has '+resp+' responses')){
						alert("Assessment has responses. You can't delete !");
					}
				}else{
					$.ajax({
						url:"<?php echo HTTP_ROOT;?>Assessments/deleteAssessment/"+assessmentId,
						success:function(resp){
							alert("Assessment is deleted successfully !");
							window.location.href="<?php echo HTTP_ROOT;?>Assessments"
						}
					})
				}
			}
		})
	}
</script>