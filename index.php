<?php

require_once 'simple_html_dom.php';
// creating a table where our scrapped data will be stored

echo  "<table border=1 cellspacing=5 cellpadding=5; ' ><th>Product name</th><th>Price</th>";


//button if when pressed will run the code below
if(isset($_POST['button1'])) { 

//get html content from the site.

$dom = file_get_html('https://www.jumia.co.ke/mens-polos/', false);



//collect the different items into array
$answer = array();
if(!empty($dom)) {
	$divClass = $title = $i = 0;
	foreach($dom->find(".prd") as $divClass) {
		//Item_name
		foreach($divClass->find(".name") as $name ) {
			$answer[$i]['name'] = $displayname = $name->plaintext;
			// echo $answer[0]['name'];
		}
		//price
		foreach($divClass->find(".prc") as $price ) {
			$answer[$i]['price'] = $displayprice = $price->plaintext;


			// loop so as to fetch whatever is in the div
			$i = $i ++;
		}
//  passing the crapped data into the vreated table table 

		echo "<tr><td>$displayname</td><td>$displayprice</td></tr>";
		

	
	

	// connecting to the database

	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "jumia";
	
	
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	
	if (!$conn) {
		die("Connection failed: " . mysqli_connect_error());
	}
	
	$sql = "INSERT INTO products (item, price)
	VALUES ('$displayname','$displayprice')";
	
	if (mysqli_query($conn, $sql)) {
		echo "success!!!";
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}
	
	mysqli_close($conn);
}
}
}


?>

<!-- the button -->

	<form method="post"> 

		<input type="submit" name="button1" id="button"
				value="Tap to scrap" onclick= "word()"
style="background-color: yellow; 
color:black; 
margin-top:10%; 
margin-left:45%;
 width:150px; 
height:50px; 
font-size:larger;
border: 2px solid red; border-radius:8px; box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
outline: none;
"
				> 

				<!-- the information that will be displayed -->
				<p id="text" style="margin-left:40%;font-size:30px;  ">
					
						
					
				</p>
				<script>
function word()  {
  document.getElementById("text").innerHTML = "Scrapping has started please wait............ ";
}
</script>

	</form> 
