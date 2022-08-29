# php-class-generator

This component creates model classes from json schema files

# Functional Usage

accounts.yaml
```
name: accounts
type: object
properties:
  personId:
    type: integer
  firstname:
    type: string
  lastname:
    type: string
  email:
    type: string
  type:
    type: string
  lastChanged:
    type: string
```

generateAccounts.php
```
fluxPhpClassGenerator\generateModelClass(
        __DIR__ . '/accounts.yaml',
        'FluxCap\ExampleApp\Core\Domain\Models',
        __DIR__ . '/generated'
);
```

generates: Accounts.php
```
<?php
namespace FluxCap\ExampleApp\Core\Domain\Models;

use JsonSerializable;

class Accounts implements JsonSerializable {

	private int $personId;

	private string $firstname;

	private string $lastname;

	private string $email;

	private string $type;

	private string $lastChanged;

	private function __construct(
		int $personId,
		string $firstname,
		string $lastname,
		string $email,
		string $type,
		string $lastChanged,
	) {
		$this->personId = $personId;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
		$this->email = $email;
		$this->type = $type;
		$this->lastChanged = $lastChanged;
	}

	public static function new(
		int $personId,
		string $firstname,
		string $lastname,
		string $email,
		string $type,
		string $lastChanged,
	): self {
		return new self(
			$personId, $firstname, $lastname, $email, $type, $lastChanged
		);
	}

	final public function getPersonId(): int {
		return $this->personId;
	}

	final public function getFirstname(): string {
		return $this->firstname;
	}

	final public function getLastname(): string {
		return $this->lastname;
	}

	final public function getEmail(): string {
		return $this->email;
	}

	final public function getType(): string {
		return $this->type;
	}

	final public function getLastChanged(): string {
		return $this->lastChanged;
	}

	final public function toJson(): string {
		return json_encode($this, JSON_THROW_ON_ERROR);
	}

	final public function toArray(): array {
		return get_object_vars($this);
	}
	final public function jsonSerialize(): array {
		return $this->toArray();
	}
}
```

## Contributing :purple_heart:

Please ...

1. ... register an account at https://git.fluxlabs.ch
2. ... create pull requests :fire:

## Adjustment suggestions / bug reporting :feet:

Please ...

1. ... register an account at https://git.fluxlabs.ch
2. ... ask us for a Service Level Agreement: support@fluxlabs.ch :kissing_heart:
3. ... read and create issues
