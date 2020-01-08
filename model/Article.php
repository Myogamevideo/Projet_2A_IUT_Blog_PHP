<?php
class Article
{
  protected $error = [];
  protected $id;
  protected $titre;
  protected $contenu;
  protected $date_creation;

  const TITRE_INVALIDE = 2;
  const CONTENU_INVALIDE = 3;

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
    return !(empty($this->titre) || empty($this->contenu));
  }
  public function getid()
  {
    return $this->id;
  }
  public function gettitre()
  {
    return $this->titre;
  }
  public function getcontenu()
  {
    return $this->contenu;
  }
  public function getdate_creation()
  {
    return $this->date_creation;
  }

  public function setid($id)
  {
    $this->id = (int) $id;
  }
  public function settitre($titre)
  {
    if (!is_string($titre) || empty($titre)) {
      $this->erreurs[] = self::TITRE_INVALIDE;
    } else {
      $this->titre = $titre;
    }
  }
  public function setcontenu($contenu)
  {
    if (!is_string($contenu) || empty($contenu)) {
      $this->erreurs[] = self::CONTENU_INVALIDE;
    } else {
      $contenu = preg_replace('#\[b\](.+)\[/b\]#isU', '<strong>$1</strong>', $contenu);
      $contenu = preg_replace('#\[i\](.+)\[/i\]#isU', '<em>$1</em>', $contenu);
      $contenu = preg_replace('#\[color=(red|green|blue|yellow|purple|olive)\](.+)\[/color\]#isU', '<span style="color:$1">$2</span>', $contenu);
      $contenu = preg_replace('#http://[a-z0-9._/-]+#i', '<a href="$0">$0</a>', $contenu);
      $this->contenu = $contenu;
    }
  }
  public function setdate_creation(DateTime $date_creation)
  {
    $this->date_creation = $date_creation;
  }
}
