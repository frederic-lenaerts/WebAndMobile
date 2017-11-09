<?php

namespace tests\model\repositories;

require_once('vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use model\Report;
use model\Location;
use model\Technician;
use model\dao\ReportDAO;
use model\repositories\ReportRepository;
use tests\util\GUID;

class ReportRepositoryTests extends TestCase {

    public function setUp() {
        $this->reportDAOMock = $this->getMockBuilder('\model\dao\ReportDAO')
                                ->disableOriginalConstructor()
                                ->getMock();
        $this->reportRepository = new ReportRepository( $this->reportDAOMock );
    }

    public function tearDown() {
        $this->reportDAOMock = null;
        $this->reportRepository = null;
    }

    public function testFind_IdExists_ReportObject() {
        //Arrange
        $report = $this->createReport();
        $this->reportDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $report->getId() )
                            ->will( $this->returnValue( $report ));
        //Act
        $actualReport = $this->reportRepository->find( $report->getId() );
        //Assert
        $this->assertEquals( $report, $actualReport );
    }

    public function testFind_IdDoesNotExist_Null() {
        //Arrange
        $id = rand();
        $this->reportDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'find' )
                            ->with( $id )
                            ->will( $this->returnValue( null ));
        //Act
        $result = $this->reportRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFind_invalidId_Null() {
        $id = GUID::create();
        $this->reportDAOMock->expects( $this->never() )
                            ->method( 'find' );
        //Act
        $result = $this->reportRepository->find( $id );
        //Assert
        $this->assertNull( $result );
    }

    public function testFindAll_MultipleReportsExist_ReportObjectArray() {
        //Arrange
        $reports = array();
        $reports[0] = $this->createReport();
        $reports[1] = $this->createReport();
        $this->reportDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'findAll' )
                            ->will( $this->returnValue( $reports ));
        //Act
        $actualReports = $this->reportRepository->findAll();
        //Assert
        $this->assertEquals( sort( $reports ), sort( $actualReports ));
    }

    public function testCreate_ValidReportObjectWithoutIdProvided_ReportObjectWithId() {
        //Arrange
        $reportWithId = $this->createReport();
        $report = clone $reportWithId;
        $report->setId( null );
        $this->reportDAOMock->expects( $this->atLeastOnce() )
                            ->method( 'create' )
                            ->with( $report )
                            ->will( $this->returnValue( $reportWithId ));
        //Act
        $createdReport = $this->reportRepository->create( $report );
        //Assert
        $this->assertNotNull( $createdReport->getId() );
        $this->assertEquals( $report->getText(), $createdReport->getText() );
        $this->assertEquals( $report->getDate(), $createdReport->getDate() );
        $this->assertEquals( $report->isHandled(), $createdReport->isHandled() );
        $this->assertEquals( $report->getLocation(), $createdReport->getLocation() );
        $this->assertEquals( $report->getTechnician(), $createdReport->getTechnician() );
    }

    public function testFind_emptyReportObject_Null() {
        $this->reportDAOMock->expects( $this->never() )
                            ->method( 'create' );
        //Act
        $result = $this->reportRepository->create( null );
        //Assert
        $this->assertNull( $result );
    }

    private function createReport() {
        $dateArray = getdate();
        $date = $dateArray['year'].'-'.$dateArray['mon'].'-'.$dateArray['mday'];
        $id = rand();
        $text = GUID::create();
        $handled = $this->createRandomBoolean();
        $location = new Location( GUID::create(), rand() );
        $technician = new Technician( GUID::create(), $location, rand() );
        return new Report( $date, $text, $handled, $location, $technician, $id );
    }

    private function createRandomBoolean() {
        return rand() % 2 == 0;
    }
}