<?php 

/* S_Event
 *
 * Simple event
 * 
 * Only the start, end, and status attributes.
*/

class S_Event {
	function __construct($ini,$fim,$status='Aguardando'){
		$this->ini = $ini;
		$this->fim = $fim;
		$this->status = $status;
	}
}

/* Gantt with Teams
 *
 * 
*/
class gantt_with_team{
	public $translate;
	function __construct($idioma,$title=null,$team=null,$line=null){
		$this->languages = json_decode(file_get_contents('includes/translate.json'));
		$this->idioma = substr($idioma, 0,2);
		$this->idioma_completo = $idioma;
		$idioma = $this->idioma;
		if(is_null($title)){
			$this->title = htmlentities($this->languages->$idioma->grafico_gantt);	
		}
		else{
			$this->title = $title;
		}

		if(is_null($team)){
			$this->team = htmlentities($this->languages->$idioma->equipe);	
		}
		else{
			$this->team = $team;
		}

		if(is_null($line)){
			$this->line = htmlentities($this->languages->$idioma->tarefa);	
		}
		else{
			$this->line = $line;
		}
		
		
		
		$this->current = new DateTime();
		$this->date_format = 'dd/MM';
		$this->fullNameMonths = false;
		$this->yearWithTwoDigits = false;
		$this->separator = ' - ';
	}
	function team($team,$color=''){
		if(!isset($this->teams[$team])){
			$this->teams[$team] = $color;
		}
		$this->active = $team;
	}
	function current(DateTime $DateTime){
		$this->current = $DateTime;
	}
	function date_format($value){
		$this->date_format = $value;
	}
	function add($line,S_Event $S_Event){
		$ini = new DateTime($S_Event->ini);
		if(!isset($this->minDate)){
			$this->minDate = $ini;
		}
		elseif($this->minDate->format('U') > $ini->format('U')){
			$this->minDate = $ini;
		}
		$fim = new DateTime($S_Event->fim);
		if(!isset($this->maxDate)){
			$this->maxDate = $fim;
		}
		elseif($this->maxDate->format('U') < $fim->format('U')){
			$this->maxDate = $fim;
		}
		$this->lines[$this->active][$line] = $S_Event;
	}
	function start(){
		return  new DateTime($this->minDate->format('Y-m-01'));
	}
	function end(){
		return  new DateTime($this->maxDate->format('Y-m-t'));
	}
	function format($date){
		$this->dateFormatter = IntlDateFormatter::create($this->idioma_completo,IntlDateFormatter::NONE,IntlDateFormatter::NONE,date_default_timezone_get(),IntlDateFormatter::GREGORIAN,$this->date_format);
		return htmlentities($this->dateFormatter->format($date));
	}
	function __toString(){
		$idioma = $this->idioma;
		$mes   = new DateInterval('P1M');
		$dia  = new DateInterval('P1D');
		$hoje = $this->current;
		$today = htmlentities($this->languages->$idioma->hoje);
		
		if($this->yearWithTwoDigits){
			$yearFormat = 'y';
		}
		else{
			$yearFormat = 'Y';
		}
		if($this->fullNameMonths){
			$NameMonths = 'meses';
		}
		else{
			$NameMonths = 'meses_abreviados';
		}
		$retorno = '
		<link href="includes/css/gantt_with_team.css" rel="stylesheet">
		<style>
		.hoje {
			background-image: url("data:image/gif;base64,R0lGODlhAgACAIABAAAAAP///yH+EUNyZWF0ZWQgd2l0aCBHSU1QACwAAAAAAgACAAACAoRRADs=") !important;
			background-repeat: repeat-y !important;
			background-attachment: local !important;
			background-position: center !important;
		}';
			foreach($this->teams as $team => $color){
				$retorno .= "
				table .$team {
					background-color: $color !important; 
					color: ".invertColor($color)."
				} 
				";
			}
			$retorno .= '</style>
		<table>
			<caption>'.$this->title.'</caption>
			<thead>
				<tr><th>'.$this->team.'</th><th>'.$this->line.'</th>';
		
		$porMes = new DatePeriod($this->start(), $mes, $this->end());
		foreach ($porMes as $date) {
			$key = ($date->format('m')-1);
			
			$month = htmlentities($this->languages->$idioma->{$NameMonths}[$key]);
			$retorno .= '<th colspan="'.$date->format('t').'">'.$month.$this->separator.$date->format($yearFormat).'</th>';
		}
		$retorno .= '</tr>
			</thead>
			<tbody>';
		foreach($this->lines as $equipe => $array){
			$retorno .= '<tr>';
			$r = count($array);
			$retorno .= '<td class="'.$equipe.' equipe" rowspan="'.$r.'">'.$equipe.'</td>';
			
			foreach($array as $tarefa => $obj){
				$retorno .= '<td class="tarefa">'.$tarefa.'</td>';
				$primeiro = true;
				$ini = new DateTime($obj->ini); 
				$fim = new DateTime($obj->fim); 
				$porDia = new DatePeriod($this->start(), $dia, $this->end());
				foreach ($porDia as $date) {
					$content = '&nbsp;';
					if($date->format('Ymd') == $hoje->format('Ymd')){$t =' title="'.$today.'" ';}else{$t = " title='".$this->format($date)."' ";}

					$w = $date->format('D');
					if($hoje->format('Ymd')==$date->format('Ymd')){
						$w = $date->format('D').' hoje';
					}
					
					if($date->format('U') < $ini->format('U')){
						
						$retorno .= '<td '.$t.' class="'.$w.' vazio">'.$content.'</td>';
					}
					elseif($date->format('Ymd') <= $fim->format('Ymd')){
						if($primeiro){
							$w .= ' pri';
						}
						if($date->format('Ymd') == $fim->format('Ymd')){
							$w .= ' ult';
						}
						$t = " title='"."[$equipe] $tarefa (".$this->format($ini)." - ".$this->format($fim).") => $obj->status "."' ";
						if($date->format('Ymd') < $hoje->format('Ymd')){$tempo = ' passado ';}elseif($date->format('Ymd') > $hoje->format('Ymd')){$tempo = ' futuro ';}else{$tempo = ' presente ';}
						$retorno .= '<td '.$t.'  class="'.$w.$tempo.' '.$obj->status.' '.$equipe.' gantt ">'.$content.'</td>';
						$primeiro = false;
					}
					else{
						$retorno .= '<td '.$t.' class="'.$w.' vazio">'.$content.'</td>';
					}
				}
				$retorno .= '</tr>';
			}
		}
		$retorno .= '</tbody>
		</table>';
		return $retorno;
	}
}
function invertColor($color) {
      
    $color = SUBSTR($color,1,6);
    $r = DECHEX(255-HEXDEC(SUBSTR($color,0,2)));
    $r = (STRLEN($r)>1)?$r:'0'.$r;
    $g = DECHEX(255-HEXDEC(SUBSTR($color,2,2)));
    $g = (STRLEN($g)>1)?$g:'0'.$g;
    $b = DECHEX(255-HEXDEC(SUBSTR($color,4,2)));
    $b = (STRLEN($b)>1)?$b:'0'.$b;
    return '#'.$r.$g.$b;
}

