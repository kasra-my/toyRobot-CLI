<?php

/**
*
* This class is to validate the toy-robot placement and movement
*
*/

class Validation
{


	// This will be displayed if user input is not valid for toy-robot placement
	private const ENTER_VALID_ENTRY    	= "\n\nPlease enter valid inputs separated by comma like this 0,3,east: \n\n\n";

	// This will be displayed if movement is not valid due to position and facing of the toy-robot
	private const INVALID_MOVEMENT 		= "The new movevement is not possible otherwise toy-robot will fall off the table!";

	// Table dimentions. Counting starts from 0, so it's actually 5 units!
	private const X_UNITS               = 4;
	private const Y_UNITS               = 4;

	private const DIRECTIONS 		    =  ['north','east','west','south'];

	/** 
	* Validate the user's inputs for x, y or face of the toy-robot
	* @param string $uesrInput
	* @return array
	*/
	public function validateUserInputs(string $userInput): array
	{
		$inputArr = explode(",", $userInput);
		$errorMsg = [];

		// Check how many comma separated values are in the string,
		// if it is not exactly equal to 3, throw error
		if (count($inputArr) !== 3){
			$errorMsg[] = self::ENTER_VALID_ENTRY;
			return $errorMsg;
		}

		$vals = $this->prepapareValues($userInput);

		$x    =  $vals[0];
		$y    =  $vals[1];
		$face =  $vals[2];

		if ($x ==="" || Self::X_UNITS < $x  || $x < 0){
			$errorMsg[] = "\nThis `$x` is not valid for X. \n";
		}

		if ($y ===""  || Self::Y_UNITS < $y  || $y < 0){
			$errorMsg[] = "\nThis `$y` is not valid for Y \n";
		}		

		if( trim($face) =="" || !in_array($face, Self::DIRECTIONS) ){
			$errorMsg[] = "\nThis `$face` is not valid for FACE! \n";
		}


		return $errorMsg;
	}

	/**
	* Prepare values (e.g. removes characters from X and Y and only keeps the numbers)
	* @param string $uesrInput
	* @return array
	*/
	public function prepapareValues(string $userInput): array
	{
		$inputArr = explode(",", $userInput);

		$x    = preg_replace("/[^\d]/", "", $inputArr[0]);
		$y    = preg_replace("/[^\d]/", "", $inputArr[1]);
		$face = strtolower(trim($inputArr[2]));

		return [$x,$y,$face];
	}


	/**
	* Checks whether the new move is possible or not
	* @return string
	* @param int $x
	* @param int $y
	* @param string $face
	*/
	public function validateMovement(int $x, int $y, string $face): string
	{
		$error ="";

		switch ($face) {
			case 'north':
				if ($y + 1 > Self::Y_UNITS){
					$error = Self::INVALID_MOVEMENT;
				}
				break;
			case 'east':
				if ($x + 1 > Self::X_UNITS){
					$error = Self::INVALID_MOVEMENT;
				}
				break;
			case 'west':
				if ($x - 1 < 0){
					$error = Self::INVALID_MOVEMENT;
				}
				break;
			case 'south':
				if ($y - 1 < 0){
					$error = Self::INVALID_MOVEMENT;
				}	
				break;
			}

		return $error;
	}


}

?>