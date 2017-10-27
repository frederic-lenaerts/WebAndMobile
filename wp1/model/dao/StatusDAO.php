<?php

namespace model\dao;

use \PDO;
use PDOException;
use util\Executor;
use model\Status;
use model\Location;
use model\interfaces\dao\IStatusDAO;
use config\DependencyInjector;

class StatusDAO implements IStatusDAO {

    public function __construct( PDO $connection = null) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        $query = function()  {
            $statement = $this->connection->prepare( 
                'SELECT s.id, s.status, s.date, s.location_id, l.name 
                 FROM status s 
                 JOIN locations l ON s.location_id = l.id' 
            );
            $statement->execute();
            return $statement->fetchAll( PDO::FETCH_ASSOC );
        };
        
        $rows = Executor::tryPDO( $query(), $this->connection );

        $status = array();
        for ( $i = 0; $i < count( $rows ); $i++ ) {
            $status[$i] = new Status( $rows[$i]["status"],
                                        $rows[$i]["date"],
                                        new Location(
                                            $rows[$i]["name"],
                                            $rows[$i]["location_id"]
                                        ),
                                        $rows[$i]["id"]);
        }

        return $status;
    }

    public function find( $id ) {
        $query = function() use ( $id ) {
            $statement = $this->connection->prepare( 
                'SELECT s.id, s.status, s.date, s.location_id, l.name 
                 FROM status s
                 JOIN locations l ON s.location_id = l.id
                 WHERE s.id = :id'
            );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            return $statement->fetchAll();
        };

        $row = Executor::tryPDO( $query(), $this->connection );

        $status = null;
        if ( count( $row ) > 0 ) {
            return new Status( $row[0]["status"],
                               $row[0]["date"],
                               new Location(
                                   $row[0]["name"],
                                   $row[0]["location_id"]
                               ),
                               $row[0]["id"]);
        } 
        return status;
    }

    public function create( $status ) {
        $query = function() use ( $status ) {
            $statement = $this->connection->prepare( 
                'INSERT INTO status (location_id, status, date)
                 VALUES (:location_id, :status, :date)' 
            );
            $locationId = $status->getLocation()->getId();
            $statement->bindParam( ':location_id', $locationId, PDO::PARAM_STR );
            $statusInteger = $status->getStatus();
            $statement->bindParam( ':status', $statusInteger, PDO::PARAM_INT );
            $date = $status->getDate();
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
            $success = $statement->execute();

            if ( $statement->execute() ) {
                return $this->connection->lastInsertId();
            }
            return null;
        };

        $id = Executor::tryPDO( $query(), $this->connection );
        
        if ( $id ) {
            $status->setId( $id );
        } else {
            $status = null;
        }
        
        return $status;
    }
}