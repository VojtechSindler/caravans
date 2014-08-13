<?php

namespace Caravans\Backend\Model;

use Nette,
    Nette\Utils\Strings,
    Nette\Security\Passwords;

/**
 * Provádí přihlašování uživatelů a logování přístupů.
 * 
 * @author Vladimír Antoš
 * @package caravans_backend
 */
class UserAuthenticator extends \Caravans\Model\ModelContainer implements Nette\Security\IAuthenticator {

    public function __construct(Nette\Database\Context $db) {
        parent::__construct($db);
    }

    /**
     * Provádí přihlašování.
     * 
     * @param array $credentials
     * @return \Nette\Security\Identity
     * @throws Nette\Security\AuthenticationException
     */
    public function authenticate(array $credentials) {
        list($email, $password) = $credentials;
        $data = $this->database->table("uzivatele")->where("email", $email)->fetch();

        if (!$data)
            throw new Nette\Security\AuthenticationException('Email '. $email .' není registrován.', self::IDENTITY_NOT_FOUND);
        elseif (!Passwords::verify($password, $data["heslo"]))
            throw new Nette\Security\AuthenticationException('Heslo není správné.', self::INVALID_CREDENTIAL);
        elseif (Passwords::needsRehash("heslo"))
            $data->update(array("heslo" => Passwords::hash($password)));
        
        $arr = $data->toArray();
        unset($arr["heslo"]);
        return new Nette\Security\Identity($data["id"], null, $arr);
    }
}