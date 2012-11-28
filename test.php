<?php

	require_once('functional_test_builder.php');
	
	$expected = array(
		'c' => array(
			'v' => 1,
			'test2' => 1,
		),
		array(
			'1',
			'2',
		),	
		array(
			'3',
			'4',
		),	


	);
	
	$actual = array(
		array(
			'1',
			'2',
		),	
		array(
			'3',
		),	
		array(
			'2',
		),	
	);
		
	$output = Test_Builder::confirmExpected($expected, $actual);
	
	echo json_encode($output);
	 
	
	
