<?php

function LoginUser($username, $password){
	global $id, $email, $nama_lengkap, $no_hp, $alamat_lengkap;
	$sql="SELECT id, email, username, password, nama_lengkap, no_hp, alamat_lengkap FROM ap_user WHERE username=?";
	if($stmt=prepare($sql)){
		$stmt->bind_param("s",$param_username);
		$param_username=$username;
		if($stmt->execute()){
			$stmt->store_result();
			if($stmt->num_rows==1){
				$stmt->bind_result($id, $email, $username, $hashed_password, $nama_lengkap, $no_hp, $alamat_lengkap);
				if($stmt->fetch()){
					if(password_verify($password, $hashed_password)){
						return true;
					}else{
						return false;
					}

				}
			}

		}
	}
	$stmt->close();
}

function LoginAdmin($username, $password){
	global $id, $nama, $email, $level;
	$sql="SELECT id, nama, email, username, password, level FROM ap_admin WHERE username=?";
	if($stmt=prepare($sql)){
		$stmt->bind_param("s",$param_username);
		$param_username=$username;
		if($stmt->execute()){
			$stmt->store_result();
			if($stmt->num_rows==1){
				$stmt->bind_result($id, $nama, $email, $username, $hashed_password, $level);
				if($stmt->fetch()){
					if(password_verify($password, $hashed_password)){
						return true;
					}else{
						return false;
					}

				}
			}

		}
	}
	$stmt->close();
}


?>