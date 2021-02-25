<div class="main-content">
	<?php echo $this->Form->create(null,array("id"=>"addClient",'type' => 'file'))?>	
		<div class="title-bar">
			<div class="row">
				<div class="col-md-6"><h4>Add Industry</h4></div>
				
			</div>
		</div>
		
		<div class="form-conatiner">
		
			<div class="row">
				<div class="col-md-12">
					<div class="form-group">
						<label for="clientname">Industry Name •</label>
						<input type="text" class="form-control required" id="first-name" name="industry_title" placeholder="Industry Name">
					</div>
				</div>
				
			</div>
		</div>
		<div class="mt-4 text-center">
			<button type="submit" class="btn btn-primary btn-lg mb-2">Submit</button>
		</div>
	</form>		
</div>
	