<?php

/**
* Get user inputs
*/
class UserCommand
{

	private const ENTER_COMMAND       	= "\n\nPlease enter your command (e.g. PLACE, MOVE, LEFT, RIGHT, REPORT, EXIT): \n\n\n";
	private const ENTER_PLACE         	= "\nEnter the placement details (e.g. 0,0,north): \n\n\n";

	/**
	* User command
	* @var string
	*/
	private $cmd;


	/**
	* User input
	* @var string
	*/
	private $userImput;

	/**
	* Get user's command
	*/
	public function getUserCommand($msg = self::ENTER_COMMAND){

		echo $msg;

		$command = trim(fgets(STDIN, 1024));

		if ($command === 'exit') {
			return false;
		}

		$this->cmd = $command;	

		return true;
	}

	/**
	* gets the user inputs of placement details of the toy-robot
	*/
	public function getPlacementDetails($msg = Self::ENTER_PLACE)
	{
		echo $msg;

		// Get the placement details
		$input = trim(fgets(STDIN, 1024));

		if ($input === 'exit') {
			die(Self::GOODBYE);
		}

		$this->userInput = $input;
	}

	/**
	* Getter for user command
	*/
	public function getCmd(): string
	{
		return $this->cmd;
	}

	/**
	* Getter for user input
	*/
	public function getUserInput(): string
	{
		return $this->userInput;
	}

}


?>
