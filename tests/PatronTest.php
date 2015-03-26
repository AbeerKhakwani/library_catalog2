<?php

  /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

  require_once "src/Book.php";
  require_once "src/Patron.php";

  $DB = new PDO('pgsql:host=localhost;dbname=library_test');

  class PatronTest extends PHPUnit_Framework_TestCase {

    protected function tearDown() {
      Patron::deleteAll();
      Book::deleteAll();
    }

    function test_getName() {
      // Arrange
      $name = "Maths";
      $test_patron = new Patron($name);

      // Act
      $result = $test_patron->getName();

      // Assert
      $this->assertEquals($name, $result);
    }

    function test_getId() {
      // Arrange
      $name = "Maths";
      $id = 1;
      $test_patron = new Patron($name, $id);

      // Act
      $result = $test_patron->getId();

      // Assert
      $this->assertEquals(1, $result);
    }

    function test_setId() {
      // Assert
      $name = "Maths";
      $test_patron = new Patron($name);

      // Act
      $test_patron->setId(2);
      $result = $test_patron->getId();

      // Assert
      $this->assertEquals(2, $result);
    }

    function test_save() {
      // Arrange
      $name = "Joe";
      $test_patron = new Patron($name);
      $test_patron->save();

      // Act
      $result = Patron::getAll();

      // Assert
      $this->assertEquals($test_patron, $result[0]);
    }
    function test_getAll() {
      // Arrange
      $name = "Maths";
      $name = "Sciences";
      $test_patron = new Patron($name);
      $test_patron->save();
      $test_patron2 = new Patron($name);
      $test_patron2->save();

      // Act
      $result = Patron::getAll();

      // Assert
      $this->assertEquals([$test_patron, $test_patron2], $result);
    }
    function test_deleteAll() {
      // Arrange
      $name = "Maths";
      $name2 = "Sciences";
      $test_patron = new Patron($name);
      $test_patron->save();
      $test_patron2 = new Patron($name2);
      $test_patron2->save();

      // Act
      Book::deleteAll();
      Patron::deleteAll();
      $result = Patron::getAll();

      // Assert
      $this->assertEquals([], $result);
    }

    function test_find() {
      // Arrange
      $name = "Maths";
      $name2 = "Sciences";
      $test_patron= new Patron($name);
      $test_patron->save();
      $test_patron2 = new Patron($name2);
      $test_patron2->save();

      // Act
      $result = Patron::find($test_patron->getId());

      // Assert
      $this->assertEquals($test_patron, $result);
    }

    function testDelete() {
      //Arrange
      $name = "Joe";
      $test_patron = new Patron($name);
      $test_patron->save();

      $book_name = "Harry Potter";
      $test_book = new Book($book_name);
      $test_book->save();

      //Act
      $test_patron->addBook($test_book);
      $test_patron->delete();

      //Assert
      $this->assertEquals([], $test_book->getBooks());
    }
















  }


  ?>
