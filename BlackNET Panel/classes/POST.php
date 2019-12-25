<?php
class POST{

	private $folder_name;
	private $file_name;
	private $data;

	public function prepare($folder_name,$file_name,$data){
		$this->folder_name = $folder_name;
		$this->file_name = $file_name;
		$this->data = $this->sanitize($data);
	}

	public function sanitize($data){
       $data = trim($data);
       $data = strip_tags($data);
       $data = htmlentities($data);
       $data = htmlspecialchars($data,ENT_QUOTES,'UTF-8');
       $data = filter_var($data,FILTER_SANITIZE_STRING);
	   return $data;
	}

	public function write(){
		$data = isset($this->data) ? $this->data : "This is incorrect";
		if ($this->folder_name == "www"){
			$myfile = fopen($this->file_name, "w");
		} else {
			if (!file_exists($this->folder_name) && !is_dir($this->folder_name)) { mkdir($this->folder_name); } 
			$myfile = fopen($this->folder_name . "/" . $this->file_name, "w");
		}
		fwrite($myfile, $data);
		fclose($myfile);
	}

}
?>