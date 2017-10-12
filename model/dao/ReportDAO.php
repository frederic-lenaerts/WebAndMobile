<?php

namespace model\dao;

use \PDO;
use PDOException;
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
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM reports' );
            $statement->execute();
            $rows = $statement->fetchAll( PDO::FETCH_ASSOC );

            $reports = array();

            for ( $i = 0; $i < count( $rows ); $i++ ) {
                $reports[$i] = ReportFactory::CreateFromArray( $rows[$i]);
            }

            return $reports;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function find( $id ) {
        try {
            $statement = $this->connection->prepare( 'SELECT * FROM reports WHERE id = :id' );
            $statement->setFetchMode( PDO::FETCH_ASSOC );
            $statement->bindParam( ':id', $id, PDO::PARAM_INT );
            $statement->execute();
            $row = $statement->fetchAll();

            if ( count( $row ) > 0 ) {
                return ReportFactory::CreateFromArray( $row[0] );
            } else {
                return null;
            }
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }

    public function create( $report ) {
        try {
            $statement = $this->connection->prepare( 
                'INSERT INTO reports (location_id, date, handled, technician_id) 
                VALUES ( :location_id, :date, :handled, :technician_id )' );
            $locationId = $report->getLocationId();
            $statement->bindParam( ':location_id', $locationId, PDO::PARAM_INT );
            $date = $report->getDate();
            $statement->bindParam( ':date', $date, PDO::PARAM_STR );
            $handled =  $report->getHandled();
            $statement->bindParam( ':handled', $handled, PDO::PARAM_INT);
            $technicianId = $report->getTechnicianId();
            $statement->bindParam( ':technician_id', $technicianId, PDO::PARAM_INT );
            $success = $statement->execute();

            if ( $success ) {
                $id = $this->connection->lastInsertId();
                $report->setId( $id );
                return $report;
            }
            return null;
        } catch ( PDOException $e ) {
            throw new Exception( 'Caught exception: ' . $e->getMessage() );
        } finally {
            $this->connection = null;
        }
    }
}