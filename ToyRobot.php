<?php

require_once "Validation.php";
require_once "UserCommand.php";

class ToyRobot
{

	private const EXIT_COMMAND 	        = "\n\nTo exit the game at anytime, enter exit!\n\n";

	private const WELCOME         	    = "Welcome to the Toy-robot game! \n\n";
	private const GOODBYE         	    = "Thank you and see you next time! \n\n";

	private const INVALID_COMMAND    	= "\n\nPlease enter a valid command (PLACE, MOVE, LEFT, RIGHT, REPORT, EXIT): \n\n\n";
	private const REPORT   	            = "\n\nThe position and direction report is as follows: ";

	private const VALID_COMMANDS 		=  ['place','move','left','right','exit'];

	/**
	* @var UserCommand
	*/
	private $userCommand;

	/**
	* X position of the toy-robot on table
	* @var int
	*/
	private $x;

	/**
	* Y position of the toy-robot on table
	* @var int
	*/
	private $y;

	/**
	* Facing direction fot he toy-robot
	* @var string
	*/
	private $face;


	/**
	* @var Validation
	*/
	private $validation;


	public function __construct(){
		
		// default position and face of the toy-robot
		$this->x    = 0;
		$this->y    = 0;
		$this->face = 'north';

		$this->validation = new Validation();
		$this->userCommand = new UserCommand();
	}


	/**
	* Start the game!
	*/
	public function start()
	{
		echo Self::EXIT_COMMAND;
		echo Self::WELCOME;

		while ($this->userCommand->getUserCommand()) {

			switch (strtolower($this->userCommand->getCmd())) {
				case 'place':
					$this->userCommand->getPlacementDetails();
					$errorMsgs = $this->validation->validateUserInputs($this->userCommand->getUserInput());

					// Echo error messages if there is any
					if(!empty($errorMsgs)){
						foreach ($errorMsgs as $key => $err) {
							echo $key . ': ' . $err . "\n";
						}
						break;
					}

					$this->setPlacementDetails();

					break;
				case 'move':
					$error = $this->validation->validateMovement($this->x, $this->y, $this->face);
					if ( $error===""){
						$this->move();
					}else{
						echo $error;
					}

					break;
				case 'left':
					$this->setDirection('left');
					break;
				case 'right':
					$this->setDirection('right');
					break;
				case 'report':
					echo $this->report();
					break;					
				default:
					echo Self::INVALID_COMMAND;
					break;
			}

			if (strtolower($this->userCommand->getCmd()) !== 'report'){
				echo $this->report();
			}

		}
	}

	/**
	* Sets the new placement details of the toy-robot entered by user
	*/
	private function setPlacementDetails(): void
	{

		$vals = $this->validation->prepapareValues($this->userCommand->getUserInput());

		$this->x    = $vals[0];
		$this->y    = $vals[1];
		$this->face = $vals[2];
	}


	/**
	* Moves the toy 1 unit forward based on the current direction
	*/
	private function move()
	{
		switch ($this->face) {
			case 'north':
				$this->y += 1;
				break;
			case 'east':
				$this->x += 1;
				break;
			case 'west':
				$this->x -= 1;
				break;
			case 'south':
				$this->y -= 1;
				break;
			}
	}

	/**
	* Sets the facing direction of the toy-robot
	* @param string $direction
	*/
	private function setDirection($direction): void
	{
		if ($direction === 'left'){
			switch ($this->face) {
				case 'north':
					$this->face = 'west';
					break;
				case 'east':
					$this->face = 'north';
					break;
				case 'south':
					$this->face = 'east';
					break;
				case 'west':
					$this->face = 'south';
					break;
			}
		} else{
			switch ($this->face) {
				case 'north':
					$this->face = 'east';
					break;
				case 'east':
					$this->face = 'south';
					break;
				case 'south':
					$this->face = 'west';
					break;
				case 'west':
					$this->face = 'north';
					break;
			}
		}
	}

	/**
	* Report the last place and face of the toy-robot
	* @return string
	*/
	private function report()
	{
		return Self::REPORT . $this->x . ',' . $this->y . ',' . $this->face;
	}

}


?>