<?php
// source: D:\Programy\xampp\htdocs\foe\app\presenters\templates\Cech\uroven_cechovych_VB.latte

use Latte\Runtime as LR;

class Templateed20b000cc extends Latte\Runtime\Template
{

	function main()
	{
		extract($this->params);
?>
<div>
    <table class="table table-striped">
        <tr>
            <th>Éra</th>
            <th class="bunka">Počet hráčov v ére</th>
            <th class="bunka">Hvezdáreň</th>
            <th class="bunka">Atómium</th>
            <th class="bunka">Oblúk</th>
        </tr>
<?php
		$iterations = 0;
		foreach ($iterator = $this->global->its[] = new LR\CachingIterator($ery) as $era) {
?>        <tr>

            <?php
			$iter = count($ery)-$iterator->counter+1;
?> 
            <td><?php echo LR\Filters::escapeHtmlText($ery[$iter]['nazov']) /* line 13 */ ?></td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['hraci'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['hraci']) /* line 14 */ ?></span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['hvezdaren'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['hvezdaren']) /* line 15 */ ?></span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['atomium'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['atomium']) /* line 16 */ ?></span><?php
			}
?>
</td>
            <td class="bunka"><?php
			if ((array_key_exists($iter, $cechove_VB) && $cechove_VB [$iter]['obluk'] > 0)) {
				?><span><?php echo LR\Filters::escapeHtmlText($cechove_VB [$iter]['obluk']) /* line 17 */ ?></span><?php
			}
?>
</td>
        </tr>
<?php
			$iterations++;
		}
		array_pop($this->global->its);
		$iterator = end($this->global->its);
?>
    </table>
</div><?php
		return get_defined_vars();
	}


	function prepare()
	{
		extract($this->params);
		if (isset($this->params['era'])) trigger_error('Variable $era overwritten in foreach on line 10');
		Nette\Bridges\ApplicationLatte\UIRuntime::initialize($this, $this->parentName, $this->blocks);
		
	}

}
