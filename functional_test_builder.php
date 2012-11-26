<?php

	class Test_Builder {
		
		static function buildTest($testConfig) {
			$test = $testConfig['test'];
			$input = $testConfig['build_input']();
			$output = $testConfig['get_output']($input);
			$asserts = $testConfig['asserts'];
			$assertArgs = $testConfig['get_assert_args']($output);
			$onTestComplete = isset($testConfig['on_test_complete']) ? $testConfig['on_test_complete'] : null;
			self::callAsserts($asserts, $test, $assertArgs);
			
			if($onTestComplete) {
				$onTestComplete($output);
			}
		}
		
		static function callAsserts($asserts, $test, $assertArgs) {
			
			foreach($asserts as $assertName => $args) {
				
				$argsToAssert = array();
				foreach($args as $argKey) {
					array_push($argsToAssert, $assertArgs[$argKey]);
				}
				
				call_user_func_array(array($test, $assertName), $argsToAssert);
			}
			
		}		
		
		
		
	}
