<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Cech/editCech.latte

use Latte\Runtime as LR;

class Templateb783d6c325 extends Latte\Runtime\Template
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
?>
<br>
<div class="menu_box_left">
	<a class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll")) ?>">Späť na prehľad cechu</a>
</div>

<h2 style="color: cornflowerblue">Úprava cechových údajov</h2>

<?php
		/* line 9 */ $_tmp = $this->global->uiControl->getComponent("editCechForm");
		if ($_tmp instanceof Nette\Application\UI\IRenderable) $_tmp->redrawControl(NULL, FALSE);
		$_tmp->render();
		
	}

}
