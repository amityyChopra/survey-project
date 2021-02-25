<script src="https://unpkg.com/jquery"></script>
<script src="https://surveyjs.azureedge.net/1.8.6/survey.jquery.js"></script>
<link href="https://surveyjs.azureedge.net/1.8.6/modern.css" type="text/css" rel="stylesheet"/>
<?php echo $this->Form->create(null,array("id"=>"addClient",'type' => 'file'))?>
</form>
<div class="main-content">
	<div class="title-bar">
		<div class="row">
			<div class="col-md-4"><h4><?php echo $assessmentEntity["assessment_title"]?></h4></div>
			<div class="col-md-8 text-right"><a href="<?php echo HTTP_ROOT;?>Assessments">Assessments</a> / <?php echo $assessmentEntity["assessment_title"]?></div>
		</div>
	</div>
	<div class="content-area">
		<div class="header">
			<div class="row">
				<div class="col-md-2"><span class="lnr lnr-user"></span> Respondent Name: </div>
				<div class="col-md-3"><input id="respondent_name" type="text" class="form-control" placeholder="Enter Name"/></div>
				<div class="col-md-7 text-right">
					<span class="lnr lnr-calendar-full"></span> Modified:
					<span class="lnr lnr-user"></span> <?php echo $clientDetails["client_name"]?>
				</div>
			</div>
			<input id="response_id" type="hidden"/>
		</div>
		<hr/>
		<div id="surveyElement" style="display:inline-block;width:100%;"></div>
		<div id="surveyResult"></div>
		<div class="assessments">
					
		</div>
	</div>
</div>
	<script>
		
Survey
    .StylesManager
	.applyTheme("modern");
var myCss = {
	matrix: {
		root: "table table-striped"
	},
	navigationButton: "button btn-lg"
};

function doOnCurrentPageChanged(survey) {
 if(survey.isFirstPage){
	 setupPageSelector(survey)
 }
}
function setupPageSelector(survey) {
	
	str = survey.pages.toString();
	
	
	var array = str.split(",");
	
	$.each(array,function(i){
	   console.log(array[i]);
	});
	
	text='';
    var selector = document.getElementById('pageSelector');
    for (var i = 0; i < survey.visiblePages.length; i++) {
        text += "<span class='navigationItem' onclick='survey.currentPageNo="+i+"'>"+array[i]+"</span>";
    }
	$("#pageSelector").html(text);
}
var json = <?php echo $assessmentEntity["json_data"]?>;






window.survey = new Survey.Model(json);

var origin   = window.location.origin;


var storageName = "SurveyJS_LoadState";
var timerId = 0;
<?php if(!empty($savedState)){?>
function loadState(survey) {
    //Here should be the code to load the data from your database
    var storageSt = window
        .localStorage
        .getItem(storageName) || "";

    var res = {};
    if (storageSt) 
        res = JSON.parse(storageSt); //Create the survey state for the demo. This line should be deleted in the real app.
    else 
        res = {
            currentPageNo: 1,
            data: <?php echo $savedState;?>
        };
    
    //Set the loaded data into the survey.
    if (res.currentPageNo) 
        survey.currentPageNo = res.currentPageNo;
    if (res.data) 
        survey.data = res.data;
}
<?php }?>

function saveState(survey) {
    var res = {
        currentPageNo: survey.currentPageNo,
        data: survey.data
    };
    //Here should be the code to save the data into your database
    window
        .localStorage
        .setItem(storageName, JSON.stringify(res));
}





survey
    .onComplete
    .add(function (result) {
		var resultAsString = JSON.stringify(survey.data);
		var token = $("input[name=_csrfToken]").val();
		var respondentName = $("#respondent_name").val();
		var responseId = $("#response_id").val();
		if(respondentName!='' && respondentName!=null){
			name = respondentName;
		}else{
			name = "";
		}
		$.ajax({
			url:origin+"/Assessments/submitReview",
			type:"POST",
			data:{finished_status:"1",surveyData:resultAsString,location:window.location.href,currentPage: survey.currentPage.name,respondName:name,responseId:responseId},
			headers: {
				'X-CSRF-Token': token
			},
			success:function(res){

			}

		});
    });

survey.showTitle = false;

survey.sendResultOnPageNext = true;

survey.onPartialSend.add(function(sender) {
	var resultAsString = JSON.stringify(survey.data);
	//alert(resultAsString); //send Ajax request to your web server.
	var token = $("input[name=_csrfToken]").val();
	var respondentName = $("#respondent_name").val();
	var responseId = $("#response_id").val();
	if(respondentName!='' && respondentName!=null){
		name = respondentName;
	}else{
		name = "";
	}
	$.ajax({
		url:origin+"/Assessments/submitReview",
		type:"POST",
		data:{surveyData:resultAsString,location:window.location.href,currentPage: survey.currentPage.name,respondName:name,responseId:responseId},
		headers: {
			'X-CSRF-Token': token
		},
		success:function(res){
			$("#response_id").val(res);
		}

	});



});
<?php if(!empty($savedState)){?>
loadState(survey);
<?php }?>

$("#surveyElement").Survey({model: survey, onCurrentPageChanged: doOnCurrentPageChanged,sendResultOnPageNex:true, css: myCss});

setupPageSelector(survey);
doOnCurrentPageChanged(survey);
survey.showTitle = false;
	</script>