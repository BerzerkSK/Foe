<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters\templates\Cech\cvc.latte

use Latte\Runtime as LR;

class Templatefe4499096d extends Latte\Runtime\Template
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
		extract($_args);
		/* line 2 */
		$this->createTemplate('navody.latte', $this->params, "include")->renderToContentType('html');
?>
    <h1 style="text-align: center">CVC boje</h1>

    <h4>Čo to vlastne CVC je?</h4>
    <p style="text-align: justify">
Je to boj o sektory na jednotlivých mapách ér (mapa kontinentu cechov) medzi cechmi. Po dobití sektora má z neho cech body do tabuľky (toto je hlavná idea hry - aby bol cech čo najlepšie umiestnený v rebríčku cechov).
Hráč má z útokov body do tabuľky hodnotenia hráčov a medaile pokiaľ sa umiestni na bodovaných priečkach v týždennom rebríčku bojov danej éry (každé susedstvo má vlastný rebríček bojov pre každú éru, ktorú ste získali
na príbehovej mape).
    </p>

    <br><h4>Ako boj prebieha?</h4>
    <p style="text-align: justify">
    Hráč, ktorý má v cechu na starosti boje CVC určí éru a sektor na ktorý sa bude útočiť. Útok môže založiť len OVERENÝ ČLEN, ktorý vloží obliehaciu armádu z vlastných vojakov a za vloženie je potrebné zaplatiť suroviny
z rovnakej éry (buď z cechovej pokladne alebo z vlastných zásob hráča, ktorý zakladá útok).
Keď je obliehacia armáda uložená, možu začať útočiť všetci členovia cechu, ktorí sa boja chcú zúčastniť. Sektor je potrebné dobiť čo najskôr aby majiteľ sektoru (alebo majitelia susediacich sektorov) nezrušil obliehaciu
armádu skôr ako sektor dobijeme. Pokiaľ ju zničia, musí sa vložiť ďalšia obliehacia armáda (ak máme záujem o ďalší boj, ale väčšinou treba nejaký čas počkať lebo je niekto z cechu, ktorý vlastní sektor online) a to
stojí cech ďalšie suroviny.
<br><br>
Sektor, ktorí dobíjame može mať 1 až 8 obranných armád (často bývajú mixované pre sťaženie dobíjania). Každá armáda musí byť porazená 10x. Keď zaútočí hráč, PC mu náhodne vyberie jednu z obranných armád, na ktorú bude
útočiť. Pokiaľ Vám nevyhovuje zvolená armáda, môžete kapitulovať a dať útok znova. Cech to nič nestojí, akurát sa predlžuje čas dobitia sektoru a brániaci hráči majú viac času na zrušenie obliehacej armády, ktorú musia
poraziť 10x aby útok odrazili.
</p>

    <br><h4>Aké jednotky sa môžu používať pri dobíjaní sektorov v CVC?</h4>
    <p style="text-align: justify">
Môžete používať len jednotky z danej éry a jednotky bez éry (rogue, bubeník, farebná stráž, ...). Niekedy je lepšie postaviť len reálne jednotky.
<br><br>
<strong>Príklad:</strong><br>
Pokiaľ máte proti sebe armádu zloženú z 1 reálnej jednotky (napr. tank) a 7x rogue, tak je výhodnejšie postaviť 8x delo a zrušiť najskôr reálnu jednotku a potom už len rogue každého jednou ranou. Keďže reálna jednotka
už je zničená, rogue sa nemajú na čo premeniť a zmiznú. V tomto prípade nedávajte automatický útok lebo Vaše delá najskôr pôjdu po rogue a budú mať proti sebe 8x tank čo je celkom problém.
<br><br>
Po dobití sektora sa obliehacia armáda zmení na prvú obrannú armádu a je potrebné (nie je to však nutnosť) vložiť ďalšie obliehacie armády. Každá ďalšia armáda stojí cech viac surovín (otvorenie slotu pre obrannú armádu)
ako predchádzajúca. Preto niektoré cechy vložia len 1 obrannú armádu okrem obliehacej.
<br><br>
Ak budete vkladať ďalšie obranné armády do otvorených slotov, snažte sa dávať mix vojakov a nepoužívať rogue. Do obrannej armády vložte poškodených vojakov, ak takých po útoku máte. Po vložení do slotu bude ich život
plný a vy ušetríte zdravé jednotky pre ďalšie boje.
    </p>

    <br><h4>Bonus obranných armád pri útočení na sektor.</h4>
    <p style="text-align: justify">
Brániace jednotky v sektore, kde je umiestnená centrála majú bonus 75% do útoku aj obrany. Preto je dobré mať silové VB (Dio, Aachen a Castel) na čo najvyššej úrovni a keďže máme už krčmu, zapínajte si 10, 20 alebo 30%
bonus na útok. Pokiaľ máte aj s 30%ným bonusom menej ako 75%, tak na sektor so základňou neútočte. Budete mať veľké straty a možno obranu ani neprerazíte.
Sektory priliehajúce k sektoru so základňou majú max. bonus 50%, ale záleží to od rezervnej podpory. Rezervnú podporu dávajú aj hvezdárne a Dealský hrad. Preto sú pre cech
dôležité aj tieto VB aj keď hlavne hvezdáreň veľa hráčov podceňuje lebo si myslia, ze dáva len zopár surovín do cechovej pokladne. Podľa mňa je hlavným bonusom z hvezdárne práve rezervná podpora.
    </p>

    <br><h4>Kedy sa najčastejšie robia útoky na sektory?</h4>
    <p style="text-align: justify">
Najčastejšie sa útočí po 20:00, ideálne po 23:00, pretože veľa hráčov už v tom čase nie je online a nemá kto brániť :).
    </p> 
<?php
	}

}
