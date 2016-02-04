<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<title>Venue Site</title>
<script type="text/javascript">

</script>

<style type="text/css">
.FormBar{
  width:100%;
  height:50px;
  left: 0px;
  float:left;
  position: fixed;
  top: 0px;
  z-index: 1;
  background-color:#005ce6;	
}

.LeftBar{
	position: fixed;
    top: 0px;
    left: 0px;
    padding-top: 50px;
    padding-bottom: 0;
    height: 100%;
    width: 300px;
    background-color:#0066ff;
    overflow:scroll;
}

.Content{
	position: fixed;
    top: 50px;
    left: 300px;
    width:100%;
    height:100%;
}

.venue {
    background: #1a75ff;
    margin-top: 10px;
    margin-bottom: 10px;
    overflow: hidden;
    padding: 5px .5%;
    position: relative;
    width: auto;
}

.floating-box {
    display: inline-block;
    margin-right: 20px;
}

</style>

</head>
<body>

<?php 
	var_dump($_GET);
	include_once 'db_retieve.php';
?>


<div class="FormBar"> 
	<div class="floating-box">
		<h2>Venue Site</h2>
	</div>
	<div class="floating-box">
		<form action="/venue"  method="get"> 
		 Location:
			<input  style="display: inline;" type="text" name="location" placeholder="Enter a location here">
		 Distance:
			<select  style="display: inline;"name="distance">
				<option value="5000">5km</option>
				<option value="10000">10km</option>
				<option value="15000">15km</option>
			</select>
			<input  style="display: inline;" type="submit" value="Search">
		</form>
	
	</div>
	<div class="floating-box">
		<form action="/venue"  method="get"> 
		 Keyword:
		  <input type="text"  style="display: inline;" name="category" placeholder="Something like 'Pizza'">
		  <input type="submit"  style="display: inline;" value="Search">
		</form>
	</div>		
</div>

<div class="LeftBar"> 
<?php 
	if(isset($venues)){
		while ($venue = $venues->fetchArray()){
			echo '<div class ="venue">';
			echo '<p>' .$venue['name'] . '</p>';
			echo '<p>' .$venue['categories'] . '</p>';
			echo '</div>';
		}
	}
?>

</div>

<div class="content">
<iframe
  width="100%"
  height="100%"
  frameborder="0" style="border:0"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyB-C_CEWwKx2C8THaIM4bByzx2yBaza_HM&q=Singapore" allowfullscreen>
</iframe>
</div>

</body>
</html>