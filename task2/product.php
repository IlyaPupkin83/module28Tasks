<?php
interface interfaceProduct
{
	function changeQuantity(int $value);
}

class Product implements interfaceProduct
{
	static int $idcounter = 0;
	private int $id;
	private string $name;
	private int $quantity;

	public function __construct(string $Name, int $Quantity = 0)
	{
		$this->id = static::$idcounter;
		static::$idcounter = static::$idcounter + 1;
		$this->name = $Name;
		if ($Quantity < 0) {
			$Quantity = 0;
		}
		$this->quantity = $Quantity;
	}

	public function GetName()
	{
		return $this->name;
	}

	public function GetID()
	{
		return $this->id;
	}

	public static function GetLastID()
	{
		return static::$idcounter;
	}


	public function changeQuantity(int $value)
	{
		if ($this->quantity + $value < 0) {
			$this->quantity = 0;
		} else
			$this->quantity = $this->quantity + $value;
	}

	public function getQuantity()
	{
		return $this->quantity;
	}
}

class ProductFactory
{
	public static function Create(string $Name, int $Quantity = 0)
	{
		return new Product($Name, $Quantity);
	}
}
