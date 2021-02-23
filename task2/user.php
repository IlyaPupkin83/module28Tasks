<?php
interface interfaceUser
{
	function getName();
	function getSurname();
	function getEmail();
	function getAddress();
	function getPhone();
}

abstract class User implements interfaceUser
{
	static int $idcounter = 0;
	private int $id;
	private string $name;
	private string $surname;
	private string $email;
	private string $address;
	private string $phone;

	public function __construct(string $Name, string $Surname = '', string $Phone, string $Email, string $Address)
	{
		$this->id = static::$idcounter;
		static::$idcounter = static::$idcounter + 1;
		$this->name = $Name;
		$this->surname = $Surname;
		$this->email = $Email;
		$this->address = $Address;
		$this->phone = $Phone;
	}

	public function GetName()
	{
		return $this->name;
	}

	function getSurname()
	{
		return $this->surname;
	}

	function getEmail()
	{
		return $this->email;
	}

	function getAddress()
	{
		return $this->address;
	}

	function getPhone()
	{
		return $this->phone;
	}
}

interface interfaceCourier
{
	function getTransportType();
	function getWorktime();
}

class Courier extends User implements interfaceCourier
{
	private $transportType;
	private $workTime;

	public function __construct(string $Name, string $Surname = '', string $Phone, string $Email, string $Address, int $Worktime = 0, int $TransportType = 0)
	{
		$this->id = static::$idcounter;
		static::$idcounter = static::$idcounter + 1;
		$this->name = $Name;
		$this->surname = $Surname;
		$this->workTime = $Worktime;
		$this->transportType = $TransportType;
		$this->phone = $Phone;
		$this->email = $Email;
		$this->address = $Address;
	}

	public function getWorktime()
	{
		return $this->workTime;
	}

	function getTransportType()
	{
		return $this->transportType;
	}
}

class CourierFactory
{
	public static function Create(string $Name, string $Surname = '', string $phone, string $Email, string $Address, int $Worktime = 0, int $TransportType = 0)
	{
		return new Courier($Name, $Surname, $phone, $Email, $Address, $Worktime, $TransportType);
	}
}

interface iCustomer
{
	function getType();
	function getStatus();
	function setStatus(int $Status);
}

class Customer extends User implements iCustomer
{
	private static $types = array(
		0 => 'normal',
		1 => 'VIP'
	);
	private static $statuses = array(
		0 => 'new',
		1 => 'not active'
	);

	private $type;
	private $status;

	public function __construct(string $Name, string $Surname = '', string $Phone, string $Email, string $Address, int $Type = 0)
	{
		$this->id = static::$idcounter;
		static::$idcounter = static::$idcounter + 1;
		$this->name = $Name;
		$this->surname = $Surname;
		$this->address = $Address;
		$this->type = static::$types[$Type];
		$this->phone = $Phone;
		$this->email = $Email;
		$this->setStatus(0);
	}

	public function getType()
	{
		return $this->type;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function setStatus(int $Status)
	{
		$this->status = static::$statuses[$Status];
	}
}

class CustomerFactory
{
	public static function Create(string $Name, string $Surname = '', string $phone, string $Email, string $Address, int $Type = 0)
	{
		return new Customer($Name, $Surname, $phone, $Email, $Address, $Type);
	}
}
