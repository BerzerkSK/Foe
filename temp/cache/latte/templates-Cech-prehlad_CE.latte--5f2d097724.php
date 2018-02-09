<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters\templates\Cech\prehlad_CE.latte

use Latte\Runtime as LR;

class Template5f2d097724 extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<div>

<?php
		$form = $_form = $this->global->formsStack[] = $this->global->uiControl["baseLawForm"];
		?>    <form class=form<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array (
		'class' => NULL,
		), FALSE) ?>>
    <p><label<?php
		$_input = end($this->global->formsStack)["termin_tyzden"];
		echo $_input->getLabelPart()->attributes() ?>>Týždeň:&nbsp;</label><select<?php
		$_input = end($this->global->formsStack)["termin_tyzden"];
		echo $_input->getControlPart()->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></select>
    <label<?php
		$_input = end($this->global->formsStack)["termin_rok"];
		echo $_input->getLabelPart()->attributes() ?>>Rok:&nbsp;</label><select<?php
		$_input = end($this->global->formsStack)["termin_rok"];
		echo $_input->getControlPart()->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></select></p>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), FALSE);
?></form>
	<h3>Výhry v CE: <?php echo LR\Filters::escapeHtmlText($CE_spolu) /* line 7 */ ?> % (Informatívny výpočet)</h3>
	<div>
    <table class="table table-striped">
        <tr>
            <th>Hráč</th>
            <th class="bunka" title="Aktuálny týždeň">Príspevok do vybranej VB</th>
            <th class="bunka" title="Aktuálny týždeň">výhry v CE</th>
            <th title="Celkový príspevok surovín v aktuálnom týždni">Suroviny celkom</th>
        </tr>
<?php
		$iterations = 0;
		foreach ($users_cech as $clen) {
?>        <tr>
            <td><?php echo LR\Filters::escapeHtmlText($clen->nick) /* line 17 */ ?></td>
            <td class="bunka"><?php
			if ((array_key_exists($clen->userid, $data) && $data [$clen->userid]['bodyVB'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($data [$clen->userid]['bodyVB']) /* line 18 */ ?></span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($clen->userid, $data) && $data [$clen->userid]['CE'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($data [$clen->userid]['CE']) /* line 19 */ ?> / 48</span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($clen->userid, $data) && $data [$clen->userid]['suroviny'] > 0)) {
				?><span"><?php echo LR\Filters::escapeHtmlText($data [$clen->userid]['suroviny']) /* line 20 */ ?></span><?php
			}
?>
</td>
        </tr>
<?php
			$iterations++;
		}
?>
    </table>
</div>

</div><?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['clen'])) trigger_error('Variable $clen overwritten in foreach on line 16');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
