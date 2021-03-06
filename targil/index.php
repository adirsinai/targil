<?php
$num_results = (! empty($_POST['num_results'])) ? $_POST['num_results'] : 20;
$delta = (! empty($_POST['delta'])) ? $_POST['delta'] : 24;
$reduce_brightness = (isset($_POST['reduce_brightness'])) ? $_POST['reduce_brightness'] : 1;
$reduce_gradients = (isset($_POST['reduce_gradients'])) ? $_POST['reduce_gradients'] : 1;

include_once("colors.inc.php");
$ex=new GetMostCommonColors();
$colors=$ex->Get_Color("test.jpg", $num_results, $reduce_brightness, $reduce_gradients, $delta);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
	<title>Image Color Extraction</title>
	
	 <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
		* {margin: 0; padding: 0}
		body {text-align: center;}
		form, div#wrap {margin: 10px auto; text-align: left; position: relative; width: 500px;}
		fieldset {padding: 20px; border: solid #999 2px;}
		img {width: 200px;}
		table {border: solid #000 1px; border-collapse: collapse;}
		td {border: solid #000 1px; padding: 2px 5px; white-space: nowrap;}
		br {width: 100%; height: 1px; clear: both; }
		table{margin: 0 auto;}
		

	</style>
</head>
<body>
<div id="wrap">
<form action="#" method="post" enctype="multipart/form-data">
<fieldset>
<legend>Upload Your Own Image</legend>
<div>
    <label>File: <input type="file" name="imgFile" /></label>
</div>
<input type="hidden" class="form-control" name="num_results" value="5" />

    <input type="submit" class="btn" name="action" value="Process" />
</div>
</fieldset>
</form>
<?php
// was any file uploaded?
if ( isset( $_FILES['imgFile']['tmp_name'] ) && strlen( $_FILES['imgFile']['tmp_name'] ) > 0 )
{
	// move image to a writable directory
	if (! move_uploaded_file($_FILES['imgFile']['tmp_name'], 'images/'.$_FILES['imgFile']['name']))
	{
		die("Error moving uploaded file to images directory");
	}
	$colors=$ex->Get_Color( 'images/'.$_FILES['imgFile']['name'], $num_results, $reduce_brightness, $reduce_gradients, $delta);
?>
<table>
<tr><td>Color</td><td>Color Code</td><td>Percentage</td><td rowspan="<?php echo (($num_results > 0)?($num_results+1):22500);?>"><img src="<?='images/'.$_FILES['imgFile']['name']?>" alt="test image" /></td></tr>
<?php
foreach ( $colors as $hex => $count )
{
	if ( $count > 0 )
	{
		echo "<tr><td style=\"background-color:#".$hex.";\"></td><td>".$hex."</td><td>".$count * 100  ."%" ."</td></tr>";
	}
}
?>
</table>
<br />
<?php
}
?>

<?php
$colors=$ex->Get_Color("images/test.jpg", $num_results, $reduce_brightness, $reduce_gradients, $delta);
?>

<br />
</div>
</body>
</html>
