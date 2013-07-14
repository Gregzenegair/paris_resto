<?php

/**
 * Description of Input
 *
 * @author Gregzenegair
 */
class Input {

    private $name;
    private $id;
    private $legend;
    private $type;
    private $value;
    private $options;
    private $position;
    private $class;

    function __construct($name, $legend, $id, $type, $value, $options, $position, $class) {
        $this->name = $name;
        $this->id = $id;
        $this->legend = $legend;
        $this->type = $type;
        $this->value = $value;
        $this->options = $options;
        $this->position = $position;
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

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getValue() {
        return $this->value;
    }

    public function setValue($value) {
        $this->value = $value;
    }

    public function getOptions() {
        return $this->options;
    }

    public function setOptions($options) {
        $this->options = $options;
    }

    function genererInput() {

        $resultat = "";

        if ($this->legend != "") {
            $resultat .= "<legend for=$this->id>$this->legend</legend>";
        }

        $resultat .= "<input";

        if ($this->name != "" || $this->name != null) {
            $resultat .= " name='" . $this->name . "'";
        }
        if ($this->id != "" || $this->id != null) {
            $resultat .= " id='" . $this->id . "'";
        }
        if ($this->type != "" || $this->type != null) {
            $resultat .= " type='" . $this->type . "'";
        }
        if ($this->value != "" || $this->value != null) {
            $resultat .= " value='" . $this->value . "'";
        }
        if ($this->options != "" || $this->options != null) {
            $resultat .= " " . $this->options . " ";
        }
        if ($this->class != "" || $this->class != null) {
            $resultat .= " class='" . $this->class . "'";
        }
        $resultat .= ">";

        return $resultat;
    }

}

?>
