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

    public function getLegend() {
        return $this->legend;
    }

    public function setLegend($legend) {
        $this->legend = $legend;
    }

    public function getClass() {
        return $this->class;
    }

    public function setClass($class) {
        $this->class = $class;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getTListeElem() {
        return $this->tListeElem;
    }

    public function setTListeElem($tListeElem) {
        $this->tListeElem = $tListeElem;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getSelected() {
        return $this->selected;
    }

    public function setSelected($selected) {
        $this->selected = $selected;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    function genererSelect() {

        $resultatHTML = "";

        if ($this->legend != "") {
            $resultatHTML .= "<legend for=$this->id>$this->legend</legend>";
        }

        $resultatHTML .= "<select name='$this->name'";
        
        if ($this->class != "" || $this->options != null) {
            $resultatHTML .= " class='" . $this->class . "'";
        }
        
        if ($this->id != null)
            $resultatHTML .= " id='$this->id'>";
        else
            $resultatHTML .= " >";

        foreach ($this->tListeElem as $key => $value) {
            if ($value == $this->selected || $key == $this->selected)
                $resultatHTML .= '<option value="' . $key . '" selected>' . $value . '</option>';
            else
                $resultatHTML .= '<option value="' . $key . '">' . $value . '</option>';
        }
        $resultatHTML .= "</select>";
        return $resultatHTML;
    }

}

?>
