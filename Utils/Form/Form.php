<?php

class Form {

    private $id;
    private $method;
    private $action;
    private $elementsForm = array();
    private $options;

    function __construct($id, $method, $action, $elementsForm, $options = "") {
        $this->id = $id;
        $this->method = $method;
        $this->action = $action;
        $this->elementsForm = $elementsForm;
        $this->options = $options;
    }

    function genererForm() {
        $resultat = "<form";

        if ($this->id != "" || $this->id != null) {
            $resultat .= " id='" . $this->id . "'";
        }
        if ($this->action != "" || $this->action != null) {
            $resultat .= " action='" . $this->action . "'";
        }
        if ($this->method != "" || $this->method != null) {
            $resultat .= " method='" . $this->method . "'";
        }
        if ($this->options != "" || $this->options != null) {
            $resultat .= " " . $this->options . " ";
        }
        $resultat .= ">";

        foreach ($this->elementsForm as $value) {
            $type = get_class($value);

            switch ($type) {
                case "Input":
                    $resultat .= $value->genererInput();

                    break;

                case "Select":
                    $resultat .= $value->genererSelect();

                    break;
                case "DataList":
                    $resultat .= $value->genererDataList();

                    break;

                case "Br":
                    $resultat .= $value->genererBr();

                    break;

                case "ElementHTML":
                    $resultat .= $value->genererHTML();

                    break;

                default:
                    break;
            }
        }

        $resultat .= "</form>";

        return $resultat;
    }

}

?>
