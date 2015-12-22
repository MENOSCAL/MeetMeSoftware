<?php
namespace autostopBundle\Modal;

class Login{
    //private $id;
    private $username;
    private $nombre;
    private $apellido;
    private $sexo;
    /**
     * Set nombreUsuario
     *
     * @param string $nombreUsuario
     * @return User
     */
    public function setUsername($nombreUsuario){
        $this->username = $nombreUsuario;
    }
    
    public function setLastName($apellido){
        $this->apellido = $apellido;
    }
    
    public function setName($nombre){
        $this->nombre = $nombre;
    }
    
    public function getLastName(){
        return $this->apellido;
    }
    
    public function getName(){
        return $this->nombre;
    }
    
    public function getSex()
    {
        return $this->sexo;
    }
    
    public function setSex($sexo)
    {
        $this->sexo = $sexo;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
}
