<?php
class Order
{
	private $customer;
	private $products = array();
	private $deliveryTime;
	private $dicountType;

	public function __construct(Customer $Customer, array $Products)
	{
		$this->customer = $Customer;
		$this->products = $Products;
		$this->deliveryTime = rand(0, 1);
		$this->dicountType = rand(0, 1);
	}

	public function getDeliveryTime()
	{
		return $this->deliveryTime;
	}
}

class OrderFactory
{
	public static function Create(Customer $Customer, array $Products)
	{
		return new Order($Customer, $Products);
	}
}
