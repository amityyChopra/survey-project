<?php
?>
<?php /*?><!DOCTYPE html>
<html lang="en">
    <head>
        <title>Example of setting and getting results into/from the survey, jQuery Survey Library Example</title>

        <meta name="viewport" content="width=device-width"/>
        <script src="https://unpkg.com/jquery"></script>
        <script src="https://surveyjs.azureedge.net/1.8.6/survey.jquery.js"></script>
        <link href="https://surveyjs.azureedge.net/1.8.6/modern.css" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="./index.css">

    </head>
    <body>
		<select id="pageSelector" onchange="survey.currentPageNo = this.value"></select>
        <div id="surveyElement" style="display:inline-block;width:100%;"></div>
        <div id="surveyResult"></div>

        <script type="text/javascript" src="<?php echo HTTP_ROOT;?>js/index.js"></script>

    </body>
</html><?php */?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Example of creating an alternative custom navigation, jQuery Survey Library Example</title>

        <meta name="viewport" content="width=device-width"/>
        <script src="https://unpkg.com/jquery"></script>
        <script src="https://surveyjs.azureedge.net/1.8.6/survey.jquery.js"></script>
        <link href="https://surveyjs.azureedge.net/1.8.6/modern.css" type="text/css" rel="stylesheet"/>
        <link rel="stylesheet" href="./index.css">

    </head>
    <body>

        External navigation:
        <span id="surveyProgress"></span>
        <a id="surveyPrev" href="#" onclick="survey.prevPage();">Prev</a>
        <a id="surveyNext" href="#" onclick="survey.nextPage();">Next</a>
        <a id="surveyComplete" href="#" onclick="survey.completeLastPage();">Complete</a>
        <br/>
        Go to page directly without validation:
        <select id="" onchange="survey.currentPageNo = this.value"></select>

        <hr/>
        <div id="surveyElement" style="display:inline-block;width:100%;"></div>
        <div id="surveyResult"></div>

        <script type="text/javascript" src="<?php echo HTTP_ROOT;?>js/index.js"></script>

    </body>
</html>