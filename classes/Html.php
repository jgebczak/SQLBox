<?php

class Html {

//----------------------------------------------------------------------------------------------------------------------

    static function option($name,$label,$value,$selected=0)
    {
        if (!$label) $label = $name;
        if ($selected) $s = "selected='selected'";
        return "<option $s name='$name' value='$value'>$label</option>";
    }


//----------------------------------------------------------------------------------------------------------------------

}

