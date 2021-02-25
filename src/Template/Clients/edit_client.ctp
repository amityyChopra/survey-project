<div class="main-content">
	<?php echo $this->Form->create(null,array("id"=>"editClient",'type' => 'file'))?>
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6"><h4>Edit Client</h4></div>
				<div class="col-md-6 text-right">
					<div class="custom-control custom-switch">
					  <input type="checkbox" class="custom-control-input" name="disabled" <?php if($clientEntity["disabled"]){?> checked="checked"<?php }?> id="customSwitch1">
					  <label class="custom-control-label" for="customSwitch1">
					  </label>
					  <?php if($clientEntity["disabled"]){$text="Enabled"; }else{$text="Disabled";}?>
					  <span class="text-primary" id="valueOfSwitch4"><?php echo $text;?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-conatiner">
		
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="clientname">Client Name *</label>
						<input type="text" class="form-control requried" value="<?php echo $clientEntity["client_name"]?>" id="first-name" name="client_name" placeholder="Client Name">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="industry">Client Industry *</label>
						<select class="form-control required" name="client_industry" id="role">
							<option value="">Select Industry</option>
							<?php if(!empty($allIndustries)){?>
							<?php foreach($allIndustries as $industry){?>
								<option <?php if($clientEntity["client_industry"]==$industry["id"]){?> selected="selected"<?php }?> value="<?php echo $industry["id"]?>"><?php echo $industry["industry_title"]?></option>
							<?php }?>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-2">
							<?php if(!empty($clientEntity["photo_logo"])){?>
								<img id="replaceImage" src="<?php echo HTTP_ROOT;?>img/client_logos/medium/<?php echo $clientEntity["photo_logo"];?>">
								<a id="hideRemoveIcon" href="javascript:void(0);" onclick="removeImage('Clients',<?php echo $clientEntity['id']?>)" style="position: absolute;left: 0;top: -14px;font-size: 24px;color: #f00;"><i class="fa fa-times-circle"></i></a>
							<?php }else{?>
								<img id="replaceImage" src="<?php echo HTTP_ROOT;?>images/profile-pic-default.png">
							<?php }?>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="firstname">Add Client's Picture/Logo</label>
								<input type="file" class="form-control" id="imageUpload" name="photo" placeholder="Last Name">
							</div>
						</div>
						<div class="col-md-2">
							<input type="hidden" id="token" value="<?php echo $this->request->getParam('_csrfToken'); ?>">
							<label for="firstname">&nbsp;</label>
							<button type="button" id="previewUpload" class="btn btn-primary mb-2">Upload</button>
						</div>
					</div>
				</div>
				
				<div class="col-md-3">
					<div class="form-group">
						<label for="firstname">Valid From *</label>
						<input type="text" readonly value="<?php echo date("d M Y",strtotime($clientEntity["valid_from"]));?>" class="form-control required" name="valid_from" id="from" placeholder="Valid From">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="firstname">Valid To *</label>
						<input type="text" readonly class="form-control required" value="<?php echo date("d M Y",strtotime($clientEntity["valid_to"]))?>" name="valid_to" id="to" placeholder="Valid To">
					</div>
				</div>
				
			</div>				
			<div class="row">
				<div class="form-group" style="width:100%">
					<label for="firstname">Assign assessment to client</label>
					<select id='pre-selected-options' name="assessment_id[]" multiple='multiple'>
						<?php if(!empty($allActiveAssessments)){?>
							<?php foreach($allActiveAssessments as $activeAssessment){?>
								<option <?php if(!empty($assignedAssessments) && in_array($activeAssessment["id"],$assignedAssessments)){?>selected="selected"<?php }?> value="<?php echo $activeAssessment["id"]?>"><?php echo $activeAssessment["assessment_title"]?></option>
							<?php }?>
						<?php }?>
					</select>
				</div>
			</div>
		</div>
		<div class="mt-4 text-center">
			<button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>

			<a onclick="return confirm('Are you sure?')" href="<?php echo HTTP_ROOT;?>Clients/deleteClient/<?php echo base64_encode(convert_uuencode($clientEntity["id"]));?>" type="submit" class="btn btn-danger btn-lg mb-2">Delete</a>
		</div>
	</form>		
</div>
	