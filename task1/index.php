<?php
class HTMLTagRemove
{
	private $iterator;
	private $dom = [];

	public function __construct(string $DocName)
	{
		try {
			$this->dom = file($DocName, FILE_SKIP_EMPTY_LINES);
			$this->iterator = new HTMLIterator($this->dom);
		} catch (Exception $a) {
			echo "Файл не читается" . $a . '</br>';
		}
	}

	public function removeTag(string $TagName, string $AttributeName, string $AttributeValue)
	{
		$this->iterator->rewind();
		do {
			$currentVal = str_replace(' ', '', $this->iterator->current());
			$srch = preg_match("(\<{$TagName})", $currentVal);
			if ($srch) {
				$srch = preg_match("({$AttributeName}=\"{$AttributeValue}\")", $currentVal);
				if ($srch) {
					echo "Удаляемое значение:" . htmlspecialchars($currentVal) . '</br>';
					array_splice($this->dom, $this->iterator->key(), 1);
				} else {
					$this->iterator->next();
				}
			} else {
				$this->iterator->next();
			}
		} while ($this->iterator->valid());
	}

	public function save(string $FileName = null)
	{
		if (!is_null($FileName)) {
			file_put_contents($FileName, $this->dom);
		} else {
			file_put_contents('user.html', $this->dom);
		}
	}
}

class HTMLIterator implements Iterator
{
	private $position = 0;
	private $dom = [];

	public function __construct(array &$Dom)
	{
		$this->position = 0;
		$this->dom = &$Dom;
	}

	public function rewind()
	{
		$this->position = 0;
	}

	public function current()
	{
		return $this->dom[$this->position];
	}

	public function key()
	{
		return $this->position;
	}

	public function next()
	{
		++$this->position;
	}

	public function valid()
	{
		return isset($this->dom[$this->position]);
	}
}

//проверка
$domr = new HTMLTagRemove('index.html');
$domr->removeTag('meta', 'name', 'keywords');
$domr->removeTag('meta', 'name', 'description');
$domr->save('index1.html');
