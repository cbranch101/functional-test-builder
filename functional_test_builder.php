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
		
		static function confirmExpected($expected, $actual) {
			
			$output = self::confirmThatEverythingInExpectedIsInActual($expected, $actual);
			$output = self::confirmThatThereIsNothingExtraInActual($expected, $actual, $output);
			return $output;
			
		}
		
		static function confirmThatThereIsNothingExtraInActual($expected, $actual, $output) {
			foreach($actual as $actualKey => $actualValue) {
				
				$extraValue = array_key_exists($actualKey, $expected) ? null : $actualValue;
				
				if($extraValue) {
				
					$output[$actualKey]['extra_value_in_actual'] = $extraValue;
					
				}
				
			}
			return $output; 
		}
		
		static function confirmThatEverythingInExpectedIsInActual($expected, $actual) {
			
			$output = array();
			foreach($expected as $expectedKey => $expectedValue) {
				
				$actualValue = array_key_exists($expectedKey, $actual) ? $actual[$expectedKey] : 'not_found';
									
				if($expectedValue == $actualValue) {
					
					$output[$expectedKey] = 'ok';
					
				} else {
				
					$output[$expectedKey]['expected'] = $expectedValue;
					$output[$expectedKey]['actual'] = $actualValue;
					
				}
				
			}
			
			return $output;
		}		
		
		
		
	}
