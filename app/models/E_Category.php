<?php
class EntityCategory
{
    public $caregory_id;
    public $parent_category_id;
    public $title;
    public $description;
    public $isactive;
    public $category_parent;

    // Constructor
    public function __construct($caregory_id, $parent_category_id, $title, $description, $isactive)
    {
        $this->caregory_id = $caregory_id;
        $this->parent_category_id = $parent_category_id;
        $this->title = $title;
        $this->description = $description;
        $this->isactive = $isactive;
    }

    // Getter and Setter methods
    public function getId()
    {
        return $this->caregory_id;
    }

    public function setId($caregory_id)
    {
        $this->caregory_id = $caregory_id;
    }

    public function getParentCategory()
    {
        return $this->parent_category_id;
    }

    public function setParentCategory($parent_category_id)
    {
        $this->parent_category_id = $parent_category_id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getIsActive()
    {
        return $this->isactive;
    }

    public function setIsActive($isactive)
    {
        $this->isactive = $isactive;
    }


}
?>