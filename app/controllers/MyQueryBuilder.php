<?php

namespace App\controllers;

use Aura\SqlQuery\QueryFactory;
use PDO;

class MyQueryBuilder {
    private $pdo;
    private $queryFactory;

    public function __construct(PDO $pdo,QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }

    public function getAll($table)
    {

        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table);
        
        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        $result = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getOne($table, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);

    }

    public function insert($table, $data)
    {
        $insert = $this->queryFactory->newInsert();
        $insert
            ->into($table)                   // INTO this table
            ->cols($data);

        $sth = $this->pdo->prepare($insert->getStatement());

        $sth->execute($insert->getBindValues());
        
    }

    public function update($table, $data, $id)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)                  // update this table
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($update->getStatement());

        $sth->execute($update->getBindValues());
    }

    public function delete($table, $id)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id =:id')
            ->bindValue('id', $id);

        $sth = $this->pdo->prepare($delete->getStatement());

        $sth->execute($delete->getBindValues());

    }
    public function getOnePost($id){
        $select = $this->queryFactory->newSelect();
        $select->cols(['p.*','c.name'])
        ->from('posts as p')
        ->join(
        'LEFT',
        'categories AS c',
        'p.category_id = c.id')
        ->where('p.id = :id')
        ->bindValue('id',$id);

        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetch(PDO::FETCH_ASSOC);
    }
    function getAllPosts() {
        $select = $this->queryFactory->newSelect();
        $select->cols(['p.*','c.name'])
            ->from('posts as p')
            ->join(
                'LEFT',
                'categories AS c',
                'p.category_id = c.id');

        $sth = $this->pdo->prepare($select->getStatement());

        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);

    }
    public function getAllPostsByCategory($id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['p.*','c.name'])
            ->from('posts as p')
            ->join(
                'INNER',
                'categories AS c',
                'p.category_id = c.id')
            ->where("p.category_id = :id")
            ->bindValue('id', $id);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPostsByUser($id)
    {
        $select = $this->queryFactory->newSelect();
        $select->cols(['p.*','c.name'])
            ->from('posts as p')
            ->join(
                'LEFT',
                'categories AS c',
                'p.category_id = c.id')
            ->where("p.user_id = :id")
            ->bindValue('id', $id);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
}