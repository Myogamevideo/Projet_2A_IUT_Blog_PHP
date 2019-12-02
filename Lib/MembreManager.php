<?php
abstract class MembreManager
{
  abstract protected function add(Membre $user);
  abstract public function count();
  abstract public function delete($id);
  abstract public function getList($debut = -1, $limite = -1);
  abstract public function getUnique($id);
  abstract protected function update(Membre $user);
}
