<?php
class MembreManagerPDO
{
  protected $db;
  public function __construct(Database $db)
  {
    $this->db = $db;
  }

  protected function add(Membre $mem)
  {
    $query = 'INSERT INTO membres(pseudo, pass, email, date_inscription, statu) VALUES(:pseudo,:pass,:email,NOW(),:statu)';
    return $this->db->query($query, array(':pseudo' => $mem->getpseudo(), ':pass' => $mem->getpass(), ':email' => $mem->getemail(), ':statu' => $mem->getstatu()));
  }

  public function count()
  {
    $query = 'SELECT COUNT(*) FROM membres';
    return $this->db->query($query)->fetchColumn();
  }

  public function delete($id)
  {
    $query = 'DELETE FROM membres WHERE id = ' . (int) $id;
    return $this->db->query($query);
  }

  public function getList($debut = -1, $limite = -1)
  {
    $query = 'SELECT id, pseudo, pass, email, date_inscription, statu FROM membres ORDER BY id DESC';
    if ($debut != -1 || $limite != -1) {
      $query .= ' LIMIT ' . (int) $limite . ' OFFSET ' . (int) $debut;
    }
    $requete = $this->db->query($query);
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Membre');
    $listeMembre = $requete->fetchAll();
    $requete->closeCursor();
    return $listeMembre;
  }

  public function getUniqueByID($id)
  {
    $query = 'SELECT id, pseudo, pass, email, date_inscription, statu FROM membres WHERE id = :id';
    $requete = $this->db->query($query, array(':id' => (int) $id));
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Membre');
    $membre = $requete->fetch();
    return $membre;
  }

  public function getUniqueByPseudo($pseudo)
  {
    $query = 'SELECT id, pseudo, pass, email, date_inscription, statu FROM membres WHERE pseudo = :pseudo';
    $requete = $this->db->query($query, array(':pseudo' => (String) $pseudo));
    $requete->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Membre');
    $membre = $requete->fetch();
    return $membre;
  }

  public function update(Membre $mem)
  {
    $query = 'UPDATE membres SET pseudo = :pseudo, pass = :pass, email= :email, statu = :statu WHERE id = :id';
    return $this->db->query($query, array(':statu' => $mem->getstatu(), ':pseudo' => $mem->getpseudo(), ':pass' => $mem->getpass(), ':email' => $mem->getemail() , ':id' => $mem->getid()));
  }
}
