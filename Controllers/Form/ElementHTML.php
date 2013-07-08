<?php

/**
 * Description of Input
 *
 * @author Gregzenegair
 */
class ElementHTML {

    private $HTML;

    function __construct($HTML) {
        $this->HTML = $HTML;
    }
    public function getHTML() {
        return $this->HTML;
    }

    public function setHTML($HTML) {
        $this->HTML = $HTML;
    }

        
    function genererHTML() {

        $resultat = $this->HTML;

        return $resultat;
    }

}

?>
