<?php

require_once('./functions.php');
include ('./connection.php');

?>

<!DOCTYPE html>

<html>
<!-- lang="en" xmlns="http://www.w3.org/1999/xhtml"  charset="utf-8" -->
<head>
      <title>Test Art</title>
		<meta name="Art of Today" content="VR room decor"> 
		<script src="https://aframe.io/releases/1.4.0/aframe.min.js"></script> 
		<script src="https://unpkg.com/aframe-event-set-component@4.2.1/dist/aframe-event-set-component.min.js"></script>
	    <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
	    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<script>
			AFRAME.registerComponent('showtext', {
			  init: function () {
				  var msg = document.querySelector('#msg-1');
				  this.el.addEventListener('mouseenter', function () {
				   msg.setAttribute('text', {value:this.id});
				  
						msg.setAttribute('visible', {value:true});
					 
						

					 
						 
					});
				 
			  
		}});

			/*
			*	Ftiaxno to component showhideform gia to antikeimeno poy an to klikaro tha anoigei ti forma
			*  	Otan ginetai klik tha kalei ti function showHideForm()
			*/
		
			
			/*
			*	H function showHideForm() anoigokleinei ti forma
			*	mporei na kaleitai apo to component kai apo to X button tis formas
			*/
			function showHideForm()
			{
				
			
				if  (document.getElementById('myDiv').style.display=='block') // an i forma einai emfanis tha klisei
				{
					
					document.getElementById('myDiv').style.display='none';
				
				}
				else if (document.getElementById('myDiv').style.display=='none') // an i forma einai kleisti
				{
						document.getElementById('myDiv').style.display='block'; // emfanisi formas
				
					
				
				}
			}

		</script>	
	  
      
</head>
<body>
	  <div id="myDiv" style="display:none; position:absolute; top:50%; left:30%; z-index:10; border-style:solid;">
			Upload Form
			<button style="position:absolute; right:0%;" onclick="showHideForm();">X</button>
			<form id="form" method="post" enctype="multipart/form-data" class="w-50">
					
					<?php inputFields("","userfile","","file") ?>
					<?php inputFields("Write something","text","","text") ?>

					<button id="btnn" class="btn btn-dark" type="submit" name="submit">Submit</button>
				</form>
		</div>

		<?php

	
	if (isset($_POST['submit'])){
		$files=$_FILES['userfile'];
		$captions=$_POST['text'];
		
		

		$filename=$files['name'];
		$filetmpname=$files['tmp_name']; 
		$filerror=$files['error'];
		$filetype=explode('.',$filename);
		$truefiletype=strtolower(end($filetype));

		$extensions=array('jpeg','jpg','png');
		if(in_array($truefiletype,$extensions)){
				$file_upload='passed/'.$filename;
				move_uploaded_file($filetmpname,$file_upload);
				$db="insert into `filez` (userfile, textt) values('$file_upload', '$captions')";
				$result=mysqli_query($conn,$db);
				if(!$result){
					die(mysqli_error($conn));
				} 
				
		}
	}
	
	



?>
		
		

		<a-scene id="scene" style="z-index:1">
	  
	         <a-assets>
			     <img id="Wall0" src="textures/Wall01.jpg">
				 <img id="Sky" src="textures/skyz.jpg">
				 <?php 
				
				
	            $res=mysqli_query($conn, 'SELECT id, userfile FROM filez');
	            while($row=mysqli_fetch_array($res))
				{
					echo '<img id="canva-'.$row['id'].'" src="'.$row['userfile'].'">';
				}

				?>
			 </a-assets>


			  <a-entity id="rig" position"25 10 0" rotation="0 180 0">
	         <a-entity id="player" 
			 camera look-controls  
					 wasd-controls="acceleration:20"
					 position="0 1.6 -1">
					 <a-cursor rayOrigin="mouse" position="0 0 -0.1" scale="0.1 0.1 0.1"> </a-cursor>
                    <a-entity id="msg-1" text="" visible="false" scale="1.3 1.3 0" position="0 -0.7 -1"
                     rotation="0 0 0"> </a-entity> 
             </a-entity>
 </a-entity>
			<a-entity light="type: directional; color: #ffff00; intensity: 0.5"> </a-entity>
			 <a-entity light="type: ambient; color: #FFF; intensity: 0.9"> </a-entity> 

	        <a-entity geometry="primitive: plane; height: 20; width: 20" 
               material="src: #Wall0; color: #F3F3ED; side: double" 
			   position="0 0 9"
               rotation="90 0 0"> 
            </a-entity>


			<a-entity geometry="primitive: plane; height: 10; width: 20" 
               material="src: #Wall0; color: #F3F3ED; side: double" 
			   position="-10 5 9"
               rotation="0 90 0"> 
            </a-entity>

			<a-entity geometry="primitive: plane; height: 10; width: 20" 
               material="src: #Wall0; color: #F3F3ED; side: double" 
			   position="10 5 9"
               rotation="0 90 0"> 
            </a-entity>
			
			<a-entity geometry="primitive: cylinder"
					position="-2 1 5"
					onclick="showHideForm();"
					>
					</a-entity>
	
			<?php 
			
			$ress=mysqli_query($conn, 'SELECT id, textt FROM filez');
				$newPosit= 1;
	           while($roww=mysqli_fetch_array($ress))
				{
				if($roww['id']>= 18){
					
				   echo '<a-entity 
				
				id="'.$roww['textt'].'"
					  event-set__leave="_event: mouseleave; _target: #msg-1; visible: false"
					  material="src: #canva-'.$roww['id'].'"
					  geometry="primitive: box"
					  position="-9.995 2 '.$newPosit.'"
					  scale="0.005 0.5 0.8"
					  raycaster-intersector
					  showtext>
					  </a-entity> ' ;
					 $newPosit++;
				} else {
					echo '<a-entity 
				
				id="'.$roww['textt'].'"
					  event-set__leave="_event: mouseleave; _target: #msg-1; visible: false"
					  material="src: #canva-'.$roww['id'].'"
					  geometry="primitive: box"
					  position="-9.995 1 '.$roww['id'].'"
					  scale="0.005 0.5 0.8"
					  raycaster-intersector
					  showtext>
					  </a-entity> ' ;
				}  
				}
			?>
			
			
			<a-sky material="src: #Sky" color="#ECECEC"></a-sky>
            </a-scene>

	

			
			  
  
             
</body>
</html>
