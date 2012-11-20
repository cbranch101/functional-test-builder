<?php

	class Test_Builder {
		
		static function buildTest($testConfig) {
			$test = $testConfig['test'];
			$input = $testConfig['build_input']();
			$output = $testConfig['get_output']($input);
			$asserts = $testConfig['asserts'];
			$assertArgs = $testConfig['get_assert_args']($output);
			self::callAsserts($asserts, $test, $assertArgs);
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
