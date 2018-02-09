<?php

namespace App\Presenters;

use Nette;
use App\Model;
use Nette\Database\Context;


class HomepagePresenter extends BasePresenter
{
    protected $database;
    
    public function __construct(\Nette\Database\Context $database) {
        $this->database = $database;
    }
    
    public function renderDefault() {
        BasePresenter::menuRule();
    }

}
