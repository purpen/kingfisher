<?php
class DspAdkcunitAdgroupAddRequest
{
	private $apiParas = array();
	
	public function getApiMethodName(){
	  return "jingdong.dsp.adkcunit.adgroup.add";
	}
	
	public function getApiParas(){
		return json_encode($this->apiParas);
	}
	
	public function check(){
		
	}
	
	public function putOtherTextParam($key, $value){
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
                                                        		                                    	                   			private $name;
    	                        
	public function setName($name){
		$this->name = $name;
         $this->apiParas["name"] = $name;
	}

	public function getName(){
	  return $this->name;
	}

                        	                   			private $campaignId;
    	                        
	public function setCampaignId($campaignId){
		$this->campaignId = $campaignId;
         $this->apiParas["campaignId"] = $campaignId;
	}

	public function getCampaignId(){
	  return $this->campaignId;
	}

                        	                        	                   			private $inFee;
    	                        
	public function setInFee($inFee){
		$this->inFee = $inFee;
         $this->apiParas["inFee"] = $inFee;
	}

	public function getInFee(){
	  return $this->inFee;
	}

                        	                   			private $searchFee;
    	                        
	public function setSearchFee($searchFee){
		$this->searchFee = $searchFee;
         $this->apiParas["searchFee"] = $searchFee;
	}

	public function getSearchFee(){
	  return $this->searchFee;
	}

                        	                                                    	}





        
 

