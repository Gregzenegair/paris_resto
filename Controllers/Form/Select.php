<?php

/**
 * Description of Input
 *
 * @author Gregzenegair
 * 
 */
class Select {

    private $name;
    private $legend;
    private $tListeElem = array();
    private $id;
    private $selected;
    private $options;
    private $position;
    private $class;

    function __construct($name, $legend, $tListeElem, $id, $selected, $position, $options, $class) {
        $this->name = $name;
        $this->legend = $legend;
        $this->tListeElem = $tListeElem;
        $this->id = $id;
        $this->selected = $selected;
        $this->position = $position;
        $this->options = $options;
        $this->class = $class;
    }


    function genererSelect() {

        $resultatHTML = "";

        if ($this->legend != "") {
            $resultatHTML .= "<legend for=$this->id>$this->legend</legend>";
        }

        $resultatHTML .= "<select name=\"$this->name\"";
        
        if ($this->class != "" || $this->options != null) {
            $resultatHTML .= " class=\"" . $this->class . "\"";
        }
        
        if ($this->id != null)
            $resultatHTML .= " id=\"$this->id\">";
        else
            $resultatHTML .= " >";

        foreach ($this->tListeElem as $key => $value) {
            if ($value == $this->selected || $key == $this->selected)
                $resultatHTML .= "<option value=\"" . $key . "\" selected>" . $value . "</option>";
            else
                $resultatHTML .= "<option value=\"" . $key . "\">" . $value . "</option>";
        }
        $resultatHTML .= "</select>";
        return $resultatHTML;
    }

}

?>
