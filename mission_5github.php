
<?php
	$dsn = 'データベース名';
	$user = 'ユーザー名';
    $password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	//$drop = "DROP TABLE. tbtest";
	//$pdo -> query ($drop);
	
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name varchar(32),"
	. "comment TEXT,"
	."date datetime,"
	. "pass1 varchar(255)"
	.");";
	$stmt = $pdo->query($sql);

	
		if (!empty($_POST["name"] )){
			if(!empty($_POST["comment"])){
				if(empty($_POST["editnumber"])){
					if(!empty($_POST["pass1"])){
	
						$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date, pass1) VALUES (:name, :comment, :date, :pass1)");
						$sql -> bindParam(':name', $name, PDO::PARAM_STR);
						$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
						$sql -> bindParam(':date', $date, PDO::PARAM_STR);
						$sql -> bindParam(':pass1', $pass1, PDO::PARAM_STR);
						$name = $_POST["name"];
						$comment = $_POST["comment"]; //好きな名前、好きな言葉は自分で決めること
						$date = date("Y/m/d H:i:s");
						$pass1 = $_POST["pass1"];
                        $sql -> execute();
                    }
						
				}else{
                    if(!empty($_POST["pass1"])){

                    $sql = 'SELECT * FROM tbtest where id=:id';
                    $stmt = $pdo->prepare($sql);
                    $id = $_POST["editnumber"];
                    $stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                    $stmt -> execute();
                    $results = $stmt->fetchAll();
                    //echo '<pre>';
				    //print_r($results);
				    //echo '</pre>';
                   // $pass1 = $results[0]['pass1'];

					//	if ($pass1 == $_POST["pass1"]){
							$id = $_POST["editnumber"]; //変更する投稿番号
		                	$name = $_POST["name"];
                            $comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
                            $pass1 = $_POST["pass1"];
		                	$sql = 'update tbtest set name=:name,comment=:comment, pass1=:pass1 where id=:id';
			                $stmt = $pdo->prepare($sql);
			                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
			                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                            $stmt->bindParam(':pass1', $pass1, PDO::PARAM_STR);
			                $stmt->execute();
                        }
                    }
				}
			}
		
		
		
		
		if(!empty($_POST["delete"])){
			if(!empty($_POST["pass2"])){
				$sql = 'SELECT * FROM tbtest where id=:id';
				$stmt = $pdo->prepare($sql);
                
                $id = $_POST["delete"];
				$stmt -> bindParam(':id', $id, PDO::PARAM_INT);
                $stmt -> execute();
                $results = $stmt->fetchAll();

                $pass1 = $results[0]['pass1'];
                if($_POST["pass2"]===$pass1){
                    $id = $_POST["delete"];
					$sql = 'delete from tbtest where id=:id';
					$stmt = $pdo->prepare($sql);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					$stmt->execute();
                }


				
			//	echo '<pre>';
			//	print_r($results);
			//	echo '</pre>';
										
			//	if($_POST["pass2"] == $row['id']){          
						
		}
		}
		

		
		if(!empty($_POST["edit"])){

            $sql = 'SELECT * FROM tbtest where id=:id';
            $stmt = $pdo->prepare($sql);
            $id = $_POST["edit"];
			$stmt -> bindParam(':id', $id, PDO::PARAM_INT);
            $stmt -> execute();
            $results = $stmt->fetchAll();

            $pass1 = $results[0]['pass1'];
            if($_POST["pass3"]===$pass1){
                $editnumber = $results[0]['id'];
                $editname = $results[0]['name'];
                $editcomment = $results[0]['comment'];
            }
        }




?>

<html>
	<head>
		<title>mission_5-4</title>

		<meta http-equiv="content-type" charset="utf-8">
		<title>mission_5-4</title>
		</head>
		<body>
		
		<form action="" method="post">
		<p>
		名前　　　  ：
		<input type="text" name="name" value="<?php if(!empty($editname)){echo $editname;}?>"placeholder"名前" ><br>	 
		コメント　：
		<input type="text" name="comment" value="<?php if(!empty($editcomment)){echo $editcomment;}?>"placeholder"コメント"><br>
		password：
		<input type="text" name="pass1" value=""placeholder"passwod" ><br>	
		<input type="submit" value="送信"></p>
		
		<p>
		削除ﾌｫｰﾑ　：
		<input type="text" name="delete" value=""placeholder"削除番号"><br>
		password：
		<input type="text" name="pass2" value=""placeholder"passwod" ><br>			
		<input type="submit" value="削除"></p>

		<p>
		編集ﾌｫｰﾑ　　:
		<input type="text" name="edit" value=""placeholder"編集対象番号"><br>
		
		password：
		<input type="text" name="pass3" value=""placeholder"passwod" ><br>
		<input type="submit" value="編集"></p>
		
		<input type="hidden"name="editnumber" value="<?php if(!empty($editnumber)){echo $editnumber;}?>"placeholder"編集される番号" >
		
		
				</form>
		</body>
</html>

<?php

	echo "<hr>";

	$sql = 'SELECT * FROM tbtest';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].'<br>';
        echo $row['name'].',';
        echo $row['date'].'<br>';
        echo $row['comment'].'<br>';
        echo '<hr>';
		
	//	echo $row['pass1'].'<br>';
		
	}

?>
