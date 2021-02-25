<div class="main-content">
	<div class="title-bar">
		<div class="row">
			<div class="col-md-6 filters">
				<i style="font-size:1.5rem" class="fa fa-filter" aria-hidden="true"></i>
				<input value="<?php if(!empty($_GET["keyword"])){echo $_GET["keyword"];}?>" class="form-control" id="keyword" name="keyword" type="text" placeholder="Search User">
				<select name="role_id" id="role_id" class="form-control">
					<option value="">--Select Role--</option>
					<option <?php if(!empty($_GET["role_id"])){if($_GET["role_id"]=="1"){?>selected="selected"<?php }}?> value="1">Admin</option>
					<option <?php if(!empty($_GET["role_id"])){if($_GET["role_id"]=="2"){?>selected="selected"<?php }}?> value="2">AdEx</option>
					<option <?php if(!empty($_GET["role_id"])){if($_GET["role_id"]=="3"){?>selected="selected"<?php }}?> value="3">Creator</option>
				</select>
			</div>
			<div class="col-md-6 text-right"><a href="<?php echo HTTP_ROOT;?>Users/addUser" class="btn btn-primary" role="button" aria-pressed="true"><span class="lnr lnr-plus-circle"></span> Add New User</a></div>
		</div>
	</div>
	<div class="table-responsive">
		<table class="tables" id="changeThis">
			<thead>
			<tr class="title">
				<th width="10%">Users</th>
				<th width="30%"></th>
				<th class="text-center">Role</th>
				<th class="text-center">Action</th>
				<th class="text-center">Valid to</th>
			</tr>
			</thead>
			<tbody>
			<?php if(!empty($allUsers)){?>
				<?php foreach($allUsers as $user){?>
					<tr <?php if(!$user["disabled"]){?>class="disabled"<?php }?>>
						<td>
							<div class="image">
								<?php if(!empty($user["user_profile"]["profile_picture"])){?>
									
									<img width="60" src="<?php echo HTTP_ROOT;?>img/user_image/medium/<?php echo $user["user_profile"]["profile_picture"]?>"/>
								<?php }else{?>
									<img width="60" src="<?php echo HTTP_ROOT;?>images/profile-pic-default.png"/>
								<?php }?>
							</div>
						</td>
						<td><h4><?php echo $user["first_name"]." ".$user["last_name"]?></h4>Position: <?php echo $user["user_profile"]["position"]?></td>
						<td class="text-center">
							<?php if($user["role_id"]==1){echo "Admin";}if($user["role_id"]==2){echo "AdEx";}if($user["role_id"]==3){echo "Creator";}?>
						</td>
						<td class="text-center"><a class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT;?>users/editUser/<?php echo base64_encode(convert_uuencode($user["id"]));?>"><span class="lnr lnr-pencil"></span></a></td>
						
						<td class="text-center"><?php echo date("Y-m-d",strtotime($user["valid_upto"]));?></td>
					</tr>
				<?php }?>
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