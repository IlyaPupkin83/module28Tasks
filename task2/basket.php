<?php
interface iBasket
{
	function addProduct(Product $Product, int $Quantity);
	function removeProduct(Product $Product);
	function changeProductQuantity(Product $Product, int $Quantity);
	function getProductList();
}

class Basket implements iBasket
{
	private $customer;
	private $products = array();

	public function __construct(Customer $Customer)
	{
		$this->customer = $Customer;
	}

	public function setDefault()
	{
		unset($this->products);
	}

	public function getCustomer()
	{
		return $this->customer;
	}

	public function addProduct(Product $Product, int $Quantity)
	{
		$index = $this->searchProduct($Product);
		if ($Product->getQuantity() > 0 && $Product->getQuantity() - $Quantity >= 0) {
			if ($index > 0) {
				$this->$Product[$index][1] = $Product[$index][1] + $Quantity;
			} else {
				$newProduct = array($Product, $Quantity);
				array_push($product, $newProduct);
				$Product->changeQuantity(-$Quantity);
			}
		} else {
			echo "Продукта нет в наличии" . '</br>';
		}
	}

	public function removeProduct(Product $Product)
	{
		$index = $this->searchProduct($Product);
		if ($index > 0) {
			$Product->changeQuantity($this->$Product[$index][1]);
			array_splice($this->$Product, $index, 1);
		}
	}

	public function changeProductQuantity(Product $Product, int $Quantity)
	{
		$index = $this->searchProduct($Product);
		if ($index > 0) {
			$this->$Product[$index][1] = $Product[$index][1] + $Quantity;
		}
	}

	public function getProductList()
	{
		return $this->products;
	}

	private function searchProduct(Product $Product)
	{
		$index = 0;
		$founded = false;
		foreach ($this->products as $currentProd) {
			if ($currentProd[0] === $Product) {
				array_splice($this->products, $index, 1);
				$founded = true;
				break;
			}
			$index++;
		}
		if ($founded) {
			return $index;
		} else {
			return -1;
		}
	}
}

class BasketFactory
{
	public static function Create(Customer $Customer)
	{
		return new Basket($Customer);
	}
}
