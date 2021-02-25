<div class="main-content">
	<?php echo $this->Form->create(null,array("id"=>"addClient",'type' => 'file'))?>	
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6"><h4>Add Client</h4></div>
				<div class="col-md-6 text-right">
					<div class="custom-control custom-switch">
					  <input type="checkbox" class="custom-control-input" id="customSwitch3">
					  <label class="custom-control-label" for="customSwitch3">
					  </label>
					  <span class="text-primary" id="valueOfSwitch3"></span>
					</div>
				</div>
			</div>
		</div>
		
		<div class="form-conatiner">
		
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="clientname">Client Name *</label>
						<input type="text" class="form-control required" id="first-name" name="client_name" placeholder="Client Name">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="industry">Client Industry *</label>
						<select class="form-control required" name="client_industry" id="role">
							<option value="">Select Industry</option>
							<?php if(!empty($allIndustries)){?>
							<?php foreach($allIndustries as $industry){?>
								<option value="<?php echo $industry["id"]?>"><?php echo $industry["industry_title"]?></option>
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
							<img id="replaceImage" src="<?php echo HTTP_ROOT;?>images/profile-pic-default.png">
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
						<input type="text" readonly class="form-control required" name="valid_from" id="from" placeholder="Valid From">
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="firstname">Valid To *</label>
						<input type="text" readonly class="form-control required" name="valid_to" id="to" placeholder="Valid To">
					</div>
				</div>
				
			</div>				
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="firstname">Assign assessment to client</label>
						<select id='pre-selected-options' name="assessment_id[]" multiple='multiple'>
							<?php if(!empty($allActiveAssessments)){?>
								<?php foreach($allActiveAssessments as $activeAssessment){?>
									<option value="<?php echo $activeAssessment["id"]?>"><?php echo $activeAssessment["assessment_title"]?></option>
								<?php }?>
							<?php }?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="mt-4 text-center">
			<button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
		</div>
	</form>		
</div>