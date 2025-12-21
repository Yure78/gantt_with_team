# Gantt With Team

## PT: Um gráfico de Gantt organizado por times. 
<img width="1317" height="399" alt="ganttWithTeam" src="https://github.com/user-attachments/assets/a6ed11e7-7395-4b23-b97c-74d86b5a6be8" />


Com essa biblioteca você consegue criar seu gráfico com poucas linhas.

Baixe nosso repositório, instale os arquivos na pasta de sua preferência depois siga os passos abaixo:
```php 
// Faça a inclusão dos arquivos
include 'minha_biblioteca/gantt_with_team/include.php';

//Crie uma instância do Gráfico definindo um idioma
$gant = new gantt_with_team('pt_BR');
```
<small>Não esqueça de consultar a nossa lista de idiomas ;)</small>
No HTML você deve incluir o arquivo com o css base.
```html
<link rel="stylesheet" href="includes/classes/gantt_with_team/gantt_with_team.css" >
```

Agora adicione um time e defina sua cor para o gráfico

```php 
$gant->team('BD','#00ff00'); //Passe a cor que deseja 
``` 

Finalmente adicione as atividades. Defina seu nome, início e fim e um Status (opcional)
```php
$gant->add('Modelagem',	new S_Event('2025-10-20','2025-10-22','OK'));
```

Repita o processo adicionando primeiramente o time e depois suas atividades. <br>

Agora é só exibir
```php 
echo $gant;
```

### Configurações
Você pode ainda definir algumas configurações.

Definir exibição do nome completo dos meses
```php 
$gant->fullNameMonths = true;
``` 
Exibir anos usando dois dígitos
```php
$gant->yearWithTwoDigits = true;
```
Mudar o separador de Mês e Ano
```php 
$gant->separator = ' / ';
```

Definir a data a ser considerada como data corrente
```php 
$gant->current(new DateTime('2025-01-01'));
```

Mudar a formatação das datas exibidas no atributo title dentro do gráfico

```php
$gant->date_format('dd/MM EEEE'); \\ Utilizar o padrão ICU
``` 
[Formatos de data no padrão ICU](https://unicode-org.github.io/icu/userguide/format_parse/datetime/#datetime-format-syntax)

### Idiomas

* Português
* Inglês (English)
* Espanhol (Español)
* Francês (Français)
* Alemão (Deutsch)
* Italiano (Italiano)
* Holandês (Nederlands)
* Sueco (Svenska)
* Norueguês (Norsk)



## EN: A Gantt chart organized by teams. 
<p>
:construction: Texto em construção :construction:
</p>