$gant = new gantt_with_team('pt_BR');
//$gant->fullNameMonths = true;
//$gant->yearWithTwoDigits = true;
//$gant->separator = ' / ';
//$gant->current(new DateTime('2025-01-01'));
//$gant->date_format('dd/MM EEEE');

$gant->team('BD',green);
$gant->add('Modelagem',					new S_Event('2025-10-20','2025-10-22','OK'));
$gant->add('Criacao',  					new S_Event('2025-10-23','2025-10-26','OK'));

$gant->team('Dev',blue);
$gant->add('Interfaces Comuns',  		new S_Event('2025-10-27','2025-11-16','OK'));
$gant->add('Administracao',  			new S_Event('2025-11-17','2025-11-30','OK'));
$gant->add('Responsavel pela Obra',  	new S_Event('2025-12-01','2025-12-14','OK'));
$gant->add('Usuario da Obra A',  		new S_Event('2025-12-15','2025-12-17','OK'));
$gant->add('Usuario da Obra B',  		new S_Event('2025-12-18','2025-12-21','Andamento'));
$gant->add('Fornecedor',  				new S_Event('2025-12-22','2025-12-28'));
$gant->add('Recesso - Testes',			new S_Event('2025-12-29','2026-01-02','Feriado'));
$gant->add('Almoxarife',  				new S_Event('2026-01-05','2026-01-11'));
$gant->add('Solicitante',  				new S_Event('2026-01-12','2026-01-18'));
$gant->add('Operacoes',  				new S_Event('2026-01-19','2026-01-25'));

$gant->team('QA',purple);
$gant->add('Testes',  					new S_Event('2025-11-17','2026-01-30','Andamento'));

$gant->team('Suporte',yellow);
$gant->add('Treinamento',				new S_Event('2026-01-12','2026-02-06'));
$gant->add('Suporte Tecnico',			new S_Event('2026-02-07','2026-03-31'));


echo $gant;
?>