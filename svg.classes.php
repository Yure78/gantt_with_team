<?php 
class coord {
	public function __construct($x,$y){
		$this->x = $x + 0;
		$this->y = $y + 0;
	}
	public function __toString(){
		return $this->x.','.$this->y;
	}
}

?>