<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Prispevok/hromadnyPrispevok.latte

use Latte\Runtime as LR;

class Template3917729a8d extends Latte\Runtime\Template
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
		if (isset($this->params['clen'])) trigger_error('Variable $clen overwritten in foreach on line 20');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<div>
    <div class="menu_box_left">
	<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:")) ?>">Späť na prehľad cechu</a>
    </div>

<?php
		/* line 8 */
		$this->createTemplate('../cechinfo.latte', $this->params, "include")->renderToContentType('html');
?>

    <h2 style="color: red">Hromadné pridanie príspevkov CE a VB pre všetkých členov.</h2>

<?php
		$form = $_form = $this->global->formsStack[] = $this->global->uiControl["hromadnyPrispevokForm"];
		?><form class=form<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormBegin(end($this->global->formsStack), array (
		'class' => NULL,
		), FALSE) ?>>
    <p><label<?php
		$_input = end($this->global->formsStack)["termin"];
		echo $_input->getLabelPart()->attributes() ?>>Týždeň:&nbsp;</label><select<?php
		$_input = end($this->global->formsStack)["termin"];
		echo $_input->getControlPart()->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></select>
    <label<?php
		$_input = end($this->global->formsStack)["rok"];
		echo $_input->getLabelPart()->attributes() ?>>Rok:&nbsp;</label><select<?php
		$_input = end($this->global->formsStack)["rok"];
		echo $_input->getControlPart()->attributes() ?>><?php echo $_input->getControl()->getHtml() ?></select>
    <input class="btn btn-primary btn-sm active"<?php
		$_input = end($this->global->formsStack)["sendHromadnyPrispevok"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>></p>

<?php
		$iterations = 0;
		foreach ($users_cech as $clen) {
?>
                <table style="border-style: solid">
                    <tr class="required">
                        <td class="bunka"><label class="required"><?php echo LR\Filters::escapeHtmlText($clen->nick) /* line 23 */ ?></label></td>
                        <td class="bunka">
                            <span>CE:</span>
                            <input type="number" value=<?php echo LR\Filters::escapeHtmlAttrUnquoted($exist_prispevky2[$clen->userid]['CE']) /* line 26 */ ?> style="width: 50px" name="dataCE[]" class="text" form="frm-hromadnyPrispevokForm">
                        </td>
                        <td class="bunka">
                            <span>Príspevok do VB:</span>
                            <input type="number" value=<?php echo LR\Filters::escapeHtmlAttrUnquoted($exist_prispevky2[$clen->userid]['bodyVB']) /* line 30 */ ?> style="width: 50px" name="dataVB[]" class="text" form="frm-hromadnyPrispevokForm">
                        </td>
                    </tr>
                </table>
                <br>
<?php
			$iterations++;
		}
		?>    <p><input class="btn btn-primary btn-sm active"<?php
		$_input = end($this->global->formsStack)["sendHromadnyPrispevok"];
		echo $_input->getControlPart()->addAttributes(array (
		'class' => NULL,
		))->attributes() ?>></p>
<?php
		echo Nette\Bridges\FormsLatte\Runtime::renderFormEnd(array_pop($this->global->formsStack), FALSE);
?></form>
    <br>
    <div class="menu_box_left">
	<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Homepage:")) ?>">Späť na prehľad cechu</a>
    </div>
</div>
<style>
    .bunka {
        width: 200px;
        text-align: center;
        font-size: 12px;
    }
    
    .era1 {
        color: navy;
        font-size: 12px;
    }
    
</style>
<?php
	}

}
