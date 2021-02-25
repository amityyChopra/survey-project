<header>
    <div class="row">
        <div class="col-md-4">
            <?php /*?><div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup">Search</label>
                <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <div class="input-group-text"><span class="lnr lnr-magnifier"></span></div>
                </div>
                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search">
                </div>
            </div><?php */?>
        </div>
    
        <div class="col-md-8 text-right">
            <div class="dropdown float-r ml-2">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php 
                    
                    if(!empty($updateUserProfile["profile_picture"])){
                        $url = HTTP_ROOT."img/user_image/medium/".$updateUserProfile["profile_picture"];
                    }else{
                        $url = "https://survey-dev.westeurope.cloudapp.azure.com/images/profile-pic-default.png";
                    }
                ?>
                <span><?php echo $updateUser["first_name"]." ".$updateUser["last_name"]?></span> <img width="56" src="<?php echo $url;?>"/>
                </a>

                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <!-- <a class="dropdown-item" href="javascript:void(0)"><span class="lnr lnr-license"></span> My Profile</a>
                <a class="dropdown-item" href="javascript:void(0)"><span class="lnr lnr-alarm"></span> Notifications</a>
                <a class="dropdown-item" href="javascript:void(0)"><span class="lnr lnr-cog"></span> Settings</a> -->
                <a class="dropdown-item" href="<?php echo HTTP_ROOT;?>Users/logout"><span class="lnr lnr-exit"></span> Logout</a>
                </div>
            </div>
        </div>
    </div>
</header>