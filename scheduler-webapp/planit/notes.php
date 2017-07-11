<?php 
	session_start();
	if(!isset($_SESSION['loggedIn'])){
		header('Location: index.php');
		exit();
	}
 ?>


<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<title>PlanIT</title>
	<meta name="description" content="Plan your day with our application. Become effective at what you're doing and forget about forgetting!" />
	<meta name="keywords" content="organizer, planner, plan, organize, day, scheduler, schedule" />
	<meta http-equiv="X-UA-Compatibile" content="IE=edge,chrome=1" />
	<link rel="stylesheet" href="css/fontello.css" type="text/css" />
	<link rel="stylesheet" href="style.css" type="text/css" />
	<link href="https://fonts.googleapis.com/css?family=Lato&amp;subset=latin-ext" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Kalam&amp;subset=latin-ext" rel="stylesheet">
	<meta name="viewport" content="width=device-width">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>
<body>
	<div class="container">

				<div class="sidebar">
					<div class="option"><a href="today.php"><i class="icon-stopwatch"></i><br/>Today</a></div>
					<div class="option"><a href="week.php"><i class="icon-calendar-1"></i><br/>Week</a></div>
					<div class="option"><a href="month.php"><i class="icon-calendar"></i><br/>Month</a></div>
					<div class="option"><a href="notes.php" style="box-shadow: inset 0 0 30px #000;"><i class="icon-edit"></i><br/>Notes</a></div>
					<div class="option"><a href="bills.php"><i class="icon-money"></i><br/>Bills</a></div>
					<div class="option"><a href="settings.php"><i class="icon-cog-alt"></i><br/>Settings</a></div>
				</div>

				<div class="todayContent">
						<h1>Notes</h1>
						<div class="calendar">
								<div class="searching-container">
									<input type="text" name="search" placeholder="search" id="searchbar">
									<div class="notes-content" id="cont">
									</div>
									<div class="newNote" id="addNewNote">
										<i class="icon-doc-add"></i>
									</div>
								</div>
								<div class="evrelse-container">
									<img id="notepad" src="img/paper.jpg"/>
									<div id="theRealContent"></div>
								</div>
						</div>
						<div style="clear: both;"></div>
				</div>

				<div style="clear:both;"></div>
				<footer>&copy; Damian Horna</footer>
	</div>
</body>
</html>

<script type="text/javascript">		

	$(window).on('load', function() {$.post('searching.php',{search: ""},function(response){ $('#cont').html(response);});});
					

$('document').ready(
	function(){ 

		$('#addNewNote').on( 'click', function() {
		    $('#theRealContent').html(
		    	"<div id=\"titleDiv\">Title:<textarea id=\"titleText\" maxlength=\"50\" class=\"transparentTextSmall\"></textarea></div><div id=\"descDiv\"><textarea id=\"descText\" class=\"transparentTextBig\" placeholder=\"Write something more...\"></textarea></div><div class=\"btns\"> <div id=\"okButton\"><i class=\"icon-ok-circled\" ></i></div><div id=\"cancelButton\"><i class=\"icon-cancel-circled\" ></i></div></div>"
		    );
		});


		$('#theRealContent').on('click','#okButton',saveNote);


		$('#theRealContent').on('click','#cancelButton',function(){
			$('#theRealContent').empty();
		});
		$('#theRealContent').on('click','#editCancel',function(){
			$('#theRealContent').empty();
		});

		$('#theRealContent').on('click','#editOk',readyToGo);
		$('#theRealContent').on('click','#editButton',editNote);
		$('#theRealContent').on('click','#delButton',delNote);

		$('#cont').on('click','.note',function(){
			var id=$(this).attr('id');
			$.post('displayNote.php',{id: id},function(response){ $('#theRealContent').html(response);});
		});


	    $('#searchbar').keypress(
	    	function(e){
		        if(e.which == 13){//Enter key pressed
		            var search = $('#searchbar').val();
		        	$.post('searching.php',{search: search},function(response){
				            $('#cont').html(response);
				        });	
		        }
    		});

	});

	function saveNote(){
		var title = $('#titleText').val();
		var descr = $('#descText').val();
		$.ajax({
			type: "POST",
			url: "addNote.php",
			data: "title="+title+"&descr="+descr,
			success: function(msg){
				$('#theRealContent').empty();
				$.post('searching.php',{search: ""},function(response){ $('#cont').html(response);});
			}
		});
	}

	function delNote(){
		$.ajax({
			url: "delNote.php",
			success: function(msg){
				$('#theRealContent').empty();
				$.post('searching.php',{search: ""},function(response){ $('#cont').html(response);});
			}
		});
	}

	function editNote(){
		var dat = $('#Ndate').text();
		var tit = $('#Ntitle').text();
		var des = $('#Ndesc').text();
		$('#theRealContent').html("<div id=\"Nwrapper\"><div id=\"Ndate\">"+ dat + "</div><textarea maxlength=\"50\" id=\"textareaTit\">" + tit + "</textarea><textarea id=\"textareaDesc\">" + des + "</textarea><div id=\"Nbtns\"><i id=\"editOk\" class=\"icon-ok-circled\" ></i><i id=\"editCancel\" class=\"icon-cancel-circled\" ></i></div></div>");
	}

	function readyToGo(){
		var newTit = $('#textareaTit').val();
		var newDesc = $('#textareaDesc').val();
		$.ajax({
			type: "POST",
			url: "editNote.php",
			data: "title="+newTit+"&descr="+newDesc,
			success: function(msg){
				$('#theRealContent').empty();
				$.post('searching.php',{search: ""},function(response){ $('#cont').html(response);});
			}
		});
	}
</script>