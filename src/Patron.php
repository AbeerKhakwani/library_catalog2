<?php
class Patron {
  private $id;
  private $name;

  function __construct($name , $id= null){

    $this->name= $name;
    $this->id=$id;


  }
  //setters
  function setName ($name) {
    $this->name = (string) $name;
  }

  function setId($id) {
    $this->id = (int) $id;
  }

  // getters
  function getName() {
    return $this->name;
  }

  function getId() {
    return $this->id;
  }

   static function deleteAll(){
     $GLOBALS['DB']->exec("DELETE FROM patron *;");

   }

    function save(){

      $statement= $GLOBALS['DB']->query("INSERT INTO patron(name) VALUES       ('{$this->getName()}') RETURNING id; ");

      $result= $statement->fetch(PDO::FETCH_ASSOC);
      $this->setId($result['id']);
    }

    static function getAll(){
      $patrons= $GLOBALS['DB']->query("SELECT * FROM  patron; ");
      $returned_patron= array();
      foreach($patrons as $patron){
        $name = $patron['name'];
        $id= $patron['id'];
        $new_patron= new Patron($name , $id);
        array_push($returned_patron,$new_patron);
      }
    return $returned_patron;

    }

    static function find($search_id)
    {
     $found_patron= null;
     $all_patron= Patron::getAll();
     foreach($all_patron as $patron)
     {
       $patron_id=$patron->getId();
       if ($patron_id ==$search_id )
       {
         $found_patron =  $patron;

       }
     }
     return $found_patron;
    }

    function delete()
    {

      $GLOBALS['DB']->exec("DELETE FROM patron Where id= {$this->getId()}");
      $GLOBALS['DB']->exec("DELETE FROM checkouts Where patron_id= {$this->getId()}");

    }

    function addBook($book){

      $GLOBALS['DB']->exec("INSERT INTO ckecouts (book_id, patron_id) Values ({$book->getId()}, {$this->getId()})");

    }

    function getBooks(){
      $returned_books= $GLOBALS['DB']->exec("SELECT books.* FROM
       patron JOIN checkouts on (patron.id = checkouts.patron_id)
       JOIN books on(checkouts.book_id= books.id)");


    }





















}

?>
