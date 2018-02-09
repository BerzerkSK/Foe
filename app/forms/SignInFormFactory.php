<?php

namespace App\Forms;

use Nette;
use Nette\Application\UI\Form;
use Nette\Security\User;


class SignInFormFactory
{
	use Nette\SmartObject;

	/** @var FormFactory */
	private $factory;

	/** @var User */
	private $user;


	public function __construct(FormFactory $factory, User $user)
	{
		$this->factory = $factory;
		$this->user = $user;
	}


	/**
	 * @return Form
	 */
	public function create(callable $onSuccess)
	{
		$form = $this->factory->create();
		$form->addText('nick', 'Nick:')
			->setAttribute('class', 'form-control')
			->setRequired('Prosím vlož svoj nick.');

		$form->addPassword('password', 'Heslo:')
			->setAttribute('class', 'form-control')
			->setRequired('Prosím vlož svoje heslo.');

//		$form->addCheckbox('remember', 'Nechaj ma prihláseného');
//		$values->remember = false;

		$form->addSubmit('send', 'Prihlásiť')
			->setAttribute('class', 'btn btn-primary btn-sm active')
			->setAttribute('role', 'button');

		$form->onSuccess[] = function (Form $form, $values) use ($onSuccess) {
			try {
                                /*if(isset($values->remember)) { 
                                    $this->user->setExpiration($values->remember ? '1 days' : '60 minutes');*/
									$this->user->setExpiration('30 minutes');
                                /*}*/
				$this->user->login($values->nick, $values->password);
			} catch (Nette\Security\AuthenticationException $e) {
				$form->addError('Nick a heslo sa neyhodujú.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}

}
