<?php 
$incremental = 1;
abstract class svg {
	public function __toString(){
        $title = '';
        if(isset($this->title) AND $this->title){
            $title = '<title>'.$this->title.'</title>';
        }
		return "
        <".$this->tag." ".$this->attr.' id="'.$this->id.'" >
            '.$title.'
		</'.$this->tag.'>';
	}
	public function string_com_function($function,$prefId=''){
		$title = '';
        if(isset($this->title) AND $this->title){
            $title = '<title>'.$this->title.'</title>';
        }
        return "<".$this->tag." ".$this->attr.' onclick="'.$function.'" id="'.$prefId.$this->id.'" >
		'.$title.'
		</'.$this->tag.'>';
	}
}
abstract class quadrado extends svg{
   
   public function __construct(coord $a, coord $b, coord $c, coord $d, $id, $attr='fill="transparent" stroke="black"'){
      $this->a = $a;
      $this->b = $b;
      $this->c = $c;
      $this->d = $d;
      $this->attr = " points=\"$a $b $d $c\" ".$attr."  style=\"opacity: 1;\"";
	  $this->id = $id;
	  $this->tag = 'polygon';
   }
   
}