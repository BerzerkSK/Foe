<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Homepage/default.latte

use Latte\Runtime as LR;

class Template95fb19c082 extends Latte\Runtime\Template
{
	public $blocks = [
		'content' => 'blockContent',
	];

	public $blockTypes = [
		'content' => 'html',
	];


	function main()
	{
		extract($this->params);
?>

<?php
		if ($this->getParentName()) return get_defined_vars();
		$this->renderBlock('content', get_defined_vars());
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
?>        <div class="boxes">

        </div>
        
            <div>

			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
				<div class="panel panel-danger">
					<div class="panel-heading" role="tab" id="headingOne">
					  <h4 class="panel-title">
						<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
							3.4.2017 - DEMO cech (klikni pre rozbalenie textu)
						</a>
					  </h4>
					</div>
					<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
						<div class="bg-danger foe_radius">
							<h4>Pridaný DEMO cech (Arvahall)</h4>
							<p>Tento cech slúži na odskúšanie webu, aby ste sa vedeli pozrieť či bude pre Váš cech zaujímavý.</p>
							<p>Pre odskúšanie sa prihláste za admina aj člena, aby ste vedeli, aké sú ich možnosti.</p>
							<br>
							<p>Prihlásenie do DEMO cechu:</p>
							<ul>
								<li>DEMO admin 1, heslo DEMO</li>
								<li>DEMO člen 1, heslo DEMO</li>
								<li>DEMO člen 2, heslo DEMO</li>
								<li>DEMO člen 3, heslo DEMO</li>
								<li>DEMO člen 4, heslo DEMO</li>
								<li>DEMO člen 5, heslo DEMO</li>
								<li>DEMO člen 6, heslo DEMO</li>
								<li>DEMO člen 7, heslo DEMO</li>
								<li>DEMO člen 8, heslo DEMO</li>
								<li>DEMO člen 9, heslo DEMO</li>
								<li>DEMO člen 10, heslo DEMO</li>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="panel panel-primary">
					<div class="panel-heading" role="tab" id="headingTwo">
						<h4 class="panel-title" style="color: black;">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
								2.4.2017
							</a>
						</h4>
					</div>
					<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
						<div class="bg-primary foe_radius">
							<ul>
								<li>pridaný prehľad cechových VB - koľko VB je v danej ére</li>
								<li>pridaný prehľad príspevkov BV do zvolenej cechovej budovy + počet výhier v CE (zatiaľ len aktuálny týždeň)</li>
							</ul>
						</div>
					</div>
				</div>
				
				<div class="panel panel-primary">
					<div class="panel-heading" role="tab" id="headingThree">
						<h4 class="panel-title" style="color: black;">
							<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
								30-31.3.2017
							</a>
						</h4>
					</div>
					<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
						<div class="bg-primary foe_radius">
							<ul>
								<li>sprístupnená editácia cechových informácií</li>
								<li>dizajnová úprava tlačítok pre lepšiu viditeľnosť</li>
								<li>doplnenie hlavnej prehľadovej tabuľky cechu o ďašie stĺpce (zobrazenie niektorých údajov z príspevku aktuálneho týždňa, pokiaľ bol príspevok založený)</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
			
            <p>
                Stránka je vytvorená na správu cechu, evidovanie členov - v akej ére sa nachádzajú, či majú cechové VB (hvezdáreň, atómium, oblúk) a na akej úrovni sú.
            </p>
			<h3>Stručný popis funkcií webu:</h3>
			<ul>
				<li>CECH:</li>
					<ul>
						<li>evidovanie úrovne cechu</li>
						<li>evidencia cechových VB a ich počet</li>
						<li>zobrazenie počtu členov v cechu</li>
						<li>informačná tabuľa - môže tu byť info pre cech</li>
						<li>poznámka - čo sa nevošlo do informačnej tabule :)</li>
					</ul>
				<li>prehľad všetkých členov v cechu - nick, éra, úroveň cechových VB, počet surovín z cechových VB za týždeň pri pravidelnom vyprázdňovaní VB</li>
				<li>prehľad cechových VB</li>
				<li>prehľad základných pravidiel</li>
				<li>spotreba surovín na otvorenie 2., 3. a 4. úrovne cechovej expedície</li>
				<li>časom pribudnú určite ďalšie funkcie :)</li>
			</ul>
			<br>
			<h3>Možnosti admina (správcu cechu):</h3>
			<ul>
				<li>pridávanie členov a ich úpravu vrátane nastavenia nového hesla členom cechu</li>
				<li>vyradenie členov z cechu (nebudú vymazaný, iba budú evidovaní ako člen bez cechu - možnosť priradiť späť alebo do iného cechu (iba superadmin - teda ja :))</li>
				<li>zadávanie a editácia príspevkov všetkých členov</li>
                                <li>úprava cechových informácií</li>
				<li>prístup k cechovým údajom</li>
			</ul>
			<br>
			<h3>Možnosti člena:</h3>
			<ul>
				<li>úpravu svojich údajov vrátane nastavenia nového hesla</li>
				<li>zadávanie a editácia vlastných príspevkov (dočasne vypnuté)</li>
				<li>prístup k cechovým údajom</li>
			</ul>
			<br>
			<p>V prípade záujmu o zaevidovanie cechu na web pošlite email, uveďte presný názov cechu, server, nick (bude pridaná skratka pre server - napr. tester (A)),
			ktorý bude vytvorený a budú mu nastavené práva admina aby mohol pridávať ďalších členov.</p>
			<br>
			<p>V prípade problémov so stránkou prosím pošlite email na <a href="mailto:berzerk1@seznam.cz">berzerk1@seznam.cz</a> ideálne s popisom čo ste robili a priloženým screenom obrazovky chyby.</p>

        </div>

<?php
	}

}
