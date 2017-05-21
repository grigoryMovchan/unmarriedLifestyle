<?php

namespace Application\Models;

use Application\Core\Model;
use Application\Models\MysqlModel;
use Application\Models\ConfigModel;

class AuthorsModel extends Model
{

    //private $quotesArray = array();
    //private $authorsArray = array();
    private $dbh;

    public function __construct()
    {
        $this->dbh = new MysqlModel(ConfigModel::UNMARRIED);
    }

    /**
     * Получает имена авторов и количество цитат автора
     * @param string $sortingType тип сортировки 'quotes' - по количеству цитат, 
     * 'names' - авторы по алфавиту
     * @return array
     */
    public function getAllAuthors($sortingType)
    {
        $authors = $this->dbh->query("SELECT * FROM `authors`;", 'fetchAll', '');

        // получает количество цитат автора
        foreach ($authors as $key => $author) {
            $countQuotes = $this->dbh->query("SELECT COUNT(*) FROM `quotes` WHERE `author_id` = ?;", 'fetch', '', array($author['id']));
            $countQuotes = $countQuotes[0];
            $authors[$key]['countQuotes'] = (integer) $countQuotes;
        }

        switch ($sortingType) {
            case 'quotes':
                // сортирует по количеству цитат у автора
                foreach ($authors as $key => $author) {
                    $countQuotesArray[$key] = $author['countQuotes'];
                }
                array_multisort($countQuotesArray, SORT_NUMERIC, SORT_DESC, $authors);

                break;

            case 'names':
                // сортирует по имени в алфавитном порядке
                foreach ($authors as $key => $author) {
                    $names[$key] = $author['name'];
                }

                // для регистронезависимой сортировки все буквы заменяются на строчные
                $namesStrtolower = array_map('mb_strtolower', $names);
                array_multisort($namesStrtolower, SORT_STRING, SORT_ASC, $authors);

                break;

            default:
                $this->ensure(false, 'Не задан тип сортировки');
                break;
        }

        return $authors;
    }

    // добавляет нового автора
    public function addAuthor($name = null)
    {
        if (is_null($name)) {
            $this->errors[] = "Имя автора пустое";
            return false;
        }

        // проверяет, существует ли автор с похожим именем в таблице
        if ($this->searchAuthor($name)) {
            $this->errors[] = "Автор уже существует";
            return false;
        } else {
            $this->dbh->query("INSERT INTO `authors` (`name`) VALUES (?)", 'none', '', array($name));
            $this->successful[] = "Новый автор \"$name\" добавлен";
            return true;
        }
    }

    /**
     * Ищет автора с похожим именем в таблице
     * Если похожий автор найден, то вернет TRUE
     * @param string $name
     * @return boolean
     */
    private function searchAuthor(string $name)
    {
        $searchQuery = "%$name%";
        $countAuthor = $this->dbh->query("SELECT * FROM `authors` WHERE `name` = ?;", 'rowCount', '', array($searchQuery));
        return $countAuthor >= 1;
    }

}
