<?php
/* This is an automated generated class by flux-eco/php-class-generator */
namespace FluxEco\ExampleApp\Domain\Models;


class Accounts {


	private function __construct(
		public int $personId,
		public string $firstname,
		public string $lastname,
		public string $email,
		public string $type,
		public DateTime $lastChanged,
	) {
		$this->properties["personId"] = $personId;
		$this->properties["firstname"] = $firstname;
		$this->properties["lastname"] = $lastname;
		$this->properties["email"] = $email;
		$this->properties["type"] = $type;
		$this->properties["lastChanged"] = $lastChanged;
	}
	public static function new(
		int $personId,
		string $firstname,
		string $lastname,
		string $email,
		string $type,
		DateTime $lastChanged,
	): self {
		return new self(
			$personId,
			$firstname,
			$lastname,
			$email,
			$type,
			$lastChanged,
		);
	}

}