<div class="main-content">
	<?php echo $this->Form->create(null,array("id"=>"addClient",'type' => 'file'))?>	
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6"><h4>Add Assessment</h4></div>
				<div class="col-md-6 text-right">
					<div class="custom-control custom-switch">
					  <input type="checkbox" name="disabled" class="custom-control-input" id="customSwitch3">
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
						<label for="firstname">Assessment Name *</label>
						<input type="text" class="form-control required" name="assessment_title" id="first-name" placeholder="Assessment Title">
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-2">
							<img id="replaceImage" src="<?php echo HTTP_ROOT;?>images/document.png">
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
						<label for="firstname">Version No * </label>
						<input type="text" class="form-control required" name="version" placeholder="Version No">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="Position">Assessment Description *</label>
						<textarea class="form-control required" id="exampleFormControlTextarea1" name="description" rows="3"></textarea>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="LoginEmail">Valid From *</label>
						<input type="text" class="form-control required" readonly name="valid_from" id="from" placeholder="Valid from">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Valid To *</label>
						<input type="text" class="form-control required" readonly name="valid_to" id="to" placeholder="Valid to">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="Position">Copy / Paste JSON *</label>
						<textarea class="form-control required" id="exampleFormControlTextarea1" name="json_data" rows="3"></textarea>
					</div>
				</div>
			</div>
			
		</div>
		<div class="mt-4 text-center">
			<button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
		</div>
	</form>		
</div>