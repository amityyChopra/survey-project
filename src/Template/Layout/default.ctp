<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<title>AdEx - Assessment</title>
	<!-- Stylesheets -->
	<link href="<?php echo HTTP_ROOT;?>css/style.css" rel="stylesheet">
	<link href="<?php echo HTTP_ROOT;?>fonts/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo HTTP_ROOT;?>css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT;?>css/multi-select.css">
	<link rel="stylesheet" type="text/css"  href="<?php echo HTTP_ROOT;?>css/jquery.ui.css">
	<link rel="stylesheet" type="text/css"  href="<?php echo HTTP_ROOT;?>css/jquery.ui.css">
	<link rel="stylesheet" type="text/css"  href="<?php echo HTTP_ROOT;?>css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css"  href="<?php echo HTTP_ROOT;?>css/font-awesome.min.css">
   
	<!--Favicon-->
	<link rel="icon" href="<?php echo HTTP_ROOT;?>images/favicon.png" type="image/x-icon">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet">
</head>

<body>
    <?php echo $this->element("header");?>
    <?php echo $this->element("sidebar");?>
	
	<?php echo $this->fetch('content');?>
	
	<script src="<?php echo HTTP_ROOT;?>js/jquery.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/popper.min.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/bootstrap.min.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/jquery.multi-select.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/jquery-ui.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/validate.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/bootstrap-notify/bootstrap-notify.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/jquery.dataTables.min.js"></script>
	<script src="<?php echo HTTP_ROOT;?>js/dataTables.bootstrap4.min.js"></script>
	<script>
		$('.dropdown-toggle').dropdown();
		
	</script>
	<script>
		$( function() {
			$('#example').DataTable({
				aaSorting: [[0, 'asc']],
				aoColumnDefs: [
					{ "aTargets": [ 3 ], "bSortable": false},
				],
				"paging":   false,
			});

			$(".nosort").removeClass("sorting_asc");

			$("#addClient").validate();
			$("#editClient").validate();

			$("#from").datepicker({
				dateFormat: "dd-M-yy",
				changeMonth: true,
				changeYear: true,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() + 1);
					$("#to").datepicker("option", "minDate", dt);
				}
			});
			$('#to').datepicker({
				dateFormat: "dd-M-yy",
				changeMonth: true,
				changeYear: true,
				onSelect: function (selected) {
					var dt = new Date(selected);
					dt.setDate(dt.getDate() - 1);
				}

			});


			$("#previewUpload").click(function(){
				
				var token = $("#token").val();
				var file_data = $("#imageUpload").prop("files")[0]; // Getting the properties of file from file field
				var form_data = new FormData(); // Creating object of FormData class
				form_data.append("file", file_data) // Appending parameter named file with properties of file_field to form_data
				if(file_data!='' && file_data!=null){
					$(this).html("Uploading....");

					$(this).html("Uploaded");
					$.ajax({
						url: "<?php echo HTTP_ROOT;?>Users/previewImage", // Upload Script
						dataType: 'script',
						cache: false,
						contentType: false,
						processData: false,
						data: form_data, // Setting the data attribute of ajax with file_data
						type: 'post',
						headers: {
							'X-CSRF-Token': token
						},
						success: function(data) {
							var obj = JSON.parse(data);
							$("#replaceImage").attr("src",obj[0].path);
							
						}
					});
				}
				
			});
			
 
		});
			
		</script>
	<script type="text/javascript">
	// run pre selected options
		$('#pre-selected-options').multiSelect({
			selectableHeader: "<div class='custom-header'>Available Assessments</div>",
			selectionHeader: "<div class='custom-header'>Assigned Assessments</div>",
			
		});
		$(document).ready(function(){
			$("#valueOfSwitch3").html("<span style='color:#adb5bd;'>Disabled</span>");
		});
		
		$("#customSwitch3").change(function(){
			$("#valueOfSwitch3").html("<span style='color:#adb5bd;'>Disabled</span>");
			if ($(this).is(':checked')) {
				$("#valueOfSwitch3").html("Enabled");
			}
		});

		$("#customSwitch1").change(function(){
			$("#valueOfSwitch4").html("<span style='color:#adb5bd;'>Disabled</span>");
			if ($(this).is(':checked')) {
				$("#valueOfSwitch4").html("Enabled");
			}
		});
		

	</script>
	<script>
		$('#client_id').bind('change', function () { // bind change event to select
			var clientId = $(this).val();

			if(clientId!=0){
				$(".loader").css("display","block");
				$(".overlay").css("display","block");

				$.ajax({
					url:"<?php echo HTTP_ROOT;?>Assessments/getAssessments/"+clientId,
					success:function(res){

						var url = "<?php echo HTTP_ROOT;?>Assessments?client_id="+clientId;
						if (url != '') { // require a URL

							history.pushState("AdEx-Assessments", "", url)
						}

						$("#changeThis").html(res);
						$(".loader").css("display","none");
						$(".overlay").css("display","none");
						return false;
					}
				});
			}else{
				location.replace('<?php echo HTTP_ROOT;?>Assessments');
			}
			


			
		});

		var getUrlParameter = function getUrlParameter(sParam) {
			var sPageURL = window.location.search.substring(1),
				sURLVariables = sPageURL.split('&'),
				sParameterName,
				i;

			for (i = 0; i < sURLVariables.length; i++) {
				sParameterName = sURLVariables[i].split('=');

				if (sParameterName[0] === sParam) {
					return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
				}
			}
		};

		$("#assessment_name").keyup(function(){
			var keyword = $(this).val();
			var clientId = getUrlParameter('client_id');


			$.ajax({
				url:"<?php echo HTTP_ROOT;?>Assessments/getAssessments/"+clientId+"?keyword="+keyword,
				success:function(res){
					$("#changeThis").html(res);
				}
			});
		});

		$('#role_id').bind('change', function () { // bind change event to select
			var roleId = $(this).val();

			if(roleId!=0){
				$(".loader").css("display","block");
				$(".overlay").css("display","block");

				$.ajax({
					url:"<?php echo HTTP_ROOT;?>Users/getUsers/"+roleId,
					success:function(res){

						var url = "<?php echo HTTP_ROOT;?>Users?role_id="+roleId;
						if (url != '') { // require a URL

							history.pushState("AdEx-Users", "", url)
						}

						$("#changeThis").html(res);
						$(".loader").css("display","none");
						$(".overlay").css("display","none");
						return false;
					}
				});
			}else{
				location.replace('<?php echo HTTP_ROOT;?>Users');
			}
			
		});

		$("#keyword").keyup(function(){
			var keyword = $(this).val();
			var roleId = getUrlParameter('role_id');


			$.ajax({
				url:"<?php echo HTTP_ROOT;?>Users/getUsers/"+roleId+"?keyword="+keyword,
				success:function(res){
					$("#changeThis").html(res);
				}
			});
		});



		function removeImage(tableName,recordId){
			$("#overlay").css("display","block");

			$.ajax({
				url:"<?php echo HTTP_ROOT;?>Users/removeImage/"+tableName+'/'+recordId,
				success:function(res){
					if(tableName=="Assessments"){
						imageUrl = '<?php echo HTTP_ROOT;?>images/document.png';
					}else{
						imageUrl = '<?php echo HTTP_ROOT;?>images/profile-pic-default.png';
					}
					$("#replaceImage").attr("src",imageUrl);

					$("#hideRemoveIcon").css("display","none");

					$("#overlay").css("display","none");
				}
			});

		}

	</script>
	<style>
        #overlay {
            position: fixed;
            display: none;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 2;
            cursor: pointer;
        }

        #text{
            position: absolute;
            top: 50%;
            left: 50%;
            font-size: 50px;
            color: white;
            transform: translate(-50%,-50%);
            -ms-transform: translate(-50%,-50%);
        }
        </style>

        <div id="overlay">
          <div id="text">Removing.......</div>
        </div>
	<?php echo $this->Flash->render();?>
	<div class="loader"></div>
	<div class="overlay"></div>
</body>
</html>