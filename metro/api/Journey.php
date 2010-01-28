<?php

class Journey extends Base
{
	public function __construct( $data = "", $params = array() )
	{
		parent::__construct( $data, $params );
		$this->data = $data;
		$this->params = $params;
	}
	public function Get()
	{
		if( !empty( $this->data ) )
		{
			switch( $this->data )
			{
				case "AllRoutes":
					$sql = "SELECT RouteNumber, RunningBoard, tblJourney.UniqueJourneyIdentifier, Location AS OriginStop FROM tblJourney INNER JOIN tblJourneyOrigin ON (tblJourney.UniqueJourneyIdentifier = tblJourneyOrigin.UniqueJourneyIdentifier)";
					$results = DataHelper::LoadTableFromSql( $sql );
					$resultJson = json_encode( $results );
					if (isset($_GET['callback'])) {
						$callback = $_GET['callback'];
						echo $callback . '(' . $resultJson . ')';
					}
					else {
						echo $resultJson;
					}
					exit;
				break;
				case "StopsOnRoute":
					if( !$this->params['route'] )
					{
						throw new Exception( "Invalid Params passed", 02 );
					}
					$sql = sprintf("SELECT * FROM tblJourneyIntermediate WHERE UniqueJourneyIdentifier = '%s'", $this->params['route']);
					$results = DataHelper::LoadTableFromSql( $sql );
					$resultJson = json_encode( $results );
					if (isset($_GET['callback'])) {
						$callback = $_GET['callback'];
						echo $callback . '(' . $resultJson . ')';
					}
					else {
						echo $resultJson;
					}
					exit;
				break;
				case "RouteOrigin":
					if( !$this->params['route'] )
					{
						throw new Exception( "Invalid Params passed", 02 );
					}
					$sql = sprintf("SELECT * FROM tblJourneyOrigin INNER JOIN tblStop ON ( tblJourneyOrigin.Location = tblStop.StopReference ) WHERE UniqueJourneyIdentifier = '%s'", $this->params['route']);
					$results = DataHelper::LoadTableFromSql( $sql );
					$resultJson = json_encode( $results );
					if (isset($_GET['callback'])) {
						$callback = $_GET['callback'];
						echo $callback . '(' . $resultJson . ')';
					}
					else {
						echo $resultJson;
					}
					exit;
				break;
				case "RouteDestination":
					if( !$this->params['route'] )
					{
						throw new Exception( "Invalid Params passed", 02 );
					}
					$sql = sprintf("SELECT * FROM tblJourneyDestination INNER JOIN tblStop ON ( tblJourneyDestination.Location = tblStop.StopReference ) WHERE UniqueJourneyIdentifier = '%s'", $this->params['route']);
					$results = DataHelper::LoadTableFromSql( $sql );
					$resultJson = json_encode( $results );
					if (isset($_GET['callback'])) {
						$callback = $_GET['callback'];
						echo $callback . '(' . $resultJson . ')';
					}
					else {
						echo $resultJson;
					}
					exit;
				break;
				default:
					throw new Exception( "Invalid Object Requested", 03 );
				break;
			}

		}
	}
}

?>