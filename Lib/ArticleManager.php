<?php
abstract class ArticleManager
{
  abstract protected function add(Article $news);
  abstract public function count();
  abstract public function delete($id);
  abstract public function getList($debut = -1, $limite = -1);
  abstract public function getUnique($id);
  abstract protected function update(Article $news);
}
