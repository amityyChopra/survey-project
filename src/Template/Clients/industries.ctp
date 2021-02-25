<div class="main-content">
		<div class="title-bar">
			<div class="row">
				<div class="col-md-4"><h4></h4></div>
				
				<div class="col-md-8 text-right"><a href="<?php echo HTTP_ROOT;?>Clients/addIndustry" class="btn btn-primary" role="button" aria-pressed="true"><span class="lnr lnr-plus-circle"></span> Add New Industry</a></div>
			</div>
		</div>
		<div class="table-responsive">
        <table class="tables">
          <thead>
            <tr class="title">
			  <th>Industry</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
			<?php if(!empty($allIndustries)){?>
				<?php $i=1;foreach($allIndustries as $industry){?>
					<tr class="disabled">
						<td><?php echo $industry["industry_title"]?></td>
						<td>
							<a class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT."Clients/editIndustry/".base64_encode(convert_uuencode($industry["id"]))?>"><span class="lnr lnr-pencil"></span></a>
							<a onclick="return confirm('Are you sure?')" class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT."Clients/deleteIndustry/".base64_encode(convert_uuencode($industry["id"]))?>"><span class="lnr lnr-trash"></span></a>
						</td>
					</tr>
				<?php $i++;}?>
			<?php }?>
			
          </tbody>
        </table>
		
		
		
      </div>
	</div>