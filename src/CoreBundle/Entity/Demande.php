<?php
namespace CoreBundle\Entity;


class Demande
{
    private $description;
    private $id;
    private $accepted;
    private $poids;
    private $date;
    private $userId;

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
    public function setAccepted($accepted)
    {
        $this->accepted=$accepted;

    }
    public function setPoids($poids)
    {
        $this->poids=$poids;
        return $this;
    }

    public function setDate($date)
    {
        $this->date=$date;
        return $this;
    }

    public function setUserId($id)
    {
        $this->userId=$id;
        return $this;
    }
    public function setId($id)
    {
        $this->id=$id;
        return $this;
    }


}