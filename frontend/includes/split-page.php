<?php
use backend\bus\ProductBUS;

class SplitPage
{
    public $start;
    public $total;
    public $limit = 12;
    public $next;
    public $back;
    public $currentPage;
    public $page;

    public function __construct($page = NULL)
    {
        if ($page != NULL) {
            $this->page = $page;
            $this->getPage();
        }
    }

    public function getPage()
    {
        if ($this->page != 1) {
            $this->start = ($this->page - 1) * $this->limit;
            $this->currentPage = $this->page;
        } else {
            $this->start = $this->page - 1;
            $this->currentPage = $this->page;
        }
    }

    public function totalRow()
    {
        $totalProducts = ProductBUS::getInstance()->getAllModels();

        if (count($totalProducts) > 0) {
            $this->total = ceil(count($totalProducts) / $this->limit);
            return $this->total;
        }
    }

    public function select_product()
    {
        $products = ProductBUS::getInstance()->getProductByIndex($this->start, $this->limit);

        $str = "";

        foreach ($products as $product) {
            $str .= "<div class=\"sp1\">";
            $str .= "<img src=\"public/images/" . $product->getImage() . "\" width=\"196\" height=\"150\">";
            $str .= "<h1 style=\"font-size:16px\">" . $product->getName() . "</h1>";
            $str .= "</div>";
        }

        return $str;
    }

    public function splitPageButton()
    {
        $str = "";
        $str .= "<div class=\"page\">";

        if ($this->currentPage > 1) {
            $this->back = $this->currentPage - 1;
            $str .= "<button class=\"custom-btn btn-7 prev\" onclick=\"location.href='index.php?page=" . $this->back . "'\"><span>< </span></button>";
        }

        for ($i = 1; $i <= $this->total; $i++) {
            if ($i == $this->currentPage) {
                $str .= "<button class=\"custom-btn btn-7\" style=\"color:red\" onclick=\"location.href='index.php?page=" . $i . "'\"><span>" . $i . "</span></button>";
            } else {
                $str .= "<button class=\"custom-btn btn-7\" onclick=\"location.href='index.php?page=" . $i . "'\"><span>" . $i . "</span></button>";
            }
        }

        if ($this->currentPage < $this->total) {
            $this->next = $this->currentPage + 1;
            $str .= "<button class=\"custom-btn btn-7 next\" onclick=\"location.href='index.php?page=" . $this->next . "'\"><span> > </span></button>";
        }

        $str .= "</div>";

        return $str;
    }

}