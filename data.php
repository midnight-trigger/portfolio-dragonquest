<?php
class Gender {
  const MAN = 1;
  const WOMAN = 2;
  const TRANS = 3;
}

class History {
  public static function set($str) {
    $_SESSION['history'] .= $str.'<br>';
  }
  public static function clear() {
    $_SESSION['history'] = '';
  }
}

abstract class Creature {
  protected $name;
  protected $hp;
  protected $attack;

 public function __construct($name, $hp, $attack) {
   $this->name = $name;
   $this->hp = $hp;
   $this->attack = $attack;
 }

 public function getName() {
   return $this->name;
 }
 public function getHp() {
   return $this->hp;
 }
 public function getAttack() {
   return $this->attack;
 }
 public function setHp($num) {
   $this->hp = $num;
 }

 abstract public function shout();
 public function attack($targetObj) {
   if (!mt_rand(0, 9)) {
     $this->attack *= 1.5;
   }
   $targetObj->setHp($targetObj->getHp() - $this->attack);
   // History::set()
 }
}

class Human extends Creature {
  protected $gender;
  public function __construct($name, $hp, $attack, $gender) {
    parent::__construct($name, $hp, $attack);
    $this->gender = $gender;
  }

  public function getGender() {
    return $this->gender;
  }

  public function shout() {
    switch ($this->gender) {
      case Gender::MAN:
        History::set('Omg!!');
        break;
      case Gender::WOMAN:
        History::set('Ahhhhhhhhhh!');
        break;
      case Gender::TRANS:
        History::set('Moreeeeeeeee!!!');
        break;
    }
  }
}

class Monster extends Creature {
  protected $img;

  public function __construct($name, $hp, $attack, $img) {
    parent::__construct($name, $hp, $attack);
    $this->img = $img;
  }

  public function getImg() {
    return $this->img;
  }

  public function shout() {
    History::set('Auch!!');
  }
}

class MagicMonster extends Monster {
  protected $magicAttack;

  public function __construct($name, $hp, $attack, $img, $magicAttack) {
    parent::__construct($name, $hp, $attack, $img);
    $this->magicAttack = $magicAttack;
  }

  public function getMagicAttack() {
    return $this->magicAttack;
  }

  public function attack($targetObj) {
    if (!mt_rand(0, 9)) {
      $targetObj->setHp($targetObj->getHp() - $this->magicAttack);
    } else {
      parent::attack($targetObj);
    }
  }
}

$human = new Human('Junya', 1000, mt_rand(100, 500), Gender::MAN);

$monsters = [];
$monsters[] = new Monster('Monster1', 500, mt_rand(50, 100), 'img/monster01.png');
$monsters[] = new MagicMonster('Monster2', 200, mt_rand(30, 80), 'img/monster02.png', mt_rand(100, 160));
$monsters[] = new Monster('Monster3', 250, mt_rand(10, 30), 'img/monster03.png');
$monsters[] = new Monster('Monster4', 20, mt_rand(5, 1000), 'img/monster04.png');
$monsters[] = new MagicMonster('Monster5', 340, mt_rand(70, 120), 'img/monster05.png', mt_rand(90, 150));

function createMonster() {
  global $monsters;
  $monster = $monsters[mt_rand(0, 4)];
  History::set($monster->getName().' appeared!!');
  $_SESSION['monster'] =  $monster;
}
function createHuman() {
  global $human;
  $_SESSION['human'] = $human;
}
function init() {
  History::clear();
  $_SESSION = [];
  createMonster();
  createHuman();
}
