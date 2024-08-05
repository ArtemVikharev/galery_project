<?


class CollectionThree{
    public static function tplMenu($collection){
        $menu = '<li>
            <a href="?route=main/collection&collectionId='. $collection['id'].'" title="'. $collection['name'] .'">'. 
            $collection['name'].'</a>';
            
            if(isset($collection['childrenCollection'])){
                $menu .= '<ul>'. self::showCollection($collection['childrenCollection']) .'</ul>';
            }
        $menu .= "</li>";
        return $menu;
    }
    

    public static function showCollection($data){
        $string = '';
        foreach($data as $item){
            $string .= self::tplMenu($item);
        }
        return $string;
    }

    private static function tplMenuForDrop($collection,$str)
    {
        if(!key_exists('childrenCollection', $collection)){
            $menu = '<option value="'.$collection['id'].'">'.$collection['name'].'</option>';
        }else{
            $menu = '<option value="'.$collection['id'].'">'.$str.' '.$collection['name'].'</option>';
        }

        if(isset($collection['childrenCollection'])){
            $i = 1;
            for($j = 0; $j < $i; $j++){
                $str .= '--';
            }
            $i++;

            $menu .= self::showDropCollection($collection['childrenCollection'], $str);
        }

        return $menu;
    }

    public static function showDropCollection($data, $str){
        $string = '';
        foreach($data as $item){
            $string .= self::tplMenuForDrop($item, $str);
        }
        return $string;
    }
}