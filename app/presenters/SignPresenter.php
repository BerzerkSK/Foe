<?php

namespace App\Presenters;

use Nette;
use App\Forms;
use Nette\Database\Context;


class SignPresenter extends BasePresenter
{
	/** @var Forms\SignInFormFactory @inject */
	public $signInFactory;

	/** @var Forms\SignUpFormFactory @inject */
	public $signUpFactory;

        protected $database;
    
        public function __construct(\Nette\Database\Context $database) {
            $this->database = $database;
        }

	/**
	 * Sign-in form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignInForm()
	{
		return $this->signInFactory->create(function () {
			$this->redirect('Cech:showAll', [0,0,1]);
		});
	}


	/**
	 * Sign-up form factory.
	 * @return Nette\Application\UI\Form
	 */
	protected function createComponentSignUpForm()
	{
            return $this->signUpFactory->create(function () {
                $this->redirect('Homepage:');
            });
	}


	public function actionOut()
	{
            $this->flashMessage('Bol si odhlásený.');
            $this->getUser()->logout(TRUE);
            $this->redirect('Homepage:');
	}

        public function renderIn() {
            BasePresenter::menuRule();
        }
}
