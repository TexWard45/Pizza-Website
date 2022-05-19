<?php
class Cart {
    private $pizzaId;
    private $sizeId;
    private $baseId;
    private $quantity;

    public function __construct($pizzaId, $sizeId, $baseId, $quantity) {
        $this->pizzaId = $pizzaId;
        $this->sizeId = $sizeId;
        $this->baseId = $baseId;
        $this->quantity = $quantity;
    }

    public function getPizzaId() { return $this->pizzaId; }
    public function setPizzaId($pizzaId) { $this->pizzaId = $pizzaId; return $this; }
    public function getSizeId() { return $this->sizeId; }
    public function setSizeId($sizeId) { $this->sizeId = $sizeId; return $this; }
    public function getBaseId() { return $this->baseId; }
    public function setBaseId($baseId) { $this->baseId = $baseId; return $this; }
    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; return $this; }
}
?>