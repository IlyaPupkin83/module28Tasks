<?php
include_once 'product.php';
include_once 'user.php';
include_once 'delivery.php';
include_once 'discount.php';
include_once 'basket.php';
include_once 'order.php';

interface interfaceObservable
{
	function addObserver($observer);
}

interface InterfaceObserver
{
	function onChanged($sender, $args);
}

class Shop implements interfaceObserver
{
	private $products = array();
	private $customers = array();
	private $orders = array();
	private $deliveries = array();
	private $couriers = array();
	private $baskets = array();
	private ProductList $productList;
	private CustomerList $customerList;
	private OrderList $orderList;
	private DeliveriesList $deliveryList;
	private CourierList $courierList;
	private BasketList $basketList;

	public function __construct()
	{
		$this->products = array();
		$this->productList = new ProductList($this->products);
		$this->customerList = new CustomerList($this->customers, $this);
		$this->orderList = new OrderList($this->orders);
		$this->deliveryList = new DeliveriesList($this->deliveries);
		$this->courierList = new CourierList($this->couriers);
		$this->basketList = new BasketList($this->baskets);
	}

	public function getProductList()
	{
		return $this->productList;
	}

	public function getCourierList()
	{
		return $this->courierList;
	}

	public function getCustomerList()
	{
		return $this->customerList;
	}

	public function getBasketList()
	{
		return $this->basketList;
	}

	public function getOrderList()
	{
		return $this->orderList;
	}

	public function getDeliveryList()
	{
		return $this->deliveryList;
	}

	public function check(Basket $Basket)
	{
		$сurrentCustomer = $Basket->getCustomer();
		$products = $Basket->getProductList();
		$newOrder = $this->orderList->addOrder($сurrentCustomer, $products);
		$Basket->setDefault();
		return $newOrder;
	}

	public function onChanged($sender, $args)
	{
		$this->basketList->addBasket($args);
	}
}

class DeliveriesList
{
	private $deliveries;

	public function __construct(array &$Deliveries)
	{
		$this->deliveries = $Deliveries;
	}

	public function addDelivery(Order $Order, array $Couriers)
	{
		$newDelivery = DeliveryFactory::Create($Order, $Couriers);
		array_push($this->deliveries, $newDelivery);
		return $newDelivery;
	}

	public function getDeliveries()
	{
		return $this->deliveries;
	}
}

class OrderList
{
	private $orders;

	public function __construct(array &$Orders)
	{
		$this->orders = $Orders;
	}

	public function addOrder(Customer $Customer, array $Products)
	{
		$newOrder = OrderFactory::Create($Customer, $Products);
		array_push($this->orders, $newOrder);
		$discount = new Discount();
		$discount->addCommand(new PercentDiscount());
		$discount->addCommand(new DeliveryDiscount());
		$discount->runCommand(new DeliveryDiscount());
		return $newOrder;
	}

	public function getOrders()
	{
		return $this->orders;
	}
}

class BasketList
{
	private $baskets;

	public function __construct(array &$Baskets)
	{
		$this->baskets = $Baskets;
	}

	public function addBasket(Customer $Customer)
	{
		array_push($this->baskets, BasketFactory::Create($Customer));
	}

	public function getCustomerBasket(Customer $Customer)
	{
		foreach ($this->baskets as $basket) {
			if ($basket->getCustomer() === $Customer) return $basket;
		}
	}
}

class ProductList
{
	private $products;

	public function __construct(array &$Products)
	{
		$this->products = $Products;
	}

	public function addProduct(string $Name, int $Quantity = 0)
	{
		$newProduct = ProductFactory::Create($Name, $Quantity);
		array_push($this->products, $newProduct);
		return $newProduct;
	}

	public function getProductList()
	{
		return $this->products;
	}

	public function getProduct(int $Index)
	{
		if (isset($this->products[$Index])) {
			return $this->products[$Index];
		} else {
			return null;
		}
	}
}

class CustomerList implements interfaceObservable
{
	private $customers;
	private $_observers = array();

	public function __construct(array &$Customers, Shop $Shop)
	{
		$this->customers = $Customers;
		$this->addObserver($Shop);
	}

	public function addCustomer(string $Name, string $Surname = '', string $phone, string $Email, string $Address, int $Type = 0)
	{
		$new_customer = CustomerFactory::Create($Name, $Surname, $phone, $Email, $Address, $Type);
		array_push($this->customers, $new_customer);
		foreach ($this->_observers as $obs)
			$obs->onChanged($this, $new_customer);
	}

	public function addObserver($observer)
	{
		$this->_observers[] = $observer;
	}

	public function getCustomerList()
	{
		return $this->customers;
	}

	public function getCustomer(int $Index)
	{
		if (isset($this->customers[$Index])) {
			return $this->customers[$Index];
		} else {
			return null;
		}
	}
}

class CourierList
{
	private $couriers;

	public function __construct(array &$Couriers)
	{
		$this->couriers = $Couriers;
	}

	public function addCourier(string $Name, string $Surname = '', string $phone, string $Email, string $Address, int $Worktime = 0, int $TransportType = 0)
	{
		array_push($this->couriers, CourierFactory::Create($Name, $Surname, $phone, $Email, $Address, $Worktime, $TransportType));
	}

	public function getCourierList()
	{
		return $this->couriers;
	}

	public function getCourier(int $Index)
	{
		if (isset($this->couriers[$Index])) {
			return $this->couriers[$Index];
		} else {
			return null;
		}
	}
}
