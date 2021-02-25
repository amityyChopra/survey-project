<div class="main-content">
	<?php echo $this->Form->create(null,array("id"=>"editClient",'type' => 'file'))?>
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6"><h4>Edit User</h4></div>
				<div class="col-md-6 text-right">
					<div class="custom-control custom-switch">
					  <input type="checkbox" name="disabled" <?php if($userEntity["disabled"]){?> checked="checked"<?php }?> class="custom-control-input" id="customSwitch1">
					  <label class="custom-control-label" for="customSwitch1">
					  </label>
					  <?php if($userEntity["disabled"]){$text="Enabled"; }else{$text="Disabled";}?>
					  <span class="text-primary" id="valueOfSwitch4"><?php echo $text;?></span>
					</div>
				</div>
			</div>
		</div>
		<div class="form-conatiner">
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">First Name</label>
						<input name="first_name" type="text" value="<?php echo $userEntity["first_name"]?>" class="form-control required" id="first-name" placeholder="First Name">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Last Name</label>
						<input name="last_name" value="<?php echo $userEntity["last_name"]?>"  type="text" class="form-control required" id="last-name" placeholder="Last Name">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="role">User Role</label>
						<select name="role_id" class="form-control required" id="role_id">
							<option <?php if($userEntity["role_id"]==1){?> selected="selected"<?php }	?> value="1">Admin</option>
							<option <?php if($userEntity["role_id"]==2){?> selected="selected"<?php }	?> value="2">AdEx</option>
							<option <?php if($userEntity["role_id"]==3){?> selected="selected"<?php }	?> value="3">Creator</option>
						</select>
					</div>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-2">
                            <?php if(!empty($userProfileEntity["profile_picture"])){?>
								<img id="replaceImage" src="<?php echo HTTP_ROOT;?>img/user_image/medium/<?php echo $userProfileEntity["profile_picture"];?>">
								<a id="hideRemoveIcon" href="javascript:void(0);" onclick="removeImage('UserProfile',<?php echo $userProfileEntity['id']?>)" style="position: absolute;left: 0;top: -14px;font-size: 24px;color: #f00;"><i class="fa fa-times-circle"></i></a>
							<?php }else{?>
								<img id="replaceImage" src="<?php echo HTTP_ROOT;?>images/profile-pic-default.png">
							<?php }?>
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
						<input type="text" class="form-control" value="<?php echo $userProfileEntity["position"];?>" name="position" id="position" placeholder="Position">
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label for="LoginEmail">Login O365 Email *</label>
						<input type="text" class="form-control required"  value="<?php echo $userEntity["email"]?>"name="email" id="first-name" placeholder="Email">
					</div>
				</div>
				<div class="col-md-6">
					<div class="form-group">
						<label for="firstname">Validity to</label>
						<input type="text" class="form-control required" readonly value="<?php echo date("d M Y",strtotime($userEntity["valid_upto"]))?>" id="from" name="valid_upto" placeholder="Valid Upto">
					</div>
				</div>
			</div>
		</div>
		<div class="mt-4 text-center">
			<button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
		</div>
	</form>
</div>