<?php

namespace App\Presenters;

use Nette;
use App\Model;

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public $hvezdaren_info = [0,3,4,4,5,6,6,7,7,8,8,
							  10,12,14,16,18,20,22,24,26,28,
							  30,32,34,36,38,40,42,44,46,48,
							  50,52,54,56];
    public $atomium_info = [0,6,7,8,9,11,12,13,14,15,17,
							19,21,23,25,27,29,31,33,35,37,
							39,41,43,45,47];
    public $obluk_info = [0,9,10,12,13,15,16,18,19,21,22,
						  24,26,28,30,32,34,36,38,40,42,
						  44,46,48,50,52,54,56,58,60,62,
						  64,66,68,70,72,74,76,78,80,82,
						  84,86,88,90,92,94,96,98,100,102,
						  104,106,108,110,112,114,116,118,120,122,
						  124,126,128,130,132,134,136,138,140,142,
						  144,146,148,150,152,154,156,158,160,162,
						  164,166,168,170,172,174,176,178,180,182,
						  184,186,188,190,192,194,196,198,200,202];
    public $max_uroven_VB = 80;

    public $ery = null;
    public $users_all = null;
    public $users = null;
    public $users_cech = null;
    public $suroviny = null;
    public $logged = false;
    public $role = null;
    public $user_id = null;
    public $nick = null;
    public $cech = null;
    public $is_role_superadmin = false;
    public $is_role_admin = false;
    public $is_role_clen = false;
    public $server = ['Arvahall' => 'Arvahall',
                        'Brisgard' => 'Brisgard',
                        'Cirgard' => 'Cirgard',
                        'Dinegu' => 'Dinegu'];

    public function menuRule() {
        if($this->getUser()->loggedIn) {
            $this->template->users = $this->users = $this->users_all = $this->database->table('user');
            $this->template->ery = $this->ery = $this->database->table('era');
            $this->template->suroviny = $this->suroviny = $this->database->table('suroviny');
            $this->template->users_cech = $this->users_cech = $this->database->table('user')
										->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)
										->order('era DESC');
            
            $this->template->logged = $this->logged = $this->getUser()->loggedIn;
            $this->template->role = $this->role = $this->getUser()->getIdentity()->role;
            $this->template->nick = $this->nick = $this->getUser()->getIdentity()->nick;
            $this->cech = $this->getUser()->getIdentity()->cech;
            $this->template->user_id = $this->user_id = $this->getUser()->getIdentity()->userid;
            $this->template->last_login = $this->getUser()->getIdentity()->last_login;

            $this->template->is_role_clen = $this->is_role_clen = FALSE;
            $this->template->is_role_admin = $this->is_role_admin = FALSE;
            $this->template->is_role_superadmin = $this->is_role_superadmin = FALSE;

            switch ($this->role) {
            case 'clen':
                $this->template->is_role_clen = $this->is_role_clen = TRUE;
                break;
            case 'admin':
                $this->template->is_role_admin = $this->is_role_admin = TRUE;
                break;
            case 'superadmin':
                $this->template->is_role_superadmin = $this->is_role_superadmin = TRUE;
                $this->template->is_role_admin = $this->is_role_admin = TRUE;
                break;
            }
            
            // vlozenie udajov o cechu do sablony
            $this->template->cech = $this->database->table('cech')->where('id LIKE ?', $this->getUser()->getIdentity()->cech)->fetch();
            $hvezdaren_obj = $this->database->table('user')->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)->where('hvezdaren > ?',0);
            $atomium_obj = $this->database->table('user')->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)->where('atomium > ?',0);
            $obluk_obj = $this->database->table('user')->where('cech LIKE ?', $this->getUser()->getIdentity()->cech)->where('obluk > ?',0);
            $this->template->hvezdaren_pocet = count($hvezdaren_obj);
            $this->template->atomium_pocet = count($atomium_obj);
            $this->template->obluk_pocet = count($obluk_obj);
            $this->template->pocet_clenov = count($this->template->users_cech);
        }
        else {
            $this->template->logged = FALSE;
            $this->template->role = FALSE;
            $this->template->nick = FALSE;
            $this->template->user_id = FALSE;
            $this->template->is_role_clen = FALSE;
            $this->template->is_role_admin = FALSE;
            $this->template->is_role_superadmin = FALSE;
            
//            $this->flashMessage('Pre prístup k cechovým informáciám sa prihlás.');
// riadok nizsie vedie k zacykleniu webu - nechat zakomentovane !!!
//            $this->redirect('Sign:in');
        }
    }
}
