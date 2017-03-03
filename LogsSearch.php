<?php

function searchFun($team,$fileTag,$month,$day,$time,$message){
    $splittedLog=array();
    $requiredLogs=array();
    //echo $team;
    //echo "<br>";
    //echo $fileTag;
    //echo "<br>";
    if ($fileTag == null or $fileTag =="all" ) {
	 /*echo "all";*/
         $logsFile=fopen("/var/log/phpg/debug.log","r");
    }
    elseif ($fileTag == "error"){
	/*echo "error";*/
        $logsFile=fopen("/var/log/phpg/err.log","r");
    }
    elseif ($fileTag == "warning") {
        $logsFile=fopen("/var/log/phpg/warn.log","r");
    }
    elseif ($fileTag == "info") {
        $logsFile=fopen("/var/log/phpg/info.log","r");
    }
    
    
        if(!$logsFile){
        echo "not open";
        exit;
        }
        else{
		
                while(!feof($logsFile)){
                        $log=fgets($logsFile,200);
			//echo $log."<br>";
			$log=preg_replace("/ {2,}/", " ",$log);
			//echo $log."<br>";
                        $splittedLog=explode(" ",$log);
			//echo $splittedLog[5]."<br>";
			
                        if($splittedLog[5] == $team)
                                array_push($requiredLogs,$log);	
                }
                //return $requiredLogs;
	//print_r($requiredLogs);
        }

//----------------------------------------------------------------------
// Date Search
        if($month != null){
            $requiredLogs=dateSearch($month,$day,$requiredLogs);
        }
        
//--------------------------------------------------------------
//Time Search
    if ($time != null){
        $requiredLogs=timeSearch($time,$requiredLogs);
    }
//---------------------------------------------------------------
//Message Search
/*    echo '<br>';*/
  /*  echo $message*/; 
    if ($message != null)
    {

        $requiredLogs = messageSearch($message,$requiredLogs);
    }
        

    return $requiredLogs; 
}



function  dateSearch($month,$day,$Logs){
    $requiredLogs=array();
    $splittedLog=array();
    if ($day == null){
        foreach($Logs as $log){
        
			$splittedLog=explode(" ",$log);
			
			if($splittedLog[0] == $month){
                            array_push($requiredLogs,$log);	

                        }
            
            
        }
        
    }
 
    else {
        foreach($Logs as $log){
        
			$splittedLog=explode(" ",$log);
			
			if($splittedLog[0] == $month && $splittedLog[1] == $day){
                            array_push($requiredLogs,$log);	

                        }
            
            
        }
    }
    
    return $requiredLogs;
    
}

function timeSearch($time,$logs){
    $requiredLogs=array();
    $splittedLog=array();
    //print_r($logs); 
        foreach($logs as $log){
            $splittedLog=explode(" ",$log);
		//echo "<br>";
		//echo $log;
		//print_r($splittedLog);
            $logTime = explode(":",$splittedLog[2]);
		//print_r($logTime);       
		if($logTime[0] == $time){
                    array_push($requiredLogs,$log);	
                }
        }
    
    return $requiredLogs;
    
}

function messageSearch($message,$logs){
    $requiredLogs=array();
    $splittedLog=array();
  
        foreach($logs as $log){
            $splittedLog=explode(" ",$log);
            $logMessage=array_slice($splittedLog,8);
            array_push($logMessage," .");
            
            //print_r($logMessage) ;
            //$logMessage= implode(" ",$logMessage);
    

            if(in_array($message,$logMessage)){
            
                
                array_push($requiredLogs,$log);
            }
            
            
            
        }
    
    
        return $requiredLogs;
    
    
    
    
    
}

function printSearch($team,$fileTag=null,$month=null,$day=null,$time=null,$message=null){
    $requiredLogs=array();
	//echo "Print";
	//echo "<br>";
	//echo "$fileTag";
	//echo "<br>";
    $requiredLogs=searchFun($team,$fileTag,$month,$day,$time,$message);

if(empty($requiredLogs)){
echo "No Data";
}
else{
    foreach ($requiredLogs as $log)
    {
        echo $log."<br>";
    }
}
}




?>



