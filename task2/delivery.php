<?php
interface interfaceStrategy
{
	function findCourier(int $DeliveryTime);
}

class CarDelivery implements interfaceStrategy
{
	private $couriers;

	public function __construct(array &$Couriers)
	{
		$this->couriers = $Couriers;
	}

	public function findCourier(int $DeliveryTime)
	{
		$returnArray = array();
		foreach ($this->couriers as $courier) {
			if ($courier->getTransportType() == 0 && $courier->getWorktime() == $DeliveryTime)
				array_push($returnArray, $courier);
		}
		return $returnArray;
	}
}

class BikeDelivery implements interfaceStrategy
{
	private $couriers;

	public function __construct(array &$Couriers)
	{
		$this->couriers = $Couriers;
	}

	public function findCourier(int $DeliveryTime)
	{
		$returnArray = array();
		foreach ($this->couriers as $courier) {
			if ($courier->getTransportType() == 1 && $courier->getWorktime() == $DeliveryTime)
				array_push($returnArray, $courier);
		}
		return $returnArray;
	}
}


interface interfaceDelivery
{
	function findCourier(interfaceStrategy $strategy);
}

class Delivery implements interfaceDelivery
{
	private Order $order;
	private $courier;
	private $couriers = array();

	public function __construct(Order &$Order, array &$Couriers)
	{
		$this->order = $Order;
		$this->couriers = $Couriers;
	}

	public function getCourier()
	{
		return $this->courier;
	}

	public function findCourier(interfaceStrategy $strategy)
	{
		$returnMassive = $strategy->findCourier($this->order->getDeliveryTime());
		return $returnMassive;
	}

	public function setCourier()
	{
		$carCourier = $this->findCourier(new CarDelivery($this->couriers));
		$bikeCourier = $this->findCourier(new BikeDelivery($this->couriers));
		if (count($bikeCourier) > 0) {
			$this->courier = $bikeCourier;
		} elseif (count($carCourier) > 0) {
			$this->courier = $carCourier;
		} else echo "К сожалению, в настоящее время нет свободных курьеров" . '</br>';
	}
}

class DeliveryFactory
{
	public static function Create(Order $Order, array $Couriers)
	{
		return new Delivery($Order, $Couriers);
	}
}
