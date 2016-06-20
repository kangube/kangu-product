<?php
	include("../php-assets/class.dbconfig.php");

	$conn = Db::getInstance();

	// Gathering the given data
	$child_parent = htmlspecialchars($_POST['childParent']);
	$child_name = htmlspecialchars($_POST['childName']);
	$child_age = htmlspecialchars($_POST['childAge']); 
    $child_school = htmlspecialchars($_POST['childSchool']);
    $child_class = htmlspecialchars($_POST['childClass']);

    // Processing the given children name
	$child_full_name = explode(' ', $child_name, 2);
	$child_first_name = $child_full_name[0];
	$child_last_name = $child_full_name[1];

	// Adding the newly created child to the database
	$add_child_statement = $conn->prepare("INSERT INTO tbl_child(child_first_name, child_last_name, child_age, child_school, child_class) VALUES('$child_first_name', '$child_last_name', '$child_age', '$child_school', '$child_class')");
	$add_child_statement->execute();

	// Recovering the newly created child id
	$child_last_created_id = $conn->lastInsertId();

	// Linking the newly created child to the corresponding parent
	$link_child_statement = $conn->prepare("INSERT INTO tbl_user_child(fk_user_id, fk_child_id) VALUES('$child_parent', '$child_last_created_id')");
	$link_child_statement->execute();

	echo $child_last_created_id;
?>