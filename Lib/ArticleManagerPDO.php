<?php
class ArticleManagerPDO
{
  protected $db;
  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  protected function add(Article $news)
  {
    $query = 'INSERT INTO billets(titre, contenu, date_creation) VALUES(:titre, :contenu, NOW())';
    return $this->db->query($query, array(':titre' => $news->gettitre(), ':continu' => $news->getcontenu()));
  }

  public function count()
  {
    $query = 'SELECT COUNT(*) FROM billets';
    return $this->db->query($query)->fetchColumn();
  }

  public function delete($id)
  {
    return $this->db->query('DELETE FROM billets WHERE id = ' . (int) $id);
  }

  public function getList($debut = -1, $limite = -1)
  {
    $query = 'SELECT id, titre, contenu, date_creation FROM billets ORDER BY date_creation ASC';
    if ($debut != -1 || $limite != -1) {
      $query .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
    }
    $requete = $this->db->query($query);
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Article');
    $listeNews = $requete->fetchAll();
    $requete->closeCursor();
    return $listeNews;
  }

  public function getUnique($id)
  {
    $query = 'SELECT id, titre, contenu, date_creation FROM billets WHERE id = :id';
    $requete = $this->db->query($query, array(':id' => (int) $id));
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Article');
    $news = $requete->fetch();
    return $news;
  }

  protected function update(Article $news)
  {
    $query = 'UPDATE billets SET titre = :titre, contenu = :contenu, date_creation = NOW() WHERE id = :id';
    return $this->db->query($query, array(':titre' => $news->gettitre(), ':contenu' => $news->getcontenu(), ':id' => $news->getid()));
  }

  public function getNBArticle()
  {
      $query = 'SELECT count(id) AS nb FROM billets';
      $requete =  $this->db->query($query);
      $nbarticle = $requete->fetch(PDO::FETCH_ASSOC);
      $requete->closeCursor();
      return $nbarticle;
  }
}
