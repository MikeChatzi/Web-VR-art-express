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
      <script src="https://aframe.io/releases/1.3.0/aframe.min.js"></script> 
	  <script src="https://unpkg.com/aframe-event-set-component@4.2.1/dist/aframe-event-set-component.min.js"></script>
	  <script src="https://code.jquery.com/jquery-3.6.0.min.js "></script>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">

	<script>
		
			/*
			*	Ftiaxno to component showhideform gia to antikeimeno poy an to klikaro tha anoigei ti forma
			*  	Otan ginetai klik tha kalei ti function showHideForm()
			*/
			AFRAME.registerComponent('showhideform', 
			{
				init: function () 
				{
					this.el.addEventListener('click', function (evt) 
					{
						console.log('Click on: ', evt.detail.intersection.object.el.id);
						
					});
					
				}
			});
			
			/*
			*	H function showHideForm() anoigokleinei ti forma
			*	mporei na kaleitai apo to component kai apo to X button tis formas
			*/
			function showHideForm()
			{
				//console.log(document.getElementById('switch').getAttribute('data-switch'));
			
				if  (document.getElementById('myDiv').style.display=='block') // an i forma einai emfanis tha klisei
				{
					
					document.getElementById('myDiv').style.display='none';
					//document.getElementById('player').setAttribute('look-controls', {pointerLockEnabled: true});
					//document.querySelectorAll('[geometry="primitive\: box"]').setAttribute('material', {shader: 'flat', color:'white'}); // epanafero to xroma tou antikeimenoy
					//document.getElementById('switch').setAttribute('data-switch', -1);
				}
				else if (document.getElementById('myDiv').style.display=='none') // an i forma einai kleisti
				{
					//if (document.getElementById('switch').getAttribute('data-switch') == 1)
					//{
						document.getElementById('myDiv').style.display='block'; // emfanisi formas
						//document.getElementById('player').setAttribute('look-controls', {enabled: false});
						//document.querySelectorAll('[geometry="primitive\: box"]').setAttribute('material', {shader: 'flat', color:'red'}); // markarisma antikeimenou
						
					//}
					
					/*
					let temp = document.getElementById('switch').getAttribute('data-switch')
					if (temp <= 0)
					{
						temp++;
						document.getElementById('switch').setAttribute('data-switch', temp);
					}
					*/
				}
			}

			/* AFRAME.registerComponent('create-boxes',
			{
				init: function ()
				{
					document.getElementById('btnn').addEventListener('click', function (evt)
					{
						var preSrc = document.querySelector('#defbox3').getAttribute('src');
						var currSrc = 'canva-' + (parseInt(preSrc.split('-')[1]) + 1);
						var prePos = document.querySelector('#defbox3').getAttribute('position');

						var box = document.createElement('a-entity');
						box.setAttribute('geometry', 'primitive: box;');
						box.setAttribute('position', prePos + ' 1 0');
						box.setAttribute('material', 'src: #' + currSrc);

						document.querySelector('#scene').appendChild(box);
					}
					)
				}
					

			}
			); */
		
		</script>	
	  
      
</head>
<body>
	  <div id="myDiv" style="display:none; position:absolute; top:50%; left:30%; z-index:10; border-style:solid;">
			Upload Form
			<button style="position:absolute; right:0%;" onclick="showHideForm();">X</button>
			<form id="form" method="post" enctype="multipart/form-data" class="w-50">
					
					<?php inputFields("","userfile","","file") ?>
					
					<button id="btnn" class="btn btn-dark" type="submit" name="submit">Submit</button>
				</form>
		</div>

		<?php

	
	if (isset($_POST['submit'])){
		$files=$_FILES['userfile'];
		
		

		$filename=$files['name'];
		$filetmpname=$files['tmp_name']; 
		$filerror=$files['error'];
		$filetype=explode('.',$filename);
		$truefiletype=strtolower(end($filetype));

		$extensions=array('jpeg','jpg','png');
		if(in_array($truefiletype,$extensions)){
				$file_upload='passed/'.$filename;
				move_uploaded_file($filetmpname,$file_upload);
				$db="insert into `filez` (userfile) values('$file_upload')";
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
				 <?php 
				
				
	            $res=mysqli_query($conn, 'SELECT id, userfile FROM filez');
	            while($row=mysqli_fetch_array($res))
				{
			    		$canvases = array();
			    		$canvases[] = "canva-'.$row['id'].'";
					echo '<img id="canva-'.$row['id'].'" src="'.$row['userfile'].'">';
				}

				?>
			 </a-assets>

	         <a-entity id="player" 
		             camera look-controls  
					 wasd-controls="acceleration:20" 
					 position="0 2 5">
                    <a-cursor position="0 0 -0.1" scale="0.1 0.1 0.1"> </a-cursor>
             </a-entity>

			<a-entity light="type: directional; color: #ffff00; intensity: 0.5"> </a-entity>
			 <a-entity light="type: ambient; color: #FFF; intensity: 0.9"> </a-entity> 

	        <a-entity geometry="primitive: plane; height: 20; width: 20" 
               material="src: #Wall0; color: #F3F3ED; side: double" 
               rotation="90 0 0"> 
            </a-entity>


			<a-entity geometry="primitive: plane; height: 10; width: 20" 
               material="src: #Wall0; color: #F3F3ED; side: double" 
			   position="-10 5 0"
               rotation="0 90 0"> 
            </a-entity>

			<a-entity geometry="primitive: plane; height: 10; width: 20" 
               material="src: #Wall0; color: #F3F3ED; side: double" 
			   position="10 5 0"
               rotation="0 90 0"> 
            </a-entity>
			
			<?php 
			
				for ($i = 0; $i < count($canvases); $i++)
				{
					$newBox = "<a-entity id=\"defbox\"
					  material=\"".$canvases[$i]."\  geometry=\"primitive: box\"
					  position=\"2 0 0\"
					  onclick=\"showHideForm();\"
					  showhideform>
					  </a-entity>";
					
					echo $newBox;
				}
			
			?>

			<!--
			<a-entity id="defbox"
					  material="src: #canva-1"
					  geometry="primitive: box"
					  position="2 0 0"
					  onclick="showHideForm();"
					  showhideform>
					  </a-entity>

					  <a-entity id="defbox2"
					  material="src: #canva-2"
					  geometry="primitive: box"
					  position="4 0 0"
					  onclick="showHideForm();"
					  showhideform>
					  </a-entity>

					  <a-entity id="defbox3"
					  material="src: #canva-3"
					  geometry="primitive: box"
					  position="6 0 0"
					  onclick="showHideForm();"
					  showhideform>
					  </a-entity>
					  
			-->
			<a-sky color="#ECECEC"></a-sky>
            </a-scene>

	

			
			  
  
             
</body>
</html>
