<div class="sidebar">
    <h1><img src="<?php echo HTTP_ROOT;?>images/logo-adex.png"/></h1>
    <ul class="leftnav">
        <li <?php if(isset($assessmentActive)){?> class="active"<?php }?>><a href="<?php echo HTTP_ROOT;?>Assessments"><span class="lnr lnr-file-empty"></span>Assessments</a></li>
        <li <?php if(isset($clientActive)){?> class="active"<?php }?>><a href="<?php echo HTTP_ROOT;?>Clients"><span class="lnr lnr-users"></span>Clients</a></li>
        <li <?php if(isset($industryActive)){?> class="active"<?php }?>><a href="<?php echo HTTP_ROOT;?>Clients/industries"><span class="lnr lnr-home"></span>Industries</a></li>
        <li <?php if(isset($usersActive)){?> class="active"<?php }?>><a href="<?php echo HTTP_ROOT;?>Users"><span class="lnr lnr-user"></span>Users</a></li>
    </ul>
</div>