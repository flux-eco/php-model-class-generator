<?php
/* This is an automated generated class by flux-eco/php-class-generator */
namespace FluxEco\ExampleApp\Domain\Models;


class DateTime {


	private function __construct(
		public string $date,
		public string $time,
	) {
		$this->properties["date"] = $date;
		$this->properties["time"] = $time;
	}
	public static function new(
		string $date,
		string $time,
	): self {
		return new self(
			$date,
			$time,
		);
	}

}