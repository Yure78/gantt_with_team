<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gantt With Team (Demo)</title>
</head>
<link rel="stylesheet" href="gantt_with_team.css" >
<body>
<?php 
// Inclusão dos arquivos
include 'include.php';

//Inclusão de Constantes de Cor (opcional)
include 'color_constants.php';

//Criar a instância do Gráfico definindo um idioma
$gant = new gantt_with_team('pt_BR');

$gant->team('PM',green);//#008000
$gant->add('Coleta de Requisitos',	new S_Event('2025-10-01','2025-10-31'));
$gant->add('Prototipagem', new S_Event('2025-11-01','2025-11-30'));
$gant->add('Validação', new S_Event('2025-12-01','2025-12-15'));
$gant->add('Acompanhamento e gestão', new S_Event('2025-12-01','2026-06-30'));
$gant->add('Planejamento da estratégia de lançamento', new S_Event('2026-04-01','2026-07-31'));

$gant->team('Design',blue);//#0000ff
$gant->add('Criação da Identidade Visual', new S_Event('2025-12-16','2025-12-31'));
$gant->add('Criação de Templates para input do Produto',new S_Event('2026-01-01','2026-01-31'));
$gant->add('Criação das Imagens',new S_Event('2026-02-01','2026-03-31'));
$gant->add('Criação de Temas para Usuário interagir',new S_Event('2026-04-01','2026-05-30'));

$gant->team('Dev',red);//#ff0000
$gant->add('Documento de Arquitetura',new S_Event('2025-12-16','2026-01-31'));
$gant->add('Modelagem de Dados', new S_Event('2026-02-01','2026-02-28'));
$gant->add('Setup do ambiente de desenvolvimento', new S_Event('2026-02-01','2026-02-28'));
$gant->add('Codificação', new S_Event('2026-03-01','2026-06-31'));
$gant->add('Ajustes', new S_Event('2026-03-01','2026-06-31'));

$gant->team('QA',purple);//#800080
$gant->add('Testes Funcionais', new S_Event('2026-03-07','2026-04-31'));
$gant->add('Testes de Usabilidade', new S_Event('2026-05-01','2026-05-31'));
$gant->add('Testes de Segurança', new S_Event('2026-06-01','2026-06-30'));
$gant->add('Testes de Desempenho', new S_Event('2026-07-01','2026-07-31'));

$gant->team('Marketing',orange);//#ffa500
$gant->add('Definição do posicionamento de mercado', new S_Event('2025-10-01','2025-10-31'));
$gant->add('Criação de materiais de divulgação', new S_Event('2026-01-01','2026-07-31'));
$gant->add('Execução da campanha de pré-lançamento', new S_Event('2026-08-01','2026-08-07'));
$gant->add('Execução da campanha de lançamento', new S_Event('2026-08-15','2026-09-30'));

echo $gant;
?>
</body>
</html>