<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="topcv.css">
</head>
<body>
	<?php

		$con = mysqli_connect("localhost","root","","cv");
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		$userid = $_COOKIE['cv_id'];
		$sql = "SELECT * FROM user_info WHERE id=$userid";
		$result = mysqli_query($con, $sql);
		if ($result) {
			$row = mysqli_fetch_row($result);
			$fullname = $row[1];
			$birthday = $row[2];
			$gender = $row[3];
			$address = $row[4];
			$phone = $row[5];
			$email = $row[6];
			$avatar = $row[7];
			$pos_job = $row[8];
			$education = $row[9];
			$working_process = $row[10];
			$society_activities = $row[11];
			$skills = $row[12];
			$experiences = $row[13];
			$certifications = $row[14];
			$hobbies = $row[15];
			$desire = $row[16];
			mysqli_free_result($result);
		}

		#chuyển dấu cách trong html thành dấu xuống dòng
		function normalstr($str)
		{
			while (strpos($str, "\n")) {
				$str = str_replace("\n", "<br>", $str);
			}
			return $str;
		}
	?>

	<div class="container">
		<div class="basic_container">
			<img class="avatar" src="<?php echo $avatar; ?>">
			<div class="basic_info_container">
				<span class="fullname">
					<?php
					echo $fullname;
					?>
				</span>
				<table>
					<tr>
						<td style="width: 200px" class="job">Position want to apply:</td>
						<td class="job">
							<?php
							echo $pos_job;
							?>
						</td>
					</tr>
				</table>
				<table class="info">
					<tr>
						<td style="width: 100px;" class="info_n">Birthday:</td>
						<td>
							<?php
							echo date("d-m-Y",strtotime($birthday));
							?>
						</td>
					</tr>
					<tr>
						<td class="info_n">Gender:</td>
						<td>
							<?php
								echo $gender;
							?>
						</td>
					</tr>
					<tr>
						<td class="info_n">Address:</td>
						<td>
							<?php
								echo $address;
							?>
						</td>
					</tr>
					<tr>
						<td class="info_n">Phone number:</td>
						<td>
							<?php
								echo $phone;
							?>
						</td>
					</tr>
					<tr>
						<td class="info_n">Email:</td>
						<td>
							<?php
								echo $email;
							?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="field_container">
			<span class="field_n">Education process</span>
			<hr>
			<span>
				<?php
					echo normalstr($education);
				?>
			</span>
		</div>
		<div class="field_container">
			<span class="field_n">Working process</span>
			<hr>
			<span>
				<?php
					echo normalstr($working_process);
				?>
			</span>
		</div>
		<div class="field_container">
			<span class="field_n">Society activities</span>
			<hr>
			<span>
				<?php
					echo normalstr($society_activities);
				?>
			</span>
		</div>
		<div class="field_container">
			<span class="field_n">Skills</span>
			<hr>
			<span>
				<?php
					echo normalstr($skills);
				?>
			</span>
		</div>
		<div class="field_container">
			<span class="field_n">Experiences</span>
			<hr>
			<span>
				<?php
					echo normalstr($experiences);
				?>
			</span>
		</div>
		<div class="field_container">
			<span class="field_n">Certifications</span>
			<hr>
			<span>
				<?php
					echo normalstr($certifications);
				?>
			</span>
		</div>
		<div class="field_container">
			<span class="field_n">Hobbies</span>
			<hr>
			<span>
				<?php
					echo normalstr($hobbies);
				?>
			</span>
		</div>
		<div class="field_container">
			<span class="field_n">Desire</span>
			<hr>
			<span>
				<?php
					echo normalstr($desire);
				?>
			</span>
		</div>
	</div>
</body>
</html>