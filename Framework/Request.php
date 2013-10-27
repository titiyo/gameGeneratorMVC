<?php

/*
 * Classe modélisant une requête HTTP entrante
 * 
 * @version 1.0
 * @author Baptiste Pesquet
 */
class Request {

    /** Tableau des paramètres de la requête */
    private $parameters;

    /**
     * Constructeur
     * 
     * @param array $parameters Paramètres de la requête
     */
    public function __construct($parameters) {
        $this->parameters = $parameters;
    }

    /**
     * Renvoie vrai si le paramètre existe dans la requête
     * 
     * @param string $name Nom du paramètre
     * @return bool Vrai si le paramètre existe et sa valeur n'est pas vide 
     */
    public function existParameter($name) {
        return (isset($this->parameters[$name]) && $this->parameters[$name] != "");
    }

    /**
     * Renvoie la valeur du paramètre demandé
     * 
     * @param string $name Nom d paramètre
     * @return string Valeur du paramètre
     * @throws Exception Si le paramètre n'existe pas dans la requête
     */
    public function getParameter($name) {
        if ($this->existParameter($name)) {
            return $this->parameters[$name];
        }
        else {
            throw new Exception("Paramètre '$name' absent de la requête");
        }
    }

}

