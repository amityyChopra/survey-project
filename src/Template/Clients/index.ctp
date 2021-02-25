<div class="main-content">
		<div class="title-bar">
			<div class="row">
				<div class="col-md-4"><h4></h4></div>
				<div class="col-md-6 filters text-right">
					
				</div>
				<div class="col-md-2 text-right"><a href="<?php echo HTTP_ROOT;?>clients/addClient" class="btn btn-primary" role="button" aria-pressed="true"><span class="lnr lnr-plus-circle"></span> Add New Client</a></div>
			</div>
		</div>
		<div class="table-responsive">
        <table id="example" class="tables table-striped table-bordered">
          <thead>
            <tr class="title">
			  <th style="display:none;">S.No</th>
              <th data-orderable="false" class="nosort">Clients Logo</th>
			  <th>Client Name</th>
			  <th class="text-center">Industry</th>
			  <th class="text-center">Valid to</th>
			  <th data-orderable="false" class="text-center">Action</th>
            </tr>
          </thead>
          <tbody>
			<?php if(!empty($allClients)){?>
				<?php $i=1;foreach($allClients as $client){?>
					<tr <?php if(!$client["disabled"]){?>class="disabled"<?php }?>>
						<td style="display:none;"><?php echo $i;?></td>
						<td>
							<div class="image">
								<?php if(!empty($client["photo_logo"])){?>
								<img width="60" src="<?php echo HTTP_ROOT;?>img/client_logos/medium/<?php echo $client["photo_logo"]?>"/>
								<?php }else{?>
									<img width="60" src="<?php echo HTTP_ROOT;?>images/profile-pic-default.png"/>
								<?php }?>
							</div>
						</td>
						<td><?php echo $client["client_name"]?></td>
						<td class="text-center"><?php echo $client["industry"]["industry_title"]?></td>
						
						<?php
							$newdate = date('d M Y', strtotime($client["valid_to"])); // Format in which I want to display
							$dateOrder = date('Y-m-d', strtotime($client["valid_to"])); // Sort Order
						?>
						<td data-order="<?php echo $dateOrder; ?>" class="text-center">
							<?php echo $newdate;?>
						</td>
						<td class="text-center"><a class="btn btn-outline-primary btn-sm" href="<?php echo HTTP_ROOT."clients/editClient/".base64_encode(convert_uuencode($client["id"]))?>"><span class="lnr lnr-pencil"></span></a></td>
					</tr>
				<?php $i++;}?>
			<?php }?>
			
          </tbody>
        </table>		
      </div>
	</div>
	<style>
		tr.disabled td, tr.disabled th{
			background-color:#eee;
		}
		
	</style>