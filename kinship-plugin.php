<?php
/*
Plugin Name: Kinship Management Plugin
Plugin URI: https://github.com/voltainc/kinship
Description: Kinship Management Plugin.
Version: 1.0.0
Author: voltainc
Author URI: https://github.com/voltainc
License: GPL2
*/
require_once ('boot.php');

add_action('admin_menu', 'menus');
function menus() {
	
add_menu_page('Kinship-Plugin | Dashboard', 'Kinship-Plugin', 'manage_options' ,'slDashboard', 'cfDashboard', 'dashicons-wordpress');
  
add_submenu_page( 'slDashboard', 'Kinship-Plugin | Person', 'Person', 'manage_options', 'slPerson','cfPerson');

add_submenu_page( 'slDashboard', 'Kinship-Plugin | Kinship', 'Kinship', 'manage_options', 'slKinship','cfKin');
  
  
//add_submenu_page( 'Kinship', 'kinship', 'addPerson', 'manage_options', 'addPerson','addPerson');
}

function cfDashboard() {
 echo "<centre><h2>Welocme to Kinship Management Plugin</h2></centre>";
}

function cfPerson() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'person';
  
  if(isset($_GET['act']) && $_GET['act']=="addPerson"){
		
		if(isset($_POST['addperson'])){
			
			$name = trim(@$_POST['newname']);
			$age = trim(@$_POST['newage']);
			
			if($name!='' AND $age!=''){
				
				if(strlen($name)>=5){
					
					if(!is_int($age)){
						
						$q = $wpdb->query("SELECT * from $table_name WHERE name='{$name}' AND age='{$age}'");
							if(!$q){
								$wpdb->query("INSERT INTO $table_name(name,age) VALUES('$name','$age')");
								echo "<script>alert('Person added');location.replace('admin.php?page=slPerson');</script>";
							}else{
								echo "<script>alert('Person already exists');</script>";
							}
							}else{
								echo "<script>alert('Age must be a number');</script>";
							}
				}else{
					echo "<script>alert('Name must be 5 characters long');</script>";
				}
				
			}else{
				echo "<script>alert('Name and Age are required');</script>";
			}
		}
	  ?>
	  
	<div class="wrap">
    <h2>Add Person</h2>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th width="25%">User ID</th>
          <th width="25%">Name</th>
          <th width="25%">Age</th>
          <th width="25%">Actions</th>
        </tr>
      </thead>
      <tbody>
		 <form action="" method="post">
          <tr>
            <td><input type="text" value="AUTO_GENERATED" disabled></td>
            <td><input type="text" id="newname" name="newname"></td>
            <td><input type="text" id="newage" name="newage"></td>
            <td><button id="newsubmit" name="addperson" type="submit">INSERT</button></td>
          </tr>
        </form>
	  </tbody>  
    </table>
  </div>
	  <?php
  }
  elseif(isset($_GET['act']) && $_GET['act']=="editPerson"){
	  
	if(isset($_POST['updatePerson']))
	{
		$id = trim(@$_POST['upid']);
		$name = trim(@$_POST['upname']);
		$age = trim(@$_POST['upage']);
			
			if($name!='' AND $age!='' AND $age!=''){
				
				if(strlen($name)>=5){
					
					if(!is_int($age))
					{
						
						$q = $wpdb->query("SELECT * from $table_name WHERE name='{$name}' AND age='{$age}' AND id <> '{$id}'");
							if(!$q){
								$wpdb->query("UPDATE $table_name SET name='$name',age='$age' WHERE id='$id'");
								echo "<script>alert('Person Updated');location.replace('admin.php?page=slPerson');</script>";
							}else{
								echo "<script>alert('Person already exists');</script>";
							}
							
					}else{
						echo "<script>alert('Age must be a number');</script>";
					}
				}else{
					echo "<script>alert('Name must be 5 characters long');</script>";
				}
				
			}else{
				echo "<script>alert('Name and Age are required');</script>";
			}
	}
			
	  
	$id = trim(@$_GET['id']);
	if($id!='')
	{
		$result = $wpdb->get_results("SELECT * FROM $table_name WHERE id='$id'");
		foreach($result as $print) {
		  $name = $print->name;
		  $age = $print->age;
		}
		echo "
		<div class='wrap'>
		<h2>Edit Person</h2>
			<table class='wp-list-table widefat striped'>
			  <thead>
				<tr>
				  <th width='25%'>User ID</th>
				  <th width='25%'>Name</th>
				  <th width='25%'>Age</th>
				  <th width='25%'>Actions</th>
				</tr>
			  </thead>
			  <tbody>
				<form action='' method='post'>
				  <tr>
					<td width='25%'>$print->id <input type='hidden' id='upid' name='upid' value='$print->id'></td>
					<td width='25%'><input type='text' id='upname' name='upname' value='$print->name'></td>
					<td width='25%'><input type='text' id='upage' name='upage' value='$print->age'></td>
					<td width='25%'><button id='editPerson' name='updatePerson' type='submit'>UPDATE</button><button type='button'>CANCEL</button></a></td>
				  </tr>
				</form>
			  </tbody>
			</table>
		</div>
		";
		
	}else{
		echo "<script>alert('Invalid Id');location.replace('admin.php?page=slPerson');</script>";
	}
  }
  elseif(isset($_GET['act']) && $_GET['act']=="deletePerson"){
	  
  }
  else{
  
  
  ?>
  <div class="wrap">
    <h2>Person <a href="admin.php?page=slPerson&act=addPerson" class="page-title-action">Add New</a></h2>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th width="25%">ID</th>
          <th width="25%">Name</th>
          <th width="25%">Age</th>
          <th width="25%">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $result = $wpdb->get_results("SELECT * FROM $table_name");
          foreach ($result as $print) {
            echo "
              <tr>
                <td width='25%'>$print->id</td>
                <td width='25%'>$print->name</td>
                <td width='25%'>$print->age</td>
                <td width='25%'><a href='admin.php?page=slPerson&act=editPerson&id=$print->id'><button type='button'>UPDATE</button></a> <a href='admin.php?page=slPerson&act=deletePerson&id=$print->id'><button type='button'>DELETE</button></a></td>
              </tr>
            ";
          }
        ?>
      </tbody>  
    </table>
  </div>
  <?php
  }
}