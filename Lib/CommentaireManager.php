<?php
abstract class CommentaireManager
{
  abstract protected function add(Commentaire $comments);
  abstract public function count();
  abstract public function delete($id);
  abstract public function getList($debut = -1, $limite = -1);
  abstract public function getUnique($id);
  abstract protected function update(Commentaire $comments);
}
