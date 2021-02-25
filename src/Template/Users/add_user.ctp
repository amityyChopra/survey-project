<div class="main-content">
	<?php echo $this->Form->create(null,array("id"=>"addClient",'type' => 'file'))?>
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6"><h4>Add User</h4></div>
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
						<label for="firstname">First Name *</label>
						<input name="first_name" type="text" class="form-control required" id="first-name" placeholder="First Name">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Last Name *</label>
						<input name="last_name" type="text" class="form-control required" id="last-name" placeholder="Last Name">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="role_id">User Role</label>
						<select name="role_id" class="form-control required" id="role_id">
							<option value="1">Admin</option>
							<option value="2">AdEx</option>
							<option value="3">Creator</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-2">
							<img id="replaceImage" src="<?php echo HTTP_ROOT;?>images/profile-pic-default.png">
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="firstname">Upload Pic</label>
								<input name="photo" type="file" id="imageUpload" class="form-control" id="last-name" placeholder="Last Name">
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
				<div class="col-md-12">
					<div class="form-group">
						<label for="Position">Position</label>
						<input type="text" class="form-control" name="position" id="position" placeholder="Position">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="LoginEmail">Login O365 Email *</label>
						<input type="text" class="form-control required" name="email" id="first-name" placeholder="Email">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Validity to *</label>
						<input type="text" class="form-control required" id="from" name="valid_upto" placeholder="Valid to">
					</div>
				</div>
			</div>
		</div>
		<div class="mt-4 text-center">
			<button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
		</div>
	</form>
</div>