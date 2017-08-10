<?php
/**
 * Created by PhpStorm.
 * User: sande
 * Date: 10-8-2017
 * Time: 21:44
 */

class Pagination
{
    private $pageMax;
    public function __construct($pageMax)
    {
        $this->pageMax = $pageMax;
    }

    /**
     * @return mixed
     */
    public function getPageMax()
    {
        return $this->pageMax;
    }

    /**
     * @param mixed $pageMax
     */
    public function setPageMax($pageMax)
    {
        $this->pageMax = $pageMax;
    }
    public function getStart(){
        if(isset($_GET['page'])) {
            $page = $_GET['page'];
            $start = $page * $this->pageMax;
        }
        else{
            $page = 0;
            $start = $page * $this->pageMax;

        }
        return $start;
    }

    public function numberOfPages($numberOfEntries){
        return ceil($numberOfEntries['count(id)']/$this->pageMax);
    }

    public function next($numberOfPages){
        if(isset($_GET['page']) && $_GET['page'] < $numberOfPages - 1){
            $page = $_GET['page'];
            $next = $page + 1;
            return '<li class="page-item"><a class="page-link" href="?page='.$next.'">Next</a></li> ';
        }
        elseif(!isset($_GET['page']) && $numberOfPages > 1){
            return '<li class="page-item"><a class="page-link" href="?page=1">Next</a></li> ';
        }
    }
    public function previous($numberOfPages){
        if(isset($_GET['page']) && $_GET['page'] > 0){
            $previous = $_GET['page'] - 1;
            return '<li class="page-item"><a class="page-link" href="?page='. $previous.'">Previous</a></li>';
        }
    }
}