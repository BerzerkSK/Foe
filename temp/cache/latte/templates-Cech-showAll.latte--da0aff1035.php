<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters/templates/Cech/showAll.latte

use Latte\Runtime as LR;

class Templateda0aff1035 extends Latte\Runtime\Template
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
		if ($TAB < 500) {
			/* line 3 */
			$this->createTemplate('../cechinfo.latte', $this->params, "include")->renderToContentType('html');
?>
    
        <ul class="nav nav-tabs">
            <li role="presentation" <?php
			if ($TAB == 0) {
				?> class="active"<?php
			}
			?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll", [0])) ?>">Prehľad členov</a></li>
            <li role="presentation" <?php
			if ($TAB == 1) {
				?> class="active" <?php
			}
			?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll", [1])) ?>">Prehľad cechových VB</a></li>
            <li role="presentation" <?php
			if ($TAB == 2) {
				?> class="active" <?php
			}
			?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll", [2])) ?>">Prehľad príspevkov a CE</a></li>
            <li role="presentation" <?php
			if ($TAB == 3) {
				?> class="active" <?php
			}
			?>><a href="<?php echo LR\Filters::escapeHtmlAttr($this->global->uiControl->link("Cech:showAll", [3])) ?>">Spotreba surovín na CE</a></li>
        </ul>
<?php
		}
?>
    
    <br>
    
<?php
		if ($TAB == 1) {
			/* line 17 */
			$this->createTemplate('uroven_cechovych_VB.latte', $this->params, "include")->renderToContentType('html');
		}
		elseif ($TAB == 2) {
			/* line 20 */
			$this->createTemplate('prehlad_CE.latte', $this->params, "include")->renderToContentType('html');
		}
		elseif ($TAB == 3) {
			/* line 23 */
			$this->createTemplate('spotreba_surovin_CE.latte', $this->params, "include")->renderToContentType('html');
?>
	
        
<?php
		}
		elseif ($TAB == 500) {
			/* line 29 */
			$this->createTemplate('navody.latte', $this->params, "include")->renderToContentType('html');
?>
        
<?php
		}
		elseif ($TAB == 501) {
			/* line 33 */
			$this->createTemplate('cvc.latte', $this->params, "include")->renderToContentType('html');
?>
    
<?php
		}
		elseif ($TAB == 502) {
			/* line 37 */
			$this->createTemplate('alcatraz.latte', $this->params, "include")->renderToContentType('html');
?>


<?php
		}
		else {
			/* line 42 */
			$this->createTemplate('all_vypis_clenov.latte', $this->params, "include")->renderToContentType('html');
		}
?>

<?php
	}

}
