<?php

/**
 * Description of Input
 *
 * @author Gregzenegair
 * 
 */
class DataList {

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

    function genererDataList() {

        $resultatHTML = "";

        if ($this->legend != "") {
            $resultatHTML .= "<legend for=\"$this->id" . "input\">$this->legend</legend>";
        }

        $resultatHTML .= "<input list=\"$this->name\" name=\"$this->name\" type=\"text\"";

        if ($this->class != "" || $this->options != null) {
            $resultatHTML .= " class=\"" . $this->class . "\"";
        }

        if ($this->selected != "") {
            $resultatHTML .= " value=\"" . $this->selected . "\"";
        }

        if ($this->id != null)
            $resultatHTML .= " id=\"$this->id" . "input\">";
        else
            $resultatHTML .= " >";

        if ($this->name != null)
            $resultatHTML .= "<datalist  id=\"$this->name\">";
        else
            $resultatHTML .= "<datalist id=\"\">";

        foreach ($this->tListeElem as $key => $value) {
            if ($value == $this->selected || $key == $this->selected)
                $resultatHTML .= "<option value=\"" . $value . "\" selected></option>";
            else
                $resultatHTML .= "<option value=\"" . $value . "\"></option>";
        }
        $resultatHTML .= "</datalist>";
        return $resultatHTML;
    }

}
?>

<!--

<legend for="choix_bieres">Indiquez votre bière préférée :</legend>
<input list="bieres" type="text" id="choix_bieres">
<datalist id="bieres">
  <option value="Meteor">
  <option value="Pils">
  <option value="Kronenbourg">
  <option value="Grimbergen">
</datalist>
-->
