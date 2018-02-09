<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Prispevok/addPrispevok.latte

use Latte\Runtime as LR;

class Template9c1842aea9 extends Latte\Runtime\Template
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
		if (isset($this->params['key'])) trigger_error('Variable $key overwritten in foreach on line 14');
		if (isset($this->params['era'])) trigger_error('Variable $era overwritten in foreach on line 14');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}


	function blockContent($_args)
	{
		extract($_args);
?>

<div>
    <div class="menu_box_left">
	<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Prispevok:vypisVsetko", [$id])) ?>">Späť na prehľad príspevkov</a>
    </div>

<?php
		/* line 8 */
		$this->createTemplate('../cechinfo.latte', $this->params, "include")->renderToContentType('html');
?>

    <h2 style="color: red">Pridanie nového príspevku pre člena <?php echo LR\Filters::escapeHtmlText($user_edited->fetchField('nick')) /* line 10 */ ?></h2>

<?php
		/* line 12 */ $_tmp = $this->global->uiControl->getComponent("addPrispevokForm");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
?>

<?php
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($ery) as $key => $era) {
			if (isset($suroviny[$iterator->counter])) {
				$iter = count($ery) - $iterator->counter + 1;
				?>                <p><strong class="era1"><?php echo LR\Filters::escapeHtmlText($era) /* line 17 */ ?></strong></p>
                <table style="border-style: solid">
                    <tr class="required">
<?php
				for ($i=0;
				$i<count($suroviny[$iter]);
				$i++) {
					?>                        <td class="bunka"><label class="required"><?php echo LR\Filters::escapeHtmlText($suroviny[$iter][$i]) /* line 20 */ ?></label></td>
<?php
				}
?>
                    </tr>
                    <tr>
<?php
				for ($j=0;
				$j<count($suroviny[$iter]);
				$j++) {
?>                        <td class="bunka"><input type="number" value="0" style="width: 50px" name="sur[]" class="text" form="frm-addPrispevokForm"></td>
<?php
				}
?>
                    </tr>
                </table>
<?php
			}
			$iterations++;
		}
		array_pop($this->global->its);
		$iterator = end($this->global->its);
?>

    <br>
    <div class="menu_box_left">
	<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Prispevok:vypisVsetko", [$id])) ?>">Späť na prehľad príspevkov</a>
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
    
</style><?php
	}

}
