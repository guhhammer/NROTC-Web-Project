<?php 
	
	function get_photo_information($photo){

		$photo_ = "";
		if ($photo === ""){   $photo_ = "src=\"../../IMAGES/Default_User_Image/user.PNG\"";  }
		else{

			$image = imagecreatefromstring($photo[0]); 
			ob_start();
			imagejpeg($image, null, 80);
		    $data = ob_get_contents();
			ob_end_clean();

			$photo_ = 'src="data:image/jpg;base64,' .  base64_encode($data)  . '"';
		
		}	

		return 
		(

			"<div id=\"my_photo\" class=\"home_div\">".
				"<table align=\"center\">".
					"<tr>"."<td colspan=\"4\" style=\"width: 100%;\">"."<img ".$photo_." id=\"photo\" style=\"width: 350px; height: 350px;\">"."</td>"."</tr>".
					"<tr>".
						"<td style=\"width: 25%;\"><p style=\"color: blue;\" id=\"link\">

							<button id=\"my_photo_click\" class=\"pop_up_click_initial_button\">(edit)</button>

						</p></td>".
						"<td style=\"width: 25%;\"><p></p></td>"."<td style=\"width: 25%;\"><p></p></td>"."<td style=\"width: 25%;\"><p></p></td>".
					"</tr>".
				"</table>".
			"</div>"

		);

	}

?>