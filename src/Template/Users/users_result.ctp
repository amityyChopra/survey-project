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
                
                <td class="text-center"><?php echo date("d F Y",strtotime($user["valid_upto"]));?></td>
            </tr>
        <?php }?>
    <?php }?>
    </tbody>
</table>