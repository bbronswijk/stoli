<?php

class Bottles_Model extends Model {

	function __construct() {		
		parent::__construct();
		
	}
	
	function getBottles(){		
		// for user part 3 12:30
		$query = $this->db->prepare("
						SELECT 
							bottles.id,
							bottles.user_id AS 'owner',
							bottles.size,
							bottles.price,
							bottles.date,
							users.first_name,
							users.last_name 
						FROM 
							bottles 
						LEFT JOIN users ON 
							bottles.user_id = users.id
						ORDER BY bottles.date DESC
						") or die('Error: bottles_Model getBottles');
	
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$query->execute();
		$data = $query->fetchAll();
		echo json_encode($data);
	}
	
	public function getTrophies(){
		
		$query = $this->db->prepare("
									SELECT
									  bottles.id,
									  COUNT(bottles_trophies.trophy_id) as 'trophies'
									FROM
									  `bottles`
									LEFT JOIN
									  bottles_trophies ON bottles.id = bottles_trophies.bottle_id
									LEFT JOIN
									  trophies ON bottles_trophies.trophy_id = trophies.id
									WHERE
									  trophies.type != 'xp' || trophies.type IS NULL
									GROUP BY
									  bottles.id
									ORDER BY bottles.date DESC
									") or die ('Error: Bottle_Model getTrophies');
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_ASSOC);
		
		//return $data;
		echo json_encode($data);
	}
	
	public function getAttendees(){
		// for user part 3 12:30
		$query = $this->db->prepare("
						SELECT 
							bottles_users.bottle_id,
							GROUP_CONCAT(bottles_users.user_id) AS 'ids',
							GROUP_CONCAT(first_name,' ', last_name) AS 'attendees'
						FROM 
							bottles_users
						LEFT JOIN users ON 
							bottles_users.user_id = users.id 
						GROUP BY
							bottle_id
						") or die('Error: bottles_Model getAttendees');
		
		$query->execute();
		$data = $query->fetchAll(PDO::FETCH_GROUP);
		
		//return $data;
		echo json_encode($data);
	}
	
	public function insertBottle(){
			date_default_timezone_set('Europe/Amsterdam');
			
			switch ($_POST['size']){
				case 0:
					$size = 70;
					break;
				case 1:
					$size = 100;
					break;
				case 2:
					$size = 150;
					break;
				}
			// put new user in DB here				
			$query = $this->db->prepare("INSERT INTO bottles
				(user_id, size, price, date, time, created, modified )
				VALUES (:user_id, :size, :price, :date, :time, now(), now())
				");
			$query->bindParam(':user_id', $_POST['user_id']);
			$query->bindParam(':size', $size);
			$query->bindParam(':price', $_POST['price']);
			$query->bindParam(':date', $_POST['date']);
			$query->bindParam(':time', $_POST['duration']);
			$query->execute();
			$bottle_id = $this->db->lastInsertId();
			
			// set xp -> don using trophies
			//$user_id = Session::get('fb_user_id');
			//$this->setXpUser($user_id,30);
			
			// add attendees
			if(!empty($_POST['users'])){
				
				$stmt = $this->db->prepare("INSERT INTO bottles_users 
						(bottle_id, user_id) 
						VALUES (:bottle_id,:user_id)");
			
			
				foreach($_POST['users'] as $user_id) {	
					    $stmt->execute(array(
							':bottle_id' => $bottle_id, 
							':user_id' => $user_id
						));
				}
			}
			echo $bottle_id;
			return;
	}
	
	public function deleteBottle(){
		// done using trophies
		//$user_id = Session::get('fb_user_id');
		//$this->setXpUser($user_id,30,true);
		
		$query = $this->db->prepare("DELETE FROM 
										bottles 
									WHERE 
										id = :bottle_id
									");
		$query->bindParam(':bottle_id', $_POST['bottle_id']);
		$count = $query->execute();
		
		echo $count;
	}

	function setXpUser($user_id, $xp, $sub = false){
				
			
			// Update XP row of user
			if( $sub != false ){
				$xpquery = $this->db->prepare("UPDATE
											users
										SET
											xp = xp - :xp
										WHERE
											id = :user_id
										")or die('Error: bottles_Model insertBottle updateXp');						
			} else{
				$xpquery = $this->db->prepare("UPDATE
											users
										SET
											xp = xp + :xp
										WHERE
											id = :user_id
										")or die('Error: bottles_Model insertBottle updateXp');	
			}
			
			$xpquery->bindParam(':xp', $xp);
			$xpquery->bindParam(':user_id', $user_id);
			$xpquery->execute();
			
			return;
	}
	
	public function getUsers(){		
		$query = $this->db->prepare("
						SELECT 
							id,
							last_name
						FROM 
							users 
						WHERE
							id != :user_id
						ORDER BY 
							last_name DESC
						") or die('Error: bottles_Model getUsers');
						
		$query->bindParam(':user_id', Session::get('fb_user_id'));
		$query->execute();
		
		$query->setFetchMode(PDO::FETCH_ASSOC);
		$data = $query->fetchAll();
		return $data;
	}

}