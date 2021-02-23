<?php
interface interfaceCommand
{
	function onCommand($name);
}

class Discount
{
	private $_commands = array();
	public function addCommand($cmd)
	{
		$this->_commands[] = $cmd;
	}

	public function runCommand($name)
	{
		foreach ($this->_commands as $cmd) {
			if ($cmd->onCommand($name))
				return;
		}
	}
}

class PercentDiscount implements InterfaceCommand
{
	public function onCommand($type)
	{
		if ($type == 0) {
			echo "У Вас имеется процентная скидка" . '</br>';
		} else echo  "У Вас отсутствует процентная скидка" . '</br>';
	}
}

class DeliveryDiscount implements interfaceCommand
{
	public function onCommand($type)
	{
		if ($type == 1) {
			echo "у Вас имеется скидка на доставку" . '</br>';
		} else {
			echo  "У Вас отсутствует скидка на доставку" . '</br>';
		}
	}
}
