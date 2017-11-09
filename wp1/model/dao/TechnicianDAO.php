<?php

namespace model\dao;

use \PDO;
use PDOException;
use util\Executor;
use model\Technician;
use model\Location;
use model\interfaces\dao\ITechnicianDAO;
use config\DependencyInjector;

class TechnicianDAO implements ITechnicianDAO {

    public function __construct( PDO $connection = null ) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        $query = function()  {
            $statement = $this->connection->prepare( 
                'SELECT t.id as t_id, t.name as t_name, t.location_id as l_id, l.name as l_name
                 FROM technicians t 
                 JOIN locations l ON t.location_id = l.id' 
            );
            $statement->execute();
            return $statement->fetchAll( PDO::FETCH_ASSOC );
        };
        
        $rows = Executor::tryPDO( $query(), $this->connection );

        $technicians = array();
        for ( $i = 0; $i < count( $rows ); $i++ ) {
            $technicians[$i] = new Technician( $rows[$i]["t_name"],
                                            new Location(
                                                $rows[$i]["l_name"],
                                                $rows[$i]["l_id"]
                                            ),
                                            $rows[$i]["t_id"]);
        }
        
        return $technicians;
    }

    public function find( $id ) {
        $query = function() use ( $id ) {
            $statement = $this->connection->prepare( 
                'SELECT t.id as t_id, t.name as t_name, t.location_id as l_id, l.name as l_name
                 FROM technicians t 
                 JOIN locations l ON t.location_id = l.id
                 WHERE t.id = :id'
            );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            return $statement->fetchAll();
        };

        $row = Executor::tryPDO( $query(), $this->connection );

        $technician = null;
        if ( count( $row ) > 0 ) {
            $technician = new Technician( $row[0]["t_name"],
                                        new Location(
                                            $rows[$i]["l_name"],
                                            $rows[$i]["l_id"]
                                        ),
                                        $rows[$i]["t_id"]);
        }

        return $technician;
    }

    public function create( $technician ) {
        $query = function() use ( $technician ) {
            $statement = $this->connection->prepare( 
                'INSERT INTO technicians (name, location_id)
                 VALUES (:name, :location_id)' 
            );
            $name = $technician->getName();
            $statement->bindParam( ':name', $name, PDO::PARAM_STR );
            $locationId = $technician->getLocation()->getId();
            $statement->bindParam( ':location_id', $locationId, PDO::PARAM_INT );
            $success = $statement->execute();

            if ( $statement->execute() ) {
                return $this->connection->lastInsertId();
            }
            return null;
        };

        $id = Executor::tryPDO( $query(), $this->connection );
        
        if ( $id ) {
            $technician->setId( $id );
        } else {
            $technician = null;
        }
        
        return $technician;
    }
}