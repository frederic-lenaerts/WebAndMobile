<?php

namespace model\dao;

use \PDO;
use PDOException;
use util\Executor;
use model\Report;
use model\Location;
use model\Technician;
use model\factories\ReportFactory;
use model\interfaces\dao\IReportDAO;
use config\DependencyInjector;

class ReportDAO implements IReportDAO {

    public function __construct( PDO $connection = null) {
        if ( !isset( $connection ) )
            $connection = DependancyInjector::getContainer()['pdo'];

        $this->connection = $connection;
    }

    public function findAll() {
        $query = function() {
            $statement = $this->connection->prepare( 
                'SELECT r.id, r.date, r.handled, 
                        l.id as l_id, l.name as l_name, 
                        t.id as t_id, t.name as t_name, 
                        l_t.id as l_t_id, l_t.name as l_t_name
                 FROM reports r
                 JOIN locations l ON r.location_id = l.id
                 JOIN technicians t ON r.technician_id = t.id
                 JOIN locations l_t ON t.location_id = l_t.id'
            );
            $statement->execute();
            return $statement->fetchAll( PDO::FETCH_ASSOC );
        };

        $rows = Executor::tryPDO( $query(), $this->connection );

        $reports = array();
        for ( $i = 0; $i < count( $rows ); $i++ ) {
            $reports[$i] = new Report( $rows[$i]["date"],
                                       $rows[$i]["handled"],
                                       new Location(
                                           $rows[$i]["l_id"],
                                           $rows[$i]["l_name"]
                                       ),
                                       new Technician(
                                           $rows[$i]["t_name"],
                                           new Location(
                                               $rows[$i]["l_t_id"],
                                               $rows[$i]["l_t_name"]
                                           ),
                                           $rows[$i]["t_id"]
                                       ),
                                       $rows[$i]["id"]);
        }
        return $reports;
    }

    public function find( $id ) {
        $query = function() {
            $statement = $this->connection->prepare( 
                'SELECT r.id, r.date, r.handled, 
                        l.id as l_id, l.name as l_name, 
                        t.id as t_id, t.name as t_name, 
                        l_t.id as l_t_id, l_t.name as l_t_name
                 FROM reports r
                 JOIN locations l ON r.location_id = l.id
                 JOIN technicians t ON r.technician_id = t.id
                 JOIN locations l_t ON t.location_id = l_t.id
                 WHERE r.id = :id' 
            );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            return $statement->fetchAll();
        };

        $row = Executor::tryPDO( $query(), $this->connection );
        var_dump($row);
        $report = null;
        if ( count( $row ) > 0 ) {
            $report = new Report( $row[0]["date"],
                                  $row[0]["handled"],
                                  new Location(
                                      $row[0]["l_id"],
                                      $row[0]["l_name"]
                                  ),
                                  new Technician(
                                      $row[0]["t_name"],
                                      new Location(
                                          $row[0]["l_t_id"],
                                          $row[0]["l_t_name"]
                                      ),
                                      $row[0]["t_id"]
                                  ),
                                  $row[0]["id"]);
        } 
        return $report;
    }

    public function create( $report ) {
        $query = function() {
            $statement = $this->connection->prepare( 
                'INSERT INTO reports (location_id, date, handled, technician_id) 
                 VALUES ( :location_id, :date, :handled, :technician_id )' );
            $locationId = $report->getLocation()->getLocationId();
            $statement->bindParam( ':location_id', $locationId, PDO::PARAM_INT );
            $date = $report->getDate();
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
            $handled =  $report->isHandled() ? 1 : 0;
            $statement->bindParam( ':handled', $handled, PDO::PARAM_INT);
            $technicianId = $report->getTechnician()->getId();
            $statement->bindParam( ':technician_id', $technicianId, PDO::PARAM_INT );
            if ( $statement->execute() ) {
                return $this->connection->lastInsertId();
            };
            return null;
        };

        $id = Executor::tryPDO( $query(), $this->connection );

        if ( $id ) {
            $report->setId( $id );
        } else {
            $report = null;
        }
        
        return $report;
    }
    
}