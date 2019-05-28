<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Reptichart--!>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/icons/favicon.ico">
    <title>Reptichart</title>

    <!--Highcharts files--!>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script type="text/javascript" src="../includes/graph_data.js" ></script>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/navbar-top-fixed.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/style-graph-form.css">

  </head>

  <body>

    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="../">Reptichart</a>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link" href="../">Live</a>
          </li>	  
          <li class="nav-item active">
            <a class="nav-link" href="./">Graphs</a>
          </li>
        </ul>
      </div>
    </nav>
    
    <h1>Graphs</h1>
	<div class="center-float"><span>
        <div class="horizontal-floating-box">
        <form action="?name=$name&dbtype=$dbtype&count=$count">
	    <p>Who?
	    <select name="name">
	    <?php
		include '../includes/graph_name_options.php';
            ?>
            </select>
            Which DB?
	    <select name="dbtype">
		<option value="detailed">Detailed</option>
		<option value="archive">Archive</option>
	    </select>
            </p>
	    </select>
	 </div>
         <div class="horizontal-floating-box">
	    <p>How much Data?<input type="text" name="count" value="">
	    
	    <select name="type">
                <option value="hours">Hours</option>
                <option value="days">Days</option>
                <option value="weeks">Weeks</option>
		<option value="months">Months</option>
		<option value="years">Years</option>
                <option value="readings">Readings</option>
	    </select>
		<input type="submit" value="Submit"></p>
         </div>
	</div>
        </span>
	</form>

	

    <div id="chart" style="height: 80%; margin: 0 auto"></div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<!--    <script src="./js/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>	--!>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
  

</body></html>

