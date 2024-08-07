<?php

class View
{
    static function render($params = ["page_view" => null, "layout" => null, "data" => []])
    {
        $params['layout'] .= "_layout.php";

        if (isset($params['page_view'])) {
            $params['page_view'] .= "_page.php";
        }
        $data = $params['data'];
        

        include "View/layout/" . $params['layout'];
    }
}