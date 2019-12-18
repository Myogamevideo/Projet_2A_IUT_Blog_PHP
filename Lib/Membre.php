<?php
class Membre
{
    protected $error = [];
    protected $id;
    protected $pseudo;
    protected $pass;
    protected $email;
    protected $date_inscription;
    protected $statu;

    const PSEUDO_INVALIDE = 2;
    const PASS_INVALIDE = 3;
    const EMAIL_INVALIDE = 4;
    const STATU_INVALIDE = 5;

    public function __construct($valeurs = [])
    {
        if (!empty($valeurs)) {
            $this->hydrate($valeurs);
        }
    }

    public function hydrate($donnees)
    {
        foreach ($donnees as $attribut => $valeur) {
            $methode = 'set' . ucfirst($attribut);
            if (is_callable([$this, $methode])) {
                $this->$methode($valeur);
            }
        }
    }

    public function isValid()
    {
        return !(empty($this->pseudo) || empty($this->pass) || empty($this->email) || empty($this->statu));
    }

    public function getid()
    {
        return $this->id;
    }
    public function getpseudo()
    {
        return $this->pseudo;
    }
    public function getpass()
    {
        return $this->pass;
    }
    public function getemail()
    {
        return $this->email;
    }
    public function getstatu()
    {
        return $this->statu;
    }
    public function getdate_inscription()
    {
        return $this->date_inscription;
    }

    public function setid($id)
    {
        $this->id = (int) $id;
    }
    public function setpseudo($pseudo)
    {
        if (!is_string($pseudo) || empty($pseudo)) {
            $this->erreurs[] = self::PSEUDO_INVALIDE;
        } else {
            $this->pseudo = $pseudo;
        }
    }
    public function setpass($pass)
    {
        if (!is_string($pass) || empty($pass)) {
            $this->erreurs[] = self::PASS_INVALIDE;
        } else {
            $this->pass = $pass;
        }
    }
    public function setemail($email)
    {
        if (!is_string($email) || empty($email)) {
            $this->erreurs[] = self::EMAIL_INVALIDE;
        } else {
            $this->email = $email;
        }
    }
    public function setstatu($statu)
    {
        if (!is_string($statu) || empty($statu)) {
            $this->erreurs[] = self::STATU_INVALIDE;
        } else {
            $this->statu = $statu;
        }
    }
    public function setdate_inscription(DateTime $date_inscription)
    {
        $this->date_inscription = $date_inscription;
    }
}
