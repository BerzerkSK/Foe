<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters\templates\Cech\navody.latte

use Latte\Runtime as LR;

class Template17dc4f8771 extends Latte\Runtime\Template
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
    <div style="text-align: center"> 
<?php
		if ($logged) {
			?>        <a style = "align: left" class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll", [501])) ?>">CVC</a>
<?php
		}
		if ($logged) {
			?>        <a style = "align: left" class="btn btn-primary btn-sm active" role="button" href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll", [502])) ?>">Alcatraz</a>
<?php
		}
?>
    </div>
<?php
	}

}
