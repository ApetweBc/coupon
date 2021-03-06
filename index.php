<?php
	
	if (isset($_POST['length'])) {
		include 'class.coupon.php';
		$no_of_coupons = $_POST['no_of_coupons'];
		$length = $_POST['length'];
		$prefix = $_POST['prefix'];
		
		$suffix = $_POST['suffix'];
		$numbers = $_POST['numbers'];
		
		$letters = $_POST['letters'];
		$symbols = $_POST['symbols'];
		$random_register = $_POST['random_register'] == 'false' ? false : true;
		$mask = $_POST['mask'] == '' ? false : $_POST['mask'];
		
		$coupons = coupon::generate_coupons($no_of_coupons, $length, $prefix, $suffix, $numbers, $letters, $symbols, $random_register, $mask);
		// var_dump($coupons);
		foreach ($coupons as $key => $value) {
			echo 'PDL-'. $value."\n ";
		}
		die();
	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Protec Dental Laboratories - Coupon Code Generator</title>
	 <!-- Bootstrap -->
	<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<style>
		.hide{
			display:none;
		}
		body{
			background-color: #899;
		}
		.main{
			background-color: #fff;
		}
		.top-bottom{
			margin: 15px 0;
		}
		.header{
			color: #2d5286;
		}
	</style>
</head>
<body>
	<div class="container main">
		<div class="row top-bottom">
			<div class="col-md-4 col-sm-12">
				<img src="images/coupon.png" alt="coupon" style="width: 205px; height: 60px;">
			</div>
			<div class="col-md-8 col-sm-12">
				<h2 class="header">Coupon Code Generator</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form action="index.php" method="post" id="coupon_form">
					<table class="table table-striped">
						<tr>
							<th>Parameter</th>
							<th>Type</th>
							<th>Default</th>
							<th>Custom value</th>
						</tr>
						<tr>
							<th>Number of coupons</th>
							<td>number</td>
							<td>1</td>
							<td><input class="form-control" type="number" name="no_of_coupons" value="1" min="1"/></td>
						</tr>
						<tr class="hide">
							<th>Length</th>
							<td>number</td>
							<td>10</td>
							<td><input class="form-control" type="number" name="length" value="10" min="1" /></td>
						</tr>
						<tr class="hide">
							<th>Prefix</th>
							<td>string</td>
							<td></td>
							<td><input class="form-control" type="text" name="prefix" value="" /></td>
						</tr>
						<tr class="hide">
							<th>Suffix</th>
							<td>string</td>
							<td></td>
							<td><input class="form-control" type="text" name="suffix" value="" /></td>
						</tr>
						<tr class="hide">
							<th>Numbers</th>
							<td>boolean</td>
							<td>true</td>
							<td>
								<select class="form-control" name="numbers">
								  	<option value="false">False</option>
								  	<option selected value="true">True</option>
								</select>
							</td>
						</tr>
						<tr class="hide">
							<th>Letters</th>
							<td>boolean</td>
							<td>true</td>
							<td>
								<select class="form-control" name="letters">
								  	<option value="false">False</option>
								  	<option selected value="true">True</option>
								</select>
							</td>
						</tr>
						<tr class="hide">
							<th>Symbols</th>
							<td>boolean</td>
							<td>false</td>
							<td>
								<select class="form-control" name="symbols">
								  	<option selected value="false">False</option>
								  	<option value="true">True</option>
								</select>
							</td>
						</tr>
						<tr class="hide">
							<th>Random register</th>
							<td>boolean</td>
							<td>false</td>
							<td>
								<select class="form-control" name="random_register">
								  	<option selected value="false">False</option>
								  	<option value="true">True</option>
								</select>
							</td>
						</tr>
						<tr class="hide">
							<th>Mask</th>
							<td>string or boolean</td>
							<td>false</td>
							<td><input class="form-control" type="text" name="mask" value="XXX-XXX" /></td>
						</tr>
					</table>
					<div class="col-md-offset-8 col-md-4">
						<button type="submit" class="btn btn-success pull-right">Generate</button>
						<br/><br/>
					</div>
					<hr />
						<textarea class="form-control" placeholder="Result here" id="result" rows="10" readonly=""></textarea>
					<hr />
					<div class="col-md-offset-8 col-md-4">
						<button type="button" onclick="exporttocsv()" class="btn btn-success pull-right">Export Codes to Excel</button>
					</div>
					<br/><br/><br/><br/><br/>
				</form>
			</div>
		</div>
	</div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript">
	$(document).ready(function(){
		$('#coupon_form').submit(function() {
			var no_of_coupons = $('input[name="no_of_coupons"]').val();
			var length = $('input[name="length"]').val();
			var prefix = $('input[name="prefix"]').val();
			// console.log($prefix);
			var suffix = $('input[name="suffix"]').val();
			var numbers = $('select[name="numbers"]').val();
			var letters = $('select[name="letters"]').val();
			var symbols = $('select[name="symbols"]').val();
			var random_register = $('select[name="random_register"]').val();
			var mask = $('input[name="mask"]').val();

			$('#result').load('index.php', {
				no_of_coupons: no_of_coupons,
				length: length,
				prefix: prefix,
				suffix: suffix,
				numbers: numbers,
				letters: letters,
				symbols: symbols,
				random_register: random_register,
				mask: mask
			});
			return false;
		});
	});

	function exporttocsv() {
		if ($('#result').val()) {
			var a = document.createElement('a');
			with (a) {
				href='data:text/csv;base64,' + btoa($('#result').val());
				download='csvfile.csv';
			}
			document.body.appendChild(a);
			a.click();
			document.body.removeChild(a);
	        }
        };
	</script>
</body>
</html>
