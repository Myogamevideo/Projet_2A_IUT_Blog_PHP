<?php
class Commentaire
{
  protected $error = [];
  protected $id;
  protected $id_billet;
  protected $auteur;
  protected $commentaire;
  protected $date_commentaire;

  const AUTEUR_INVALIDE = 1;
  const COMMENTAIRE_INVALIDE = 2;

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
    return !(empty($this->auteur) || empty($this->commentaire));
  }

  public function getid()
  {
    return $this->id;
  }
  public function getauteur()
  {
    return $this->auteur;
  }
  public function getcommentaire()
  {
    return $this->commentaire;
  }
  public function getdate_commentaire()
  {
    return $this->date_commentaire;
  }

  public function setid($id)
  {
    $this->id = (int) $id;
  }
  public function setauteur($auteur)
  {
    if (!is_string($auteur) || empty($auteur)) {
      $this->erreurs[] = self::AUTEUR_INVALIDE;
    } else {
      $this->auteur = $auteur;
    }
  }
  public function setcommentaire($commentaire)
  {
    if (!is_string($commentaire) || empty($commentaire)) {
      $this->erreurs[] = self::COMMENTAIRE_INVALIDE;
    } else {
      $commentaire = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $commentaire);
      $commentaire = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $commentaire);
      $commentaire = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $commentaire);
      $commentaire = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $commentaire);
      $this->commentaire = $commentaire;
    }
  }
  public function setdate_creation(DateTime $date_creation)
  {
    $this->date_creation = $date_creation;
  }
}
