<?php
class DBApp{

    static $db = null;

    static function getDatabase(){
        if(!self::$db){
            self::$db = new Database('root', '', 'blog_project');
        }
        return self::$db;
    }

}