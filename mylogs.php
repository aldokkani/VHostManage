<?php 
session_start();
$_SESSION['username']='nahla';
$_SESSION['groupname']='serveradmin';
$_SESSION['projectNum']=2;
if (isset($_SESSION['username']) && isset($_SESSION['groupname']) && isset($_SESSION['projectNum'])){
include_once('LogsSearch.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Logging Application</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/simple-sidebar.css" rel="stylesheet">
	<style>	
		body
		{
			background-image: url("mapimage.jpg") ;
			background-size: cover;
			color: white;
		}		
		.iframecls {
		    width: 100%;
		    height: 673px;
		    margin: 0 auto;
		}
		.iframedev
		{
			width: 71%;
		    margin-left: 76px;
		    overflow: scroll;
		    width: 65%;
		}
		.mainselection
        {
            width: 80%;
        }
        .criteriacheckbox
        {
            margin-top: 13px !important;
            margin-left: -37px !important;
        }
        .checkbox
        {
            color: whitesmoke;
        }
        .filtercrit
        {
            color: black;
        }
        .filterdiv
        {
            margin-left: 40px !important;
        }
        .submitbutton
        {

            width: 112%;
        }
        .dayselection
        {
            margin-left: 20px !important;
        }
        
        .jumbotron
        {
            text-align: center;
            width: 40%;
            margin-left: 200px;
        }

        #dimScreen
        {
            padding: 18px;
            border-radius: 10px;
            width: 67%;
            height: 80%;
            background: rgba(255,255,255,0.5);
            position: absolute;
            z-index: 15;
            top: 6%;
            left: 9%;
            margin: 0 auto;
		    margin-left: 258px;
          
        }

	</style>
</head>
<body>
    <div id="wrapper" >
        <div id="sidebar-wrapper" style="width:25%" style="display:inline-block;vertical-align: top;">
            <form method="post" action="mylogs.php" class="form-horizontal">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="">
                          Choose Filteration Criteria
                    </a>
                </li>
                <li>
                </li>
                <li>
					<div class="checkbox">
					  <label>Severity</label>
					 		<div  id="categorytype" class="filtercrit filterdiv">
								<select class='mainselection btn btn-default' name="cattype">
									<option  value="all" default>All</option>
									<option  value="info">Success</option>
									<option  value="error">Error</option>
									<option value="warning">Warning</option>
								</select>
							</div>
					</div>				
                </li>				
                <li>
                	<div class="checkbox">
					  <label><input name="date" type="checkbox" value="" class="criteriacheckbox" onclick='handleClick(this);'>Filter by Date</label>
					<div id="monthbox" class="filterdiv">
					</div>

					<div id="daybox" class="filterdiv">
								
					</div>
					</div>
                </li>  				
  				<li>
                	<div class="checkbox">
					  <label><input name="time" type="checkbox" value="" class="criteriacheckbox" onclick='handleClick(this);'>Filter by Time</label>
					 <div id="timebox" class="filterdiv">
							
					</div>
					</div>
                </li>
                <li>
                	<div class="checkbox">
					  <label><input name="message" type="checkbox" value="" class="criteriacheckbox" onclick='handleClick(this);'>Filter by Message</label>
						  
						  <div id="messagebox" class="filtercrit filterdiv">

						  </div>
					</div>
                </li>
                <li>
                	<input  name="search" type="submit" value="Submit and get Search results" class="btn btn-default submitbutton">

                </li>
            </ul>		
			</form>
        </div>
		<div style="display:inline-block;vertical-align: top;">
			<div id="dimScreen" class="iframedev" >


<?php
 if($_POST['search']){
$fileTag=$_POST['cattype'];
$team=$_SESSION['projectNum'];
$month=$_POST['month'];
$day=$_POST['day'];
$time=$_POST['time'];
$message=$_POST['text'];
printSearch($team,$fileTag,$month,$day,$time,$message);
 }
?>
				</div>
		</div>
        <div>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
			function handleClick(cb) {
			    if(cb.checked)
			    {
			    	var x = cb.name;
			    	changeFunction(x)
			    }
				else
				{
					var x = cb.name;
					if(x == "message")
			    	{
			    			document.getElementById("messagebox").innerHTML ="";
					}
					else if(x == "date")
					{
							document.getElementById("monthbox").innerHTML ="";
							document.getElementById("daybox").innerHTML ="";
					}
					else if(x == "time")
					{
							document.getElementById("timebox").innerHTML ="";							
					}
				}
			    
			}



			function changeFunction(x) {			
				
				 if(x=="message"){
					document.getElementById("messagebox").innerHTML ="<input class=\"form-control\" type=\"text\" name=\"text\">";
				}
				
				else if(x=="date"){					

					document.getElementById("monthbox").innerHTML ="<select class='mainselection btn btn-default' name=\"month\">\
						<option  value=\"default\">choose</option>\
						<option  value=\"Jan\">Jan</option>\
						<option  value=\"Feb\">Feb</option>\
						<option  value=\"Mar\">Mar</option>\
						<option value=\"Apr\">Apr</option>\
						<option value=\"May\">May</option>\
						<option value=\"Jun\">Jun</option>\
						<option value=\"Jul\">Jul</option>\
						<option value=\"Aug\">Aug</option>\
						<option value=\"Sep\">Sep</option>\
						<option value=\"Oct\">Oct</option>\
						<option value=\"Nov\">Nov</option>\
						<option value=\"Dec\">Dec</option>\
						</select>";
					var y="<select class='btn btn-default mainselection dayselection' id=\"day\" name=\"day\">";
					    y+="<option value='0' selected='selected'>0</option>";
						for(var i=1;i<=31;i++){
							y+="<option  value=\""+i+"\">"+i+"</option>";
						
						}
							y+="</select>";	

					   document.getElementById("monthbox").innerHTML +=y;

				}

				else if(x=="time"){
					
					var y="<select class='mainselection btn btn-default' id=\"time\" name=\"time\">";

						for(var i=1;i<=24;i++){
							y+="<option  value=\""+i+"\">"+i+"</option>";
						
						}
							y+="</select>";	

					document.getElementById("timebox").innerHTML =y;
				}
			}
		</script>

</body>

</html>
<?php
}
?>