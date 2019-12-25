<?php
class Settings extends Database{
	public function getSettings($id){
    	$pdo = $this->Connect();
    	$sql = "SELECT * FROM settings WHERE id = :id";
    	$stmt = $pdo->prepare($sql);
        $stmt->bindParam(":id",$id);
    	$stmt->execute();
    	$data = $stmt->fetch();
    	return $data;
	}

	public function updateSettings($id,$recaptchaprivate,$recaptchapublic,$recaptchastatus,$panel_status){
		$pdo = $this->Connect();
        $settings = $this->getSettings($id);

        if ($settings->recaptchaprivate == $recaptchaprivate) {
                $newRCP = $settings->recaptchaprivate;
            } else {
                $newRCP = $recaptchaprivate;
            }

            if ($settings->recaptchapublic == $recaptchapublic) {
                $newRCPub = $settings->recaptchapublic;
            } else {
                $newRCPub = $recaptchapublic;
            }

            if ($recaptchastatus == "") {
                $status = "off";
            } else {
                $status = "on";
            }

            if ($panel_status == "") {
                $pstatus = "off";
            } else {
                $pstatus = "on";
            }
        $sql = "UPDATE settings SET
        recaptchaprivate = :private,
        recaptchapublic = :public,
        recaptchastatus = :status,
        panel_status = :pstatus
        WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            "private"=>$newRCP,
            "public"=>$newRCPub,
            "status"=>$status,
            "pstatus"=>$pstatus,
            "id"=>$id
        ]);
        return 'Settings Updated';
	}
}
?>