<?php
class CommentaireManagerPDO
{
  protected $db;
  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  protected function add(Commentaire $comments)
  {
    $query = 'INSERT INTO commentaires(id_billet, auteur, commentaire, date_commentaire) VALUES(:id_billet,:auteur,:commentaire,NOW())';
    return $this->db->query($query, array(':id_billet' => $comments->getid_billet(), ':auteur' => $comments->getauteur(), ':commentaire', $comments->getcontenu()));
  }

  public function count()
  {
    $query = 'SELECT COUNT(*) FROM commentaires';
    return $this->db->query($query)->fetchColumn();
  }

  public function delete($id)
  {
    $query = 'DELETE FROM commentaires WHERE id = ' . (int) $id;
    return $this->db->query($query);
  }

  public function getList($debut = -1, $limite = -1)
  {
    $query = 'SELECT id, id_billet, auteur, commentaire, date_commentaire FROM commentaires ORDER BY id DESC';
    if ($debut != -1 || $limite != -1) {
      $query .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
    }
    $requete = $this->db->query($query);
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Commentaire');
    $listeComments = $requete->fetchAll();
    $requete->closeCursor();
    return $listeComments;
  }

  public function getListUnique($id)
  {
    $query = 'SELECT id, id_billet, auteur, commentaire, date_commentaire FROM commentaires WHERE id = :id ORDER BY id DESC';
    $requete = $this->db->query($query, array(':id' => (int) $id));
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Commentaire');
    $listeComments = $requete->fetchAll();
    $requete->closeCursor();
    return $listeComments;
  }

  public function getUnique($id)
  {
    $query = 'SELECT id, id_billet, auteur, commentaire, date_commentaire FROM commentaires WHERE id_billet = :id_billet';
    $requete = $this->db->query($query, array(':id_billet' => (int) $id));
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Commentaire');
    $comments = $requete->fetch();
    return $comments;
  }

  protected function update(Commentaire $comments)
  {
    $query = 'UPDATE commentaires SET auteur = :auteur, commentaire = :commentaire, date_commentaire = NOW() WHERE id = :id';
    return $this->db->query($query, array(':titre' => $comments->getauteur(), ':contenu' => $comments->getcommentaire(), ':id' => $comments->getid()));
  }

  public function getNBCommentaire($pseudo)
  {
    $query = 'SELECT count(*) AS nbcommentaire FROM commentaires WHERE auteur=:auteur';
    $requete = $this->db->query($query, array(':auteur' => $pseudo));
    $nbcommentaire = $requete->fetch(PDO::FETCH_ASSOC);
    $requete->closeCursor();
    setcookie('nbcommentaire', $nbcommentaire['nbcommentaire'], time() + 3600, null, null, false, true);
    return $nbcommentaire;
  }
}
